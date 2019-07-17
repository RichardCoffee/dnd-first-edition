<?php

#define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );

#require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/includes/treasure.php' );
#require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

#include_once( DND_FIRST_EDITION_DIR . '/command_line/monster.php' );

function dnd1e_show_possible_monster_treasure( &$monster, $possible = '' ) {
	$treasure = $monster->get_treasure( $possible );
	if ( is_array( $treasure ) ) {
		foreach( $treasure as $item ) {
			echo "$item\n";
		}
	} else {
		echo "$treasure\n";
	}
	echo "\n";
}

function dnd1e_show_magic_treasure_table( $table = 'items' ) {
	$table = strtolower( $table );
	$func  = dnd1e_get_sub_table_string( $table );
	$items = $func();
	$forms = ( in_array( $table , [ 'potions', 'rings', 'armor_shields' ] ) ) ? [ '%03u', '  %1$03u  ' ] : [ '%02u', '  %1$02u ' ];
	$perc  = 1;
	foreach( $items as $item ) {
		if ( ! is_array( $item ) ) {
			echo "          $item\n";
			continue;
		}
		$rg_end  = $perc + $item['chance'] - 1;
		$format  = ( $perc === $rg_end ) ? $forms[1] : "{$forms[0]}-{$forms[0]}";
		$format .= ' : %3$-30s';
		$line = sprintf( $format, $perc, $rg_end, $item['text'] );
		echo "  $line\n";
		$perc += $item['chance'];
	}
}
