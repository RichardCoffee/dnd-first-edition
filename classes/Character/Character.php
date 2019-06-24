<?php

abstract class DND_Character_Character {

	protected $attacks = '1/1';
	protected $current = '';
	protected $experience = 0;
	protected $level = 1;
	protected $non_proficiency = -100;
	protected $skill = 'NP';
	protected $to_hit_ac = array();
	protected $weapon = array();
	protected $weapons = array();

	use DND_Trait_ParseArgs;
	use DND_Trait_Weapons;

	abstract protected function to_hit_ac_row();

	public function __construct( $args = array() ) {
		$this->parse_args( $args );
		$this->set_current_weapon( $this->current );
		$this->to_hit_ac = $this->to_hit_ac_row();
	}

	protected function set_current_weapon( $new = '' ) {
		if ( ! empty ( $new ) ) {
			$this->current = $new;
			$this->skill   = 'NP';
			if ( ! empty( $this->weapons ) ) {
				foreach ( $this->weapons as $weapon => $skill ) {
					if ( $weapon === $new ) {
						$this->current = $weapon;
						$this->skill   = $skill;
						break;
					}
				}
			}
			$this->load_current_weapon();
		}
	}

	protected function load_current_weapon() {
		$this->weapon  = $this->get_weapon_info( $this->current );
		$attacks = $this->get_weapon_attacks_array( $this->weapon['Attacks'] );
		$index   = $this->get_weapon_attacks_index( $this->skill );
		$this->attacks = $attacks[ $index ];
	}

	protected function get_weapon_attacks_index( $skill = 'NP' ) {
		$index = 0;
		switch( $skill ) {
			case 'DS':
				$index = 2;
				break;
			case 'SP':
				$index = 1;
				break;
			case 'NP':
			case 'PF':
			default:
				$index = 0;
		}
		return $index;
	}

	protected function to_hit_ac_table() {
		return array(
			/*     10   9   8   7   6   5   4   3   2   1   0  -1  -2  -3  -4  -5  -6  -7  -8  -9 -10 */
			array( 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25, 26 ), //  0
			array( 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25 ), //  1
			array(  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24 ), //  2
			array(  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23 ), //  3
			array(  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22 ), //  4
			array(  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21 ), //  5
			array(  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20 ), //  6
			array(  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20 ), //  7
			array(  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20 ), //  8
			array(  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20 ), //  9
			array(  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20 ), // 10
			array(  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ), // 11
			array( -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ), // 12
		);
	}

	public function get_to_hit_number( $target_ac, $target_at = -1 ) {
		$target_at = max( $target_ac, $target_at, 0 );
		return $this->get_to_hit_base( $target_ac ) - $this->get_weapon_adjustment( $target_at );
	}

	protected function get_to_hit_base( $target_ac = 10 ) {
		$ac_index = 10 - $target_ac;
		if ( isset( $this->to_hit_ac[ $ac_index ] ) ) {
			return $this->to_hit_ac[ $ac_index ];
		}
		return 10000;
	}

	protected function get_weapon_adjustment( $target_at ) {
		return $this->weapon['ACType'][ $target_at ];
	}

}
