<?php

trait DND_Monster_Trait_Combat {


	protected $ac_rows      = array( 1, 1, 2, 3, 4, 5, 6, 7, 7, 8, 9, 10, 10, 11, 12, 13, 13, 14, 14, 15, 15, 15 );
	protected $armor_type   = 11;
	protected $att_types    = array();
	protected $to_hit_row   = array();


	/**  Monster Combat Setup functions  **/

	protected function determine_armor_type() {
		$this->armor_type = max( 0, $this->armor_class );
	}

	protected function determine_attack_types() {
		foreach( $this->attacks as $key => $damage ) {
			if ( ! array_key_exists( $key, $this->att_types ) ) {
				$type = $this->get_modified_weapon_type( $key );
				if ( $this->weapons_check( $type ) ) {
					$this->att_types[ $key ] = $this->get_weapon_info( $type );
					$this->att_types[ $key ]['damage'][0] = $this->get_damage_string( $damage );
					$this->att_types[ $key ]['damage'][1] = $this->get_damage_string( $damage );
				}
			}
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
		if ( in_array( $check, [ 'Bite', 'Claw' ] ) ) {
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

	/**  Monster Combat functions  **/

	public function get_to_hit_number( $armor_class, $armor_type, $info, $range = 2000 ) {
		$armor_type = min( max( $armor_class, $armor_type, 0 ), 10 );
		if ( empty( $this->to_hit_row ) ) $this->determine_to_hit_row();
		$index  = 10 - $armor_class;
		$number = $this->to_hit_row[ $index ];
		if ( array_key_exists( $armor_type, $info['type'] ) ) {
			$number -= $info['type'][ $armor_type ];
		}
		if ( in_array( $info['attack'], $this->get_weapons_using_strength_bonuses() ) ) {
		} else if ( in_array( $info['attack'], $this->get_weapons_using_missile_adjustment() ) ) {
			$number -= $this->get_missile_range_adjustment( $info['range'], $range );
		}
		return apply_filters( 'monster_to_hit_number', $number, $this );
	}

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
