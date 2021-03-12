<?php

class DND_Combat_Invisibility {


	public function get_chance_numeric( $observer ) {
		$chance = $this->determine_chance( $observer );
		return ( is_null( $chance ) ) ? 0 : $chance;
	}

	public function get_chance_string( $observer ) {
		return sprintf(
			'%s has a %u%% chance of seeing the target.',
			$observer->get_name(),
			$this->get_chance_numeric( $observer )
		);
	}

	public function get_random_result_boolean( $observer ) {
		$chance = $this->get_chance_numeric( $observer );
		$roll   = mt_rand( 1, 100 );
		return ( $roll > $chance ) ? false : true;
	}

	public function get_random_result_string( $observer ) {
		$result = $this->get_random_result_boolean( $observer );
		if ( $result ) {
			return sprintf( '%s has detected the target!', $observer->get_name() );
		}
		return sprintf( '%s has not detected the target.', $observer->get_name() );
	}


	/**  Determination functions  **/

	protected function determine_chance( $observer ) {
		$table = $this->invisibility_table();
		$level = $this->determine_observer_level( $observer );
		$intel = $this->determine_observer_intelligence( $observer );
		return $table[ $level ][ $intel ];
	}

	protected function determine_observer_level( $observer ) {
		$table = $this->hit_dice_table();
		$index = 0;
		if ( $observer instanceOf DND_Character_Character ) {
			foreach( $table as $key => $level ) {
				if ( $observer->level < $level[0] ) continue;
				$index = $key;
			}
		} else if ( $observer instanceOf DND_Monster_Monster ) {
			foreach( $table as $key => $hd ) {
				$index = $key;
				if ( $observer->hit_dice < $hd[1] ) break;
				if ( $observer->hit_dice === $hd[1] ) {
					if ( $hd[2] ) break;
					if ( $observer->hit_dice === $hd[3] ) {
						if ( ! $hd[4] ) {
							if ( $observer->hp_extra ) continue;
							break;
						}
					}
				}
				if ( $observer->hit_dice < $hd[2] ) break;
				if ( $observer->hit_dice === $hd[3] ) {
					if ( $hd[4] ) break;
				}
			}
		}
		return $index;
	}

	protected function determine_observer_intelligence( $observer ) {
		$table = $this->intelligence_table();
		$intel = 0;
		if ( $observer instanceOf DND_Character_Character ) {
			$intel = $observer->stats['int'];
		} else if ( $observer instanceOf DND_Monster_Monster ) {
			if ( property_exists( $observer, 'stats' ) && array_key_exists( 'int', $observer->stats ) ) {
				$intel = $observer->stats['int'];
			} else if ( is_numeric( $observer->intelligence ) ) {
				$intel = intval( $observer->intelligence );
			} else {
				$enum = new DND_Enum_Intelligence;
				if ( $enum->has( $observer->intelligence ) ) {
					$intel = $enum->pos( $observer->intelligence );
				}
			}
		}
		return ( array_key_exists( $intel, $table ) ) ? $table[ $intel ] : 0;
	}


	/**  Tables  **/

	protected function hit_dice_table() {
		return array(
			array(  0,  0, false,  6, true ),  # 0
			array(  7,  7, false,  7, true ),  # 1
			array(  8,  8, false,  8, true ),  # 2
			array(  9,  9, false,  9, true ),  # 3
			array( 10, 10, false, 10, false ), # 4
			array( 11, 10, true,  11, false ), # 5
			array( 12, 11, true,  12, false ), # 6
			array( 13, 12, true,  13, false ), # 7
			array( 14, 13, true,  14, true ),  # 8
			array( 15, 15, true,  99, true ),  # 9
		);
	}

	protected function intelligence_table() {
		return array( 0, 0, 1, 1, 1, 2, 2, 2, 3, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7, 7 );
	}

	protected function invisibility_table() {
		return array(
			array( null, null, null, null, null, null, null, null ),
			array( null, null, null, null, null, null, null,    5 ),
			array( null, null, null, null, null, null,    5,   10 ),
			array( null, null, null, null, null,    5,   10,   15 ),
			array( null, null, null, null,    5,   15,   20,   25 ),
			array( null, null, null,    5,   15,   20,   25,   30 ),
			array( null, null,    5,   15,   25,   35,   40,   45 ),
			array( null,    5,   10,   25,   35,   45,   50,   55 ),
			array(    5,   10,   15,   35,   45,   55,   65,   75 ),
			array(   10,   15,   20,   45,   55,   65,   80,   95 ),
		);
	}


}
