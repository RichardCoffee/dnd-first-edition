<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );

$cnt = count( $argv );
$t = new DND_Treasure;
if ( $cnt === 1 ) {
	$t->show_treasure_table();
} else {
	$roll = intval( $argv[1] );
	if ( $roll > 0 ) {
		$next = $t->get_sub_table_name( $roll );
		if ( $cnt === 2 ) {
			$t->show_treasure_table( $next );
		} else if ( $cnt === 3 ) {
			$t->show_treasure_item( $next, $argv[2] );
		}
	}
}
