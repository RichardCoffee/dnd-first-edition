<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );

require( DND_FIRST_EDITION_DIR . '/functions.php' );

$args = array(
	'current' => 'Staff,Quarter',
	'level'   => 4,
	'weapons' => array(
		'Spell'         => 'PF',
		'Staff,Quarter' => 'PF',
		'Hammer,Lucern' => 'NP',
		'Bow,Long'      => 'SP'
	),
	'stats' => array(
		'str' => 19
	)
);

$test = new DND_Character_Cleric( $args );

echo "strength: " . $test->stats['str'] . "\n";

echo $test->get_to_hit_number( 10, 10 ) . "\n";
echo $test->get_to_hit_number( -4,  1 ) . "\n";
echo $test->get_to_hit_number(  8,  8 ) . "\n";
echo $test->get_to_hit_number(  4,  7 ) . "\n";
echo $test->get_to_hit_number( -2,  4 ) . "\n";
echo $test->get_to_hit_number(  2,  3 ) . "\n";
echo $test->get_to_hit_number( -2,  5 ) . "\n";
echo $test->get_to_hit_number( -1,  4 ) . "\n";
echo $test->get_to_hit_number(  1,  5 ) . "\n";
