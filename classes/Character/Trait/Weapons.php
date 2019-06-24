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
			$info = static::$weapons_table[ 'Spell' ];
		}
		return $info;
	}

	private function get_weapons_adjustments_table() {
		return array(
			'Bow,Long' => array(
				'type'   => array( -2, -1, -1, 0, 0, 1, 2, 3, 3, 3, 3 ),
				'damage' => array( '1d6', '1d6', 'No' ),
				'range'  => array( 7, 14, 21 ),
				'attack' => 'bow'
			),
			'Hammer,Lucern' => array(
				'type'   => array( 0, 1, 1, 1, 2, 2, 2, 1, 1, 0, 0 ),
				'speed'  => 9,
				'damage' => array( '2d4', '1d6', 'Yes' ),
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
		);
	}

	private function get_weapon_attacks_array( $type ) {
		$table = array();
		switch( $type ) {
			case 'bow':
				$table = array( '2/1', '3/1'. '4/1', '5/1', '6/1' );
				break;
			case 'hand':
				$table = array( '1/1', '3/2', '2/1', '5/2', '3/1' );
				break;
			default:
				$table = array( '1/1', '1/1', '1/1', '1/1', '1/1' );
		}
		return $table;
	}



}
