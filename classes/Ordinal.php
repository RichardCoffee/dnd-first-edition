<?php

/*
 *  classes/ordinal.php
 *
 */

require_once('Enum.php');

class Ordinal extends Enum {


	use DND_Trait_Singleton;


	protected function __construct( $args = array() ) {
		$this->set = array( 'Cantrips',
			'First',         'Second',         'Third',         'Fourth',        'Fifth',
			'Sixth',         'Seventh',        'Eighth',        'Ninth',         'Tenth',
			'Eleventh',      'Twelfth',        'Thirteenth',    'Fourteenth',    'Fifteenth',
			'Sixteenth',     'Seventeenth',    'Eighteenth',    'Nineteenth',    'Twentieth',
			'Twenty-First',  'Twenty-Second',  'Twenty-Third',  'Twenty-Fourth', 'Twenty-Fifth',
			'Twenty-Sixth',  'Twenty-Seventh', 'Twenty-Eighth', 'Twenty-Ninth',  'Thirtieth',
		);
		if ( $args ) $this->set[0] = (array)$args[0];
	}

}
