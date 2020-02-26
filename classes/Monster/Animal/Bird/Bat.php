<?php
/* Name: Ordinary Bat
 * Class: DND_Monster_Animal_Bird_Bat
 * Encounter: {"CC":{"M":"C","H":"U","F":"U","S":"R","P":"R","D":"VR"},"CW":{"M":"C","H":"U","F":"U","S":"R","P":"R","D":"VR"},"TC":{"M":"C","H":"U","F":"U","S":"R","P":"R","D":"VR"},"TW":{"M":"C","H":"U","F":"U","S":"R","P":"R","D":"VR"},"TSC":{"M":"C","H":"U","F":"U","S":"R","P":"R","D":"VR"},"TSW":{"M":"C","H":"U","F":"U","S":"R","P":"R","D":"VR"}}
 */

class DND_Monster_Template extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 100, 0 );
	protected $armor_class  = 8;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Bite' => [ 1, 1, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 2;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $immune       = array();
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
	protected $movement     = array( 'air' => 24, 'foot' => 1 );
	protected $name         = 'Bat';
#	protected $psionic      = 'Nil';
	protected $race         = 'Bat';
	protected $reference    = 'Monster Manual II page 15';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = "Small";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
#	protected $treasure     = 'Nil';
#	protected $vulnerable   = array();
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
	protected $xp_value     = array( 1, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = "Many varieties are included in the category of ordinary bats. They will attack only if cornered and forced to. If startled, bats tend to become frightened and confused and will swarm around and fly into things, putting out torches, confusing spell casting, etc., if humans are concerned. Bat sonar allows flight in total darkness. Under fine flying conditions, a bat's armor class rating rises from 8 to 4. In certain large caverns there could be as many as 1000 or more bats.";
	}

	protected function determine_specials() {
		parent::determine_specials();
#		$this->specials['index'] = 'Special Attack';
	}

/*	protected function is_sequence_attack( $check ) {
		if ( $check === '' ) return false;
		return true;
	} //*/

/*	protected function non_sequence_chance( $segment ) {
		return 50;
	} //*/


}
