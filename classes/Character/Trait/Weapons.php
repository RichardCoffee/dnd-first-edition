<?php

if ( ! defined( 'BOW_POINT_BLANK' ) ) {
	define( 'BOW_POINT_BLANK',      31 );
	define( 'CROSSBOW_POINT_BLANK', 61 );
}

trait DND_Character_Trait_Weapons {

#  Would love to do this, but traits cannot have constants.
#	private const BOW_POINT_BLANK = 31;
#	private const CROSSBOW_POINT_BLANK = 61;

	protected $weap_allow = array();
	protected $weap_dual  = false;
	protected $weapon     = array( 'current' => 'none', 'skill' => 'NP', 'attacks' => [ 1, 1 ], 'bonus' => 0 );
	protected $weapons    = array();
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

	protected function weapons_armor_type_check( $target ) {
		if ( $target instanceOf DND_Character_Character ) return true;
		if ( ! ( $target instanceOf DND_Monster_Humanoid_Humanoid ) ) return false;
		if ( ! ( $target->armor_type === $target->armor_class ) ) return true;
		return false;
	}

	protected function set_character_weapon( $new ) {
		if ( empty ( $new ) ) return false;
		if ( ! $this->weapons_check( $new ) ) return false;
		if ( ! empty( $this->weap_allow ) && ! in_array( $new, $this->weap_allow ) ) return false;
		$this->weapon = $this->base_weapon_array( $new );
		if ( ( ! empty( $this->weapons ) ) && array_key_exists( $new, $this->weapons ) ) {
			$this->weapon = array_merge( $this->weapon, $this->weapons[ $new ] );
		} else {
			// TODO: show alert for non-proficient weapon use
		}
		$data = $this->get_weapon_info( $this->weapon['current'] );
		$this->weapon = array_merge( $this->weapon, $data );
		$this->weapon['attacks'] = $this->get_weapon_attacks_per_round( $this->weapon );
		if ( $this->weap_dual ) $this->set_current_weapon_dual();
		$this->determine_armor_class();
		return true;
	}

	protected function base_weapon_array( $new, $skill = 'NP' ) {
		return array( 'current' => $new, 'skill' => $skill, 'attacks' => array( 1, 1 ), 'bonus' => 0 );
	}

	private function weapons_check( $weapon = 'Spell' ) {
		if ( empty( static::$weapons_table ) ) {
			static::$weapons_table = $this->get_weapons_table();
		}
		if ( ! empty( $this->weap_allow ) ) {
			foreach( [ 'Stunned', 'Immobilized' ] as $state ) {
				$this->add_to_allowed_weapons( $state );
			}
		}
		return array_key_exists( $weapon, static::$weapons_table );
	}

	protected function get_weapon_info( $weapon = 'Spell' ) {
		if ( empty( static::$weapons_table ) ) {
			static::$weapons_table = $this->get_weapons_table();
		}
		$info  = static::$weapons_table['Bite'];
		$check = substr( $weapon, 0, 4 );
		if ( in_array( $check, [ 'Bite', 'Claw', 'Horn' ] ) ) {
			$weapon = $check;
		}
		if ( array_key_exists( $weapon, static::$weapons_table ) ) {
			$info = static::$weapons_table[ $weapon ];
		}
		return $info;
	}

	protected function get_random_pole_arm() {
		static $pole_arms = array();
		if ( empty( static::$weapons_table ) ) {
			static::$weapons_table = $this->get_weapons_table();
		}
		if ( empty( $pole_arms ) ) {
			foreach( static::$weapons_table as $weapon => $data ) {
				if ( $data['attack'] === 'pole' ) {
					$pole_arms[] = $weapon;
				}
			}
		}
		$cnt  = count( $pole_arms ) - 1;
		$roll = mt_rand( 0, $cnt );
		return $pole_arms[ $roll ];
	}

