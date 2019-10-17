<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/includes/combat.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

$combat = dnd1e_transient( 'combat' );
if ( empty( $combat ) ) {
	$combat = DND_CommandLine::instance();
}

include_once( DND_FIRST_EDITION_DIR . '/command_line/characters.php' );
include_once( DND_FIRST_EDITION_DIR . '/command_line/monster.php' );

$combat->process_arguments( $argv );
$combat->show_enemy_information();
$combat->show_party_information();
$combat->show_notifications();

#print_r($combat->casting);
#print_r($combat->effects);
#print_r( dnd1e()->logging_reduce_object( $combat->enemy ) );
#print_r( dnd1e()->logging_reduce_object( $combat->party['Pointer'] ) );
#print_r( $combat->party['Gaius'] );
#print_r( $combat->party['Pointer'] );
#print_r( $combat->party['Trindle'] );
#print_r( $combat->party['Tula'] );

dnd1e_transient( 'combat', $combat );
