<?php

trait DND_Character_Trait_Armor {


	private function armor_get_armor_table() {
		$table = array(
			'banded'       => [ 'name' => 'Banded Mail',             'ac' =>  4, 'bulk' => 'bulky',  'weight' => 35, 'move' => 9,  'cost' =>    90 ],
			'bracers ac7'  => [ 'name' => 'Bracers of Defense AC 7', 'ac' =>  7, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' =>  9000 ],
			'bracers ac6'  => [ 'name' => 'Bracers of Defense AC 6', 'ac' =>  6, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 12000 ],
			'bracers ac5'  => [ 'name' => 'Bracers of Defense AC 5', 'ac' =>  5, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 15000 ],
			'bracers ac4'  => [ 'name' => 'Bracers of Defense AC 4', 'ac' =>  4, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 18000 ],
			'bracers ac3'  => [ 'name' => 'Bracers of Defense AC 3', 'ac' =>  3, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 21000 ],
			'bracers ac2'  => [ 'name' => 'Bracers of Defense AC 2', 'ac' =>  2, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 24000 ],
			'brigandine'   => [ 'name' => 'Brigandine Mail',         'ac' =>  6, 'bulk' => 'fairly', 'weight' => 40, 'move' => 6,  'cost' =>    45 ],
			'bronze plate' => [ 'name' => 'Bronze Plate Mail',       'ac' =>  4, 'bulk' => 'bulky',  'weight' => 45, 'move' => 6,  'cost' =>   100 ],
			'chain'        => [ 'name' => 'Chainmail',               'ac' =>  5, 'bulk' => 'fairly', 'weight' => 30, 'move' => 9,  'cost' =>    75 ],
			'elfin chain'  => [ 'name' => 'Elfin Chainmail',         'ac' =>  5, 'bulk' => 'non-',   'weight' => 15, 'move' => 12, 'cost' => 'n/a' ],
			'field plate'  => [ 'name' => 'Field Plate Armor',       'ac' =>  2, 'bulk' => 'fairly', 'weight' => 55, 'move' => 6,  'cost' =>  2000 ],
			'full plate'   => [ 'name' => 'Full Plate Armor',        'ac' =>  1, 'bulk' => 'fairly', 'weight' => 65, 'move' => 6,  'cost' =>  4000 ],
			'leather'      => [ 'name' => 'Leather Armor',           'ac' =>  8, 'bulk' => 'non-',   'weight' => 15, 'move' => 12, 'cost' =>     5 ],
			'none'         => [ 'name' => 'no armor',                'ac' => 10, 'bulk' => 'non-',   'weight' =>  0, 'move' => 12, 'cost' => 'n/a' ],
			'padded'       => [ 'name' => 'Padded Armor',            'ac' =>  8, 'bulk' => 'fairly', 'weight' => 10, 'move' => 9,  'cost' =>     4 ],
			'plate mail'   => [ 'name' => 'Plate Mail',              'ac' =>  3, 'bulk' => 'bulky',  'weight' => 45, 'move' => 6,  'cost' =>   400 ],
			'ring'         => [ 'name' => 'Ring Mail',               'ac' =>  7, 'bulk' => 'fairly', 'weight' => 25, 'move' => 9,  'cost' =>    30 ],
			'scale'        => [ 'name' => 'Scale Mail',              'ac' =>  6, 'bulk' => 'fairly', 'weight' => 40, 'move' => 6,  'cost' =>    45 ],
			'splint'       => [ 'name' => 'Splint Mail',             'ac' =>  4, 'bulk' => 'bulky',  'weight' => 40, 'move' => 6,  'cost' =>    80 ],
			'studded'      => [ 'name' => 'Studded Leather Armor',   'ac' =>  7, 'bulk' => 'fairly', 'weight' => 20, 'move' => 9,  'cost' =>    15 ],
		);
		return $table;
	}

	protected function get_armor_info( $armor ) {
		$armor = strtolower( $armor );
		$info  = false;
		$table = $this->armor_get_armor_table();
		if ( array_key_exists( $armor, $table ) ) {
			$info = $table[ $armor ];
		}
		return $info;
	}

	private function get_armor_trait_value( $armor, $trait ) {
		static $table = null;
		if ( ! $table ) $table = $this->armor_get_armor_table();
		$value = "Armor $armor not found in armor table.";
		$armor = strtolower( $armor );
		if ( array_key_exists( $armor, $table ) ) {
			$value = "$armor trait $trait not found in armor table.";
			$trait = strtolower( $trait );
			if ( array_key_exists( $trait, $table[ $armor ] ) ) {
				$value = $table[ $armor ][ $trait ];
			}
		}
		return $value;
	}

	public function get_armor_proper_name( $armor ) {
		return $this->get_armor_trait_value( $armor, 'name' );
	}

	private function get_armor_ac_value( $armor ) {
		$ac = $this->get_armor_trait_value( $armor, 'ac' );
		$this->add_replacement_filter( 'character_armor_type' );
		return apply_filters( 'character_armor_type', $ac, $this );
	}

	protected function get_armor_bulk( $armor ) {
		return $this->get_armor_trait_value( $armor, 'bulk' );
	}

	private function get_armor_weight( $armor ) {
		return $this->get_armor_trait_value( $armor, 'weight' );
	}

	protected function get_armor_base_movement( $armor ) {
		return $this->get_armor_trait_value( $armor, 'move' );
	}

	private function get_armor_base_cost( $armor ) {
		return $this->get_armor_trait_value( $armor, 'cost' );
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
