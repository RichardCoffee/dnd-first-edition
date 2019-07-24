<?php

abstract class DND_Monster_Monster implements JsonSerializable, Serializable {


	protected $ac_rows      = array( 1, 1, 2, 3, 4, 5, 6, 7, 7, 8, 9, 10, 10, 11, 12, 13, 13, 14, 14, 15, 15, 15 );
	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 10;
	protected $armor_type   = 11;
	protected $attacks      = array();
	protected $att_types    = array();
	public    $companions   = array();
	protected $comparison   = array(); // used for weapon comparisons, such as the sword +1, +4 vs reptiles
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
	protected $size         = 'Medium';
	protected $specials     = array();
	protected $to_hit_row   = array();
	protected $treasure     = 'Nil';
	protected $xp_value     = array( 0, 0 );


	use DND_Character_Trait_Weapons;
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
/*		add_filter( 'humanoid_fighter_data', function( $data, $class ) {
			echo get_class($this);
			echo " $class\n";
		}, 10, 2 ); //*/
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

	/**
	 *  Note:  if overloading in a child class, then the child class also needs get_appearing_hit_points()
	 */
	protected function determine_hit_points() {
		if ( ( $this->hit_points === 0 ) && ( $this->hit_dice > 0 ) ) {
			$this->hit_points = $this->calculate_hit_points();
		}
	}

	protected function calculate_hit_points() {
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

	protected function determine_armor_type() {
		if ( $this->armor_type === 11 ) {
			$this->armor_type = max( 0, $this->armor_class );
		}
	}

	protected function determine_to_hit_row() {
		$table = $this->to_hit_ac_table();
		$index = $this->hit_dice;
		$index+= ( ( $this->hit_dice > 1 ) || ( ( $this->hd_value === 8 ) && ( $this->hp_extra > -2 ) ) ) ? 1 : 0;
		$index+= ( ( $this->hit_dice > 1 ) || ( ( $this->hd_value === 8 ) && ( $this->hp_extra > -1 ) ) ) ? 1 : 0;
		$index+= ( ( $this->hit_dice > 1 ) || ( ( $this->hd_value === 8 ) && ( $this->hp_extra >  0 ) ) ) ? 1 : 0;
		$index+= ( $this->hp_extra > 3 )  ? 1 : 0;
		$this->to_hit_row = $table[ $this->ac_rows[ $index ] ];
	}

	protected function determine_attack_types() {
		foreach( $this->attacks as $key => $damage ) {
			if ( ! isset( $this->att_types[ $key ] ) ) {
				$type = $this->get_modified_weapon_type( $key );
				if ( $this->weapons_check( $type ) ) {
					$this->att_types[ $key ] = $this->get_weapon_info( $type );
					$this->att_types[ $key ]['damage'][0] = $this->get_damage_string( $damage );
					$this->att_types[ $key ]['damage'][1] = $this->get_damage_string( $damage );
				}
			}
		}
	}

	protected function get_modified_weapon_type( $type ) {
		$check = substr( $type, 0, 4 );
		if ( in_array( $check, [ 'Bite', 'Claw' ] ) ) {
			$type = $check;
		}
		return $type;
	}

	protected function determine_specials() {
		do_action( 'monster_determine_specials' );
	}

	protected function determine_saving_throw() {
		if ( $this->hp_extra > 3 ) {
			$this->specials['saving'] = sprintf( 'Saves as a %u HD creature.', $this->get_saving_throw_level() );
		}
	}

	protected function get_saving_throw_level() {
		return $this->hit_dice + ( ( $this->hp_extra > 3 ) ? 1 : 0 );
}

	protected function determine_xp_value() {
		$xp = 0;
		if ( is_array( $this->xp_value ) && $this->xp_value ) {
			$xp = $this->xp_value[0] + ( $this->xp_value[1] * $this->hit_points );
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
			$monster = $this->calculate_hit_points();
			$hit_points[] = [ $monster, $monster ];
		}
		return $hit_points;
	}

	public function get_possible_damage( $type = 'Bite' ) {
		$dam = 'special';
		if ( isset( $this->attacks[ $type ] ) ) {
			$dam = $this->get_damage_string( $this->attacks[ $type ] );
		}
		return $dam;
	}

	protected function get_damage_string( $damage ) {
		$string  = sprintf( '%ud%u', $damage[0], $damage[1] );
		$string .= ( $damage[2] > 0 ) ? sprintf( '+%u', $damage[2] ) : '';
		return $string;
	}

	public function get_attack_info() {
		$info = array();
		foreach( $this->att_types as $key => $data ) {
			$info[] = array( 'type' => $key, 'damage' => $data['damage'][0] );
		}
		return $info;
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

	protected function get_to_hit_number( $armor_class, $armor_type, $info, $range = 2000 ) {
		$armor_type = min( max( $armor_class, $armor_type, 0 ), 10 );
		if ( empty( $this->to_hit_row ) ) { $this->determine_to_hit_row(); }
		$index  = 10 - $armor_class;
		$number = $this->to_hit_row[ $index ];
		if ( isset( $info['type'][ $armor_type ] ) ) {
			$number -= $info['type'][ $armor_type ];
		}
		if ( in_array( $info['attack'], $this->get_weapons_using_strength_bonuses() ) ) {
		} else if ( in_array( $info['attack'], $this->get_weapons_using_missile_adjustment() ) ) {
			$number -= $this->get_missile_range_adjustment( $info['range'], $range );
		}
		return apply_filters( 'monster_to_hit_number', $number, $this );
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

	public function command_line_display() {
		$line = "{$this->name}: ";
		$line.= "HD {$this->hit_dice}";
		if ( $this->hp_extra ) {
			$line .= "+{$this->hp_extra}";
		}
		$line .= ", HP {$this->current_hp}/{$this->hit_points}, ";
		$line .= $this->reference . "\n";
		foreach( $this->specials as $string ) {
			$line.= $string . "\n";
		}
		return $line;
	}


}
