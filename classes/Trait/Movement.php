<?php

trait DND_Trait_Movement {


	protected $moves = array();


	protected function determine_movement() {
		$this->determine_enemy_movement();
		$this->determine_party_movement();
	}

	private function determine_enemy_movement() {
		$monster = $this->get_base_monster();
		if ( $monster ) {
			$this->add_object_movement( $monster );
		}
	}

	private function determine_party_movement() {
		foreach( $this->party as $name => $char ) {
			$this->add_object_movement( $char );
		}
	}

	private function add_object_movement( $obj ) {
		$sequence = $this->get_movement_sequence( $obj->movement );
		$seg = $this->segment % 10;
		$seg = ( $seg === 0 ) ? 10 : $seg;
		$cnt = count( array_keys( $sequence, $seg ) );
		if ( $cnt ) {
			$name = $obj->get_name();
			$this->moves[] = $name . ( ( $cnt > 1 ) ? sprintf( ' x %u', $cnt ) : '' );
		}
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
				$segs = array( 1, 2, 3, 4, 5, 7, 8, 9, 10 );
				break;
			case '9a':
				$segs = array( 2, 3, 4, 5, 6, 7, 8, 9, 10 );
				break;
			case '10':
				$segs = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
				break;
			case '11':
				$segs = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10 );
				break;
			case '15':
				$segs = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10 );
				break;
			case '18':
				$segs = array( 1, 1, 2, 2, 3, 4, 4, 5, 5, 6, 6, 7, 8, 8, 9, 9, 10, 10 );
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
				default:
					$str .= '@|';
			}
		}
		return $str;
	}


}
