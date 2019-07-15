<?php

trait DND_Character_Trait_Weapons {


	static protected $weapons_table;


	private function to_hit_ac_table() {
		return array(
			/*     10   9   8   7   6   5   4   3   2   1   0  -1  -2  -3  -4  -5  -6  -7  -8  -9 -10 */
			array( 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25, 26, 27 ), //  0
			array( 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25, 26 ), //  1
			array( 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25 ), //  2
			array(  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24 ), //  3
			array(  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23 ), //  4
			array(  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22 ), //  5
			array(  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21 ), //  6
			array(  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20 ), //  7
			array(  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20 ), //  8
			array(  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20 ), //  9
			array(  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20 ), // 10
			array(  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20 ), // 11
			array(  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ), // 12
			array( -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ), // 13
			array( -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ), // 14
			array( -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17 ), // 15
			array( -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16 ), // 16
			array( -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15 ), // 17
			array( -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14 ), // 18
			array( -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13 ), // 19
			array( -8, -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12 ), // 20
			array( -9, -8, -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11 ), // 21
			array(-10, -9, -8, -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10 ), // 22
		);
	}



	private function get_weapon_info( $weapon = 'Spell' ) {
		if ( empty( static::$weapons_table ) ) {
			static::$weapons_table = $this->get_weapons_table();
		}
		$info = array();
		if ( isset( static::$weapons_table[ $weapon ] ) ) {
			$info = static::$weapons_table[ $weapon ];
		} else {
			$info = static::$weapons_table['Spell'];
		}
		return $info;
	}

	private function weapons_check( $weapon = 'Spell' ) {
		if ( empty( static::$weapons_table ) ) {
			static::$weapons_table = $this->get_weapons_table();
		}
		return isset( static::$weapons_table[ $weapon ] );
	}

