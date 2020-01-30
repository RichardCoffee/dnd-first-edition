<?php

require_once( 'setup.php' );

$cnt = count( $argv );
$t = new DND_Combat_Treasure_Treasure;
if ( $cnt === 1 ) {
	$t->show_treasure_table();
} else {
	list( $line, $roll, $item, $type ) = array_pad( $argv, 4, '' );
	$roll = intval( $roll );
	if ( $roll > 0 ) {
		$next = $t->get_sub_table_name( $roll );
		if ( $cnt === 2 ) {
			$t->show_treasure_table( $next );
		} else if ( $cnt > 2 ) {
			$t->show_treasure_item( $next, $item, $type );
		}
	}
}
