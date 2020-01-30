<?php

trait DND_Character_Trait_SavingThrows {


	public function get_saving_throws( $source = null, $extra = null ) {
		$level = ( $this instanceof DND_Monster_Monster ) ? $this->get_saving_throw_level() : $this->level;
		$base  = $this->get_raw_saving_throws( $level, $source, $extra );
		return $this->get_keyed_saving_throws( $base );
	}

	protected function get_raw_saving_throws( $level, $source = null, $extra = null ) {
		$keys = $this->get_saving_throw_key_table();
		$base = array();
		foreach( $keys as $key => $index ) {
			$base[] = array(
				'key'  => $key,
				'roll' => $this->get_base_saving_throw( $key, $level, $source, $extra ),
			);
		}
		return $base;
	}

	protected function get_keyed_saving_throws( $base ) {
		$mixed = array();
		foreach( $base as $roll ) {
			$key = $roll['roll'];
			if ( array_key_exists( $key, $mixed ) ) {
				$mixed[ $key ] .= '/' . $roll['key'];
			} else {
				$mixed[ $key ] = $roll['key'];
			}
		}
		$table = array();
		foreach( $mixed as $roll => $type ) {
			$table[ $type ] = $roll;
		}
		return $table;
	}

	/**
	 * @param string $type An index from the saving throw key table
	 * @param integer $index Level of character/monster
	 * @param mixed $origin May be an object (Character/Monster) or an array (spell)
	 * @param mixed $extra parameter passed on to filter
	 */
	public function get_base_saving_throw( $type = 'Spells', $index = 0, $origin = null, $extra = null ) {
		if ( ( $row = $this->get_saving_throw_table_row( $type ) ) === false ) {
			return 100;
		}
		if ( ( $this instanceOf DND_Monster_Monster ) && ( $this->intelligence === 'Non-' ) ) {
			if ( ! in_array( $type, [ 'Poison', 'Death Magic' ] ) ) {
				$index = ceil( $index / 2 );
			}
		}
		$index = min( 21, $index );
		$table = $this->get_saving_throw_table();
		$base  = $table[ $row ][ $index ];
		$type  = str_replace( ' ', '', $type );
		$filters = array(
			$this->get_key(1) . "_{$type}_saving_throws",
			$this->get_key(1) . '_all_saving_throws',
			"{$this->race}_{$type}_saving_throws",
			"{$this->race}_all_saving_throws",
		);
		if ( $this instanceOf DND_Character_Character ) {
			$filters[] = "character_{$type}_saving_throws";
			$filters[] = 'character_all_saving_throws';
		}
		if ( $this instanceOf DND_Monster_Monster ) {
			$filters[] = "monster_{$type}_saving_throws";
			$filters[] = 'monster_all_saving_throws';
		}
		foreach( $filters as $filter ) {
			$base = apply_filters( $filter, $base, $this, $origin, $extra );
		}
		return max( $base, 2 );
	}

	protected function get_saving_throw_table_row( $type = 'Spells' ) {
		$keys = $this->get_saving_throw_key_table();
		if ( array_key_exists( $type, $keys ) ) {
			return $keys[ $type ];
		}
		return false;
	}

	protected function get_saving_throw_key_table() {
		return array(
			'Rod'           => 'RSW',
			'Staff'         => 'RSW',
			'Wand'          => 'RSW',
			'Breath Weapon' => 'Breath',
			'Death Magic'   => 'Death Magic',
			'Paralyzation'  => 'Paralyzation',
			'Poison'        => 'Poison',
			'Petrification' => 'Petri/Poly',
			'Polymorph'     => 'Petri/Poly',
			'Spells'        => 'Spells',
		);
	}

	protected function get_combined_saving_throw_table( array $tables ) {
		$func = "get_{$tables[0]}_saving_throw_table";
		$base = $this->$func();
		foreach( $tables as $key => $table ) {
			if ( $key === 0 ) continue;
			$func = "get_{$table}_saving_throw_table";
			$comp = $this->$func();
			foreach( $comp as $type => $row ) {
				foreach( $row as $index => $item ) {
					$base[$type][$index] = min( $base[$type][$index], $item );
				}
			}
		}
		return $base;
	}

