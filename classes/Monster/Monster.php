<?php

abstract class DND_Monster_Monster implements JsonSerializable, Serializable {


#	protected $ac_rows      = array( 1, 1, 2, 3, 4, 5, 6, 7, 7, 8, 9, 10, 10, 11, 12, 13, 13, 14, 14, 15, 15, 15 ); // DND_Monster_Trait_Combat
	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 10;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
#	protected $att_types    = array(); // DND_Monster_Trait_Combat
	protected $attacks      = array();
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
	public    $current_hp   = -10000;
	protected $description  = '';
	protected $frequency    = 'Common';
	protected $hd_minimum   = 1;
	protected $hd_value     = 8;
	protected $hit_dice     = 0;
	protected $hit_points   = 0;
	protected $hp_extra     = 0;
	protected $in_lair      = 0;
	protected $initiative   = 10;
	protected $intelligence = 'Animal';
	protected $magic_user   = null;
	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Monster';
	protected $psionic      = 'Nil';
	protected $race         = 'Monster';
	protected $reference    = 'Monster Manual page';
	protected $resistance   = 'Standard';
	protected $saving       = array( 'fight' );
	protected $segment      = 0;
	protected $size         = 'Medium';
	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'Nil';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array( 'current' => 'none', 'skill' => 'NP', 'attacks' => [ 1, 1 ], 'bonus' => 0 ); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
	protected $xp_value     = array( 0, 0, 0, 0 );


	use DND_Character_Trait_SavingThrows;
	use DND_Character_Trait_Weapons;
	use DND_Monster_Trait_Combat;
	use DND_Monster_Trait_Experience;
	use DND_Monster_Trait_Treasure;
	use DND_Monster_Trait_Serialize;
	use DND_Trait_Logging;
	use DND_Trait_Magic { __get as magic__get; }
	use DND_Trait_ParseArgs;


	abstract protected function determine_hit_dice();


	public function __construct( $args = array() ) {
		$this->parse_key( $args ); // DND_Monster_Trait_Combat
		$this->parse_args( $args );
		$this->determine_hit_dice();
		$this->determine_hit_points();
		$this->determine_armor_type(); // DND_Monster_Trait_Combat
		$this->determine_to_hit_row();
		$this->determine_attack_types(); // DND_Monster_Trait_Combat
		$this->determine_specials();
		$this->determine_saving_throw();
		$this->initialize_sequence_attacks(); // DND_Monster_Trait_Combat
		if ( $this->current_hp === -10000 ) $this->current_hp = $this->hit_points;
	}

	public function __get( $name ) {
		if ( substr( $name, 0, 4 ) === 'move' ) {
			if ( ( ( $name === 'movement' ) || ( $name === 'move_foot' ) ) && array_key_exists( 'foot', $this->movement ) ) {
				return $this->movement['foot'];
			} else if ( in_array( $name, [ 'move_air', 'move_fly' ] ) && array_key_exists( 'air',   $this->movement ) ) {
				return $this->movement['air'];
			} else if ( ( $name === 'move_earth' ) && array_key_exists( 'earth', $this->movement ) ) {
				return $this->movement['earth'];
			} else if ( in_array( $name, [ 'move_swim', 'move_water' ] ) && array_key_exists( 'swim',  $this->movement ) ) {
				return $this->movement['swim'];
			} else if ( ( $name === 'move_web'   ) && array_key_exists( 'web',   $this->movement ) ) {
				return $this->movement['web'];
			} else {
				$key = array_key_first( $this->movement );
				return $this->movement[ $key ];
			}
		}
		if ( ( $name === 'xp_value' ) && ( ( ! $this->xp_value ) || is_array( $this->xp_value ) ) ) {
			$this->determine_xp_value();
		}
		return $this->magic__get( $name );
	}

	public function __toString() {
		return $this->name;
	}


	/**  Setup functions  **/

	protected function determine_hit_points() {
		if ( ( $this->hit_points === 0 ) && ( $this->hit_dice > 0 ) ) {
			$this->hit_points = $this->calculate_hit_points();
		}
	}

