<?php

#	 * @link https://www.geekality.net/2014/04/20/php-simple-directory-recursion/
#	 * @link https://www.php.net/manual/en/class.recursivecallbackfilteriterator.php

class DND_Encounters {


	public function __construct() { }

	public function get_monster_list() {
		return $this->get_monster_files();
	}

	public function get_random_encounter( $terrain, $roll = 0, $creature = 0 ) {
		list( $type, $area ) = explode( ':', $terrain );
		$list = $this->get_monster_files();
		$possibles = array();
		foreach( $list as $key => $data ) {
			if ( empty( $data ) ) continue;
			if ( array_key_exists( $type, $data ) ) {
				if ( array_key_exists( $area, $data[ $type ] ) ) {
					$possibles[ $key ] = $data[ $type ][ $area ];
				}
			}
		}
		if ( $roll ) {
			$rarity = $this->get_rarity_type( $roll );
			$possibles = array_filter( $possibles, function( $a ) use ( $rarity ) {
				if ( $a === $rarity ) return true;
				return false;
			} );
		}
		if ( $creature ) {
			foreach( $possibles as $key => $data ) {
				$creature--;
				if ( $creature === 0 ) {
					$result = $list[ $key ];
				}
			}
		} else {
			$result = $possibles;
		}
		return $result;
	}

	protected function get_rarity_type( $roll = 0 ) {
		if ( $roll === 0 ) $roll = mt_rand( 1, 100 );
		if ( $roll < 66 ) {
			$rarity = 'C';
		} else if ( $roll < 86 ) {
			$rarity = 'U';
		} else if ( $roll < 97 ) {
			$rarity = 'R';
		} else {
			$rarity = 'VR';
		}
		return $rarity;
	}

	public function get_terrain_list() {
		$types = $this->get_terrain_types();
		$areas = $this->get_terrain_areas();
		return $this->generate_listing( $types, $areas );
	}

	public function get_water_list() {
		$types = $this->get_water_types();
		$areas = $this->get_water_areas();
		return $this->generate_listing( $types, $areas );
	}

	protected function generate_listing( $types, $areas ) {
		$list = array();
		foreach( $types as $kt => $type ) {
			foreach( $areas as $ka => $area ) {
				$list[ "$kt:$ka" ] = sprintf( '%s - %s', $type, $area );
			}
		}
		return $list;
	}

	protected function get_terrain_types() {
		return array(
			'CC'  => 'Cold Civilized',
			'CW'  => 'Cold Wilderness',
			'TC'  => 'Temperate Civilized',
			'TW'  => 'Temperate Wilderness',
			'TSC' => 'Tropical/Sub-Tropical Civilized',
			'TSW' => 'Tropical/Sub-Tropical Wilderness',
		);
	}

	protected function get_terrain_areas() {
		return array(
			'M' => 'Mountains',
			'H' => 'Hills',
			'F' => 'Forest',
			'S' => 'Swamp/Marsh',
			'P' => 'Plains',
			'D' => 'Desert',
		);
	}

	protected function get_water_types() {
		return array(
			'CF' => 'Cold Freshwater',
			'CS' => 'Cold Saltwater',
			'TF' => 'Temperate Freshwater',
			'TS' => 'Temperate Saltwater',
			'TSF' => 'Tropical/Sub-Tropical Freshwater',
			'TSS' => 'Tropical/Sub-Tropical Saltwater',
		);
	}

	protected function get_water_areas() {
		return array(
			'S' => 'Surface',
			'D' => 'Depths',
		);
	}

	protected function get_monster_files() {
		$files = array();
		$info  = array(
			'name' => 'Name',
			'class' => 'Class',
			'encounter' => 'Encounter',
		);
		$path = ( ( defined('DND_FIRST_EDITION_DIR') ) ? DND_FIRST_EDITION_DIR : DND_Plugin_Paths::get_instance()->dir ) . '/classes/Monster/';
		$directory = new RecursiveDirectoryIterator( $path, FilesystemIterator::SKIP_DOTS );
		$filtered  = new RecursiveCallbackFilterIterator( $directory, [ $this, 'monster_directory_filter' ] );
		foreach ( new RecursiveIteratorIterator( $filtered ) as $file ) {
			$data = get_file_data( $file->getPathname(), $info );
			if ( ! empty( $data['name'] ) ) {
				if ( $data['name'] === 'Template' ) continue;
				$key = $data['class'];
				$files[ $key ] = json_decode( $data['encounter'], true );
				$files[ $key ]['name'] = $data['name'];
				$files[ $key ]['class'] = $key;
			}
		}
#		if ( ! $encounter ) asort( $files, SORT_NATURAL );
		return $files;
	}

	public function monster_directory_filter( $file, $key, $iterator ) {
		$exclude = array( 'Trait' );
		return ! in_array( $file->getFilename(), $exclude );
	}


}
