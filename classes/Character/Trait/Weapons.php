<?php

trait DND_Character_Trait_Weapons {


	static protected $weapons_table;


	private function get_weapon_info( $weapon = 'Spell' ) {
		if ( empty( static::$weapons_table ) ) {
			static::$weapons_table = $this->get_weapons_adjustments_table();
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
			static::$weapons_table = $this->get_weapons_adjustments_table();
		}
		return isset( static::$weapons_table[ $weapon ] );
	}

	private function get_weapons_adjustments_table() {
		return array(
			'Axe,Hand' => array(
				'type'   => array( -5, -4, -3, -2, -2, -1, 0, 0, 1, 1, 1 ),
				'speed'  => 4,
				'damage' => array( '1d6', '1d4', 'Yes' ),
				'attack' => 'hand'
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
			'Hammer,Lucern' => array(
				'type'   => array( 0, 1, 1, 1, 2, 2, 2, 1, 1, 0, 0 ),
				'speed'  => 9,
				'damage' => array( '2d4', '1d6', 'Yes' ),
				'attack' => 'hand'
			),
			'Javelin' => array(
				'type'   => array( -7, -6, -5, -4, -3, -2, -1, 0, 1, 0, 1 ),
				'damage' => array( '1d6', '1d6', 'Yes' ),
				'range'  => array( 20, 40, 60 ),
				'attack' => 'hand'
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
				'attack' => 'hand'
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
				'attack' => 'hand'
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
			'Sword,Two Handed' => array(
				'type'   => array( 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 1 ),
				'speed'  => 10,
				'damage' => array( '1d10', '3d6', 'Yes' ),
				'attack' => 'hand'
			),
		);
	}

	private function get_weapon_attacks_array( $type ) {
		$table = array();
		switch( $type ) {
			case 'bow':
				$table = array( [ 2, 1 ], [ 3, 1 ], [ 4, 1 ], [ 5, 1 ], [ 6, 1 ] );
				break;
			case 'hand':
			case 'lgtXbow':
				$table = array( [ 1, 1 ], [ 3, 2 ], [ 2, 1 ], [ 5, 2 ], [ 3, 1 ] );
				break;
			default:
				$table = array( [ 1, 1 ], [ 1, 1 ], [ 1, 1 ], [ 1, 1 ], [ 1, 1 ] );
		}
		return $table;
	}

	private function get_weapon_proficiency_bonus( $skill, $non_prof, $desire = 'hit' ) {
		$bonus = 0;
		switch( $skill ) {
			case 'NP':
				$bonus = ( $desire === 'hit' ) ? $non_prof : 0;
				break;
			case 'SP':
				$bonus = ( $desire === 'hit' ) ? 1 : 2;
				break;
			case 'DP':
				$bonus = 3;
				break;
			default:
		}
		return $bonus;
	}

	private function get_missile_range_adjustment( $weapon, $range ) {
		$adjust = 0;
		if ( $range > $weapon[2] ) {
			$adjust = -13;
		} else if ( $range > $weapon[1] ) {
			$adjust = -5;
		} else if ( $range > $weapon[0] ) {
			$adjust = -2;
		}
		return $adjust;
	}


}
