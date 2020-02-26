<?php

require_once('setup.php');

class Sword {
	use DND_Combat_Treasure_Generate;
	use DND_Combat_Treasure_Tables;
	public function sword_type( $item ) { return $this->generate_swords_type( $item ); }
}

$sword = new Sword;

$item = array( 'chance' =>  5, 'text' => 'Sword +2, Dragon Slayer',       'bonus' => 2, 'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164', 'symbol' => 'Dragon head on pommel' );

$result = $sword->sword_type( $item );
print_r( $result );
