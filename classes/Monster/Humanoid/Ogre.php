<?php
/* Name: Ogre
 * Class: DND_Monster_Humanoid_Ogre
 * Encounter: {"CC":{"M":"C","H":"C","F":"C","P":"C","D":"U"},"CW":{"M":"C","H":"C","F":"C","P":"C","D":"U"},"TC":{"M":"C","H":"C","F":"C","P":"C","D":"U"},"TW":{"M":"C","H":"C","F":"C","P":"C","D":"U"},"TSC":{"M":"C","H":"C","F":"C","P":"C","D":"U"},"TSW":{"M":"C","H":"C","F":"C","P":"C","D":"U"}}
 */

class DND_Monster_Humanoid_Ogre extends DND_Monster_Humanoid_Humanoid {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
	protected $alignment    = 'Chaotic Evil';
	protected $appearing    = array( 2, 10, 0 );
#	protected $armor        = array(); // DND_Character_Trait_Armor
	protected $armor_class  = 5;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Weapon' => [ 1, 10, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $gear         = array();
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 4;
#	protected $hit_points   = 0;
	protected $hp_extra     = 1;
	protected $in_lair      = 20;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Ogre';
#	protected $psionic      = 'Nil';
	protected $race         = 'Ogre';
	protected $reference    = 'Monster Manual page 75';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $shield       = array(); // DND_Character_Trait_Armor
	protected $size         = "Large (9'+ tall)";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'M,Q,B,S';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'The hide of ogres varies from dull blackish-brawn to dead yellow. Rare specimens are a sickly violet in color. Their warty bumps are often of different color - or at least darker than their hides. Hair is blackish-blue to dull dark green. Eyes are purple with white pupils. Teeth are black or orange, as are talons. Ogres wear any sort of skins or furs.  They care for their arms and armor reasonably well. The life span of an ogre is not less than 90 years.';
		add_filter( 'dnd1e_origin_damage', [ $this, 'ogre_damage' ], 10, 4 );
	}

	protected function determine_specials() {
		parent::determine_specials();
		if ( $this->hit_dice === 7 ) {
			if ( $this->armor_class === 3 ) {
				$this->specials['leader'] = 'Ogre Leader';
			} else if ( $this->armor_class === 4 ) {
				$this->specials['chief'] = 'Ogre Chieftain';
			}
		}
	}

	public function get_number_appearing( $number = 1 ) {
		$num = parent::get_number_appearing( $number );
		if ( $num > 10 ) {
			$ogres = array( $num );
			$ogres[] = $this->ogre_leader();
			if ( $num > 15 ) {
				$ogres[] = $this->ogre_leader();
				$ogres[] = $this->ogre_chieftain();
			}
			return $ogres;
		}
		return $num;
	}

	protected function ogre_leader() {
		return array(
			'armor_class' => 3,
			'attacks'     => [ 'Weapon' => [ 2, 6, 0 ] ],
			'hit_dice'    => 7,
			'hit_points'  => 29 + mt_rand( 1, 4 ),
			'hp_extra'    => 0,
			'name'        => 'Ogre Leader',
		);
	}

	protected function ogre_chieftain() {
		return array(
			'armor_class' => 4,
			'attacks'     => [ 'Weapon' => [ 2, 6, 2 ] ],
			'hit_dice'    => 7,
			'hit_points'  => 33 + mt_rand( 1, 4 ),
			'hp_extra'    => 0,
			'name'        => 'Ogre Chieftain',
		);
	}

	protected function generate_humanoid_accouterments( $chance = 0 ) {
		parent::generate_humanoid_accouterments( $chance );
		foreach( $this->extra as $key => $item ) {
			if ( ! is_array( $item ) ) continue;
			if ( ! array_key_exists( 'type', $item ) ) continue;
			if ( ( ! in_array( $item['type'], [ 'swords', 'weapons' ] ) ) || ( array_key_exists( 'ex', $item ) && ( $item['ex'] === 'N:2' ) ) ) {
				unset( $this->extra[ $key ] );
			}
		}
if ( ! empty( $this->extra ) ) print_r( $this->extra );
	}

	public function ogre_damage( $damage, $origin, $target, $type ) {
		if ( $origin === $this ) {
			if ( ! ( ( $this->weapon['current'] === 'Spear' ) && ( $this->weapon['damage'] === [ 1, 10, 0 ] ) ) ) {
				$damage += 2;
				if ( $this->hit_dice === 7 ) $damage += 2;
			}
		}
		return $damage;
	}


}
