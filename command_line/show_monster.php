<?php

echo "\n";

echo $monster->command_line_display() . "\n";

echo "{$appearing['number']} Appearing HP: {$monster->current_hp}/{$monster->hit_points}";
for( $i = 1; $i < $appearing['number']; $i++ ) {
	echo ", {$appearing['hit_points'][ $i ][0]}";
	echo "/{$appearing['hit_points'][ $i ][1]}";
}
echo "\n\n";


$heading = '            Name                Weapon           Dam    Atts          Movement           Seg   Attack Sequence';
echo "$heading\n";

$monmove = array_key_first( $monster->movement );

if ( $monster instanceOf DND_Monster_Humanoid_Humanoid ) {

	$att_seq = array();

	foreach( $monster->attacks as $type => $attack ) {
		$monster->fighter->set_current_weapon( $type );
		$current = $monster->fighter->weapon;
		$att_seq[ $type ] = dnd1e_get_attack_sequence( $rounds, $monster->initiative, $current['attacks'] );
		$line = '   '    . sprintf( '%20s',  substr( $monster->name, 0, 20 ) );
		$line.= ' '      . sprintf( '%15s',  $type );
		$line.= '      ' . sprintf( '%5s',   $monster->get_possible_damage( $type ) );
		$line.= '      ' . sprintf( '%u/%u', $current['attacks'][0], $current['attacks'][1] );
		$line.= '  '     . sprintf( '%2u',   $monster->movement[ $monmove ] );
		$line.= '  '     . dnd1e_get_mapped_movement_sequence( $monster->movement[ $monmove ] );
		$line.= '   '    . sprintf( '%d', ( $att_seq[ $type ][0] ) );//% 10 ) );
		$line.= '  '     . substr( dnd1e_get_mapped_attack_sequence( $rounds, $att_seq[ $type ] ), $minus );
		echo "$line\n";
	}

} else {

	$att_num = 0;
	$att_seq = array();
	$att_cnt = count( $monster->attacks );
	$att_cnt-= ( isset( $monster->attacks['Breath']  ) ) ? 1 : 0;
	$att_cnt-= ( isset( $monster->attacks['Spell']   ) ) ? 1 : 0;
	$att_cnt-= ( isset( $monster->attacks['Special'] ) ) ? 1 : 0;
	$att_seq['Normal'] = dnd1e_get_attack_sequence( $rounds, $monster->initiative, [ $att_cnt, 1 ] );
	$att_str = substr( dnd1e_get_mapped_attack_sequence( $rounds, $att_seq['Normal'] ), $minus );

	foreach( $monster->att_types as $type => $attack ) {
		$line = '   '       . sprintf( '%14s', substr( $monster->name, 0, 13 ) );
		$line.= '        '  . sprintf( '%15s', $type );
		$line.= '        '  . sprintf( '%-5s', $monster->get_possible_damage( $type ) );
		if ( isset( $attack['attacks'] ) ) {
			$line.= '    '   . sprintf( '%u/%u', $attack['attacks'][0], $attack['attacks'][1] );
			$line.= '      ' . dnd1e_get_mapped_movement_sequence( $monster->movement[ $monmove ] );
			$att_seq[ $type ] = dnd1e_get_attack_sequence( $rounds, $monster->initiative, $attack['attacks'] );
			$line.= '  '     . sprintf( '%2d', ( $att_seq[ $type ][0] ) );//% 10 ) );
			$line.= '  '     . substr( dnd1e_get_mapped_attack_sequence( $rounds, $att_seq[ $type ] ), $minus );
		} else if ( ! in_array( $type, [ 'Breath', 'Spell', 'Special' ] ) ) {
			$line.= '    '   . sprintf( '%u/1', $att_cnt );
			$line.= '      ' . dnd1e_get_mapped_movement_sequence( $monster->movement[ $monmove ] );
			$line.= '  '     . sprintf( '%2d', ( $att_seq['Normal'][ $att_num++ ] ) );//% 10 ) );
			$line.= '  '     . $att_str;
		}
		echo "$line\n";
	}

}

echo "\n";

$atts = $monster->get_to_hit_characters( $chars, $range );
