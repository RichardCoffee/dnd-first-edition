<?php
/*
 *  classes/Enum.php
 *
 */

abstract class Enum {


	public function get( $position ) {
		if ( isset( $this->set[ $position ] ) ) {
			return $this->set[ $position ];
		}
		return '-undefined-';
	}

	public function has( $search, $strict = false ) {
		if ( in_array( $search, $this->set, $strict ) ) {
			return true;
		}
		return false;
	}

	public function position( $search, $strict = false ) {
		if ( $this->has( $search, $strict ) ) {
			$location = array_keys( $this->set, $search, $strict );
			return $location[0];
		}
		return -1;
	}

	public function compare( $one, $two, $strict = false ) {
		$p1 = $this->position( $one, $strict );
		$p2 = $this->position( $two, $strict );
		if ( $p1 > $p2 ) return 1;
		if ( $p2 > $p1 ) return -1;
		return 0;
	}


}
