<?php
/* Name: Lamia Noble
 * Class: DND_Monster_Lamia_Noble
 * Encounter: {"TW":{"D":"VR"}}
 * Dungeon: {"VII":"VR"}
 */

class DND_Monster_Lamia_Noble extends DND_Monster_Lamia_Lamia {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Chaotic Evil';
#	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Sword,Short' => [ 1, 6, 0 ], 'Spell' => [ 0, 0, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
#	protected $frequency    = 'Very Rare';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 10;
#	protected $hit_points   = 0;
	protected $hp_extra     = 1;
#	protected $immune       = array();
#	protected $in_lair      = 60;
#	protected $initiative   = 1;
#	protected $intelligence = 'High';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Lamia Noble';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Lamia';
	protected $reference    = 'Fiend Folio page 59';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = "Medium";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
#	protected $treasure     = 'D';
#	protected $vulnerable   = array();
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
	protected $xp_value     = array( 2550, 14 );


	protected function determine_hit_dice() {
#		$this->hit_dice = 1;
		$this->description = "These beings have rule over other lamias and the wild, lonely areas they inhabit. They differ from the normal lamia in that the lamia noble's lower body is that of a giant serpent and the upper body can be either male or female.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['male']   = 'Males use magic at 1d6 level';
		$this->specials['female'] = 'Females use magic at 2d4 level';
		$this->specials['more']   = sprintf( 'See %s for more details', $this->reference );
	}

/*	protected function is_sequence_attack( $check ) {
		if ( $check === '' ) return false;
		return true;
	} //*/

/*	protected function non_sequence_chance( $segment ) {
		return 50;
	} //*/


}
