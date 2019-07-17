<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/includes/treasure.php' );
/*
$monster = new DND_Monster_Hydra( [ 'heads' => 8 ] );

$treasure = $monster->get_treasure();
foreach( $treasure as $item => $data ) {
	printf( '%10s %s', $item, $data );
	echo "\n";
} //*/
/*
$table = dnd1e_get_magic_armor_shields_table();

$total = 0;
foreach( $table as $data ) {
	if ( ! is_array( $data ) ) continue;
	$total += $data['chance'];
}
echo "Total: $total\n"; //*/

require_once( DND_FIRST_EDITION_DIR . '/command_line/treasure.php' );

$cnt = count( $argv );
if ( $cnt === 1 ) {
	dnd1e_show_magic_treasure_table();
} else {
	$roll = intval( $argv[1] );
	if ( $roll > 0 ) {
		$main = dnd1e_get_magic_items_table();
		$next = '';
		foreach( $main as $item ) {
			if ( ! is_array( $item ) ) continue;
			$roll -= $item['chance'];
			if ( $roll < 1 ) {
				$next = $item['sub'];
				break;
			}
		}
		if ( $cnt === 2 ) {
			dnd1e_show_magic_treasure_table( $next );
		} else if ( $cnt === 3 ) {
			$func = dnd1e_get_sub_table_string( $next );
			$sec  = $func();
			$roll = intval( $argv[2] );
			$pick = '';
			foreach( $sec as $item ) {
				if ( ! is_array( $item ) ) {
					echo "    $item\n";
					continue;
				}
				$roll -= $item['chance'];
				if ( $roll < 1 ) {
					echo "  {$item['text']}   {$item['xp']}xp  {$item['gp']}gp  {$item['link']}\n";
					$roll = 1000000;
				}
			}
		}
	}
} //*/
