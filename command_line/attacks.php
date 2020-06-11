<?php

require_once( 'setup.php' );
require_once( '../tests/Test_Monster.php' );

$combat  = dnd1e()->combat;
$monster = new DND_Monster_Test;
#$combat->set_range( 50 );

foreach( $combat->party as $key => $char ) {
	if ( ! ( $key === 'Derryl' ) ) continue;
#	$name = sprintf( '%9s: %s', $key, $char->get_name(1) );
	$opponent = $combat->get_to_hit_number( $monster, $char );
	$name     = sprintf( '%-20s %2d', $char->get_name(1), $opponent );
	echo "  $name\n";
	foreach( $char->weapons as $key => $data ) {
		if ( in_array( $key, [ 'Ranged', 'Spell' ] ) ) continue;
		$combat->change_weapon( $char, $key );
		if ( array_key_exists( 'range', $char->weapon ) ) $combat->set_range( $char->weapon['range'][1] );
		$to_hit = max( 2, $combat->get_to_hit_number( $char, $monster ) );
		$weapon = sprintf( '%16s: %s  %2d', $key, $data['skill'], $to_hit );
		echo "\t$weapon\n";
	}
}
