<?php

require_once( 'setup.php');

$combat = dnd1e()->combat;

include_once( DND_FIRST_EDITION_DIR . '/command_line/characters.php' );
include_once( DND_FIRST_EDITION_DIR . '/command_line/monster.php' );

$combat->process_opts();
$combat->process_arguments( $argv );
$combat->show_enemy_information();
$combat->show_party_information();
$combat->show_notifications();

dnd1e()->transient( 'combat', $combat );
