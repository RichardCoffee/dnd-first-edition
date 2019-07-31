<?php

abstract class DND_Monster_Monster implements JsonSerializable, Serializable {


	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 10;
	protected $attacks      = array();
	public    $current_hp   = 0;
	protected $description  = '';
	protected $frequency    = 'Common';
	protected $hit_dice     = 0;
	protected $hd_minimum   = 1;
	protected $hd_value     = 8;
	protected $hit_points   = 0;
	protected $hp_extra     = 0;
	protected $in_lair      = 0;
	public    $initiative   = 1;
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
	protected $size         = 'Medium';
	protected $specials     = array();
	protected $treasure     = 'Nil';
	protected $xp_value     = array( 0, 0, 0, 0 );


	use DND_Character_Trait_SavingThrows;
	use DND_Character_Trait_Weapons;
	use DND_Monster_Trait_Combat;
	use DND_Monster_Trait_Treasure;
	use DND_Monster_Trait_Serialize;
	use DND_Trait_Logging;
	use DND_Trait_Magic { __get as magic__get; }
	use DND_Trait_ParseArgs;


	abstract protected function determine_hit_dice();


	public function __construct( $args = array() ) {
		$this->parse_args( $args );
		if ( ! isset( $args['initiative'] ) ) {
			$this->initiative = mt_rand( 1, 10 );
		}
		$this->determine_hit_dice();
		$this->determine_hit_points();
		$this->determine_armor_type();
		$this->determine_to_hit_row();
		$this->determine_attack_types();
		$this->determine_specials();
		$this->determine_saving_throw();
		$this->determine_xp_value();
		if ( ! $this->current_hp ) $this->current_hp = $this->hit_points;
	}

	public function __get( $name ) {
		if ( substr( $name, 0, 4 ) === 'move' ) {
			if ( ( ( $name === 'movement' ) || ( $name === 'move_foot' ) ) && isset( $this->movement['foot'] ) ) {
				return $this->movement['foot'];
			} else if ( ( $name === 'move_air' ) && isset( $this->movement['air'] ) ) {
				return $this->movement['air'];
			} else if ( ( $name === 'move_sea' ) && isset( $this->movement['sea'] ) ) {
				return $this->movement['sea'];
			} else if ( ( $name === 'move_web' ) && isset( $this->movement['web'] ) ) {
				return $this->movement['web'];
			}
		}
		if ( property_exists( $this, $name ) ) {
			return $this->$name;  #  Allow read access to private/protected variables
		}
		return null;
	}

	public function __toString() {
		return $this->name;
	}

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
		do_action( 'monster_determine_specials' );
	}

	protected function determine_saving_throw() {
		if ( $this->hp_extra > 0 ) {
			$this->specials['saving'] = sprintf( 'Saves as a %u HD creature.', $this->get_saving_throw_level() );
		}
	}

	protected function get_saving_throw_level() {
		$level = $this->hit_dice;
		$level+= ceil( $this->hp_extra / 4 );
		return $level;
	}

	protected function get_saving_throw_table() {
		return $this->get_combined_saving_throw_table( $this->saving );
	}

	protected function determine_xp_value() {
		$xp = 0;
		if ( $this->xp_value && is_array( $this->xp_value ) ) {
			$xp  = $this->xp_value[0];
			$xp += ( $this->xp_value[1] * $this->hit_points );
			if ( isset( $this->xp_value[2] ) && isset( $this->xp_value[3] ) ) {
				if ( $this->hit_points > $this->xp_value[3] ) {
					$mod = $this->hit_points - $this->xp_value[3];
					$xp += ( $this->xp_value[2] * $mod );
				}
			}
		}
		$this->xp_value = $xp;
	}

	public function set_initiative( $new ) {
		$this->initiative = $new;
	}

	public function get_name() {
		return $this->name;
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

	/**
	 * @param array $chars An array of character objects.
	 */
	public function get_to_hit_characters( $chars = array(), $range = 2000 ) {
		$data = array();
		if ( defined( 'ABSPATH' ) ) { // intended for website use only
			foreach( $this->att_types as $key => $attack ) {
				$data[ $key ] = array();
				foreach( $chars as $name => $obj ) {
					$number = $this->get_to_hit_number( $obj->armor['class'], $obj->armor['type'], $attack, $range );
					$data[ $key ][ $name ] = apply_filters( 'monster_to_hit_character', $number, $this, $obj );
				}
			}
		} else { // intended for command line use
			foreach( $chars as $name => $obj ) {
				$hits = array();
				foreach( $this->att_types as $key => $attack ) {
					$to_hit = $this->get_to_hit_number( $obj->armor['class'], $obj->armor['type'], $attack, $range );
					$to_hit = apply_filters( 'monster_to_hit_character', $to_hit, $this, $obj );
					if ( ! in_array( $to_hit, $hits ) ) $hits[] = $to_hit;
				}
				$data[ $name ] = implode( '/', $hits );
			}
		}
		return $data;
	}

	protected function check_chance( $chance ) {
		$result = false;
		$perc = intval( $chance );
		if ( $perc ) {
			$roll = mt_rand( 1, 100 );
			if ( ! ( $roll > $perc ) ) {
				$result = true;
			}
		}
		return $result;
	}

	public function check_for_lair() {
		if ( $this->in_lair) {
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

	public function this_monster_only( $purpose, $spell, $monster ) {
		if ( $monster->get_name() === $spell['target'] ) {
			return true;
		}
		return false;
	}

	/**  Command Line  **/

	public function command_line_display() {
		$line = "{$this->name}: ";
		$line.= "AC:{$this->armor_class}";
		$line.= ", HD:{$this->hit_dice}";
		if ( $this->hp_extra ) {
			$line .= "+{$this->hp_extra}";
		}
		$line .= ", HP:{$this->current_hp}/{$this->hit_points}, ";
		$line .= $this->reference . "\n";
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
