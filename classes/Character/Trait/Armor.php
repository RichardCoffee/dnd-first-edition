<?php

trait DND_Character_Trait_Armor {


	private function get_armor_table() {
		$table = array(
			'banded'       => [ 'ac' => 4, 'bulk' => 'bulky',  'weight' => 35, 'move' => 9,  'cost' => '90 gp' ],
			'bracers ac7'  => [ 'ac' => 7, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => '9000 gp' ],
			'bracers ac6'  => [ 'ac' => 6, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => '12000 gp' ],
			'bracers ac5'  => [ 'ac' => 5, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => '15000 gp' ],
			'bracers ac4'  => [ 'ac' => 4, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => '18000 gp' ],
			'bracers ac3'  => [ 'ac' => 3, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => '21000 gp' ],
			'bracers ac2'  => [ 'ac' => 2, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => '24000 gp' ],
			'bronze plate' => [ 'ac' => 4, 'bulk' => 'bulky',  'weight' => 45, 'move' => 6,  'cost' => '100 gp' ],
			'chain'        => [ 'ac' => 5, 'bulk' => 'fairly', 'weight' => 30, 'move' => 9,  'cost' => '75 gp' ],
			'elfin chain'  => [ 'ac' => 5, 'bulk' => 'non-',   'weight' => 15, 'move' => 12, 'cost' => 'n/a' ],
			'field plate'  => [ 'ac' => 2, 'bulk' => 'fairly', 'weight' => 55, 'move' => 6,  'cost' => '2000 gp' ],
			'full plate'   => [ 'ac' => 1, 'bulk' => 'fairly', 'weight' => 65, 'move' => 6,  'cost' => '4000 gp' ],
			'leather'      => [ 'ac' => 8, 'bulk' => 'non-',   'weight' => 15, 'move' => 12, 'cost' => '5 gp' ],
			'padded'       => [ 'ac' => 8, 'bulk' => 'fairly', 'weight' => 10, 'move' => 9,  'cost' => '4 gp' ],
			'plate mail'   => [ 'ac' => 3, 'bulk' => 'bulky',  'weight' => 45, 'move' => 6,  'cost' => '400 gp' ],
			'ring'         => [ 'ac' => 7, 'bulk' => 'fairly', 'weight' => 25, 'move' => 9,  'cost' => '30 gp' ],
			'scale'        => [ 'ac' => 6, 'bulk' => 'fairly', 'weight' => 40, 'move' => 6,  'cost' => '45 gp' ],
			'splint'       => [ 'ac' => 4, 'bulk' => 'bulky',  'weight' => 40, 'move' => 6,  'cost' => '80 gp' ],
			'studded'      => [ 'ac' => 7, 'bulk' => 'fairly', 'weight' => 20, 'move' => 9,  'cost' => '15 gp' ]
		);
		return $table;
	}

	protected function get_armor_info( $armor ) {
		$armor = strtolower( $armor );
		$info  = false;
		$table = $this->get_armor_table();
		if ( isset( $table[ $armor ] ) ) {
			$info = $table[ $armor ];
		}
		return $info;
	}

	private function get_armor_ac_value( $armor ) {
		$armor = strtolower( $armor );
		$ac    = 10;
		$table = $this->get_armor_table();
		if ( isset( $table[ $armor ] ) ) {
			$ac = $table[ $armor ]['ac'];
		}
		return $ac;
	}

	protected function get_armor_bulk( $armor ) {
		$armor = strtolower( $armor );
		$bulk  = 10;
		$table = $this->get_armor_table();
		if ( isset( $table[ $armor ] ) ) {
			$bulk = $table[ $armor ]['bulk'];
		}
		return $bulk;
	}

	protected function get_armor_base_movement( $armor ) {
		$armor = strtolower( $armor );
		$move  = 12;
		$table = $this->get_armor_table();
		if ( isset( $table[ $armor ] ) ) {
			$move = $table[ $armor ]['move'];
		}
		return $move;
	}


}
