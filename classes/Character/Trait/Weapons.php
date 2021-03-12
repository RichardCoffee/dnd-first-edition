<?php

if ( ! defined( 'BOW_POINT_BLANK' ) ) {
	define( 'BOW_POINT_BLANK',      31 );
	define( 'CROSSBOW_POINT_BLANK', 61 );
}

trait DND_Character_Trait_Weapons {


	protected $weap_allow = array();
	protected $weap_dual  = false;
	protected $weapon     = array( 'current' => 'none', 'skill' => 'NP', 'attacks' => [ 1, 1 ], 'bonus' => 0, 'attack' => 'none' );
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
		if ( ! ( $target->armor['armor'] === 'none' ) ) return true;
		return false;
	}

	protected function set_character_weapon( $new ) {
		if ( empty ( $new ) ) return false;
		$name = ( is_object( $new ) ) ? $new->typepub : $new;
		if ( ! $this->weapons_check( $name ) )     return false;
		if ( ! $this->is_allowed_weapon( $name ) ) return false;
		$weapon = $this->get_merged_weapon_info( $name );
		if ( is_object( $new ) ) $weapon = $new->merge_gear_info( $weapon );
		$this->weapon = ( $this->weap_dual ) ? $this->set_current_weapon_dual( $weapon ) : $weapon;
		return true;
	}

	private function weapons_check( $weapon = 'Spell' ) {
		if ( empty( static::$weapons_table ) ) static::$weapons_table = $this->get_weapons_table();
		if ( ! empty( $this->weap_allow ) ) {
			$conds = $this->state_weapon_entries( true );
			foreach( $conds as $state ) {
				$this->add_to_allowed_weapons( $state );
			}
		}
		return array_key_exists( $weapon, static::$weapons_table );
	}

	protected function get_merged_weapon_info( $name ) {
		$weapon = $this->base_weapon_array( $name );
		if ( array_key_exists( $name, $this->weapons ) ) $weapon = array_merge( $weapon, $this->weapons[ $name ] );
		$weapon = array_merge( $weapon, $this->get_weapon_info( $name ) );
		$weapon['attacks'] = $this->get_weapon_attacks_per_round( $weapon );
		return $weapon;
	}

	protected function base_weapon_array( $name, $skill = 'NP' ) {
		return array(
			'current' => $name,
			'skill'   => $skill,
			'attacks' => array( 1, 1 ),
			'bonus'   => 0,
			'attack'  => 'none'
		);
	}

	protected function get_weapon_info( $weapon = 'Spell' ) {
		if ( empty( static::$weapons_table ) ) static::$weapons_table = $this->get_weapons_table();
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
		if ( empty( static::$weapons_table ) ) static::$weapons_table = $this->get_weapons_table();
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

	public function get_weapon_effect( $weapon ) {
		if ( empty( static::$weapons_table ) ) static::$weapons_table = $this->get_weapons_table();
		if ( array_key_exists( $weapon, static::$weapons_table ) ) {
			if ( array_key_exists( 'effect', static::$weapons_table[ $weapon ] ) ) {
				return static::$weapons_table[ $weapon ]['effect'];
			}
		}
		return 'none';
	}

	private function get_weapons_table() {
		$weapons = array(
			'Axe,Battle' => array(
				'type'   => array( -5, -4, -3, -2, -1, -1, 0, 0, 1, 1, 2 ),
				'speed'  => 7,
				'reach'  => 4,
				'damage' => array( '1d8', '1d8', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Axe,Hand' => array(
				'type'   => array( -5, -4, -3, -2, -2, -1, 0, 0, 1, 1, 1 ),
				'speed'  => 4,
				'reach'  => 1,
				'damage' => array( '1d6', '1d4', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Axe,Throwing' => array(
				'type'   => array( -6, -5, -4, -3, -2, -1, -1, 0, 0, 0, 1 ),
				'damage' => array( '1d6', '1d4', 'Yes' ),
				'range'  => array( 10, 20, 30 ),
				'attack' => 'thrown1',
				'effect' => 'slash',
			),
			'Bardiche' => array(
				'type'   => array( -3, -2, -2, -1, 0, 0, 1, 1, 2, 2, 3 ),
				'speed'  => 9,
				'reach'  => 5,
				'damage' => array( '2d4', '3d4', 'Yes' ),
				'attack' => 'pole',
				'effect' => 'slash',
			),
			'Beak' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 2,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster',
				'effect' => 'pierce',
			),
			'Bec de Corbin' => array(
				'type'   => array( 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, -1 ),
				'speed'  => 9,
				'reach'  => 6,
				'damage' => array( '1d8', '1d6', 'Yes' ),
				'attack' => 'pole',
				'effect' => 'slash',
			),
			'Bill-Guisarme' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0 ),
				'speed'  => 10,
				'reach'  => 8,
				'damage' => array( '2d4', '1d10', 'Yes' ),
				'attack' => 'pole',
				'effect' => 'slash',
			),
			'Bite' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 3,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster',
				'effect' => 'slash',
			),
			'Bow,Long' => array(
				'type'   => array( -2, -1, -1, 0, 0, 1, 2, 3, 3, 3, 3 ),
				'damage' => array( '1d6', '1d6', 'No' ),
				'range'  => array( 70, 140, 210 ),
				'attack' => 'bow',
				'effect' => 'pierce',
			),
			'Bow,Short' => array(
				'type'   => array( -7, -6, -5, -4, -1, 0, 0, 1, 2, 2, 2 ),
				'damage' => array( '1d6', '1d6', 'No' ),
				'range'  => array( 50, 100, 150 ),
				'attack' => 'bow',
				'effect' => 'pierce',
			),
			'Breath' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'No' ),
				'attack' => 'spell',
			),
			'Claw' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 4,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster',
				'effect' => 'slash',
			),
			'Club' => array(
				'type'   => array( -7, -6, -5, -4, -3, -2, -1, -1, 0, 0, 1 ),
				'speed'  => 4,
				'reach'  => 3,
				'damage' => array( '1d6', '1d3', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'crush',
			),
			'Crossbow,Hand' => array(
				'type'   => array( -6, -4, -2, -1, 0, 0, 0, 1, 2, 2, 3 ),
				'damage' => array( '1d3', '1d2', 'No' ),
				'range'  => array( 20, 40, 60 ),
				'attack' => 'handXbow',
				'effect' => 'pierce',
			),
			'Crossbow,Heavy' => array(
				'type'   => array( -1, 0, 1, 2, 3, 3, 3, 4, 4, 4, 4 ),
				'damage' => array( '1d4+1', '1d6+1', 'No' ),
				'range'  => array( 80, 160, 240 ),
				'attack' => 'hvyXbow',
				'effect' => 'pierce',
			),
			'Crossbow,Light' => array(
				'type'   => array( -3, -2, -2, -1, 0, 0, 1, 2, 3, 3, 3 ),
				'damage' => array( '1d4', '1d4', 'No' ),
				'range'  => array( 60, 120, 180 ),
				'attack' => 'lgtXbow',
				'effect' => 'pierce',
			),
			'Dagger' => array(
				'type'   => array( -4, -4, -3, -3, -2, -2, 0, 0, 1, 1, 3 ),
				'speed'  => 2,
				'reach'  => 1,
				'damage' => array( '1d4', '1d3', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Dagger,Off-Hand' => array(
				'type'   => array( -4, -4, -3, -3, -2, -2, 0, 0, 1, 1, 3 ),
				'speed'  => 2,
				'reach'  => 1,
				'damage' => array( '1d4', '1d3', 'Yes' ),
				'attack' => 'off-hand',
				'effect' => 'slash',
			),
			'Dagger,Thrown' => array(
				'type'   => array( -7, -6, -5, -4, -3, -2, -1, -1, 0, 0, 1 ),
				'damage' => array( '1d4', '1d3', 'Yes' ),
				'range'  => array( 10, 20, 30 ),
				'attack' => 'thrown2',
				'effect' => 'pierce',
			),
			'Dart' => array(
				'type'   => array( -7, -6, -5, -4, -3, -2, -1, 0, 1, 0, 1 ),
				'damage' => array( '1d3', '1d2', 'Yes' ),
				'range'  => array( 15, 30, 45 ),
				'attack' => 'dart',
				'effect' => 'pierce',
			),
			'Flail,Foot' => array(
				'type'   => array( 3, 3, 2, 2, 1, 2, 1, 1, 1, 1, -1 ),
				'speed'  => 7,
				'reach'  => 6,
				'damage' => array( '1d6+1', '2d4', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Flail,Horse' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0 ),
				'speed'  => 6,
				'reach'  => 4,
				'damage' => array( '1d4+1', '1d4+1', 'Yes' ),
				'attack' => 'horse',
				'effect' => 'slash',
			),
			'Halberd' => array(
				'type'   => array( 0, 1, 1, 1, 1, 2, 2, 2, 1, 1, 0 ),
				'speed'  => 9,
				'reach'  => 5,
				'damage' => array( '1d10', '2d6', 'Yes' ),
				'attack' => 'pole',
				'effect' => 'slash',
			),
			'Hammer' => array(
				'type'   => array( 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0 ),
				'speed'  => 4,
				'reach'  => 2,
				'damage' => array( '1d4+1', '1d4', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'crush',
			),
			'Hammer,Lucern' => array(
				'type'   => array( 0, 1, 1, 1, 2, 2, 2, 1, 1, 0, 0 ),
				'speed'  => 9,
				'reach'  => 5,
				'damage' => array( '2d4', '1d6', 'Yes' ),
				'attack' => 'two-hand',
				'effect' => 'crush',
			),
			'Horn' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 3,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster',
				'effect' => 'pierce',
			),
			'Javelin' => array(
				'type'   => array( -7, -6, -5, -4, -3, -2, -1, 0, 1, 0, 1 ),
				'damage' => array( '1d6', '1d6', 'Yes' ),
				'range'  => array( 20, 40, 60 ),
				'attack' => 'thrown1',
				'effect' => 'pierce',
			),
			'Knife' => array(
				'type'   => array( -6, -5, -5, -4, -3, -2, -1, 0, 1, 1, 3 ),
				'speed'  => 2,
				'reach'  => 1,
				'damage' => array( '1d3', '1d2', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Knife,Thrown' => array(
				'type'   => array( -8, -7, -6, -5, -4, -3, -2, -1, 0, 0, 1 ),
				'damage' => array( '1d3', '1d2', 'Yes' ),
				'range'  => array( 10, 20, 30 ),
				'attack' => 'thrown2',
				'effect' => 'pierce',
			),
			'Mace,Foot' => array(
				'type'   => array( 2, 2, 1, 1, 0, 0, 0, 0, 0, 1, -1 ),
				'speed'  => 7,
				'reach'  => 4,
				'damage' => array( '1d6+1', '1d6', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'crush',
			),
			'Mace,Horse' => array(
				'type'   => array( 2, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 6,
				'reach'  => 2,
				'damage' => array( '1d6', '1d4', 'Yes' ),
				'attack' => 'horse',
				'effect' => 'crush',
			),
			'Morning Star' => array(
				'type'   => array( 0, 0, 0, 1, 1, 1, 1, 1, 1, 2, 2 ),
				'speed'  => 7,
				'reach'  => 5,
				'damage' => array( '2d4', '1d6+1', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'crush',
			),
			'Pick,Foot' => array(
				'type'   => array( 3, 3, 2, 2, 1, 1, 0, -1, -1, -1, -2 ),
				'speed'  => 7,
				'reach'  => 4,
				'damage' => array( '1d6+1', '2d4', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Pick,Horse' => array(
				'type'   => array( 2, 2, 1, 1, 1, 1, 0, 0, -1, -1, -1 ),
				'speed'  => 5,
				'reach'  => 2,
				'damage' => array( '1d4+1', '1d4', 'Yes' ),
				'attack' => 'horse',
				'effect' => 'slash',
			),
			'Scimitar' => array(
				'type'   => array( -4, -3, -3, -2, -2, -1, 0, 0, 1, 1, 3 ),
				'speed'  => 4,
				'reach'  => 2,
				'damage' => array( '1d8', '1d8', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Sling' => array(
				'type'   => array( -7, -6, -5, -4, -2, -1, 0, 0, 2, 1, 3 ),
				'damage' => array( '1d4', '1d4', 'Yes' ),
				'range'  => array( 40, 80, 160 ),
				'attack' => 'thrown1',
				'effect' => 'crush',
			),
			'Spear' => array(
				'type'   => array( -2, -2, -2, -1, -1, -1, 0, 0, 0, 0, 0 ),
				'speed'  => 7,
				'reach'  => 5,
				'damage' => array( '1d6', '1d8', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'pierce',
			),
			'Spear,Thrown' => array(
				'type'   => array( -4, -4, -3, -3, -2, -2, -1, 0, 0, 0, 0 ),
				'damage' => array( '1d6', '1d8', 'Yes' ),
				'range'  => array( 10, 20, 30 ),
				'attack' => 'thrown1',
				'effect' => 'pierce',
			),
			'Spell' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'No' ),
				'attack' => 'spell',
			),
			'Staff,Quarter' => array(
				'type'   => array( -9, -8, -7, -5, -3, -1, 0, 0, 1, 1, 1 ),
				'speed'  => 4,
				'reach'  => 7,
				'damage' => array( '1d6', '1d6', 'Yes' ),
				'attack' => 'two-hand',
				'effect' => 'crush',
			),
			'Stinger' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 5,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster',
				'effect' => 'pierce',
			),
			'Sword,Bastard' => array(
				'type'   => array( 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1 ),
				'speed'  => 6,
				'reach'  => 4,
				'damage' => array( '2d4', '2d8', 'Yes' ),
				'attack' => 'two-hand',
				'effect' => 'slash',
			),
			'Sword,Broad' => array(
				'type'   => array( -5, -4, -3, -2, -1, 0, 0, 0, 1, 1, 1),
				'speed'  => 5,
				'reach'  => 4,
				'damage' => array( '2d4', '1d6+1', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Sword,Long' => array(
				'type'   => array( -4, -3, -2, -1, 0, 0, 0, 0, 0, 1, 2 ),
				'speed'  => 5,
				'reach'  => 3,
				'damage' => array( '1d8', '1d12', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Sword,Short' => array(
				'type'   => array( -5, -4, -3, -2, -1, 0, 0, 0, 1, 0, 2 ),
				'speed'  => 3,
				'reach'  => 2,
				'damage' => array( '1d6', '1d8', 'Yes' ),
				'attack' => 'hand',
				'effect' => 'slash',
			),
			'Sword,Two Handed' => array(
				'type'   => array( 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 1 ),
				'speed'  => 10,
				'reach'  => 6,
				'damage' => array( '1d10', '3d6', 'Yes' ),
				'attack' => 'two-hand',
				'effect' => 'slash',
			),
			'Tail' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 5,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster',
				'effect' => 'slash',
			),
			'Touch' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 5,
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'monster',
				'effect' => 'slash',
			),
			'Turn Undead' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'Yes' ),
				'attack' => 'cleric',
				'effect' => 'undead',
			),
			'Voice' => array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'damage' => array( 'Spec', 'Spec', 'No' ),
				'range'  => array( 10, 20, 30 ),
				'attack' => 'spell',
			),
			'Voulge' => array(
				'type'   => array( -2, -2, -1, -1, 0, 1, 1, 1, 0, 0, 0 ),
				'speed'  => 10,
				'reach'  => 8,
				'damage' => array( '2d4', '2d4', 'Yes' ),
				'attack' => 'pole',
				'effect' => 'slash',
			),
		);
		$states = $this->state_weapon_entries();
		return $weapons + $states;
	}

	public function state_weapon_entries( $raw = false ) {
		$conditions = array( 'Immobilized', 'Poisoned', 'Stunned' );
		if ( $raw ) return $conditions;
		$entries = array();
		foreach( $conditions as $state ) {
			$entries[ $state ] = array(
				'type'   => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'speed'  => 10,
				'damage' => array( 'None', 'None', 'No' ),
				'attack' => strtolower( $state ),
			);
		}
		return $entries;
	}


	/**  Status functions  **/

	protected function get_weapons_using_strength_bonuses() {
		return array( 'hand', 'horse', 'monster', 'off-hand', 'pole', 'two-hand' );
	}

	private function get_weapons_using_strength_damage() {
		return array( 'dart', 'hand', 'horse', 'monster', 'off-hand', 'pole', 'thrown1', 'thrown2', 'two-hand' );
	}

	protected function get_weapons_not_allowed_shield() {
		return array( 'bow', 'hvyXbow', 'immobilized', 'lgtXbow', 'monster', 'off-hand', 'pole', 'prone', 'spell', 'stunned', 'two-hand' );
	}

	private function get_weapons_using_missile_adjustment() {
		return array( 'bow', 'dart', 'handXbow', 'hvyXbow', 'lgtXbow', 'thrown1', 'thrown2' );
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

	public function get_attack_sequence( $rounds, $weapon = array() ) {
		$seqent = array();
		if ( $weapon['attacks'][0] > 0 ) {
			$segment  = $this->segment;
			$interval = 10 / ( $weapon['attacks'][0] / $weapon['attacks'][1] );
			do {
				$seqent[] = intval( round( $segment ) );
				$segment += $interval;
			} while( $segment < ( ( $rounds * 10 ) + 1 ) );
		}
		return $seqent;
	}

	public function set_next_attack_segment( $current ) {
		$rounds   = intval( floor( $current / 10 ) ) + 2;
		$sequence = $this->get_attack_sequence( $rounds, $this->weapon );
		foreach( $sequence as $seg ) {
			if ( $current > $seg ) continue;
			$this->segment = $seg;
			break;
		}
	}


	/**  Bonus functions  **/

	protected function get_weapon_proficiency_bonus( $skill, $desire = 'hit' ) {
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

	private function check_for_point_blank_range( $weapon, $range ) {
		if ( $weapon['attack'] === 'bow' ) {
			if ( $range < BOW_POINT_BLANK ) {
				add_filter( 'dnd1e_damage_to_target', [ $this, 'bow_double_damage' ], 20, 3 );
			}
		} else if ( substr( $weapon['attack'], 3 ) === 'Xbow' ) {
			if ( $range < CROSSBOW_POINT_BLANK ) {
				add_filter( 'dnd1e_damage_to_target', [ $this, 'bow_double_damage' ], 20, 3 );
			}
		}
	}

	public function bow_double_damage( $damage, $target, $type ) {
		return $damage * 2;
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

	public function get_weapon_damage_array( $weapon, $target = 'SM' ) {
		$info = $this->get_weapon_info( $weapon );
		$base = ( $target === 'SM' ) ? $info['damage'][0] : $info['damage'][1];
		$base = str_replace( [ 'd', '+' ], ',', $base );
		$dam  = explode( ',', $base );
		if ( count( $dam ) < 2 ) $dam[] = 0;
		if ( count( $dam ) < 3 ) $dam[] = 0;
		return $dam;
	}

	public function get_weapon_damage_bonus( $target = null, $range = -1 ) {
		$bonus = $this->weapon_damage_bonus( $this->weapon, $target, $range );
		return apply_filters( 'dnd1e_weapon_damage_bonus', $bonus, $this, $target );
	}

	protected function weapon_damage_bonus( $weapon, $target, $range ) {
		$bonus = 0;
		if ( in_array( $weapon['attack'], $this->get_weapons_using_missile_adjustment() ) ) {
			$bonus += $this->get_missile_proficiency_bonus( $weapon, $range, 'damage' );
			$this->check_for_point_blank_range( $weapon, $range );
		}
		if ( in_array( $weapon['attack'], $this->get_weapons_using_strength_damage() ) ) {
			if ( array_key_exists( 'str', $this->stats ) ) {
				$bonus += $this->get_strength_damage_bonus( $this->stats['str'] );
			}
		}
		$bonus += $this->get_weapon_proficiency_bonus( $weapon['skill'], 'damage' );
		$bonus += $weapon['bonus'];
		return $bonus;
	}


	/**  Allowed Weapons functions  **/

	public function add_to_allowed_weapons( $new ) {
		if ( empty( static::$weapons_table ) ) static::$weapons_table = $this->get_weapons_table();
		if ( array_key_exists( $new, static::$weapons_table ) ) {
			if ( ! in_array( $new, $this->weap_allow ) ) {
				$this->weap_allow[] = $new;
			}
		}
	}

	protected function is_allowed_weapon( $name ) {
		if ( ! empty( $this->weap_allow ) && ! in_array( $name, $this->weap_allow ) ) return false;
		return true;
	}

	public function is_dual_weapon() {
		if ( $this->weap_dual && in_array( $this->weapon['current'], $this->weap_dual ) ) {
			if ( property_exists( $this, 'weap_twins' ) && ( count( $this->weap_twins ) === 2 ) ) {
				return true;
			}
		}
		return false;
	}


}
