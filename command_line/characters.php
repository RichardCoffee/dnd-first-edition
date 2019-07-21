<?php

$players = array(
	'David'   => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 3 ], 'shield' => [ 'type' => 'Small' ] ] ),
#	'Dayna'   => array( 'class' => 'ClericMagicUser',  'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
#	'Derryl'  => array( 'class' => 'Cleric',           'data' => [ 'initiative' => [ 'roll' => 2 ], 'weap_allow' => [ 'Bow,Long' ] ] ),
	'Evandur' => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),
#	'Gaius'   => array( 'class' => 'Druid',            'data' => [ 'initiative' => [ 'roll' => 2 ], 'weap_allow' => [ 'Voulge' ] ] ),
	'Ivan'    => array( 'class' => 'Paladin',          'data' => [ 'initiative' => [ 'roll' => 5 ], 'shield' => [ 'type' => 'Large' ], 'has_horse' => true ] ),
#	'Krieg'   => array( 'class' => 'Barbarian',        'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
#	'Pointer' => array( 'class' => 'RangerThief',      'data' => [ 'initiative' => [ 'roll' => 4 ] ] ),
	'Saerwen' => array( 'class' => 'FighterMagicUser', 'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),
#	'Strider' => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),
	'Susan'   => array( 'class' => 'ClericThief',      'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
	'Tank'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),
#	'Trindle' => array( 'class' => 'FighterThief',     'data' => [ 'initiative' => [ 'roll' => 5 ], 'weap_dual' => [ 'Dagger', 'Dagger,Off-Hand' ] ] ),
#	'Tula'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),
); //*/

$chars = dnd1e_import_kregen_characters( $players );
/*
$read_character_transients = array(
	'David' => 'Ranger',
);

foreach( $read_
*/
