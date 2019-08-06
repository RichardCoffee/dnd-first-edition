<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/includes/combat.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );
/*
$temp = dnd1e_transient( 'class' ); //'combat' );
$coded = json_encode( $temp );
#print_r($coded);
$decode = json_decode( $coded, true );//, 512, JSON_OBJECT_AS_ARRAY );
#print_r($decode);
$combat = DND_CommandLine::get_instance( $decode );
*/

$combat = dnd1e_transient( 'combat' );
if ( empty( $combat ) ) {
	$combat = DND_CommandLine::instance();
}
/*
$segment = intval( dnd1e_transient( 'segment' ) );
echo "seg: $segment\n";
while ( $combat->segment < $segment ) {
	$combat->increment_segment();
	echo "seg:{$combat->segment}\n";
	echo get_class($combat)."\n";
} //*/
/*
$ongoing = dnd1e_transient( 'ongoing' );
$combat->import_effects( $ongoing );
print_r( $combat->effects ); //*/
/*
$chars = dnd1e_transient( 'party' );
foreach( $chars as $char ) {
	$combat->add_to_party( $char );
} //*/
/*
$monster = dnd1e_transient( 'monster' );
$combat->add_to_enemy( $monster );
print_r( $combat->enemy ); //*/
/*
$enemy = dnd1e_transient( 'enemy' );
$combat->import_enemy( $enemy );
print_r( dnd1e()->logging_reduce_object( $combat ) ); //*/
/*
$state = dnd1e_transient( 'combat' );
$combat->import_combat( $state ); //*/

#print_r( $combat );
#print_r( dnd1e()->logging_reduce_object( $combat ) );
/*
foreach( $combat->enemy as $index => $monster ) {
	printf( '%20s %2u %3d/%3u', $monster->get_name(), $monster->initiative, $monster->current_hp, $monster->hit_points );
	echo "\n";
}
echo "\n"; //*/
/*
foreach( $combat->party as $name => $char ) {
	printf( '%20s %2u %20s %3d/%3u', $char->get_name(), $char->segment, $char->weapon['current'], $char->get_hit_points(), $char->hit_points );
	echo "\n";
}
echo "\n"; //*/

#print_r($combat->casting);
#print_r(dnd1e()->logging_reduce_object($combat->party['Derryl']));
#print_r(dnd1e()->logging_reduce_object($combat->party['Strider']));
print_r($combat->party['Derryl']);

#dnd1e_transient( 'combat', $combat );
