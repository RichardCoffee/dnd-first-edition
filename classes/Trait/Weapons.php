<?php

trait DND_Trait_Weapons {


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
				'ACType'  => array( -2, -1, -1, 0, 0, 1, 2, 3, 3, 3, 3 ),
				'Damage'  => array( '1d6', '1d6', 'No' ),
				'Attacks' => 'bow'
			),
			'Hammer,Lucern' => array(
				'ACType'  => array( 0, 1, 1, 1, 2, 2, 2, 1, 1, 0, 0 ),
				'Damage'  => array( '2d4', '1d6', 'Yes' ),
				'Attacks' => 'hand'
			),
			'Spell' => array(
				'ACType'  => array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ),
				'Damage'  => array( 'spec', 'spec', 'No' ),
				'Attacks' => 'spell'
			),
			'Staff,Quarter' => array(
				'ACType'  => array( -9, -8, -7, -5, -3, -1, 0, 0, 1, 1, 1 ),
				'Damage'  => array( '1d6', '1d6', 'Yes' ),
				'Attacks' => 'hand'
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
