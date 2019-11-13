<?php

if ( empty( $combat->party ) ) {
	$players = array(
		'Evandur' => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
		'Ivan'    => array( 'class' => 'Paladin',          'data' => [ 'initiative' => [ 'roll' => 2 ], 'shield' => [ 'type' => 'Large' ], 'horse' => 'paladin' ] ),
		'Saerwen' => array( 'class' => 'FighterMagicUser', 'data' => [ 'initiative' => [ 'roll' => 3 ] ] ),
		'Tank'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 1 ] ] ), //*/
		'Dayna'   => array( 'class' => 'ClericMagicUser',  'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
		'Derryl'  => array( 'class' => 'Cleric',           'data' => [ 'initiative' => [ 'roll' => 4 ], 'weap_allow' => [ 'Bow,Long' ] ] ),
		'Gaius'   => array( 'class' => 'Druid',            'data' => [ 'initiative' => [ 'roll' => 2 ], 'weap_allow' => [ 'Voulge' ] ] ),
		'Pointer' => array( 'class' => 'RangerThief',      'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
		'Strider' => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
		'Trindle' => array( 'class' => 'FighterThief',     'data' => [ 'initiative' => [ 'roll' => 1 ], 'weap_dual' => [ 'Dagger', 'Dagger,Off-Hand' ] ] ),
		'Tula'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 2 ] ] ), //*/
#		'Krieg'   => array( 'class' => 'Barbarian',        'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
#		'David'   => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 3 ], 'shield' => [ 'type' => 'Small' ] ] ),
#		'Susan'   => array( 'class' => 'ClericThief',      'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
	); //*/
	$combat->import_party( $players );
} else {
	echo "Using transient party data\n";
	$allowed = array(
		'Derryl' => 'Bow,Long',
		'Gaius'  => 'Voulge',
	);
	foreach( $combat->party as $name => $char ) {
		if ( array_key_exists( $name, $allowed ) ) {
			$char->add_to_allowed_weapons( $allowed[ $name ] );
		}
	}
	if ( array_key_exists( 'Trindle', $combat->party ) ) {
		$combat->party['Trindle']->set_dual_weapons( 'Dagger', 'Dagger,Off-Hand' );
#		$combat->party['Trindle']->set_current_weapon( 'Dagger,Off-Hand' );
	} //*/
}
#$combat->add_to_party('Gaius',array( 'class' => 'Druid',   'data' => [ 'initiative' => [ 'roll' => 2 ], 'weap_allow' => [ 'Voulge' ] ] ) );
#$combat->add_to_party('Ivan', array( 'class' => 'Paladin', 'data' => [ 'initiative' => [ 'roll' => 2 ], 'shield' => [ 'type' => 'Large' ], 'horse' => 'paladin' ] ) );
#$combat->add_to_party('Saerwen', array( 'class' => 'FighterMagicUser', 'data' => [ 'initiative' => [ 'roll' => 3 ] ] ) );
#$combat->add_to_party('Krieg');
