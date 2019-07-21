<?php

$heading = '  ';
$heading.= 'Att      ';
$heading.= 'Name        ';
$heading.= 'Weapon          ';
$heading.= 'To Hit    ';
$heading.= 'Dam    ';
$heading.= 'Atts          ';
$heading.= 'Movement           ';
$heading.= 'Seg   Attack Sequence';
echo "$heading\n";

$opponent = array(
	'type'  => $monster->race,
	'ac'    => $monster->armor_class,
	'at'    => $monster->armor_type,
	'range' => $range,
);
foreach( $chars as $name => $body ) {
	$body->opponent = $opponent;
	$line  = ' ';
	$line .= sprintf( '%5s  ',   $atts[ $name ] );
	$line .= dnd1e_get_combat_string( $body, $monster, $range );
	if ( $body->is_off_hand_weapon() ) {
		$body->set_primary_weapon();
		$string = dnd1e_get_combat_string( $body, $monster, $range );
		echo "      $string\n";
		$body->set_dual_weapon();
	}
	$line .= sprintf( '%u/%u  ', $body->weapon['attacks'][0], $body->weapon['attacks'][1] );
	$line .= sprintf( '%2u" ',   $body->movement );
#	$mapped = dnd1e_get_mapped_movement_sequence( $body->movement );
#	$line .= sprintf( '%s  ',    dnd1e_get_adjusted_movement_map( $mapped, $segment ) );
	$line .= sprintf( '%s  ',    dnd1e_get_mapped_movement_sequence( $body->movement ) );
	$line .= sprintf( '%2d  ',   ( $body->segment ));//% 10 ) );
	$seq = dnd1e_get_attack_sequence( $rounds, $body->segment, $body->weapon['attacks'] );
	$line .= substr( dnd1e_get_mapped_attack_sequence( $rounds, $seq ), $minus );
	echo "$line\n";
	dnd1e_update_movement_transient( $segment, $body );
}

