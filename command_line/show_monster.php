<?php

echo "\n";

echo $monster->command_line_display() . "\n";

$enemy = dnd1e_transient( 'enemy' );
echo count( $enemy ) . " Appearing HP: ";
foreach( $enemy as $key => $entity ) {
	echo "  $key: {$entity->current_hp}/{$entity->hit_points}";
}
echo "\n\n";


$heading = '            Name                Weapon           Dam    Atts          Movement           Seg   Attack Sequence';
echo "$heading\n";

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
		$line.= '  '     . sprintf( '%2u',   $monster->movement );
		$line.= '  '     . dnd1e_get_mapped_movement_sequence( $monster->movement[ $monmove ] );
		$line.= '  '     . sprintf( '%2d', ( $att_seq[ $type ][0] ) );//% 10 ) );
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
	$att_mon = dnd1e_get_attack_sequence( $rounds, $monster->initiative, [ $att_cnt, 1 ] );

	foreach( $monster->att_types as $type => $attack ) {
		if ( in_array( $type, [ 'Breath', 'Spell', 'Special' ] ) ) {
			$att_seq[ $type ] = dnd1e_get_attack_sequence( $rounds, $monster->initiative, [ 1, 1 ] );
		} else {
			$att_seq[ $type ] = dnd1e_get_attack_sequence( $rounds, $att_mon[ $att_num++ ], [ 1, 1 ] );
		}
	}

	foreach( $monster->att_types as $type => $attack ) {
		$line = '   '       . sprintf( '%14s', substr( $monster->name, 0, 13 ) );
		$line.= '        '  . sprintf( '%15s', $type );
		$line.= '        '  . sprintf( '%-5s', $monster->get_possible_damage( $type ) );
		$line.= '       ';
		$line.= '      ' . dnd1e_get_mapped_movement_sequence( $monster->movement );
		$line.= '  '     . sprintf( '%2d', ( $att_seq[ $type ][0] ) );//% 10 ) );
		$line.= '  '     . substr( dnd1e_get_mapped_attack_sequence( $rounds, $att_seq[ $type ] ), $minus );
		echo "$line\n";
	}

}

dnd1e_update_movement_transient( $segment, $monster );

echo "\n";

$atts = $monster->get_to_hit_characters( $chars, $range );
