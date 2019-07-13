<?php

$heading  = ' ';
$heading .= ' Att   ';
$heading .= 'Name      Weapon         To Hit     Dam       Atts          Movement         Seg   Attack Sequence';
echo "$heading\n";

foreach( $chars as $name => $body ) {
	$body->opponent['type']  = $monster->race;
	$body->opponent['ac']    = $monster->armor_class;
	$body->opponent['at']    = $monster->armor_type;
	$body->opponent['range'] = $range;
	$line  = '  ';
	$line .= sprintf( '%2u  ',   $atts[ $att_key ][ $name ] );
	$line .= dnd1e_get_combat_string( $body, $monster, $range );
	if ( $body->is_off_hand_weapon() ) {
		$body->set_primary_weapon();
		$string = dnd1e_get_combat_string( $body, $monster, $range );
		echo "      $string\n";
		$body->set_dual_weapon();
	}
	$line .= sprintf( '%u/%u  ', $body->weapon['attacks'][0], $body->weapon['attacks'][1] );
	$line .= sprintf( '%2u" ',   $body->movement );
	$line .= sprintf( '%s  ',    dnd1e_show_movement_segments( $body->movement ) );
	$line .= sprintf( '%2d  ',   $body->initiative['segment'] );
	$line .= substr( dnd1e_show_attack_sequence( $rounds, $body->initiative['segment'], $body->weapon['attacks'] ), $minus );
	echo "$line\n";
}

