<?php
/* Name: Hippopotamus
 * Class: DND_Monster_Water_Hippopotamus
 * Encounter: {"TSW":{"S":"U"},"TSF":{"S":"U","D":"R"}}
 */

class DND_Monster_Water_Hippopotamus extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 2, 6, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Bite' => [ 2, 6, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 8;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $immune       = array();
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 9, 'water' => 12 );
	protected $name         = 'Hippopotamus';
#	protected $psionic      = 'Nil';
	protected $race         = 'Hippopotomi';
	protected $reference    = 'Monster Manual page 51';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = "Large";
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
		$this->description = 'As their name implies, hippopotomi are found in rivers and lakes of
tropical regions. They are herbivores, but they aggressively defend their
own territory. A hippo bites with exceedingly strong jaws, and a bull will
do 3-18 hit points of damage/attack. There will be 1-3 bulls in a herd, 1 for
every 4 animals. If a boat or canoe passes over submerged hippopotomi
there i s a 50% chance that a bull will emerge under it and tip the craft
over. Hippopotomi travel underwater by running along the bottom. They
can stay submerged for 15 minutes.';
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

	public function get_number_appearing() {
		$num = parent::get_number_appearing();
		$num -= 2;
		$act = array( new DND_Monster_Water_BullHippo );
		if ( $num > 0 ) {
			$act[] = min( 2, $num );
			$num -= 2;
			while( $num > 0 ) {
				$act[] = new DND_Monster_Water_BullHippo;
				$num--;
				$act[] = min( 3, $num );
				$num -= 3;
			}
		}
		return $act;
	}


}
