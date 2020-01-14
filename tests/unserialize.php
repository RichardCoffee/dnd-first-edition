<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );
include_once( DND_FIRST_EDITION_DIR . '/command_line/monster.php' );

#print_r( $monster );
/*
$arr = array(
	'CW' => array(
		'H' => 'VR',
		'F' => 'R',
		'SM' => 'VR',
	),
	'TW' => array(
		'H' => 'VR',
		'F' => 'R',
		'SM' => 'VR',
	),
	'TSW' => array(
		'H' => 'VR',
		'F' => 'R',
		'SM' => 'VR',
	),
);
*/

class Test_Class {
	public function get_name() {
		return get_class($this);
	}
}

$me = new Test_Class;

#$test = serialize( $monster );
#$test = serialize( $arr );
$test = serialize( $me );

#echo "$test\n";

$obj = dnd1e_unserialize( $test );

if ( is_object( $obj ) ) {
	echo "\n" . $obj->get_name() . "\n\n";
} else {
	print_r( $obj );
}