	protected function get_cleric_saving_throw_table() {
		return array(          /*    0   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19  20  21  */
			'Paralyzation' => array( 11, 10, 10, 10,  9,  9,  8,  7,  7,  7,  6,  6,  6,  5,  5,  5,  4,  4,  3,  2,  2,  2 ),
			'Poison'       => array( 11, 10, 10, 10,  9,  9,  8,  7,  7,  7,  6,  6,  6,  5,  5,  5,  4,  4,  3,  2,  2,  2 ),
			'Death Magic'  => array( 11, 10, 10, 10,  9,  9,  8,  7,  7,  7,  6,  6,  6,  5,  5,  5,  4,  4,  3,  2,  2,  2 ),
			'Petri/Poly'   => array( 14, 13, 13, 13, 12, 12, 11, 10, 10, 10,  9,  9,  9,  8,  8,  8,  7,  7,  7,  6,  6,  6 ),
			'RSW'          => array( 15, 14, 14, 14, 13, 13, 12, 11, 11, 11, 10, 10, 10,  9,  9,  9,  8,  8,  7,  6,  6,  6 ),
			'Breath'       => array( 17, 16, 16, 16, 15, 15, 14, 13, 13, 13, 12, 12, 12, 11, 11, 11, 10, 10,  9,  8,  8,  8 ),
			'Spells'       => array( 16, 15, 15, 15, 14, 14, 13, 12, 12, 12, 11, 11, 11, 10, 10, 10,  9,  9,  8,  7,  7,  7 ),
/*			'Paralyzation' => array( 11, 10, 10, 10,  9,  9,  9,  7,  7,  7,  6,  6,  6,  5,  5,  5,  4,  4,  4,  2,  2,  2 ),
			'Poison'       => array( 11, 10, 10, 10,  9,  9,  9,  7,  7,  7,  6,  6,  6,  5,  5,  5,  4,  4,  4,  2,  2,  2 ),
			'Death Magic'  => array( 11, 10, 10, 10,  9,  9,  9,  7,  7,  7,  6,  6,  6,  5,  5,  5,  4,  4,  4,  2,  2,  2 ),
			'Petri/Poly'   => array( 14, 13, 13, 13, 12, 12, 12, 10, 10, 10,  9,  9,  9,  8,  8,  8,  7,  7,  7,  6,  6,  6 ),
			'RSW'          => array( 15, 14, 14, 14, 13, 13, 13, 11, 11, 11, 10, 10, 10,  9,  9,  9,  8,  8,  8,  6,  6,  6 ),
			'Breath'       => array( 17, 16, 16, 16, 15, 15, 15, 13, 13, 13, 12, 12, 12, 11, 11, 11, 10, 10, 10,  8,  8,  8 ),
			'Spells'       => array( 16, 15, 15, 15, 14, 14, 14, 12, 12, 12, 11, 11, 11, 10, 10, 10,  9,  9,  9,  7,  7,  7 ), //*/
		);
	}

