<?php

echo "\n" . $monster->command_line_display() . "\n";

$heading = '  Name                Weapon                 Dam     Atts          Movement          Seg   Attack Sequence';
echo "$heading\n";

$monmove = array_key_first( $monster->movement );

if ( property_exists( $monster, 'fighter' ) ) {

	$att_seq = array();

	foreach( $monster->attacks as $type => $attack ) {
		$monster->fighter->set_current_weapon( $type );
		$current = $monster->fighter->weapon;
		$att_seq[ $type ] = dnd1e_get_attack_sequence( $rounds, $monster->initiative, $current['attacks'] );
		$line = ' '      . sprintf( '%-20s', substr( $monster->name, 0, 20 ) );
		$line.= ' '      . sprintf( '%-15s', $type );
		$line.= '      ' . sprintf( '%5s',   $monster->get_possible_damage( $type ) );
		$line.= '      ' . sprintf( '%u/%u', $current['attacks'][0], $current['attacks'][1] );
		$line.= '  ' . sprintf( '%2u', $monster->movement[ $monmove ] );
		$line.= '  ' . dnd1e_show_movement_segments( $monster->movement[ $monmove ] );
		$line.= '  ' . sprintf( '%2u', $att_seq[ $type ][0] );
		$line.= '  ' . substr( dnd1e_show_attack_sequence( $rounds, $monster->initiative, $current['attacks'] ), $minus );
		echo "$line\n";
	}

} else {

	$att_num = 0;
	$att_cnt = count( $monster->attacks );
	$att_cnt-= ( isset( $monster->attacks['Breath'] ) ) ? 1 : 0;
	$att_cnt-= ( isset( $monster->attacks['Spell']  ) ) ? 1 : 0;
	$att_seq = dnd1e_get_attack_sequence( $rounds, $monster->initiative, [ $att_cnt, 1 ] );
	$att_str = substr( dnd1e_show_attack_sequence( $rounds, $monster->initiative, [ $att_cnt, 1 ] ), $minus );

	foreach( $monster->attacks as $type => $attack ) {
		$line = ' '                   . sprintf( '%-14s', substr( $monster->name, 0, 13 ) );
		$line.= ''                    . sprintf( '%-10s', $type );
		$line.= '                   ' . sprintf( '%4s', $monster->get_possible_damage( $type ) );
		if ( $type !== 'Breath' && $type !== 'Spell' ) {
			$line.= '      '              . sprintf( '%u/1', $att_cnt );
			$line.= '      '              . dnd1e_show_movement_segments( $monster->movement[ $monmove ] );
			$line.= '  '                  . sprintf( '%2u', $att_seq[ $att_num++ ] );
			$line.= '  '                  . $att_str;
		}
		echo "$line\n";
	}

}

echo "\n";

$atts = $monster->get_to_hit_characters( $chars, true );
