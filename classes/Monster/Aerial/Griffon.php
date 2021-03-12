<?php
/* Name: Griffon
 * Class: DND_Monster_Aerial_Griffon
 * Encounter: {"CC":{"M":"U","H":"VR","D":"VR"},"CW":{"M":"U","H":"VR","D":"VR"},"TC":{"M":"U","H":"VR","D":"VR"},"TW":{"M":"U","H":"VR","D":"VR"},"TSC":{"M":"U","H":"VR","D":"VR"},"TSW":{"M":"U","H":"VR","D":"VR"},"CF":{"S":"VR"},"CS":{"S":"VR"},"TF":{"S":"VR"},"TS":{"S":"VR"},"TSF":{"S":"VR"},"TSS":{"S":"VR"}}
 */

class DND_Monster_Aerial_Griffon extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 2, 6, 0 );
	protected $armor_class  = 3;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Claw Right' => [ 1, 4, 0 ], 'Claw Left' => [ 1, 4, 0 ],'Beak' => [ 2, 8, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 7;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $immune       = array();
	protected $in_lair      = 25;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 12, 'air' => 30 );
	protected $name         = 'Griffon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Griffon';
	protected $reference    = 'Monster Manual page 49';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = "Large";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'C,S';
#	protected $vulnerable   = array();
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
#		$this->hit_dice = 1;
		$this->description = 'Griffons seek cliffs and rocky habitats in which to build their nests. If
conditions permit they will lair in a cave. They are aggressive carnivores,
and their favorite prey are horses. If they come within sighting or smelling
distance (36" as a general rule) of horseflesh, the griffons will wing to the
hunt. They ore much sought after in their fledgling state, for they can be
tamed for use as fierce, loyal, steeds if obtained before maturity. If
encountered in their lair, there is a 75% chance that there will be 1 or 2
eggs or young for every 2 griffons. The young are non-combative, but the
adults will attack until killed. Fledglings sell for 5,000 gold pieces, eggs for
2,000, on the open market.';
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
