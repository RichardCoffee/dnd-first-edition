<?php

$data = get_transient( 'dnd1e_monster' );
if ( empty( $data ) ) $data = array();

if ( isset( $data['monster'] ) ) {
	$create = $data['monster'];
	$monster = new $create( $data );
	echo "Using transient data\n";
} else {
	$monster = new DND_Monster_Dragon_Bronze( $data );
#	$monster = new DND_Monster_Dragon_Bronze( [ 'hit_dice' => 9, 'hd_minimum' => 8, 'spell_list' => [ 'First' => [ 'Dancing Lights', 'Ventriloquism' ], 'Second' => [ 'Pyrotechnics', 'Continual Light' ], 'Third' => [ 'Hold Person', 'Protection From Normal Missiles' ], 'Fourth' => [ 'Wizard Eye', 'Dispel Illusion' ] ] ] );
#	$monster = new DND_Monster_Giant_Crane( $data );
#	$monster = new DND_Monster_Giant_Lynx( $data );
#	$monster = new DND_Monster_Hydra( $data );
#	$monster = new DND_Monster_Humanoid_Jermlaine;
#	$monster = new DND_Monster_Lycan_Wolf( $data );
#	$monster = new DND_Monster_Rat( $data );
#	$monster = new DND_Monster_Giant_Spider( $data );
#	$monster = new DND_Monster_Water_StingRay( $data );
}

