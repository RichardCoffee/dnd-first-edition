<?php

function minimize_string( $base, $len, $string ) {
	if ( $len > 0 ) {
#echo " len: $len\n";
		$diff = $base[1] - strlen( $string );
#echo "diff: $diff\n";
		$base[1] -= ( $len > $diff ) ? $diff : $len;
		$len -= $diff;
#echo " len: $len\n";
	}
	return array( $len, implode( '', $base ) );
}

$test = array(
	array(
		'hits' => '20/22/18/21/46',
		'info' => 'Evandur(60/60)',
		'weap' => ': Sword,Short',
		'to'   => 7,
	),
	array(
		'hits' => '22/23/19/47',
		'info' => 'Ivan(50/50)',
		'weap' => ': Sword,Bastard',
		'to'   => 8,
	),
	array(
		'hits' => '11/10/12/35',
		'info' => 'Saerwen(28/28)',
		'weap' => ': Spell(7/7)',
		'to'   => 11,
	),
	array(
		'hits' => '17/18/14/42',
		'info' => 'Tank(50/50)',
		'weap' => ': Sword,Long',
		'to'   => 7,
	),
	array(
		'hits' => '20/50',
		'info' => 'Derryl(54/54)',
		'weap' => ': Spell(15/15)',
		'to'   => 11,
	),
	array(
		'hits' => '11/10/35',
		'info' => 'Gaius(27/27)',
		'weap' => ': Spell(10/10)',
		'to'   => 13,
	),
	array(
		'hits' => '17/19/18/43',
		'info' => 'Strider(40/40)',
		'weap' => ': Sword,Long',
		'to'   => 11,
	),
	array(
		'hits' => '14/15/39',
		'info' => 'Trindle(43/43)',
		'weap' => ': Dagger',
		'to'   => 7,
	),
);

foreach( $test as $item ) {
	extract( $item );
	$len  = max( 0, strlen( $hits ) - 5 );
	$line = sprintf( ' %5s ', $hits );
	list( $len, $string ) = minimize_string( [ '%', 16, 's' ], $len, $info );
	$line.= sprintf( $string,  $info );
	list( $len, $string ) = minimize_string( [ '%-', 34, 's ' ], $len, $weap );
	$line.= sprintf( $string, $weap );
	echo "$line.\n";
}
