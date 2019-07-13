<?php

echo "\n" . $monster->command_line_display() . "\n";

$heading = '  Name         Weapon                       Dam       Atts          Movement         Seg   Attack Sequence';
echo "$heading\n";

$att_key = '';
$att_num = 0;
$att_seq = dnd1e_get_attack_sequence( $rounds, $monster->initiative, [ count( $monster->attacks), 1 ] );
$att_str = substr( dnd1e_show_attack_sequence( $rounds, $monster->initiative, [ count( $monster->attacks), 1 ] ), $minus );
$atts    = $monster->get_to_hit_characters( $chars );
#print_r($atts);
$monmove = array_key_first( $monster->movement );

foreach( $monster->attacks as $type => $attack ) {
	if ( empty( $att_key ) ) $att_key = $type;
	$line  = ' '                   . sprintf( '%-14s', substr( $monster->name, 0, 13 ) );
	$line .= ''                    . sprintf( '%-10s', $type );
	$line .= '                   ' . sprintf( '%-4s', $monster->get_possible_damage( $type ) );
	$line .= '      '              . sprintf( '%u/1', count( $monster->attacks ) );
	$line .= '      '              . dnd1e_show_movement_segments( $monster->movement[ $monmove ] );
	$line .= '  '                  . sprintf( '%2u', $att_seq[ $att_num++ ] );
	$line .= '  '                  . $att_str;
	echo "$line\n";
}

echo "\n";
