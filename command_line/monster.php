<?php

$monster = dnd1e_transient( 'monster' );

if ( $monster instanceOf DND_Monster_Monster ) {
	echo "Using transient monster data\n";
} else {
#	$monster = new DND_Monster_Dragon_Bronze();
#	$monster = new DND_Monster_Dragon_Bronze( [ 'hit_dice' => 9, 'hd_minimum' => 8, 'spell_list' => [ 'First' => [ 'Dancing Lights', 'Ventriloquism' ], 'Second' => [ 'Pyrotechnics', 'Continual Light' ], 'Third' => [ 'Hold Person', 'Protection From Normal Missiles' ], 'Fourth' => [ 'Wizard Eye', 'Dispel Illusion' ] ] ] );
#	$monster = new DND_Monster_Dragon_Faerie();
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

$enemy = dnd1e_transient( 'enemy' );
if ( empty( $enemy ) ) {
	$what   = get_class( $monster );
	$enemy  = array( $monster );
	$number = $monster->get_number_appearing();
	$points = $monster->get_appearing_hit_points( $number );
	for( $i = 1; $i < $number; $i++ ) {
		$enemy[] = new $what( [ 'current_hp' => $points[ $i ], 'hit_points' => $points[ $i ] ] );
	}
	if ( ( $monster instanceOf DND_Monster_Dragon_Dragon ) && ( ! empty( $monster->mate ) ) ) {
		$enemy[1] = $monster->mate;
	}
	dnd1e_transient( 'enemy' );
}
