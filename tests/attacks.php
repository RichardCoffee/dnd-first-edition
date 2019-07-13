<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require( DND_FIRST_EDITION_DIR . '/functions.php' );
require( DND_FIRST_EDITION_DIR . '/includes/combat.php' );

require( DND_FIRST_EDITION_DIR . '/tests/setup.php' );

$rnds = 4;

echo "   Name           Weapon  Atts  Init  Seg   Attack Sequence\n";
foreach( $chars as $name => $body ) {
	$line  = sprintf( '%7s:',     $name );
	$line .= sprintf( '%17s  ',   $body->weapon['current'] );
	$line .= sprintf( '%u/%u   ', $body->weapon['attacks'][0], $body->weapon['attacks'][1] );
	$line .= sprintf( '%2u   ',   $body->initiative['actual'] );
	$line .= sprintf( '%2u  ',    $body->initiative['segment'] );
	$line .= dnd1e_show_attack_sequence( $rnds, $body->initiative['segment'], $body->weapon['attacks'] );
	echo "$line\n";
} //*/

