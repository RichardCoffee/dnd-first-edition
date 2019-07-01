<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );

require( DND_FIRST_EDITION_DIR . '/functions.php' );
#require( DND_FIRST_EDITION_DIR . '/includes/combat.php' );
/*
$tank = new DND_Character_Fighter;
$tank->import_kregen_csv( CSV_PATH . 'Tank.csv' ); /*/
$strider = new DND_Character_Ranger;
#echo "import task: {$strider->import_task}\n";
$strider->import_kregen_csv( CSV_PATH . 'Strider.csv' ); /*
$ivan = new DND_Character_Paladin;
$ivan->import_kregen_csv( CSV_PATH . 'Ivan.csv' ); /*
$saerwen = new DND_Character_FighterMagicUser;
$saerwen->import_kregen_csv( CSV_PATH . 'Saerwen.csv' ); /*
$david = new DND_Character_Ranger;
$david->import_kregen_csv( CSV_PATH . 'David.csv' ); /*
$susan = new DND_Character_Cleric;
$susan->import_kregen_csv( CSV_PATH . 'Susan.csv' );
*/
/*
$players = array(
	'Tank'    => array( 'class' => 'Fighter' ),
#	'Strider' => array( 'class' => 'Ranger' ),
#	'Ivan'    => array( 'class' => 'Paladin' ),
#	'Saerwen' => array( 'class' => 'FighterMagicUser' ),
#	'David'   => array( 'class' => 'Ranger' ),
#	'Susan'   => array( 'class' => 'Cleric' )
);

$characters = dnd1e_load_characters( $players );

foreach( $characters as $name => $body ) {
	echo "$name: {$body->level}\n";
}
*/
#print_r($tank);
$strider->set_current_weapon('Bow,Long');
print_r($strider);
