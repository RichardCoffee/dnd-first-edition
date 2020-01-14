<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require( DND_FIRST_EDITION_DIR . '/functions.php' );
require( DND_FIRST_EDITION_DIR . '/tests/setup.php' );

echo "   Name    Move        Movement\n";
foreach( $chars as $name => $body ) {
	$line  = sprintf( '%8s:   ',   $name );
	$line .= sprintf( '%2u    ', $body->movement );
	$line .= sprintf( '%s',      dnd1e_show_movement_segments( $body ) );
	echo "$line\n";
} //*/

