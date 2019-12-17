<?php

/*
 *  classes/Enum/Latinate.php
 *
 */

class DND_Enum_Latinate extends DND_Enum_Enum {


	use DND_Trait_Singleton;


	protected function __construct( $args = array() ) {
		$this->set = array( 'Absence',
			'Primary',      'Secondary',      'Tertiary',      'Quaternary',     'Quinary',
			'Senary',       'Septenary',      'Octonary',      'Nonary',         'Denary',
			'Undenary',     'Duodenary',      'Tredenary',     'Quattuordenary', 'Quindenary',
			'Sedenary',     'Septendenary',   'Octodenary',    'Novemdenary',    'Vigenary',
		);
		if ( $args && is_array( $args ) ) $this->set = array_replace( $this->set, $args );
	}

}