	private function get_weapons_table() {
		return array(
			'Axe,Hand' => array(
				'type'   => array( -5, -4, -3, -2, -2, -1, 0, 0, 1, 1, 1 ),
				'speed'  => 4,
				'damage' => array( '1d6', '1d4', 'Yes' ),
				'attack' => 'hand'
			),
			'Axe,Throwing' => array(
				'type'   => array( -6, -5, -4, -3, -2, -1, -1, 0, 0, 0, 1 ),
				'damage' => array( '1d6', '1d4', 'Yes' ),
				'range'  => array( 10, 20, 30 ),
				'attack' => 'thrown1'
			),
			'Beak' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster'
			),
			'Bite' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster'
			),
			'Bow,Long' => array(
				'type'   => array( -2, -1, -1, 0, 0, 1, 2, 3, 3, 3, 3 ),
				'damage' => array( '1d6', '1d6', 'No' ),
				'range'  => array( 70, 140, 210 ),
				'attack' => 'bow'
			),
			'Bow,Short' => array(
				'type'   => array( -7, -6, -5, -4, -1, 0, 0, 1, 2, 2, 2 ),
				'damage' => array( '1d6', '1d6', 'No' ),
				'range'  => array( 50, 100, 150 ),
				'attack' => 'bow'
			),
			'Breath' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'No' ),
				'attack' => 'breath'
			),
			'Claw' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster'
			),
			'Crossbow,Heavy' => array(
				'type'   => array( -1, 0, 1, 2, 3, 3, 3, 4, 4, 4, 4 ),
				'damage' => array( '1d4+1', '1d6+1', 'No' ),
				'range'  => array( 80, 160, 240 ),
				'attack' => 'hvyXbow',
			),
			'Crossbow,Light' => array(
				'type'   => array( -3, -2, -2, -1, 0, 0, 1, 2, 3, 3, 3 ),
				'damage' => array( '1d4', '1d4', 'No' ),
				'range'  => array( 60, 120, 180 ),
				'attack' => 'lgtXbow'
			),
			'Dagger' => array(
				'type'   => array( -4, -4, -3, -3, -2, -2, 0, 0, 1, 1, 3 ),
				'speed'  => 2,
				'damage' => array( '1d4', '1d3', 'Yes' ),
				'attack' => 'hand'
			),
			'Dagger,Off-Hand' => array(
				'type'   => array( -4, -4, -3, -3, -2, -2, 0, 0, 1, 1, 3 ),
				'speed'  => 2,
				'damage' => array( '1d4', '1d3', 'Yes' ),
				'attack' => 'off-hand'
			),
			'Dagger,Thrown' => array(
				'type'   => array( -7, -6, -5, -4, -3, -2, -1, -1, 0, 0, 1 ),
				'damage' => array( '1d4', '1d3', 'Yes' ),
				'range'  => array( 10, 20, 30 ),
				'attack' => 'thrown2'
			),
			'Dart' => array(
				'type'   => array( -7, -6, -5, -4, -3, -2, -1, 0, 1, 0, 1 ),
				'damage' => array( '1d3', '1d2', 'Yes' ),
				'range'  => array( 15, 30, 45 ),
				'attack' => 'dart'
			),
			'Hammer' => array(
				'type'   => array( 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0 ),
				'speed'  => 4,
				'damage' => array( '1d4+1', '1d4', 'Yes' ),
				'attack' => 'hand'
			),
			'Hammer,Lucern' => array(
				'type'   => array( 0, 1, 1, 1, 2, 2, 2, 1, 1, 0, 0 ),
				'speed'  => 9,
				'damage' => array( '2d4', '1d6', 'Yes' ),
				'attack' => 'two-hand'
			),
			'Javelin' => array(
				'type'   => array( -7, -6, -5, -4, -3, -2, -1, 0, 1, 0, 1 ),
				'damage' => array( '1d6', '1d6', 'Yes' ),
				'range'  => array( 20, 40, 60 ),
				'attack' => 'thrown1'
			),
			'Knife' => array(
				'type'   => array( -6, -5, -5, -4, -3, -2, -1, 0, 1, 1, 3 ),
				'speed'  => 2,
				'damage' => array( '1d3', '1d2', 'Yes' ),
				'attack' => 'hand'
			),
			'Spear' => array(
				'type'   => array( -2, -2, -2, -1, -1, -1, 0, 0, 0, 0, 0 ),
				'speed'  => 7,
				'damage' => array( '1d6', '1d8', 'Yes' ),
				'attack' => 'hand'
			),
			'Spear,Thrown' => array(
				'type'   => array( -4, -4, -3, -3, -2, -2, -1, 0, 0, 0, 0 ),
				'damage' => array( '1d6', '1d8', 'Yes' ),
				'range'  => array( 10, 20, 30 ),
				'attack' => 'thrown1'
			),
			'Spell' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'spec', 'spec', 'No' ),
				'attack' => 'spell'
			),
			'Staff,Quarter' => array(
				'type'   => array( -9, -8, -7, -5, -3, -1, 0, 0, 1, 1, 1 ),
				'speed'  => 4,
				'damage' => array( '1d6', '1d6', 'Yes' ),
				'attack' => 'two-hand'
			),
			'Sword,Bastard' => array(
				'type'   => array( 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1 ),
				'speed'  => 6,
				'damage' => array( '2d4', '2d8', 'Yes' ),
				'attack' => 'hand'
			),
			'Sword,Broad' => array(
				'type'   => array( -5, -4, -3, -2, -1, 0, 0, 0, 1, 1, 1),
				'speed'  => 5,
				'damage' => array( '2d4', '1d6+1', 'Yes' ),
				'attack' => 'hand'
			),
			'Sword,Long' => array(
				'type'   => array( -4, -3, -2, -1, 0, 0, 0, 0, 0, 1, 2 ),
				'speed'  => 5,
				'damage' => array( '1d8', '1d12', 'Yes' ),
				'attack' => 'hand'
			),
			'Sword,Short' => array(
				'type'   => array( -5, -4, -3, -2, -1, 0, 0, 0, 1, 0, 2 ),
				'speed'  => 3,
				'damage' => array( '1d6', '1d8', 'Yes' ),
				'attack' => 'hand'
			),
			'Sword,Two Handed' => array(
				'type'   => array( 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 1 ),
				'speed'  => 10,
				'damage' => array( '1d10', '3d6', 'Yes' ),
				'attack' => 'two-hand'
			),
			'Tail' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster'
			),
			'Voulge' => array(
				'type'   => array( -2, -2, -1, -1, 0, 1, 1, 1, 0, 0, 0 ),
				'speed'  => 10,
				'damage' => array( '2d4', '2d4', 'Yes' ),
				'attack' => 'pole'
			),
		);
	}

	protected function get_weapons_using_strength_bonuses() {
		return array( 'hand', 'monster', 'off-hand', 'pole', 'two-hand' );
	}

	private function get_weapons_using_strength_damage() {
		return array( 'dart', 'hand', 'monster', 'off-hand', 'pole', 'thrown1', 'thrown2', 'two-hand' );
	}

	private function get_weapons_not_allowed_shield() {
		return array( 'bow', 'hvyXbow', 'lgtXbow', 'monster', 'off-hand', 'pole', 'spell', 'two-hand' );
	}

	private function get_weapons_using_missile_adjustment() {
		return array( 'bow', 'breath', 'dart', 'hvyXbow', 'lgtXbow', 'thrown1', 'thrown2' );
	}

	private function get_weapon_attacks_array( $type ) {
		$table = array();
		switch( $type ) {
			case 'dart':
				$table = array( [ 3, 1 ], [ 4, 1 ], [ 5, 1 ], [ 6, 1 ], [ 7, 1 ] );
				break;
			case 'bow':
			case 'thrown2':
				$table = array( [ 2, 1 ], [ 3, 1 ], [ 4, 1 ], [ 5, 1 ], [ 6, 1 ] );
				break;
			case 'hvyXbow':
				$table = array( [ 1, 2 ], [ 2, 3 ], [ 1, 1 ], [ 3, 2 ], [ 2, 1 ] );
				break;
			default:
				$table = array( [ 1, 1 ], [ 3, 2 ], [ 2, 1 ], [ 5, 2 ], [ 3, 1 ] );
		}
		return $table;
	}

	protected function get_weapon_attacks_per_round_index( $skill = 'NP' ) {
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
#echo "#atts: $index {$this->name}\n";
		return $index;
	}

	private function get_weapon_proficiency_bonus( $skill, $desire = 'hit' ) {
		$bonus = 0;
		switch( $skill ) {
			case 'NP':
				$bonus = ( $desire === 'hit' ) ? $this->non_prof : 0;
				break;
			case 'SP':
				$bonus = ( $desire === 'hit' ) ? 1 : 2;
				break;
			case 'DS':
				$bonus = 3;
				break;
			default:
		}
		return $bonus;
	}

	private function get_weapon_type_adjustment( $weapon, $type ) {
		$info = $this->get_weapon_info( $weapon );
		return $info['type'][ $type ];
	}

	private function get_missile_proficiency_bonus( $weapon, $range, $desire = 'hit' ) {
		$bonus = $this->get_weapon_proficiency_bonus( $weapon['skill'], $desire );
		if ( ( $bonus > 0 ) && ( $range > 0 ) ) {
			if ( $weapon['attack'] === 'bow' ) {
				if ( $range < 31 ) {
					$bonus = 2;
				} else if ( $range < $weapon['range'][0] ) {
					$bonus = 1;
				}
			} else if ( $weapon['attack'] === 'lgtXbow' ) {
				if ( $range < 61 ) {
					$bonus = 2;
				} else if ( $range < $weapon['range'][0] ) {
					$bonus = 1;
				} else if ( $range < $weapon['range'][1] ) {
					$bonus = ( $desire === 'hit' ) ? 1 : 0;
				}
			} else {
				$bonus = ( $desire === 'hit' ) ? 1 : 2;
			}
		}
		return $bonus;
	}

	private function get_missile_range_adjustment( $ranges, $actual ) {
		$adjust = 0;
		if ( $actual > ( $ranges[2] * 2 ) ) {
			$adjust = -30;
		} else if ( $actual > $ranges[2] ) {
			$adjust = -13;
		} else if ( $actual > $ranges[1] ) {
			$adjust = -5;
		} else if ( $actual > $ranges[0] ) {
			$adjust = -2;
		}
		return $adjust;
	}


}
