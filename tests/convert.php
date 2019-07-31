<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/includes/combat.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

$monster = dnd1e_transient( 'monster' );
$appear  = dnd1e_transient( 'appearing' );

print_r( $appear );

$what   = get_class( $monster );
$enemy  = array( $monster );
$number = $appear['number'];
$points = $appear['hit_points'];
for( $i = 1; $i < $number; $i++ ) {
	$enemy[] = new $what( [ 'current_hp' => $points[ $i ][0], 'hit_points' => $points[ $i ][1] ] );
}
dnd1e_transient( 'enemy', $enemy ); //*/

#$enemy = dnd1e_transient( 'enemy' );
echo count( $enemy ) . " Appearing HP: ";
foreach( $enemy as $key => $entity ) {
	echo "  $key: {$entity->current_hp}/{$entity->hit_points}";
}
echo "\n\n";
