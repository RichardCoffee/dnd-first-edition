<?php

echo "\nSegment $segment\n";
$rank = array();
foreach( $chars as $name => $body ) {
	$atts = dnd1e_get_attack_sequence( $rounds, $body->initiative['segment'], $body->weapon['attacks'] );
	if ( in_array( $segment, $atts ) ) {
		$rank[] = $body;
	}
}
if ( in_array( $segment, $att_seq ) ) {
	$rank_obj = new StdClass;
	$rank_obj->name = $monster->name;
	$rank_obj->stats = array( 'dex' => round( ( ( 10 - $monster->armor_class ) * 1.5 ) + 3 ) );
	$rank_obj->initiative = array( 'actual' => $monster->initiative );
	$rank[] = $rank_obj;
}
dnd1e_rank_attackers( $rank );
foreach( $rank as $body ) {
	echo "{$body->name}";
	if ( isset( $hold[ $body->name ] ) ) {
		echo " (holding)";
	}
	echo "\n";
}

