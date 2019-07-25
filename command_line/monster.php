<?php

$monster = get_transient( 'dnd1e_monster' );

if ( $monster instanceOf DND_Monster_Monster ) {
	echo "Using transient monster data\n";
} else {
#	$monster = new DND_Monster_Dragon_Bronze();
#	$monster = new DND_Monster_Dragon_Bronze( [ 'hit_dice' => 9, 'hd_minimum' => 8, 'spell_list' => [ 'First' => [ 'Dancing Lights', 'Ventriloquism' ], 'Second' => [ 'Pyrotechnics', 'Continual Light' ], 'Third' => [ 'Hold Person', 'Protection From Normal Missiles' ], 'Fourth' => [ 'Wizard Eye', 'Dispel Illusion' ] ] ] );
#	$monster = new DND_Monster_Dragon_Shadow();
#	$monster = new DND_Monster_Giant_Crane();
#	$monster = new DND_Monster_Giant_Lynx();
	$monster = new DND_Monster_Giant_Spider();
#	$monster = new DND_Monster_Hydra();
#	$monster = new DND_Monster_Humanoid_Jermlaine;
#	$monster = new DND_Monster_Lycan_Wolf();
#	$monster = new DND_Monster_Rat();
#	$monster = new DND_Monster_Sphinx_Manticore();
#	$monster = new DND_Monster_Troll();
#	$monster = new DND_Monster_Water_StingRay();
}

$appearing = get_transient( 'dnd1e_appearing' );
if ( empty( $appearing ) ) {
	$number = $monster->get_number_appearing();
	$appearing = array(
		'number'     => $number,
		'hit_points' => $monster->get_appearing_hit_points( $number ),
	);
	set_transient( 'dnd1e_appearing', $appearing );
}
