<?php

trait DND_Character_Trait_SavingThrows {


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
			$this->get_name() . "_{$type}_saving_throws",
			$this->get_name() . '_all_saving_throws',
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
		return $base;
	}

	protected function get_saving_throw_table_row( $type = 'Spells' ) {
		$keys = $this->get_saving_throw_key_table();
		if ( isset( $keys[ $type ] ) ) {
			return $keys[ $type ];
		}
		return false;
	}

	protected function get_saving_throw_key_table() {
		return array(
			'Paralyzation'  => 'Paralyzation',
			'Poison'        => 'Poison',
			'Death Magic'   => 'Death Magic',
			'Petrification' => 'Petri/Poly',
			'Polymorph'     => 'Petri/Poly',
			'Rod'           => 'RSW',
			'Staff'         => 'RSW',
			'Wand'          => 'RSW',
			'Breath Weapon' => 'Breath',
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
			'Paralyzation' => array( 11, 10, 10, 10,  9,  9,  9,  7,  7,  7,  6,  6,  6,  5,  5,  5,  4,  4,  4,  2,  2,  2 ),
			'Poison'       => array( 11, 10, 10, 10,  9,  9,  9,  7,  7,  7,  6,  6,  6,  5,  5,  5,  4,  4,  4,  2,  2,  2 ),
			'Death Magic'  => array( 11, 10, 10, 10,  9,  9,  9,  7,  7,  7,  6,  6,  6,  5,  5,  5,  4,  4,  4,  2,  2,  2 ),
			'Petri/Poly'   => array( 14, 13, 13, 13, 12, 12, 12, 10, 10, 10,  9,  9,  9,  8,  8,  8,  7,  7,  7,  6,  6,  6 ),
			'RSW'          => array( 15, 14, 14, 14, 13, 13, 13, 11, 11, 11, 10, 10, 10,  9,  9,  9,  8,  8,  8,  6,  6,  6 ),
			'Breath'       => array( 17, 16, 16, 16, 15, 15, 15, 13, 13, 13, 12, 12, 12, 11, 11, 11, 10, 10, 10,  8,  8,  8 ),
			'Spells'       => array( 16, 15, 15, 15, 14, 14, 14, 12, 12, 12, 11, 11, 11, 10, 10, 10,  9,  9,  9,  7,  7,  7 ),
		);
	}

	protected function get_fight_saving_throw_table() {
		return array(          /*    0   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19  20  21 */
			'Paralyzation' => array( 16, 14, 14, 13, 13, 11, 11, 10, 10,  8,  8,  7,  7,  5,  5,  4,  4,  3,  3,  3,  3,  3 ),
			'Poison'       => array( 16, 14, 14, 13, 13, 11, 11, 10, 10,  8,  8,  7,  7,  5,  5,  4,  4,  3,  3,  3,  3,  3 ),
			'Death Magic'  => array( 16, 14, 14, 13, 13, 11, 11, 10, 10,  8,  8,  7,  7,  5,  5,  4,  4,  3,  3,  3,  3,  3 ),
			'Petri/Poly'   => array( 17, 15, 15, 14, 14, 12, 12, 11, 11,  9,  9,  8,  8,  6,  6,  5,  5,  4,  4,  4,  4,  4 ),
			'RSW'          => array( 18, 16, 16, 15, 15, 13, 13, 12, 12, 10, 10,  9,  9,  7,  7,  6,  6,  5,  5,  5,  5,  5 ),
			'Breath'       => array( 20, 17, 17, 16, 16, 13, 13, 12, 12,  9,  9,  8,  8,  5,  5,  4,  4,  4,  4,  4,  4,  4 ),
			'Spells'       => array( 19, 17, 17, 16, 16, 14, 14, 13, 13, 11, 11, 10, 10,  8,  8,  7,  7,  6,  6,  6,  6,  6 ),
		);
	}

	protected function get_magic_saving_throw_table() {
		return array(          /*    0   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19  20  21 */
			'Paralyzation' => array( 15, 14, 14, 14, 14, 14, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11, 10, 10, 10, 10, 10,  8 ),
			'Poison'       => array( 15, 14, 14, 14, 14, 14, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11, 10, 10, 10, 10, 10,  8 ),
			'Death Magic'  => array( 15, 14, 14, 14, 14, 14, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11, 10, 10, 10, 10, 10,  8 ),
			'Petri/Poly'   => array( 14, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11,  9,  9,  9,  9,  9,  7,  7,  7,  7,  7,  5 ),
			'RSW'          => array( 12, 11, 11, 11, 11, 11,  9,  9,  9,  9,  9,  7,  7,  7,  7,  7,  5,  5,  5,  5,  5,  3 ),
			'Breath'       => array( 16, 15, 15, 15, 15, 15, 13, 13, 13, 13, 13, 11, 11, 11, 11, 11,  9,  9,  9,  9,  9,  7 ),
			'Spells'       => array( 13, 12, 12, 12, 12, 12, 10, 10, 10, 10, 10,  8,  8,  8,  8,  8,  6,  6,  6,  6,  6,  4 ),
		);
	}

	protected function get_thief_saving_throw_table() {
		return array(          /*    0   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19  20  21 */
			'Paralyzation' => array( 14, 13, 13, 13, 13, 12, 12, 12, 12, 11, 11, 11, 11, 10, 10, 10, 10,  9,  9,  9,  9,  8 ),
			'Poison'       => array( 14, 13, 13, 13, 13, 12, 12, 12, 12, 11, 11, 11, 11, 10, 10, 10, 10,  9,  9,  9,  9,  8 ),
			'Death Magic'  => array( 14, 13, 13, 13, 13, 12, 12, 12, 12, 11, 11, 11, 11, 10, 10, 10, 10,  9,  9,  9,  9,  8 ),
			'Petri/Poly'   => array( 13, 12, 12, 12, 12, 11, 11, 11, 11, 10, 10, 10, 10,  9,  9,  9,  9,  8,  8,  8,  8,  7 ),
			'RSW'          => array( 15, 14, 14, 14, 14, 12, 12, 12, 12, 10, 10, 10, 10,  8,  8,  8,  8,  6,  6,  6,  6,  4 ),
			'Breath'       => array( 17, 16, 16, 16, 16, 15, 15, 15, 15, 14, 14, 14, 14, 13, 13, 13, 13, 12, 12, 12, 12, 11 ),
			'Spells'       => array( 16, 15, 15, 15, 15, 13, 13, 13, 13, 11, 11, 11, 11,  9,  9,  9,  9,  7,  7,  7,  7,  5 ),
		);
	}


}
