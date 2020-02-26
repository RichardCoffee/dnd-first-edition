<?php
/* Name: Skeleton
 * Class: DND_Monster_Undead_Skeleton
 * Encounter: {"CC":{"S":"R"},"CW":{"S":"R"},"TC":{"S":"R"},"TW":{"S":"R"},"TSC":{"S":"R"},"TSW":{"S":"R"}}
 */

class DND_Monster_Undead_Skeleton extends DND_Monster_Undead_Undead {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 3, 10, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Sword,Short' => [ 1, 6, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $immune       = array( 'mental' );
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Skeleton';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Undead';
	protected $reference    = 'Monster Manual page 87-88';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = "Medium (6' tall)";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
#	protected $treasure     = 'Nil';
#	protected $vulnerable   = array( 'undead' );
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->immune[] = 'cold';
		$this->description = 'Undead description.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['immune'] = 'Immune to sleep, charm, hold, fear, and cold based attacks.';
		add_filter( 'dnd1e_origin_damage', [ $this, 'damage_to_skeleton' ], 10, 4 );
	}

	public function damage_to_skeleton( $damage, $origin, $target, $effect ) {
		static $weapons = null;
		if ( $target === $this ) {
			if ( in_array( $effect, $this->immune ) ) return 0;
			if ( ! $weapons ) $weapons = new DND_Combat_Weapons;
			$weap_effect = $weapons->get_weapon_effect( $origin->weapon['current'] );
			if ( in_array( $weap_effect, [ 'pierce', 'slash' ] ) ) {
				$damage = intval( $damage / 2 );
			}
		}
		return $damage;
	}


}