	protected function get_fight_saving_throw_table() {
		return array(          /*    0   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19  20  21 */
			'Paralyzation' => array( 16, 14, 14, 13, 12, 11, 11, 10,  9,  8,  8,  7,  6,  5,  5,  4,  4,  3,  3,  3,  3,  3 ),
			'Poison'       => array( 16, 14, 14, 13, 12, 11, 11, 10,  9,  8,  8,  7,  6,  5,  5,  4,  4,  3,  3,  3,  3,  3 ),
			'Death Magic'  => array( 16, 14, 14, 13, 12, 11, 11, 10,  9,  8,  8,  7,  6,  5,  5,  4,  4,  3,  3,  3,  3,  3 ),
			'Petri/Poly'   => array( 17, 15, 15, 14, 13, 12, 12, 11, 10,  9,  9,  8,  7,  6,  6,  5,  5,  4,  4,  4,  4,  4 ),
			'RSW'          => array( 18, 16, 16, 15, 14, 13, 13, 12, 11, 10, 10,  9,  8,  7,  7,  6,  6,  5,  5,  5,  5,  5 ),
			'Breath'       => array( 20, 17, 17, 16, 15, 14, 13, 12, 11, 10,  9,  8,  7,  6,  5,  4,  4,  4,  4,  4,  4,  4 ),
			'Spells'       => array( 19, 17, 17, 16, 15, 14, 14, 13, 12, 11, 11, 10,  9,  8,  8,  7,  7,  6,  6,  6,  6,  6 ),
/*			'Paralyzation' => array( 16, 14, 14, 13, 13, 11, 11, 10, 10,  8,  8,  7,  7,  5,  5,  4,  4,  3,  3,  3,  3,  3 ),
			'Poison'       => array( 16, 14, 14, 13, 13, 11, 11, 10, 10,  8,  8,  7,  7,  5,  5,  4,  4,  3,  3,  3,  3,  3 ),
			'Death Magic'  => array( 16, 14, 14, 13, 13, 11, 11, 10, 10,  8,  8,  7,  7,  5,  5,  4,  4,  3,  3,  3,  3,  3 ),
			'Petri/Poly'   => array( 17, 15, 15, 14, 14, 12, 12, 11, 11,  9,  9,  8,  8,  6,  6,  5,  5,  4,  4,  4,  4,  4 ),
			'RSW'          => array( 18, 16, 16, 15, 15, 13, 13, 12, 12, 10, 10,  9,  9,  7,  7,  6,  6,  5,  5,  5,  5,  5 ),
			'Breath'       => array( 20, 17, 17, 16, 16, 13, 13, 12, 12,  9,  9,  8,  8,  5,  5,  4,  4,  4,  4,  4,  4,  4 ),
			'Spells'       => array( 19, 17, 17, 16, 16, 14, 14, 13, 13, 11, 11, 10, 10,  8,  8,  7,  7,  6,  6,  6,  6,  6 ), //*/
		);
	}

	protected function get_magic_saving_throw_table() {
		return array(          /*    0   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19  20  21 */
			'Paralyzation' => array( 15, 14, 14, 14, 14, 14, 13, 13, 13, 13, 12, 11, 11, 11, 11, 11, 10, 10, 10, 10,  9,  8 ),
			'Poison'       => array( 15, 14, 14, 14, 14, 14, 13, 13, 13, 13, 12, 11, 11, 11, 11, 11, 10, 10, 10, 10,  9,  8 ),
			'Death Magic'  => array( 15, 14, 14, 14, 14, 14, 13, 13, 13, 13, 12, 11, 11, 11, 11, 11, 10, 10, 10, 10,  9,  8 ),
			'Petri/Poly'   => array( 14, 13, 13, 13, 13, 12, 11, 11, 11, 11, 10,  9,  9,  9,  9,  8,  7,  7,  7,  7,  6,  5 ),
			'RSW'          => array( 12, 11, 11, 11, 11, 10,  9,  9,  9,  9,  8,  7,  7,  7,  7,  6,  5,  5,  5,  5,  4,  3 ),
			'Breath'       => array( 16, 15, 15, 15, 15, 14, 13, 13, 13, 13, 12, 11, 11, 11, 11, 10,  9,  9,  9,  9,  8,  7 ),
			'Spells'       => array( 13, 12, 12, 12, 12, 11, 10, 10, 10, 10,  9,  8,  8,  8,  8,  7,  6,  6,  6,  6,  5,  4 ),
/*			'Paralyzation' => array( 15, 14, 14, 14, 14, 14, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11, 10, 10, 10, 10, 10,  8 ),
			'Poison'       => array( 15, 14, 14, 14, 14, 14, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11, 10, 10, 10, 10, 10,  8 ),
			'Death Magic'  => array( 15, 14, 14, 14, 14, 14, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11, 10, 10, 10, 10, 10,  8 ),
			'Petri/Poly'   => array( 14, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11,  9,  9,  9,  9,  9,  7,  7,  7,  7,  7,  5 ),
			'RSW'          => array( 12, 11, 11, 11, 11, 11,  9,  9,  9,  9,  9,  7,  7,  7,  7,  7,  5,  5,  5,  5,  5,  3 ),
			'Breath'       => array( 16, 15, 15, 15, 15, 15, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11,  9,  9,  9,  9,  9,  7 ),
			'Spells'       => array( 13, 12, 12, 12, 12, 12, 10, 10, 10, 10, 10,  8,  8,  8,  8,  8,  6,  6,  6,  6,  6,  4 ), //*/
		);
	}

