<?php
/* Name: Template
 * Class: DND_Monster_Template
 * Encounter: {}
 */

class DND_Monster_Template extends DND_Monster_Monster {


#	protected $ac_rows      = array( 1, 1, 2, 3, 4, 5, 6, 7, 7, 8, 9, 10, 10, 11, 12, 13, 13, 14, 14, 15, 15, 15 ); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
#	protected $armor_class  = 10;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
#	protected $att_types    = array(); // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Bite' => [ 1, 8, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
#	protected $name         = 'Monster';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Monster';
#	protected $reference    = 'Monster Manual page';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
#	protected $treasure     = 'Nil';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array( 'current' => 'none', 'skill' => 'NP', 'attacks' => [ 1, 1 ], 'bonus' => 0 ); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Monster template.';
	}

	protected function determine_specials() {
		parent::determine_specials();
#		$this->specials['index'] = 'Special Attack';
	}


}
