<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require( DND_FIRST_EDITION_DIR . '/functions.php' );
require( DND_FIRST_EDITION_DIR . '/includes/combat.php' );

require( DND_FIRST_EDITION_DIR . '/tests/setup.php' );

print_r( $monster );
