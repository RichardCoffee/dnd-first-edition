<?php
/* Name: Orc
 * Class: DND_Monster_Humanoid_Orc
 * Encounter: {"CW":{"M":"C","H":"C","F":"C","S":"C","P":"R","D":"R"},"TW":{"M":"C","H":"C","F":"C","S":"C","P":"R","D":"R"},"TSW":{"M":"C","H":"C","F":"C","S":"C","P":"R","D":"R"}}
 */

class DND_Monster_Humanoid_Orc extends DND_Monster_Humanoid_Humanoid {

	protected $alignment    = 'Lawful Evil';
	protected $appearing    = array( 30, 10, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
#	protected $attacks      = array( 'Weapon' => [ 1, 8, 0 ] );
	protected $extra        = array();
#	protected $fighter      = null;
#	protected $frequency    = 'Common';
	protected $hit_dice     = 1;
#	protected $hp_extra     = 0;
	protected $in_lair      = 35;
#	protected $initiative   = 1;
	protected $intelligence = 'Average (Low)';
	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Orc';
#	protected $psionic      = 'Nil';
	protected $race         = 'Orc';
	protected $reference    = 'Monster Manual page 75';
#	protected $resistance   = 'Standard';
	protected $size         = "Medium(6'+ tall)";
#	protected $specials     = array();
	protected $treasure     = 'L,C,O,Q,S';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->description = "Orcs appear particularly disgusting because their coloration - brownish green with a bluish sheen - highlights their pinkish snouts and ears. Their bristly hair is dark brown or black, sometimes with dirty and often tan patches. Even their armor tends to be unattractive - bit rusty. Orcs favor unpleasant colors in general. Their garments are in tribal colors, as are shield devices or trim. Typical colors are blood red, rust red, mustard yellow, yellow green, moss green, greenish purple, and blackish brown. They live for 40 years.";
		if ( array_key_exists( 'Weapon', $this->attacks ) ) {
			$this->determine_weapon();
		}
	}

	protected function determine_specials() {
		$this->specials = array(
			'senses' => "Infravision 30'",
		);
	}

	protected function determine_weapon() {
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
		unset( $this->attacks['Weapon'] );
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

	# TODO: finish function - see monster manual
	public function group_composition( $num ) {
		$extra = array();
		$leads = intval( $num / 30 );
		for( $i = 1; $i <= $leads; $i++ ) {
			$extra[] = 'leader and 3 assistants (8hp each)';
		}
		if ( $this->check_for_lair() ) {
			if ( $this->check_chance( 75 ) ) {
				$this->in_lair = '100: Underground caves';
			} else {
				$this->in_lair = '100: Above ground village';
			}
		} else {
			$stats = 'AC4, 11hp, as 2HD, dam 1d6+1';
			if ( $this->check_chance( 20 ) ) {
				$num_carts = mt_rand( 1, 6 );
				$num_slave = 0;
				for( $i = 1; $i <= 10; $i++ ) {
					$num_slave += mt_rand( 1, 6 );
				}
				$extra[] = "$num_carts carts, with $num_slave slaves";
			} else {
				if ( $num > 150 ) {
					$extra[] = 'subchief ' . $stats;
					$num_gd = 0;
					for( $i = 1; $i <= 3; $i++ ) {
						$num_gd += mt_rand( 1, 6 );
					}
					$extra[] = "$num_gd guards " . $stats;
				}
			}
		}
	}

}
