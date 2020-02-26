<?php

require_once( 'setup.php' );

/*
$monster = new DND_Monster_Hydra( [ 'heads' => 8 ] );

$treasure = $monster->get_treasure();
foreach( $treasure as $item => $data ) {
	printf( '%10s %s', $item, $data );
	echo "\n";
} //*/
/*
$t = new DND_Combat_Treasure_Treasure;
$table = $t->get_weapons_table();

$total = 0;
foreach( $table as $data ) {
	if ( is_array( $data ) ) {
		$total += $data['chance'];
	}
}
echo "Total: $total\n"; //*/
/*
$cnt = count( $argv );
$t = new DND_Combat_Treasure_Treasure;
if ( $cnt === 1 ) {
	$t->show_treasure_table();
} else {
	$roll = intval( $argv[1] );
	if ( $roll > 0 ) {
		$next = $t->get_sub_table_name( $roll );
		if ( $cnt === 2 ) {
			$t->show_treasure_table( $next );
		} else if ( $cnt === 3 ) {
			$t->show_treasure_item( $next, $argv[2] );
		}
	}
} //*/


$t = new DND_Combat_Treasure_Treasure;
#$item = $t->acc_get_table_accouterment( 'potions' );
#$item = $t->acc_get_table_accouterment( 'scrolls' );
#$cnt = count( $item->data );
#if ( $cnt ) {
#	$spell = $item->get_spell( $cnt - 1 );
#	print_r( $spell );
#}
#$item = $t->acc_get_table_accouterment( 'rings' );
#$item = $t->acc_get_table_accouterment( 'rods' );
#$item = $t->acc_get_table_accouterment( 'staves' );
#$item = $t->acc_get_table_accouterment( 'wands' );
#$item = $t->acc_get_table_accouterment( 'armor' );
#$item = $t->acc_get_table_accouterment( 'armor_shields' );
$item = $t->acc_get_table_accouterment( 'shields' );
#$item = $t->acc_get_table_accouterment( 'swords' );
#$item = $t->acc_get_table_accouterment( 'weapons', 700 );
print_r( $item );
$item->show_index_item( 'A' );
/*
$table = $t->get_sub_table( 'weapons' );
$i = 1;
foreach( $table as $entry ) {
	if ( is_string( $entry ) ) continue;
	$item = $t->acc_get_table_accouterment( 'weapons', $i );
	$item->show_index_item( 'A' );
	$i += $entry['chance'];
} //*/
