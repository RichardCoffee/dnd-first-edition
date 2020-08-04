<?php
if ( empty( $combat->party ) ) {
	$players = array(
		'Derryl'  => array( 'class' => 'Cleric',           'data' => [ 'initiative' => [ 'roll' => 4 ], 'weap_allow' => [ 'Bow,Long' ] ] ),
		'Evandur' => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
#		'Fundin'  => array( 'class' => 'ClericMagicUser',  'data' => [ 'initiative' => [ 'roll' => 5 ], 'weap_allow' => [ 'Halberd' ] ] ),
		'Gaius'   => array( 'class' => 'Druid',            'data' => [ 'initiative' => [ 'roll' => 2 ], 'weap_allow' => [ 'Voulge' ] ] ),
		'Ivan'    => array( 'class' => 'Paladin',          'data' => [ 'initiative' => [ 'roll' => 2 ], 'shield' => [ 'type' => 'Large' ], 'horse' => 'paladin' ] ),
		'Saerwen' => array( 'class' => 'FighterMagicUser', 'data' => [ 'initiative' => [ 'roll' => 3 ] ] ),
		'Strider' => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
		'Tank'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
		'Trindle' => array( 'class' => 'FighterThief',     'data' => [ 'initiative' => [ 'roll' => 1 ], 'weap_dual' => [ 'Dagger', 'Dagger,Off-Hand' ] ] ),
#		'Krieg'   => array( 'class' => 'Barbarian',        'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
#		'David'   => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 3 ], 'shield' => [ 'type' => 'Small' ] ] ),
		'Dayna'   => array( 'class' => 'ClericMagicUser',  'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
		'Pointer' => array( 'class' => 'RangerThief',      'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
#		'Susan'   => array( 'class' => 'ClericThief',      'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
		'Tula'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
	);
	$combat->import_party( $players );
}
#$combat->add_to_party('Fundin',array( 'class' => 'ClericMagicUser', 'data' => [ 'initiative' => [ 'roll' => 5 ], 'weap_allow' => [ 'Halberd' ] ] ) );
#$combat->add_to_party('Gaius',array( 'class' => 'Druid',   'data' => [ 'initiative' => [ 'roll' => 2 ], 'weap_allow' => [ 'Voulge' ] ] ) );
#$combat->add_to_party('Ivan', array( 'class' => 'Paladin', 'data' => [ 'initiative' => [ 'roll' => 2 ], 'shield' => [ 'type' => 'Large' ], 'horse' => 'paladin' ] ) );
#$combat->add_to_party('Saerwen', array( 'class' => 'FighterMagicUser', 'data' => [ 'initiative' => [ 'roll' => 3 ] ] ) );
#$combat->add_to_party('Krieg');
