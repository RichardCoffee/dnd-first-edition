<?php
/* Name: Giant Scorpion
 * Class: DND_Monster_Invertebrates_Scorpion_Giant
 * Encounter: {"CW":{"M":"R","F":"R","S":"U","P":"U","D":"U"},"TW":{"H":"R","F":"R","P":"U","D":"U"},"TSW":{"M":"R","H":"R","F":"R","S":"U","P":"U","D":"U"}}
 * Dungeon: {"VI":"C"}
 */

class DND_Monster_Invertebrates_Scorpion_Giant extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 3;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Claw,Left' => [ 1, 10, 0 ], 'Claw,Right' => [ 1, 10, 0 ], 'Stinger' => [ 1, 4, 0 ]  );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 5;
#	protected $hit_points   = 0;
	protected $hp_extra     = 5;
#	protected $immune       = array();
	protected $in_lair      = 50;
#	protected $initiative   = 1;
	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Giant Scorpion';
#	protected $psionic      = 'Nil';
	protected $race         = 'Scorpion';
	protected $reference    = 'Monster Manual page 84';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = "Medium";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'D';
#	protected $vulnerable   = array();
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
#		$this->hit_dice = 1;
		$this->description = "Giant scorpions are vicious predators which are likely to be found even in
relatively cold places such as dungeons due to the adaptability of these
mutations. They are likely to attack any creature which approaches. The
monster seeks to grab prey with its huge pincers while its segmented tail
lashes forward to sting its victim to death with poison. This latter attack
inflicts 1-4 points of damage per hit and, if a poison saving throw fails, the
victim dies immediately. The giant scorpion can fight up to 3 opponents at
once. Note that the scorpion's poison kills it if it accidentally stings itself.
Creatures killed are dragged to the scorpion's lair to be eoten.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['sting'] = 'Stinger is poisonous, ST vs poison or die.';
		$this->specials['opponents'] = 'Can fight up to three opponents at once.';
	}

/*	protected function is_sequence_attack( $check ) {
		if ( $check === '' ) return false;
		return true;
	} //*/

/*	protected function non_sequence_chance( $segment ) {
		return 50;
	} //*/


}
