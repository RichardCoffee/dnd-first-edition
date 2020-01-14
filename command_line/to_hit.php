<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );

require( DND_FIRST_EDITION_DIR . '/functions.php' );

$players = array(
	'David'   => array( 'class' => 'Ranger', 'data' => [ 'shield' => [ 'type' => 'Small' ] ] ),
	'Dayna'   => array( 'class' => 'ClericMagicUser' ),
	'Derryl'  => array( 'class' => 'Cleric' ),
	'Evandur' => array( 'class' => 'Fighter' ),
	'Gaius'   => array( 'class' => 'Druid' ),
	'Ivan'    => array( 'class' => 'Paladin', 'data' => [ 'shield' => [ 'type' => 'Large' ] ] ),
	'Saerwen' => array( 'class' => 'FighterMagicUser' ),
	'Strider' => array( 'class' => 'Ranger' ),
	'Susan'   => array( 'class' => 'Cleric' ),
	'Tank'    => array( 'class' => 'Fighter' ),
	'Trindle' => array( 'class' => 'FighterThief' ),
	'Tula'    => array( 'class' => 'Fighter' ),
);

$chars = dnd1e_import_characters( $players );

$chars['David'  ]->set_current_weapon('Bow,Long');
$chars['Dayna'  ]->set_current_weapon('Dagger');
$chars['Derryl' ]->set_current_weapon('Bow,Long');
$chars['Evandur']->set_current_weapon('Sword,Short');
$chars['Gaius'  ]->set_current_weapon('Voulge');
$chars['Ivan'   ]->set_current_weapon('Sword,Two Handed');
$chars['Saerwen']->set_current_weapon('Javelin');
$chars['Strider']->set_current_weapon('Bow,Long');
$chars['Susan'  ]->set_current_weapon('Staff,Quarter');
$chars['Tank'   ]->set_current_weapon('Sword,Long');
$chars['Trindle']->set_current_weapon('Dagger');
$chars['Tula'   ]->set_current_weapon('Crossbow,Heavy');

$tar_ac = 5;
$tar_at = 5;
$range  = 80;

echo "  Name   Lvl    Weapon               To Hit  Dam   Atts   Movement\n";
foreach( $chars as $name => $body ) {
	$line  = sprintf( '%7s: %2u   %-25s', $name, $body->level, $body->weapon['current'] );
	$line .= sprintf( '%2d', $body->get_to_hit_number( $tar_ac, $tar_at, $range ) );
	$line .= sprintf( '    %2d', $body->get_weapon_damage_bonus( $range ) );
	$line .= sprintf( '    %u/%u', $body->weapon['attacks'][0], $body->weapon['attacks'][1] );
	$line .= sprintf( '   %s', dnd1e_show_movement_segments( $body ) );
	echo "$line\n";
} //*/
