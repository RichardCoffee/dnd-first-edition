<?php
/* Name: Basilisk
 * Class: DND_Monster_Reptile_Basilisk
 * Encounter: {"TC":{"M":"VR","H":"U","F":"U","S":"U","P":"VR"},"TW":{"M":"VR","H":"U","F":"U","S":"U","P":"VR"},"TSC":{"M":"VR","H":"U","F":"U","S":"U","P":"VR"},"TSW":{"M":"VR","H":"U","F":"U","S":"U","P":"VR"},{"AE":{"A":"U","E":"U"}}}
 * Dungeon: {"VI":"U"}
 */

class DND_Monster_Reptile_Basilisk extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Bite' => [ 1, 10, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 6;
#	protected $hit_points   = 0;
	protected $hp_extra     = 1;
#	protected $immune       = array();
	protected $in_lair      = 40;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 6 );
	protected $name         = 'Basilisk';
#	protected $psionic      = 'Nil';
	protected $race         = 'Basilisk';
	protected $reference    = 'Monster Manual page 7';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = "Medium (7' Long)";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'F';
#	protected $vulnerable   = array();
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
#		$this->hit_dice = 1;
		$this->description = "The basilisk is a reptilian monster. Although it has eight legs, its slow
metabolic process allows it only slow movement. While it has strong,
toothy jaws, the basilisk's major weapon is its gaze by means of which it is
able to turn to stone any fleshly creature which meets its glance. However,
if its gaze is reflected so that the basilisk sees its own eyes, i t will itself be
petrified, but this requires light at least equal to bright torchlight and a
good, smooth reflector. Basilisks are usually dull brown with yellowish
underbellies. Their eyes are glowing pale green. The basilisk is able to see
in both the astral and ethereal planes. In the former plane its gaze kills,
while in the latter it turns victims to ethereal stone which can only be seen
by those who are in that plane or can see ethereal objects.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['gaze'] = 'Gaze turns flesh to stone';
	}

/*	protected function is_sequence_attack( $check ) {
		if ( $check === '' ) return false;
		return true;
	} //*/

/*	protected function non_sequence_chance( $segment ) {
		return 50;
	} //*/


}
