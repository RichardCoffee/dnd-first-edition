<?php

echo "\nSegment $segment\n";
echo "---Attacks---\n";
$rankc = dnd1e_get_character_attackers( $chars, $rounds, $segment );
$rankm = dnd1e_get_monster_attackers( $monster, $att_seq, $segment );
$rank = array_merge( $rankc, $rankm );
dnd1e_rank_attackers( $rank, $segment );
foreach( $rank as $body ) {
	$name = ( $body instanceOf DND_Character_Character ) ? $body->get_name() : $body->name;
	echo "\t$name";
	if ( isset( $hold[ $name ] ) ) {
		echo " (holding)";
	}
	if ( isset( $cast[ $name ] ) ) {
		if ( $segment === $cast[ $name ]['when'] ) {
			$spell = $body->locate_magic_spell( $cast[ $name ]['spell'] );
			$spell['target'] = ( isset( $cast[ $name ]['target'] ) ) ? $cast[ $name ]['target'] : $name;
			dnd1e_show_casting_spell( $spell, $segment );
			dnd1e_finish_casting_spell( $spell, $segment );
		} else {
			echo " (casting {$segment}/{$cast[ $name ]['when']})";
		}
	}
	echo "\n";
}

$moves = dnd1e_transient( 'movement' );
if ( $moves ) {
	echo "---Movement---\n";
	foreach( $moves as $moving ) {
		echo "\t$moving\n";
	}
}
