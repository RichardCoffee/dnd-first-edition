<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );

require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

delete_transient('dnd1e_appearing');
delete_transient('dnd1e_cast');
delete_transient('dnd1e_combat');
delete_transient('dnd1e_hold');
delete_transient('dnd1e_monster');
delete_transient('dnd1e_ongoing');
delete_transient('dnd1e_segment');
