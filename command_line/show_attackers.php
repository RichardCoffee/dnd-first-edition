<?php

echo "\nSegment $segment\n";
$rank = array();
foreach( $chars as $name => $body ) {
	$atts = dnd1e_get_attack_sequence( $rounds, $body->segment, $body->weapon['attacks'] );
	if ( in_array( $segment, $atts ) ) {
		$rank[] = $body;
	} else if ( $cast && ( isset( $cast[ $name ] ) ) ) {
		$rank[] = $body;
	}
}
if ( property_exists( $monster, 'fighter' ) ) {
	foreach( $monster->attacks as $type => $damage ) {
		if ( in_array( $segment, $att_seq[ $type ] ) ) {
			$rank_obj = new StdClass;
			$rank_obj->name = $monster->name . " ($type)";
			$rank_obj->stats = array( 'dex' => round( ( ( 10 - $monster->armor_class ) * 1.5 ) + 3 ) );
			$rank_obj->initiative = array( 'actual' => $monster->initiative );
			$rank[] = $rank_obj;
		}
	}
} else {
	if ( in_array( $segment, $att_seq ) ) {
		$rank_obj = new StdClass;
		$rank_obj->name = $monster->name;
		$rank_obj->stats = array( 'dex' => round( ( ( 10 - $monster->armor_class ) * 1.5 ) + 3 ) );
		$rank_obj->initiative = array( 'actual' => $monster->initiative );
		$rank[] = $rank_obj;
	}
}
dnd1e_rank_attackers( $rank, $segment );
foreach( $rank as $body ) {
	$name = ( $body instanceOf DND_Character_Character ) ? $body->get_name() : $body->name;
	echo "$name";
	if ( isset( $hold[ $name ] ) ) {
		echo " (holding)";
	}
	if ( isset( $cast[ $name ] ) ) {
		if ( $segment === $cast[ $name ]['when'] ) {
			$spell = $body->get_spell_info( $cast[ $name ]['spell'] );
			echo " casting {$cast[ $name ]['spell']} {$spell['page']}";
			if ( isset( $spell['range']    ) ) echo "\n\t         Range: {$spell['range']}";
			if ( isset( $spell['duration'] ) ) echo "\n\t      Duration: {$spell['duration']}";
			if ( isset( $spell['aoe']      ) ) echo "\n\tArea of Effect: {$spell['aoe']}";
			if ( isset( $spell['special']  ) ) echo "\n\t       Special: {$spell['special']}";
		} else {
			echo " (casting {$segment}/{$cast[ $name ]['when']})";
		}
	}
	echo "\n";
}

