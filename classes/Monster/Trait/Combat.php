<?php

trait DND_Monster_Trait_Combat {


	protected $ac_rows      = array( 1, 1, 2, 3, 4, 5, 6, 7, 7, 8, 9, 10, 10, 11, 12, 13, 13, 14, 14, 15, 15, 15 );
	protected $armor_type   = 11;
	protected $att_types    = array();
	private   $combat_key   = '';
	protected $to_hit_row   = array();
#	protected $weapon       = array( 'current' => 'none', 'skill' => 'NP', 'attacks' => [ 1, 1 ], 'bonus' => 0 ); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons


	/**  Key functions  **/

	protected function parse_key( &$args ) {
		if ( array_key_exists( 'combat_key', $args ) ) {
			$this->set_key( $args['combat_key'] );
			unset( $args['combat_key'] );
		}
	}

	public function get_key() {
		return $this->combat_key;
	}

	public function set_key( $new ) {
		if ( empty( $this->combat_key ) ) $this->combat_key = $new;
	}


	/**  Setup functions  **/

	protected function determine_armor_type() {
		if ( $this->armor_type === 11 ) {
			$this->armor_type = max( 0, $this->armor_class );
		}
	}

	protected function determine_attack_types() {
		foreach( $this->attacks as $key => $damage ) {
			if ( ! array_key_exists( $key, $this->att_types ) ) {
				$type = $this->get_modified_weapon_type( $key );
				$this->att_types[ $key ] = $this->get_weapon_info( $type );
				$this->att_types[ $key ]['damage'][0] = $this->get_damage_string( $damage );
				$this->att_types[ $key ]['damage'][1] = $this->get_damage_string( $damage );
			}
		}
	}

	protected function initialize_sequence_attacks() {
		$this->weapons['sequence'] = array();
		foreach( $this->attacks as $name => $damage ) {
			if ( $this->is_sequence_attack( $name ) ) {
				$this->weapons['sequence'][] = $name;
			} else {
				$this->weapons[ $name ] = $damage;
			}
		}
		if ( $this->weapon['current'] === 'none' ) {
			$this->set_attack_weapon( $this->weapons['sequence'][0] );
		}
	}

	public function get_attack_info() {
		$info = array();
		foreach( $this->att_types as $key => $data ) {
			$info[] = array( 'type' => $key, 'damage' => $data['damage'][0] );
		}
		return $info;
	}

	private function get_modified_weapon_type( $type ) {
		$check = substr( $type, 0, 4 );
		if ( in_array( $check, [ 'Bite', 'Claw', 'Horn' ] ) ) {
			$type = $check;
		}
		return $type;
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


	/**  Weapon functions  **/

	protected function set_attack_weapon( $new ) {
		if ( empty( $new ) ) return false;
		if ( ! array_key_exists( $new, $this->attacks ) ) return false;
		$this->weapon = $this->base_weapon_array( $new, 'PF' );
		$search = $this->get_modified_weapon_type( $this->weapon['current'] );
		$data   = $this->get_weapon_info( $search );
		$this->weapon = array_merge( $this->weapon, $data );
		$this->weapon['damage'] = $this->attacks[ $new ];
		if ( $this->in_sequence( $new ) ) $this->weapon['attacks'][0] = count( $this->weapons['sequence'] );
		return true;
	}

#	public function set_next_attack(

	protected function get_attack_type( $seq, $segment ) {
		$count = count( $this->weapons['sequence'] );
		$index = array_search( $segment, $seq );
		$spot  = $index % $count;
		return $this->weapons['sequence'][ $spot ];
	}

	public function set_sequence_weapon( $new ) {
		if ( $this->in_sequence( $new ) ) {
			$search = $this->get_modified_weapon_type( $new );
			$data   = $this->get_weapon_info( $search );
			$this->weapon = array_merge( $this->weapon, $data );
			$this->weapon['damage']  = $this->attacks[ $new ];
			$this->weapon['current'] = $new;
		}
	}

	protected function is_sequence_attack( $check ) {
		return true;
	}

	protected function in_sequence( $check ) {
		return in_array( $check, $this->weapons['sequence'] );
	}


	/**  Attack functions  **/

	public function get_to_hit_number( $target, $range = 2000, $weapon = '' ) {
		$armor_type = min( max( $target->armor_class, $target->armor_type, 0 ), 10 );
		if ( empty( $this->to_hit_row ) ) $this->determine_to_hit_row();
		$index  = 10 - $target->armor_class;
		$number = $this->to_hit_row[ $index ];
		$info   = $this->att_types[ $weapon ];
		if ( $this->weapons_armor_type_check( $target ) && array_key_exists( $armor_type, $info['type'] ) ) {
			$number -= $info['type'][ $armor_type ];
		}
		if ( in_array( $info['attack'], $this->get_weapons_using_strength_bonuses() ) ) {
		} else if ( in_array( $info['attack'], $this->get_weapons_using_missile_adjustment() ) ) {
			$number -= $this->get_missile_range_adjustment( $info['range'], $range );
		}
		return apply_filters( 'monster_to_hit_number', $number, $this, $target );
	} //*/

	protected function get_damage_string( $damage ) {
		$string  = sprintf( '%ud%u', $damage[0], $damage[1] );
		$bonus   = apply_filters( 'monster_damage_bonus', $damage[2], $this );
		$string .= ( $bonus > 0 ) ? sprintf( '+%u', $bonus ) : '';
		return $string;
	}

	public function get_possible_damage( $type = 'Bite' ) {
		$dam = 'special';
		if ( array_key_exists( $type, $this->attacks ) ) {
			$dam = $this->get_damage_string( $this->attacks[ $type ] );
		}
		return $dam;
	}


}
