<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/includes/combat.php' );

require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

include_once( DND_FIRST_EDITION_DIR . '/command_line/setup.php' );
include_once( DND_FIRST_EDITION_DIR . '/command_line/monster.php' );

$range   = get_transient( 'dnd1e_range' );
$rounds  = 2;
$segment = intval( get_transient( 'dnd1e_segment' ) );

if ( ! $range ) {
	$range = 2000;
}
if ( ! $segment ) {
	$segment = 1;
}

include_once( DND_FIRST_EDITION_DIR . '/command_line/getopts.php' );

if ( ! empty( $hold ) ) { // $hold created in getopts.php
	foreach( $hold as $hname => $hseg ) {
		$hold [ $hname ] = $segment;
		$chars[ $hname ]->set_segment( $segment );
	}
	set_transient( 'dnd1e_hold', $hold );
}

if ( ! empty( $attack ) ) { // $attack created in getopts.php
	foreach( $attack as $aname => $aseg ) {
		if ( isset( $hold[ $aname ] ) ) continue;
		$chars[ $aname ]->set_segment( $aseg );
	}
}

if ( ! empty( $weapons ) ) { // $weapons created in getopts.php
	foreach( $weapons as $wname => $wweapon ) {
		$chars[ $wname ]->set_current_weapon( $wweapon );
	}
}

$minus = ( ( ( $segment - 1 ) + floor( ( $segment -1 ) / 10 ) ) * 2 );

include_once( DND_FIRST_EDITION_DIR . '/command_line/show_monster.php' );
include_once( DND_FIRST_EDITION_DIR . '/command_line/show_characters.php' );
include_once( DND_FIRST_EDITION_DIR . '/command_line/show_attackers.php' );

set_transient( 'dnd1e_monster', $monster );

#print_r($monster);
