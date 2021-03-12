<?php
if ( empty( $combat->party ) ) {
	$players = array(

		'Tank'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 4 ] ] ),
		'Strider' => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),

		'Derryl'  => array( 'class' => 'Cleric',           'data' => [ 'initiative' => [ 'roll' => 5 ], 'weap_allow' => [ 'Bow,Long' ] ] ),
		'Gaius'   => array( 'class' => 'Druid',            'data' => [ 'initiative' => [ 'roll' => 1 ], 'weap_allow' => [ 'Voulge' ] ] ),

		'Trindle' => array( 'class' => 'FighterThief',     'data' => [ 'initiative' => [ 'roll' => 6 ], 'weap_dual' => [ 'Dagger', 'Dagger,Off-Hand' ] ] ),
		'Evandur' => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 4 ] ] ),
		'Rider'   => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
		'Tifa'    => array( 'class' => 'MagicUserThief',   'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),

		'Saerwen' => array( 'class' => 'FighterMagicUser', 'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
		'Zao'     => array( 'class' => 'Monk',             'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),

#		'Krieg'   => array( 'class' => 'Barbarian',        'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
#		'David'   => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 3 ], 'shield' => [ 'type' => 'Small' ] ] ),
#		'Dayna'   => array( 'class' => 'ClericMagicUser',  'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),
#		'Pointer' => array( 'class' => 'RangerThief',      'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
#		'Susan'   => array( 'class' => 'ClericThief',      'data' => [ 'initiative' => [ 'roll' => 2 ] ] ),
#		'Tula'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),
	);
	$combat->import_party( $players );
}
#$combat->add_to_party( 'Fundin', array( 'class' => 'ClericMagicUser', 'data' => [ 'initiative' => [ 'roll' => 5 ], 'weap_allow' => [ 'Halberd' ] ] ) );
#$combat->add_to_party( 'Gaius', array( 'class' => 'Druid',   'data' => [ 'initiative' => [ 'roll' => 2 ], 'weap_allow' => [ 'Voulge' ] ] ) );
#$combat->add_to_party( 'Ivan', array( 'class' => 'Paladin', 'data' => [ 'initiative' => [ 'roll' => 2 ], 'shield' => [ 'type' => 'Large' ], 'horse' => 'paladin' ] ) );
#$combat->add_to_party( 'Saerwen', array( 'class' => 'FighterMagicUser', 'data' => [ 'initiative' => [ 'roll' => 3 ] ] ) );
#$combat->add_to_party( 'Krieg' );
