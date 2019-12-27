<?php

if ( empty( $combat->enemy ) ) {
#	$monster = new DND_Monster_Animal_Boar_Wild();
	$monster = new DND_Monster_Animal_Wolf();
#	$monster = new DND_Monster_Dragon_Bronze();
#	$monster = new DND_Monster_Dragon_Bronze( [ 'hit_dice' => 9, 'hd_minimum' => 8, 'spell_list' => [ [ 'name' => 'Dancing Lights', 'level' => 'First' ], [ 'name' => 'Ventriloquism', 'level' => 'First' ], [ 'name' => 'Pyrotechnics', 'level' => 'Second' ], [ 'name' => 'Continual Light', 'level' => 'Second' ], [ 'name' => 'Hold Person', 'level' => 'Third' ], [ 'name' => 'Protection From Normal Missiles', 'level' => 'Third' ], [ 'name' => 'Wizard Eye', 'level' => 'Fourth' ], [ 'name' => 'Dispel Illusion', 'level' => 'Fourth' ] ] ] );
#	$monster = new DND_Monster_Dragon_Faerie();
#	$monster = new DND_Monster_Dragon_Shadow();
#	$monster = new DND_Monster_Giant_Crane();
#	$monster = new DND_Monster_Giant_Lynx();
#	$monster = new DND_Monster_Giant_Spider();
#	$monster = new DND_Monster_Hydra();
#	$monster = new DND_Monster_Humanoid_Jermlaine;
#	$monster = new DND_Monster_Humanoid_Orc;
#	$monster = new DND_Monster_Invertebrates_Centipede_Giant();
#	$monster = new DND_Monster_Lycan_Wolf();
#	$monster = new DND_Monster_Rat();
#	$monster = new DND_Monster_Sphinx_Manticore();
#	$monster = new DND_Monster_Troll();
#	$monster = new DND_Monster_Water_StingRay();
	if ( isset( $monster ) ) {
		$combat->initialize_enemy( $monster );
	}
} else {
	echo "Using transient monster data\n";
}
