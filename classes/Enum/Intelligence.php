<?php

/*
 *  classes/Enum/Intelligence.php
 *
 */

class DND_Enum_Intelligence extends DND_Enum_Enum {


	public function __construct( $args = array() ) {
		$this->set = array( 'Non-',
			'Animal',        'Semi-',        'Semi-',        'Semi-',       'Low',
			'Low',           'Low',          'Average',      'Average',     'Average',
			'Very',          'Very',         'High',         'High',        'Exceptional',
			'Exceptional',   'Genius',       'Genius',       'Supra-',      'Supra-',
			'Godlike',
		);
		if ( $args && is_array( $args ) ) $this->set = array_replace( $this->set, $args );
	}

	public function has( $search, $strict = false ) {
		$parsed = explode( ' ', $search );
		return parent::has( $parsed[0], $strict );
	}

	public function position( $search, $strict = false ) {
		$parsed = explode( ' ', $search );
		return parent::position( $parsed[0], $strict );
	}

	public function range( $search, $strict = false ) {
		$parsed = explode( ' ', $search );
		$range  = array();
		if ( $this->has( $parsed[0], $strict ) ) {
			$pos1 = $this->pos( $parsed[0], $strict );
			$pos2 = ( count( $parsed ) > 2 ) ? $this->pos( $parsed[2], $strict ) : $pos1;
			while( ( $pos1 < $pos2 ) || in_array( $this->set[ $pos1 ], $parsed ) ) {
				$range[] = $pos1++;
			}
		}
		return $range;
	}

}
