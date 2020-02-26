<?php
/* Name: Orc
 * Class: DND_Monster_Humanoid_Orc
 * Encounter: {"CW":{"M":"C","H":"C","F":"C","S":"C","P":"R","D":"R"},"TW":{"M":"C","H":"C","F":"C","S":"C","P":"R","D":"R"},"TSW":{"M":"C","H":"C","F":"C","S":"C","P":"R","D":"R"}}
 */

class DND_Monster_Humanoid_Orc extends DND_Monster_Humanoid_Humanoid {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
	protected $alignment    = 'Lawful Evil';
	protected $appearing    = array( 30, 10, 0 );
#	protected $armor        = array(); // DND_Character_Trait_Armor
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
#	protected $attacks      = array( 'Weapon' => [ 1, 8, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
#	protected $fighter      = null;
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 1;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
	protected $in_lair      = 35;
#	protected $initiative   = 1;
	protected $intelligence = 'Average (Low)';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Orc';
#	protected $psionic      = 'Nil';
	protected $race         = 'Orc';
	protected $reference    = 'Monster Manual page 75';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $shield       = array(); // DND_Character_Trait_Armor
	protected $size         = "Medium (6'+ tall)";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'L,C,O,Q,S';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array();
#	protected $extra        = array();


	protected function determine_hit_dice() {
		$this->description = "Orcs appear particularly disgusting because their coloration - brownish green with a bluish sheen - highlights their pinkish snouts and ears. Their bristly hair is dark brown or black, sometimes with dirty and often tan patches. Even their armor tends to be unattractive - bit rusty. Orcs favor unpleasant colors in general. Their garments are in tribal colors, as are shield devices or trim. Typical colors are blood red, rust red, mustard yellow, yellow green, moss green, greenish purple, and blackish brown. They live for about 40 years.";
		if ( array_key_exists( 'Weapon', $this->attacks ) ) $this->determine_weapons();
	}

	protected function determine_specials() {
		$this->specials = array(
			'senses' => "Infravision 30'",
		);
	}

	protected function determine_weapons() {
		$roll = mt_rand( 1, 100 );
		if ( $roll < 6 ) {
			$carry = array( 'Sword,Long', 'Flail,Foot' );
		} else if ( $roll < 16 ) {
			$carry = array( 'Sword,Long', 'Spear' );
		} else if ( $roll < 26 ) {
			$carry = array( 'Axe,Hand', 'Spear' );
		} else if ( $roll < 36 ) {
			$carry = array( 'Axe,Hand', 'Pole-Arm' );
		} else if ( $roll < 41 ) {
			$carry = array( 'Axe,Hand', 'Crossbow,Light' );
		} else if ( $roll < 46 ) {
			$carry = array( 'Axe,Hand', 'Crossbow,Heavy' );
		} else if ( $roll < 51 ) {
			$carry = array( 'Axe,Hand', 'Bow,Short' );
		} else if ( $roll < 56 ) {
			$carry = array( 'Axe,Hand', 'Bow,Long' );
		} else if ( $roll < 61 ) {
			$carry = array( 'Sword,Long', 'Axe,Battle' );
		} else if ( $roll < 71 ) {
			$carry = array( 'Spear' );
		} else if ( $roll < 81 ) {
			$carry = array( 'Axe,Hand' );
		} else {
			$carry = array( 'Pole-Arm' );
		}
		$this->attacks = array();
		foreach( $carry as $weapon ) {
			if ( $weapon === 'Pole-Arm' ) $weapon = $this->get_random_pole_arm();
			$this->attacks[ $weapon ] = $this->get_weapon_damage_array( $weapon );
		}
	}

	public function get_tribes_list() {
		return array(
			'Bloody Head',
			'Broken Bone',
			'Death Moon',
			'Dripping Blade',
			'Evil Eye',
			'Leprous Hand',
			'Red Shroud',
			'Rotting Eye',
			'Vile Rune',
		);
	}

	public function get_number_appearing() {
		$num   = parent::get_number_appearing();
		$orcs  = array( $num );
		for( $i = 1; $i <= intval( $num / 30 ); $i++ ) {
			$orcs[] = array( 'name' => 'Leader', 'hit_points' => 8 );
			$orcs[] = array( 'name' => 'Assistant', 'hit_points' => 8 );
			$orcs[] = array( 'name' => 'Assistant', 'hit_points' => 8 );
			$orcs[] = array( 'name' => 'Assistant', 'hit_points' => 8 );
		}
		if ( $num > 150 ) {
			$orcs[] = array( 'name' => 'Subchief', 'armor_class' => 4, 'hit_dice' => 2, 'hit_points' => 11 );
			$num_gd = mt_rand( 1, 6 ) + mt_rand( 1, 6 ) + mt_rand( 1, 6 );
			for( $i = 1; $i <= $num_gd; $i++ ) {
				$orcs[] = array( 'name' => 'Guard', 'armor_class' => 4, 'hit_dice' => 2, 'hit_points' => 11 );
			}
		}
		if ( $this->check_for_lair() ) {
			if ( $this->check_chance( 75 ) ) {
				$this->in_lair = '100: Underground caves';
			} else {
				$this->in_lair = '100: Above ground village';
			}
			$orcs[] = array( 'name' => 'Chief', 'armor_class' => 4, 'hit_dice' => 3, 'hit_points' => 12 + mt_rand( 1, 4 ) );
			$num_gd = mt_rand( 1, 6 ) + mt_rand( 1, 6 ) + mt_rand( 1, 6 ) + mt_rand( 1, 6 ) + mt_rand( 1, 6 );
			for( $i = 1; $i <= $num_gd; $i++ ) {
				$orcs[] = array( 'name' => 'Guard', 'armor_class' => 4, 'hit_dice' => 3, 'hit_points' => 12 + mt_rand( 1, 4 ) );
			}
		} else {
			if ( $this->check_chance( 20 ) ) {
				$num_carts = mt_rand( 1, 6 );
				$num_slave = 0;
				for( $i = 1; $i <= 10; $i++ ) {
					$num_slave += mt_rand( 1, 6 );
				}
				$extra[] = "$num_carts carts, with $num_slave slaves";
			}
		}
		return $orcs;
	}


}
