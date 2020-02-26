<?php
/* Name: Zombie
 * Class: DND_Monster_Undead_Zombie
 * Encounter: {"CC":{"M":"VR","H":"VR","F":"VR","S":"R","P":"VR","D":"VR"},"CW":{"M":"VR","H":"VR","F":"VR","S":"R","P":"VR","D":"VR"},"TC":{"M":"VR","H":"VR","F":"VR","S":"R","P":"VR","D":"VR"},"TC":{"M":"VR","H":"VR","F":"VR","S":"R","P":"VR","D":"VR"},"TSC":{"M":"VR","H":"VR","F":"VR","S":"R","P":"VR","D":"VR"},"TSW":{"M":"VR","H":"VR","F":"VR","S":"R","P":"VR","D":"VR"}}
 */

class DND_Monster_Undead_Zombie extends DND_Monster_Undead_Undead {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 3, 8, 0 );
	protected $armor_class  = 8;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Claw' => [ 1, 8, 0 ] );
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
	protected $name         = 'Zombie';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Undead';
#	protected $reference    = 'Monster Manual page';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = 'Medium';
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
		$this->hit_dice = 2;
		$this->immune[] = 'cold';
		$this->description = 'Undead description.';
	}

	protected function determine_specials() {
		parent::determine_specials();
#		$this->specials['index'] = 'Special Attack';
		add_filter( 'dnd1e_origin_damage', [ $this, 'damage_to_zombie' ], 10, 4 );
	}

	public function damage_to_zombie( $damage, $origin, $target, $effect ) {
		if ( $target === $this ) {
			if ( in_array( $effect, $this->immune ) ) return 0;
		}
		return $damage;
	}


}