	protected function get_thief_saving_throw_table() {
		return array(          /*    0   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19  20  21 */
			'Paralyzation' => array( 14, 13, 13, 13, 13, 12, 12, 12, 12, 11, 11, 11, 11, 10, 10, 10, 10,  9,  9,  9,  9,  8 ),
			'Poison'       => array( 14, 13, 13, 13, 13, 12, 12, 12, 12, 11, 11, 11, 11, 10, 10, 10, 10,  9,  9,  9,  9,  8 ),
			'Death Magic'  => array( 14, 13, 13, 13, 13, 12, 12, 12, 12, 11, 11, 11, 11, 10, 10, 10, 10,  9,  9,  9,  9,  8 ),
			'Petri/Poly'   => array( 13, 12, 12, 12, 12, 11, 11, 11, 11, 10, 10, 10, 10,  9,  9,  9,  9,  8,  8,  8,  8,  7 ),
			'RSW'          => array( 15, 14, 14, 14, 13, 12, 12, 12, 11, 10, 10, 10,  9,  8,  8,  8,  7,  6,  6,  6,  5,  4 ),
			'Breath'       => array( 17, 16, 16, 16, 16, 15, 15, 15, 15, 14, 14, 14, 14, 13, 13, 13, 13, 12, 12, 12, 12, 11 ),
			'Spells'       => array( 16, 15, 15, 15, 14, 13, 13, 13, 12, 11, 11, 11, 10,  9,  9,  9,  8,  7,  7,  7,  6,  5 ),
/*			'RSW'          => array( 15, 14, 14, 14, 14, 12, 12, 12, 12, 10, 10, 10, 10,  8,  8,  8,  8,  6,  6,  6,  6,  4 ),
			'Breath'       => array( 17, 16, 16, 16, 16, 15, 15, 15, 15, 14, 14, 14, 14, 13, 13, 13, 13, 12, 12, 12, 12, 11 ),
			'Spells'       => array( 16, 15, 15, 15, 15, 13, 13, 13, 13, 11, 11, 11, 11,  9,  9,  9,  9,  7,  7,  7,  7,  5 ), //*/
		);
	}

	protected function add_racial_saving_throw_filters() {
		if ( $this->race === 'Dwarf' ) {
			add_filter( "Dwarf_Rod_saving_throws",    [ $this, 'racial_constitution_saving_throws' ], 10, 2 );
			add_filter( "Dwarf_Staff_saving_throws",  [ $this, 'racial_constitution_saving_throws' ], 10, 2 );
			add_filter( "Dwarf_Wand_saving_throws",   [ $this, 'racial_constitution_saving_throws' ], 10, 2 );
			add_filter( "Dwarf_Spells_saving_throws", [ $this, 'racial_constitution_saving_throws' ], 10, 2 );
		}
		if ( $this->race === 'Gnome' ) {
			add_filter( "Gnome_Poison_saving_throws", [ $this, 'racial_constitution_saving_throws' ], 10, 2 );
		}
		add_filter( 'character_Spells_saving_throws', [ $this, 'mental_wisdom_saving_throws' ], 10, 4 );
	}

	public function racial_constitution_saving_throws( $num, $target ) {
		if ( $target === $this ) {
			$num -= intval( $this['stats']['con'] / 3.5 );
		}
		return $num;
	}

	public function mental_wisdom_saving_throws( $num, $target, $origin, $type ) {
		if ( $target === $this ) {
			if ( is_array( $origin ) && array_key_exists( 'type', $origin ) && ( stripos( $origin['type'], 'Charm' ) !== false ) ) {
				$num -= $this->get_wisdom_saving_throw_bonus( $this->stats['wis'] );
			} else if ( is_string( $type ) && ( $type === 'mental' ) ) {
				$num -= $this->get_wisdom_saving_throw_bonus( $this->stats['wis'] );
			}
		}
		return $num;
	}


}