	protected function calculate_hit_points( $appearing = false ) {
		$hit_points = 0;
		if ( $this->maximum_hp ) {
			$hit_points = ( $this->hit_dice * $this->hd_value ) + $this->hp_extra;
		} else {
			for( $i = 1; $i <= $this->hit_dice; $i++ ) {
				$hit_points += mt_rand( $this->hd_minimum, $this->hd_value );
			}
			$hit_points += $this->hp_extra;
		}
		return $hit_points;
	}

	protected function determine_specials() {
		$this->specials['reference'] = $this->reference;
		do_action( 'monster_determine_specials' );
	}

	protected function determine_saving_throw() {
		$this->specials['saving'] = sprintf( 'Saves as a %u HD creature.', $this->get_saving_throw_level() );
	}

	protected function get_saving_throw_level() {
		$level = $this->hit_dice;
		$level+= ceil( $this->hp_extra / 4 );
		return $level;
	}


	/**  Get functions  **/

	public function get_name() {
		return $this->name;
#		return str_replace( ' ', '_', $this->name );
	}

	public function get_number_appearing() {
		$num = $this->appearing[2];
		for( $i = 1; $i <= $this->appearing[0]; $i++ ) {
			$num += mt_rand( 1, $this->appearing[1] );
		}
		return $num;
	}

	public function get_appearing_hit_points( $number = 1 ) {
		$number = intval( $number );
		$hit_points = array( $this->hit_points );
		for( $i = 1; $i < $number; $i++ ) {
			$monster = $this->calculate_hit_points( true );
			$hit_points[] = [ $monster, $monster ];
		}
		return $hit_points;
	}

	protected function get_saving_throw_table() {
		return $this->get_combined_saving_throw_table( $this->saving );
	}


	/**  Set functions  **/

	public function set_initiative( $roll ) {
		$this->initiative = 11 - $roll;
		$this->segment = max( $this->initiative, $this->segment );
	}

	public function set_attack_segment( $new ) {
		$this->segment = max( $this->segment, intval( $new ) );
	}

	public function set_current_weapon( $new ) {
		return $this->set_attack_weapon( $new );
	}


	/**  Utility functions  **/

	protected function check_chance( $chance ) {
		$perc = intval( $chance );
		if ( $perc ) {
			$roll = mt_rand( 1, 100 );
			if ( ! ( $roll > $perc ) ) {
				return true;
			}
		}
		return false;
	}

	public function check_for_lair() {
		if ( $this->in_lair && ( $this->in_lair < 100 ) ) {
			if ( $this->check_chance( $this->in_lair ) ) {
				$this->in_lair = 100;
			} else {
				$this->in_lair = 0;
			}
		}
		return ( $this->in_lair ) ? true : false;
	}

	public function get_treasure( $possible = '' ) {
		$response = 'No Treasure Available.';
		if ( empty( $possible ) ) $possible = $this->treasure;
		if ( ! ( $possible === 'Nil' ) ) {
			$test = $this->get_treasure_possibilities( $possible );
			if ( $test ) {
				$response = $test;
			}
		}
		return $response;
	}

	/**  Filter Conditions  **/

	public function this_monster_only( $purpose, $spell, $object ) {
		if ( $this->get_key() === $spell['target'] ) {
			return true;
		}
		return false;
	}

	public function single_attacks( $isolated ) {
		return $isolated;
	}

	/**  Command Line  **/

	public function command_line_display() {
		$line = "{$this->name}: ";
		$line.= "AC:{$this->armor_class}";
		$line.= ", HD:{$this->hit_dice}";
		if ( $this->hp_extra ) {
			$line .= "+{$this->hp_extra}";
		}
		$line .= ", HP:{$this->current_hp}/{$this->hit_points}\n";
		if ( intval( $this->resistance ) ) {
			$this->specials['resistance'] = sprintf( 'Magic Resistance: %u%%', $this->resistance );
		}
		ksort( $this->specials );
		foreach( $this->specials as $string ) {
			$line.= $string . "\n";
		}
		return $line;
	}


}
