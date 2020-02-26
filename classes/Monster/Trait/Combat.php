<?php

trait DND_Monster_Trait_Combat {


	protected $ac_rows      = array( 1, 1, 2, 3, 4, 5, 6, 7, 7, 8, 9, 10, 10, 11, 12, 13, 13, 14, 14, 15, 15, 15 );
	protected $armor_type   = 11;
	private   $combat_key   = '';
	protected $to_hit_row   = array();
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons


	/**  Key functions  **/

	protected function parse_key( &$args ) {
		if ( array_key_exists( 'combat_key', $args ) ) {
			$this->set_key( $args['combat_key'] );
			unset( $args['combat_key'] );
		}
	}

	public function get_key( $under = false ) {
#		if ( empty( $this->combat_key ) ) $this->set_key( $this->name ); // needed for testing outside combat environment
		if ( $under ) return str_replace( ' ', '_', $this->combat_key );
		return $this->combat_key;
	}

	public function set_key( $new ) {
		$this->combat_key = $new;
	}


	/**  Setup functions  **/

	protected function determine_to_hit_row() {
		$table = $this->to_hit_ac_table();
		$index = $this->hit_dice;
		$index+= ( ( $this->hit_dice > 1 ) || ( ( $this->hd_value === 8 ) && ( $this->hp_extra > -2 ) ) ) ? 1 : 0;
		$index+= ( ( $this->hit_dice > 1 ) || ( ( $this->hd_value === 8 ) && ( $this->hp_extra > -1 ) ) ) ? 1 : 0;
		$index+= ( ( $this->hit_dice > 1 ) || ( ( $this->hd_value === 8 ) && ( $this->hp_extra >  0 ) ) ) ? 1 : 0;
		$index+= ( $this->hp_extra > 3 )  ? 1 : 0;
		$this->to_hit_row = $table[ $this->ac_rows[ $index ] ];
	}

	protected function initialize_sequence_attacks() {
		$this->weapons['sequence'] = array();
		foreach( $this->attacks as $name => $damage ) {
			if ( $this->is_sequence_attack( $name ) ) {
				$this->weapons['sequence'][] = $name;
			} else {
				$this->weapons[ $name ] = $damage;
				if ( $this instanceOf DND_Monster_Humanoid_Humanoid ) {
					$this->weapons[ $name ] = array( 'damage' => $damage );
				}
			}
		}
		if ( empty( $this->weapon ) || $this->weapon['current'] === 'none' ) {
			$this->determine_attack_weapon();
		}
	}


	/**  Armor Class functions  **/

	public function determine_armor_class() {
		if ( $this->armor_type === 11 ) {
			$this->armor_type = max( 0, $this->armor_class );
		}
	}

	public function get_armor_type() {
		return $this->armor_type;
	}

	public function get_armor_class() {
		return $this->armor_class - apply_filters( 'dnd1e_armor_class_adj', 0, $this );
	}


	/**  Weapon functions  **/

	public function determine_attack_weapon( $segment = 0 ) {
		$count   = count( $this->weapons );
		$current = $this->weapon['current'];
		if ( empty( $this->weapons['sequence'] ) || ( ( $count > 1 ) && $this->check_chance( $this->non_sequence_chance( $segment ) ) ) ) {
			$this->set_non_sequence_weapon();
		} else {
			$this->set_sequence_weapon( $this->weapons['sequence'][0] );
		}
		if ( ! ( $current === $this->weapon['current'] ) ) {
			if ( $segment && ! ( $this->is_sequence_attack( $current ) && $this->is_sequence_attack( $this->weapon['current'] ) ) ) {
				$this->segment = $segment;
			}
		}
	}

	protected function set_sequence_weapon( $new ) {
		if ( $this->is_sequence_attack( $new ) ) {
			$this->weapon = $this->get_attack_info( $new );
		}
	}

	protected function set_non_sequence_weapon() {
		$count = count( $this->weapons );
		if ( ( $count > 2 ) || ( ( $count > 1 ) && ( ! array_key_exists( 'sequence', $this->weapons ) ) ) ) {
			$list = array_keys( array_filter( $this->weapons, function( $a ) { if ( empty( $a ) ) return false; return true; } ) );
			$cnt  = count( $list );
			$spot = mt_rand( 1, $cnt ) - 1;
			$weapon = $list[ $spot ];
		} else {
			$weapon = array_key_last( $this->weapons );
		}
		$this->weapon = $this->get_attack_info( $weapon );
	}

	protected function get_attack_info( $new ) {
		if ( empty( $new ) ) return null;
		if ( ! array_key_exists( $new, $this->attacks ) ) return null;
		$info = $this->base_weapon_array( $new, 'PF' );
		$data = $this->get_weapon_info( $info['current'] );
		$info = array_merge( $info, $data );
		$info['damage'] = $this->attacks[ $new ];
		if ( $this->is_sequence_attack( $new ) ) $info['attacks'][0] = count( $this->weapons['sequence'] );
		return $info;
	}

	protected function is_sequence_attack( $check ) {
		return true;
		return in_array( $check, $this->weapons['sequence'] );
	}

	protected function non_sequence_chance( $segment ) {
		return 50;
	}

	public function check_for_weapon_change( $seg ) {
		if ( ( ( $seg - $this->segment ) % 10 ) === 0 ) {
			$this->determine_attack_weapon( $seg );
		}
	}

	public function check_weapon_sequence( $seq, $segment ) {
		if ( apply_filters( 'dnd1e_check_weapon_sequence', false ) ) {
			if ( $this->is_sequence_attack( $this->weapon['current'] ) ) {
				if ( in_array( $segment - 1, $seq ) ) {
					$this->cycle_weapon_sequence( $segment );
				}
			}
		}
	}

	protected function cycle_weapon_sequence( $segment ) {
		$key = array_search( $this->weapon['current'], $this->weapons['sequence'] );
		$key = ( $key + 1 === count( $this->weapons['sequence'] ) ) ? 0: $key + 1;
		$this->weapon['current'] = $this->weapons['sequence'][ $key ];
		$this->weapon['damage']  = $this->attacks[ $this->weapon['current'] ];
	}


	/**  Attack functions  **/

	public function get_to_hit_number( $target, $range = 2000 ) {
		$target_armor = ( $this->weapon['current'] === 'Spell' ) ? $target->get_armor_spell() : $target->get_armor_class();
		$armor_type = min( max( $target_armor, $target->armor_type, 0 ), 10 );
		if ( empty( $this->to_hit_row ) ) $this->determine_to_hit_row();
		$index  = 10 - $target_armor;
		$to_hit = $this->to_hit_row[ $index ];
		if ( $this->weapons_armor_type_check( $target ) && array_key_exists( $armor_type, $this->weapon['type'] ) ) {
			$to_hit -= $this->weapon['type'][ $armor_type ];
		}
		if ( in_array( $this->weapon['attack'], $this->get_weapons_using_missile_adjustment() ) ) {
			$to_hit -= $this->get_missile_range_adjustment( $this->weapon['range'], $range );
		}
		return $to_hit;
	} //*/


}
