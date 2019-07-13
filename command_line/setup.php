<?php

$players = array(
#	'David'   => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 1 ], 'shield' => [ 'type' => 'Small' ] ] ),
	'Dayna'   => array( 'class' => 'ClericMagicUser',  'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
	'Derryl'  => array( 'class' => 'Cleric',           'data' => [ 'initiative' => [ 'roll' => 2 ], 'weap_allow' => [ 'Bow,Long' ] ] ),
	'Evandur' => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 4 ] ] ),
	'Gaius'   => array( 'class' => 'Druid',            'data' => [ 'initiative' => [ 'roll' => 2 ], 'weap_allow' => [ 'Voulge' ] ] ),
#	'Ivan'    => array( 'class' => 'Paladin',          'data' => [ 'initiative' => [ 'roll' => 1 ], 'shield' => [ 'type' => 'Large' ], 'has_horse' => true ] ),
#	'Krieg'   => array( 'class' => 'Barbarian',        'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
	'Pointer' => array( 'class' => 'RangerThief',      'data' => [ 'initiative' => [ 'roll' => 4 ] ] ),
#	'Saerwen' => array( 'class' => 'FighterMagicUser', 'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
	'Strider' => array( 'class' => 'Ranger',           'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),
#	'Susan'   => array( 'class' => 'ClericThief',      'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
#	'Tank'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 1 ] ] ),
	'Trindle' => array( 'class' => 'FighterThief',     'data' => [ 'initiative' => [ 'roll' => 5 ], 'weap_dual' => [ 'Dagger', 'Dagger,Off-Hand' ] ] ),
	'Tula'    => array( 'class' => 'Fighter',          'data' => [ 'initiative' => [ 'roll' => 5 ] ] ),
); //*/

$chars = dnd1e_import_kregen_characters( $players );

#	$chars['David'  ]->set_segment( 1 );
#	$chars['Dayna'  ]->set_segment( 3 );
#	$chars['Derryl' ]->set_segment( 1 );
#	$chars['Evandur']->set_segment( 10 );
#	$chars['Gaius'  ]->set_segment( 1 );
#	$chars['Ivan'   ]->set_segment( 1 );
#	$chars['Krieg'  ]->set_segment( 1 );
#	$chars['Pointer']->set_segment( 1 );
#	$chars['Searwen']->set_segment( 1 );
#	$chars['Strider']->set_segment( 1 );
#	$chars['Susan'  ]->set_segment( 1 );
#	$chars['Tank'   ]->set_segment( 1 );
#	$chars['Trindle']->set_segment( 10 );
#	$chars['Tula'   ]->set_segment( 1 );

#	$chars['David'  ]->set_current_weapon('Bow,Long');
#	$chars['Dayna'  ]->set_current_weapon('Dagger');
	$chars['Derryl' ]->set_current_weapon('Bow,Long');
	$chars['Evandur']->set_current_weapon('Axe,Throwing');
#	$chars['Evandur']->set_current_weapon('Sword,Short');
	$chars['Gaius'  ]->set_current_weapon('Voulge');
#	$chars['Ivan'   ]->set_current_weapon('Sword,Two Handed');
#	$chars['Krieg'  ]->set_current_weapon('Bow,Short');
#	$chars['Krieg'  ]->set_current_weapon('Sword,Broad');
	$chars['Pointer']->set_current_weapon('Bow,Long');
#	$chars['Pointer']->set_current_weapon('Sword,Long');
#	$chars['Saerwen']->set_current_weapon('Javelin');
	$chars['Strider']->set_current_weapon('Bow,Long');
#	$chars['Susan'  ]->set_current_weapon('Staff,Quarter');
#	$chars['Tank'   ]->set_current_weapon('Sword,Long');
#	$chars['Trindle']->set_current_weapon('Dagger');
#	$chars['Trindle']->set_current_weapon('Dagger,Off-Hand');
	$chars['Trindle']->set_current_weapon('Dagger,Thrown');
	$chars['Tula'   ]->set_current_weapon('Crossbow,Heavy');

