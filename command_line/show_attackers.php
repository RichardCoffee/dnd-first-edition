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
			$spell = $body->get_spell_info( $cast[ $name ]['spell'] );
#print_r($spell);
			echo " casting {$cast[ $name ]['spell']} {$spell['data']['page']}";
			if ( isset( $spell['data']['range']    ) ) echo "\n\t\t         Range: {$spell['data']['range']}";
			if ( isset( $spell['data']['duration'] ) ) echo "\n\t\t      Duration: {$spell['data']['duration']}";
			if ( isset( $spell['data']['aoe']      ) ) echo "\n\t\tArea of Effect: {$spell['data']['aoe']}";
			if ( isset( $spell['data']['special']  ) ) echo "\n\t\t       Special: {$spell['data']['special']}";
			if ( isset( $spell['data']['filters']  ) ) {
				$spell['target']  = $name;
				$spell['segment'] = $segment;
				if ( isset( $spell['data']['duration'] ) ) {
					$length = ( strpos( $spell['data']['duration'], 'segment' ) ) ? intval( $spell['data']['duration'] ) : intval( $spell['data']['duration'] ) * 10;
					$spell['ends'] = $segment + $length;
				}
				dnd1e_add_ongoing_spell_effects( $spell );
			}
		} else {
			echo " (casting {$segment}/{$cast[ $name ]['when']})";
		}
	}
	echo "\n";
}

$moves = get_transient( 'dnd1e_movement' );
if ( $moves ) {
	echo "---Movement---\n";
	foreach( $moves as $moving ) {
		echo "\t$moving\n";
	}
}
