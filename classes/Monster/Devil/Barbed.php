<?php
/* Name: Barbed Devil
 * Class: DND_Monster_Devil_Barbed
 * Encounter: {"CC":{"M":"VR"}}
 */

class DND_Monster_Devil_Barbed extends DND_Monster_Devil_Devil {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
	protected $alignment    = 'Lawful Evil';
	protected $appearing    = array( 1, 2, 0 );
	protected $armor_class  = 0;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Claw Right' => [ 1, 8, 0 ], 'Claw Left' => [ 1, 8, 0 ], 'Bite' => [ 3, 4, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 8;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $immune       = array();
	protected $in_lair      = 50;
#	protected $initiative   = 1;
	protected $intelligence = 'Very';
#	protected $magic_user   = null;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Barbed';
#	protected $psionic      = 'Nil';
	protected $race         = 'Devil';
	protected $reference    = 'Monster Manual page 22';
	protected $resistance   = 35;
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = "Medium (7'+)";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
#	protected $treasure     = 'Nil';
#	protected $vulnerable   = array();
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
#		$this->hit_dice = 1;
#		$this->description = 'Monster template.';
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
