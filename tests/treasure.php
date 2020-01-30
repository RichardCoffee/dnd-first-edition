<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
#require_once( DND_FIRST_EDITION_DIR . '/includes/treasure.php' );
/*
$monster = new DND_Monster_Hydra( [ 'heads' => 8 ] );

$treasure = $monster->get_treasure();
foreach( $treasure as $item => $data ) {
	printf( '%10s %s', $item, $data );
	echo "\n";
} //*/

$t = new DND_Combat_Treasure_Treasure;
$table = $t->get_weapons_table();

$total = 0;
foreach( $table as $data ) {
	if ( is_array( $data ) ) {
		$total += $data['chance'];
	}
}
echo "Total: $total\n"; //*/
/*
#require_once( DND_FIRST_EDITION_DIR . '/command_line/treasure.php' );

$cnt = count( $argv );
$t = new DND_Combat_Treasure_Treasure;
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
} //*/
