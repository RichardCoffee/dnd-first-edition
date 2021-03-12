<?php

trait DND_Combat_Movement {


	protected $moves = array();
	protected $show_moves = 'count'; # valid values: 'count', 'init'


	protected function determine_movement() {
		$this->determine_enemy_movement();
		$this->determine_party_movement();
	}

	private function determine_enemy_movement() {
		$added = array();
		foreach( $this->enemy as $key => $object ) {
			if ( ! in_array( $object->race, $added ) ) {
				$this->add_object_movement( $object, $object->initiative );
				$added[] = $object->race;
			}
		}
	}

	private function determine_party_movement() {
		static $states = array();
		foreach( $this->party as $key => $char ) {
			if ( ! $states ) $states = $char->state_weapon_entries( true );
			if ( in_array( $char->weapon['current'], $states ) ) continue;
			if ( $char->get_hit_points() < 1 ) continue;
			if ( $this->is_casting( $key ) ) continue;
			if ( in_array( $char->get_key(), $this->action ) ) continue;
			if ( in_array( $key, $this->holding ) && ( $char->segment > $this->segment ) ) continue;
			$this->add_object_movement( $char, $char->initiative['actual'] );
		}
	}

	private function add_object_movement( $obj, $init = 0 ) {
		$key = $obj->get_key();
		if ( $this->is_casting( $key ) ) return;
		$sequence = $this->get_movement_sequence( $obj->movement );
		$seg = $this->segment % 10;
		$seg = ( $seg === 0 ) ? 10 : $seg;
		$cnt = count( array_keys( $sequence, $seg ) );
		if ( $cnt ) {
			$idx = ( $obj instanceOf DND_Monster_Monster) ? $obj->race : $key;
			$this->moves[ $idx ] = array(
				'cnt'  => $cnt,
				'init' => $init,
				'name' => ( ( $obj instanceOf DND_Monster_Monster) ? $obj->race : $obj->get_name() ),
				'keep' => ( $obj instanceOf DND_Monster_Monster ),
			);
		}
	}

	private function movement_sort_by_init( $a, $b ) {
		if ( $a['init'] === $b['init'] ) {
			if ( $a['cnt'] === $b['cnt'] ) {
				return 0;
			}
			return ( $a['cnt'] > $b['cnt'] ) ? -1 : 1;
		}
		return ( $a['init'] > $b['init'] ) ? -1 : 1;
	}

	private function movement_sort_by_count( $a, $b ) {
		if ( $a['cnt'] === $b['cnt'] ) {
			if ( $a['init'] === $b['init'] ) {
				return 0;
			}
			return ( $a['init'] > $b['init'] ) ? -1 : 1;
		}
		return ( $a['cnt'] > $b['cnt'] ) ? -1 : 1;
	}

	private function get_movement_sequence( $move = 12 ) {
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
			case '5a':
				$segs = array( 1, 3, 5, 7, 9 );
				break;
			case '6':
				$segs = array( 2, 3, 5, 6, 8, 10 );
				break;
			case '6a':
				$segs = array( 1, 3, 5, 7, 8, 10 );
				break;
			case '7':
				$segs = array( 1, 2, 4, 5, 7, 8, 9 );
				break;
			case '8':
				$segs = array( 1, 3, 4, 5, 6, 8, 9, 10 );
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
#			case '12': case 12 is the default
			case '11':
				$segs = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10 );
				break;
			case '15':
				$segs = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10 );
				break;
			case '18':
				$segs = array( 1, 1, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 8, 8, 9, 9, 10, 10 );
				break;
			case '21':
				$segs = array( 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 10 );
				break;
			case '24':
				$segs = array( 1, 1, 2, 2, 2, 3, 3, 4, 4, 4, 5, 5, 6, 6, 6, 7, 7, 8, 8, 8, 9, 9, 10, 10 );
				break;
			case '30':
				$segs = array( 1, 1, 1, 2, 2, 2, 3, 3, 3, 4, 4, 4, 5, 5, 5, 6, 6, 6, 7, 7, 7, 8, 8, 8, 9, 9, 9, 10, 10, 10 );
				break;
			case '33':
				$segs = array( 1, 1, 1, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 5, 5, 5, 6, 6, 6, 6, 7, 7, 7, 8, 8, 8, 9, 9, 9, 9, 10, 10, 10 );
				break;
			case '39':
				$segs = array( 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 6, 6, 6, 6, 7, 7, 7, 7, 8, 8, 8, 8, 9, 9, 9, 9, 10, 10, 10, 10 );
				break;
			case '12':
			default:
				$segs = array( 1, 2, 3, 4, 5, 5, 6, 7, 8, 9, 10, 10 );
		}
		return $segs;
	}

	/**  Command Line functions  **/

	protected function get_mapped_movement_sequence( $movement = 12 ) {
		$test = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
		$str  = '|';
		$move = $this->get_movement_sequence( $movement );
		foreach( $test as $seg ) {
			$cnt = count( array_keys( $move, $seg ) );
			switch( $cnt ) {
				case 0:
					$str .= '-|';
					break;
				case 1:
					$str .= ( $seg === 10 ) ? '0|' : $seg . '|';
					break;
				case 2:
					$str .= '@|';
					break;
				case 3:
					$str .= '#|';
					break;
				case 4:
					$str .= '$|';
					break;
				default:
					$str .= '*|';
			}
		}
		return $str;
	}

	protected function movement_when_attacking( $key ) {
		if ( $this->show_moves === 'init' ) {
			echo " [{$this->moves[ $key ]['cnt']}]";
			if ( ! $this->moves[ $key ]['keep'] ) unset( $this->moves[ $key ] );
		} else if ( $this->show_moves === 'count' ) {
			echo " [1]";
			if ( $this->moves[ $key ]['keep'] ) {
				// retain monster classes
			} else if ( $this->moves[ $key ]['cnt'] === 1 ) {
				unset( $this->moves[ $key ] );
			} else {
				$this->moves[ $key ]['cnt']--;
			}
		}
	}

#	 * @since 20190806
	protected function show_movement_by_init() {
		if ( $this->moves ) {
			uasort( $this->moves, [ $this, 'movement_sort_by_init' ] );
			foreach( $this->moves as $char => $data ) {
				$text = $char . ( ( $data['cnt'] > 1 ) ? sprintf( ' x %u', $data['cnt'] ) : '' );
				echo "\t$text ";
			} //*/
			echo "\n";
		}
	}

	protected function show_movement_by_count() {
		if ( $this->moves ) {
			uasort( $this->moves, [ $this, 'movement_sort_by_count' ] );
			echo "\t";
			while( $this->moves ) {
				$key  = array_key_first( $this->moves );
				$curr = array_shift( $this->moves );
				echo "{$curr['name']}  ";
				if ( $curr['cnt'] > 1 ) {
					$curr['cnt']--;
					$this->moves[ $key ] = $curr;
				}
			}
			echo "\n";
		}
	}


}
