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


}
