<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/includes/combat.php' );

require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

$range   = 2000;
$rounds  = 3;
$segment = intval( get_transient( 'dnd1e_segment' ) );

if ( ! $segment ) {
	$segment = 1;
}

dnd1e_apply_ongoing_spell_effects( $segment );

include_once( DND_FIRST_EDITION_DIR . '/command_line/characters.php' );
include_once( DND_FIRST_EDITION_DIR . '/command_line/monster.php' );

dnd1e_load_combat_state( $chars );

include_once( DND_FIRST_EDITION_DIR . '/command_line/getopts.php' );

if ( ! empty( $hold ) ) { // $hold created in getopts.php
	foreach( $hold as $hname => $hseg ) {
		$hold [ $hname ] = $segment;
		$chars[ $hname ]->segment = $segment;
	}
	set_transient( 'dnd1e_hold', $hold );
}

$minus = ( ( ( $segment - 1 ) + floor( ( $segment -1 ) / 10 ) ) * 2 );

delete_transient( 'dnd1e_movement' );

include_once( DND_FIRST_EDITION_DIR . '/command_line/show_monster.php' );
include_once( DND_FIRST_EDITION_DIR . '/command_line/show_characters.php' );
include_once( DND_FIRST_EDITION_DIR . '/command_line/show_attackers.php' );

set_transient( 'dnd1e_monster', $monster );

dnd1e_save_combat_state( $chars );

dnd1e_save_character_transients( $chars );

#print_r($monster);
