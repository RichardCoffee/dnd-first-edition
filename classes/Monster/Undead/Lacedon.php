<?php
/* Name: Ghoul
 * Class: DND_Monster_Undead_Ghoul
 * Encounter: {"CC":{"M":"U","H":"U","S":"U","P":"U"},"CW":{"M":"U","H":"U","S":"U","P":"U"},"TC":{"M":"U","H":"U","S":"U","P":"U"},"TW":{"M":"U","H":"U","S":"U","P":"U"},"TSC":{"M":"U","H":"U","S":"U","P":"U"},"TSW":{"M":"U","H":"U","S":"U","P":"U"}}
 */

class DND_Monster_Undead_Lacedon extends DND_Monster_Undead_Ghoul {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
	protected $alignment    = 'Chaotic Evil';
	protected $appearing    = array( 2, 12, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Claw R' => [ 1, 3, 0 ], 'Claw L' => [ 1, 3, 0 ], 'Bite' => [ 1, 6, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
	protected $immune       = array( 'sleep', 'charm' );
	protected $in_lair      = 20;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 9, 'swim' => 9 );
	protected $name         = 'Lacedon';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Ghoul';
	protected $reference    = 'Monster Manual page 42-43';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'B,T';
#	protected $vulnerable   = array( 'undead' );
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 2;
		$this->description = 'Undead description.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['touch'] = 'Touch causes paralyzation.';
		add_filter( 'dnd1e_origin_damage', [ $this, 'ghoul_paralyzation' ], 10, 4 );
	}

	protected function is_sequence_attack( $check ) {
		return true;
	}

	protected function non_sequence_chance( $segment ) {
		return 0;
	}

	public function ghoul_paralyzation( $damage, $origin, $target, $effect ) {
		if ( ( $origin === $this ) && ( ! in_array( $target->race, [ $origin->race, 'Elf' ] ) ) ) {
			$combat = dnd1e()->combat;
			$combat->messages[] = $target->get_key() . ' needs to save versus paralyzation!';
		}
		return $damage;
	}


}
