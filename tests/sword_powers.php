<?php

require_once('setup.php');

class Make_Sword {
	use DND_Combat_Treasure_Generate;
	use DND_Combat_Treasure_Tables;
}

class Sword extends Make_Sword {

	public function random_sword( $roll = 0 ) {
		$item = $this->generate_random_result( $this->get_swords_table(), $roll );
		$item = $this->generate_swords_type( $item );
		return $this->generate_special_weapon( $item );
	}

	public function special_sword( $item, $roll = 0 ) {
		return $this->generate_special_weapon( $item, $roll );
	}

	protected function generate_weapon_languages( $powers, $roll = 0 ) {
		return parent::generate_weapon_languages( $powers, 100 );
	}

	protected function generate_weapon_extra_ability( $powers, $roll = 0 ) {
		return parent::generate_weapon_extra_ability( $powers, 100 );
	}

}

$sword = new Sword;

$item = $sword->random_sword();
#$item = $sword->special_sword( $item, 76 );
#$item = $sword->special_sword( $item, 84 );
#$item = $sword->special_sword( $item, 90 );
#$item = $sword->special_sword( $item, 95 );
#$item = $sword->special_sword( $item, 98 );
$item = $sword->special_sword( $item, 100 );

$weapon = new DND_Combat_Treasure_Items_Weapon( $item );

print_r($weapon);

