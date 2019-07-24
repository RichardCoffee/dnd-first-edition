<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/includes/combat.php' );

require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

$trans = get_transient( 'dnd1e_ongoing' );

print_r($trans);
