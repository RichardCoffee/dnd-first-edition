<?php

trait DND_Character_Trait_Armor {


	private function get_armor_table() {
		$table = array(
			'banded'       => [ 'ac' => 4, 'bulk' => 'bulky',  'weight' => 35, 'move' => 9,  'cost' =>    90 ],
			'bracers ac7'  => [ 'ac' => 7, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' =>  9000 ],
			'bracers ac6'  => [ 'ac' => 6, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 12000 ],
			'bracers ac5'  => [ 'ac' => 5, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 15000 ],
			'bracers ac4'  => [ 'ac' => 4, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 18000 ],
			'bracers ac3'  => [ 'ac' => 3, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 21000 ],
			'bracers ac2'  => [ 'ac' => 2, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 24000 ],
			'brigandine'   => [ 'ac' => 6, 'bulk' => 'fairly', 'weight' => 40, 'move' => 6,  'cost' =>    45 ],
			'bronze plate' => [ 'ac' => 4, 'bulk' => 'bulky',  'weight' => 45, 'move' => 6,  'cost' =>   100 ],
			'chain'        => [ 'ac' => 5, 'bulk' => 'fairly', 'weight' => 30, 'move' => 9,  'cost' =>    75 ],
			'elfin chain'  => [ 'ac' => 5, 'bulk' => 'non-',   'weight' => 15, 'move' => 12, 'cost' => 'n/a' ],
			'field plate'  => [ 'ac' => 2, 'bulk' => 'fairly', 'weight' => 55, 'move' => 6,  'cost' =>  2000 ],
			'full plate'   => [ 'ac' => 1, 'bulk' => 'fairly', 'weight' => 65, 'move' => 6,  'cost' =>  4000 ],
			'leather'      => [ 'ac' => 8, 'bulk' => 'non-',   'weight' => 15, 'move' => 12, 'cost' =>     5 ],
			'padded'       => [ 'ac' => 8, 'bulk' => 'fairly', 'weight' => 10, 'move' => 9,  'cost' =>     4 ],
			'plate mail'   => [ 'ac' => 3, 'bulk' => 'bulky',  'weight' => 45, 'move' => 6,  'cost' =>   400 ],
			'ring'         => [ 'ac' => 7, 'bulk' => 'fairly', 'weight' => 25, 'move' => 9,  'cost' =>    30 ],
			'scale'        => [ 'ac' => 6, 'bulk' => 'fairly', 'weight' => 40, 'move' => 6,  'cost' =>    45 ],
			'splint'       => [ 'ac' => 4, 'bulk' => 'bulky',  'weight' => 40, 'move' => 6,  'cost' =>    80 ],
			'studded'      => [ 'ac' => 7, 'bulk' => 'fairly', 'weight' => 20, 'move' => 9,  'cost' =>    15 ],
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

	protected function get_armor_base_movement( $armor, $move = 12 ) {
		$armor = strtolower( $armor );
		$table = $this->get_armor_table();
		if ( isset( $table[ $armor ] ) ) {
			$move = $table[ $armor ]['move'];
		}
		return $move;
	}

	public function get_movement_segments( $move = 12 ) {
		$segs = array( 1, 2, 3, 4, 5, 5, 6, 7, 8, 9, 10, 10 );
		switch( "$move" ) {
			case '1':
				$segs = array( 10 );
				break;
			case '2':
				$segs = array( 5, 10 );
				break;
			case '3':
				$segs = array( 3, 6, 9 );
				break;
			case '4':
				$segs = array( 2, 4, 6, 8 );
				break;
			case '5':
				$segs = array( 2, 4, 6, 8, 10 );
				break;
			case '6':
				$segs = array( 2, 4, 5, 6, 8, 10 );
				break;
			case '6a':
				$segs = array( 1, 3, 5, 7, 9, 10 );
				break;
			case '7':
				$segs = array( 1, 2, 4, 6, 7, 8, 10 );
				break;
			case '8':
				$segs = array( 1, 2, 4, 5, 6, 8, 9, 10 );
				break;
			case '9':
				$segs = array( 1, 2, 3, 4, 6, 7, 8, 9, 10 );
				break;
			case '9a':
				$segs = array( 1, 2, 3, 4, 5, 6, 7, 8, 9 );
				break;
			case '10':
				$segs = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
				break;
			case '11':
				$segs = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10 );
				break;
			case '12':
			default:
				$segs = array( 1, 2, 3, 4, 5, 5, 6, 7, 8, 9, 10, 10 );
		}
		return $segs;
	}


}