	private function get_weapons_table() {
		return array(
			'Axe,Battle' => array(
				'type'   => array( -5, -4, -3, -2, -1, -1, 0, 0, 1, 1, 2 ),
				'speed'  => 7,
				'damage' => array( '1d8', '1d8', 'Yes' ),
				'attack' => 'hand'
			),
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
			'Bardiche' => array(
				'type'   => array( -3, -2, -2, -1, 0, 0, 1, 1, 2, 2, 3 ),
				'speed'  => 9,
				'damage' => array( '2d4', '3d4', 'Yes' ),
				'attack' => 'pole'
			),
			'Beak' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 2,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster'
			),
			'Bec de Corbin' => array(
				'type'   => array( 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, -1 ),
				'speed'  => 9,
				'damage' => array( '1d8', '1d6', 'Yes' ),
				'attack' => 'pole'
			),
			'Bill-Guisarme' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0 ),
				'speed'  => 10,
				'damage' => array( '2d4', '1d10', 'Yes' ),
				'attack' => 'pole'
			),
			'Bite' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 3,
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
				'attack' => 'spell'
			),
			'Claw' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 4,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster'
			),
			'Club' => array(
				'type'   => array( -7, -6, -5, -4, -3, -2, -1, -1, 0, 0, 1 ),
				'speed'  => 4,
				'damage' => array( '1d6', '1d3', 'Yes' ),
				'attack' => 'hand'
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
			'Flail,Foot' => array(
				'type'   => array( 3, 3, 2, 2, 1, 2, 1, 1, 1, 1, -1 ),
				'speed'  => 7,
				'damage' => array( '1d6+1', '2d4', 'Yes' ),
				'attack' => 'hand',
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
			'Horn' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 3,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster'
			),
			'Immobilized' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 10,
				'damage' => array( 'spec', 'spec', 'No' ),
				'attack' => 'immobilized'
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
			'Stunned' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 10,
				'damage' => array( 'spec', 'spec', 'No' ),
				'attack' => 'stunned'
			),
			'Sword,Bastard' => array(
				'type'   => array( 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1 ),
				'speed'  => 6,
				'damage' => array( '2d4', '2d8', 'Yes' ),
				'attack' => 'two-hand'
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
				'speed'  => 5,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster'
			),
			'Voice' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'No' ),
				'range'  => array( 10, 20, 30 ),
				'attack' => 'spell'
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
		return array( 'bow', 'hvyXbow', 'immobilized', 'lgtXbow', 'monster', 'off-hand', 'pole', 'prone', 'spell', 'stunned', 'two-hand' );
	}

	private function get_weapons_using_missile_adjustment() {
		return array( 'bow', 'dart', 'hvyXbow', 'lgtXbow', 'thrown1', 'thrown2' );
	}

	protected function get_weapon_attacks_per_round( $weapon, $opponent = null ) {
		$atts  = $this->get_weapon_attacks_array( $weapon['attack'] );
		$index = $this->get_weapon_attacks_per_round_index( $weapon['skill'] );
		return $atts[ $index ];
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
			case 'stunned':
			case 'immobilized':
				$table = array( [ 0, 1 ], [ 0, 1 ], [ 0, 1 ], [ 0, 1 ], [ 0, 1 ] );
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
		return $index;
	}

	public function get_attack_sequence( $rounds ) {
		$seqent = array();
		if ( $this->weapon['attacks'][0] > 0 ) {
			$segment  = $this->segment;
			$interval = 10 / ( $this->weapon['attacks'][0] / $this->weapon['attacks'][1] );
			do {
				$seqent[] = intval( round( $segment ) );
				$segment += $interval;
			} while( $segment < ( ( $rounds * 10 ) + 1 ) );
		}
		return $seqent;
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
		$bonus = 0;
		$check = $this->get_weapon_proficiency_bonus( $weapon['skill'], $desire );
		if ( ( $check > 0 ) && ( $range > 0 ) ) {
			if ( $weapon['attack'] === 'bow' ) {
				if ( $range < BOW_POINT_BLANK ) {
					$bonus = 2;
				} else if ( $range < $weapon['range'][0] ) {
					$bonus = 1;
				}
			} else if ( substr( $weapon['attack'], 3 ) === 'Xbow' ) {
				if ( $range < CROSSBOW_POINT_BLANK ) {
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

	protected function get_weapon_damage_array( $weapon, $target = 'SM' ) {
		$info = $this->get_weapon_info( $weapon );
		$base = ( $target === 'SM' ) ? $info['damage'][0] : $info['damage'][1];
		$base = str_replace( [ 'd', '+' ], ',', $base );
		$dam  = explode( ',', $base );
		if ( count( $dam ) < 2 ) $dam[] = 0;
		if ( count( $dam ) < 3 ) $dam[] = 0;
		return $dam;
	}

	public function add_to_allowed_weapons( $new ) {
		if ( array_key_exists( $new, static::$weapons_table ) ) {
			if ( ! in_array( $new, $this->weap_allow ) ) {
				$this->weap_allow[] = $new;
			}
		}
	}

	/**  Dual Weapon functions  **/

	public function is_off_hand_weapon() {
		if ( $this->weap_dual && array_key_exists( 1, $this->weap_dual ) ) {
			if ( ( $this->weapon['current'] === $this->weap_dual[1] ) ) {
				return true;
			}
		}
		return false;
	}

	public function set_primary_weapon() {
		if ( array_key_exists( 0, $this->weap_dual ) ) {
			$this->set_current_weapon( $this->weap_dual[0] );
		}
	}

	public function set_dual_weapon() {
		if ( array_key_exists( 1, $this->weap_dual ) ) {
			$this->set_current_weapon( $this->weap_dual[1] );
		}
	}

	protected function set_current_weapon_dual() {
		if ( in_array( $this->weapon['current'], $this->weap_dual ) ) {
			if ( stripos( $this->weapon['current'], 'off-hand' ) ) {
				$primary  = $this->weap_dual[0];
				$priminfo = $this->get_weapon_info( $primary );
				$primatt  = $this->get_weapon_attacks_array( $priminfo['attack'] );
				$primidx  = $this->get_weapon_attacks_per_round_index( $this->weapons[ $primary ]['skill'] );
				$prime    = $primatt[ $primidx ];
				if ( $prime[1] === $this->weapon['attacks'][1] ) {
					$this->weapon['attacks'][0] += $prime[0];
				} else {
					$this->weapon['attacks'][0] += ( $prime[1] === 2 ) ? ( $this->weapon['attacks'][0] + $prime[0] ) : ( $prime[0] * 2 ) ;
					$this->weapon['attacks'][1] += ( $prime[1] === 2 ) ? 1 : 0;
				}
			}
		}
	}

	public function assign_damage( $damage, $segment, $type = '' ) {
		$this->current_hp -= $damage;
	}


}
