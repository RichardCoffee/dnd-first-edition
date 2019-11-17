<?php

/*
 *  classes/latinate.php
 *
 */

require_once('Enum.php');

class Latinate extends Enum {


	use DND_Trait_Singleton;


	protected function __construct( $args = array() ) {
		$this->set = array( 'Absence',
			'Primary',      'Secondary',      'Tertiary',      'Quaternary',     'Quinary',
			'Senary',       'Septenary',      'Octonary',      'Nonary',         'Denary',
			'Undenary',     'Duodenary',      'Tredenary',     'Quattuordenary', 'Quindenary',
			'Sedenary',     'Septendenary',   'Octodenary',    'Novemdenary',    'Vigenary',
			'Twenty-First', 'Twenty-Second',  'Twenty-Third',  'Twenty-Fourth',  'Twenty-Fifth',
			'Twenty-Sixth', 'Twenty-Seventh', 'Twenty-Eighth', 'Twenty-Ninth',   'Thirtieth',
		);
		if ( $args ) $this->set[0] = (array)$args[0];
	}

}
