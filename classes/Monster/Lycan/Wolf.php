<?php
/* Name: Werewolf
 * Class: DND_Monster_Lycan_Wolf
 * Encounter: {"CC":{"M":"R","H":"C","F":"C","S":"R","P":"R","D":"R"},"CW":{"M":"R","H":"C","F":"C","S":"R","P":"R","D":"R"},"TC":{"M":"R","H":"C","F":"C","S":"R","P":"R","D":"R"},"TW":{"M":"R","H":"C","F":"C","S":"R","P":"R","D":"R"},"TSC":{"M":"R","H":"C","F":"C","S":"R","P":"R","D":"R"},"TSW":{"M":"R","H":"C","F":"C","S":"R","P":"R","D":"R"}}
 */

class DND_Monster_Lycan_Wolf extends DND_Monster_Lycan_Lycan {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
	protected $alignment    = 'Chaotic Evil';
	protected $appearing    = array( 3, 6, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 4;
#	protected $hit_points   = 0;
	protected $hp_extra     = 3;
	protected $in_lair      = 25;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 15 );
#	protected $mtdw_iron    = false; // DND_Monster_Trait_Defense_Weapons
#	protected $mtdw_limit   = 1;     // DND_Monster_Trait_Defense_Weapons
	protected $mtdw_silver  = true;  // DND_Monster_Trait_Defense_Weapons
	protected $name         = 'Werewolf';
#	protected $psionic      = 'Nil';
	protected $race         = 'Lycan';
	protected $reference    = 'Monster Manual page 62';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'B';
#	protected $vulnerable   = array( 'shifter' );
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->description = 'In their human form, werewolves are very difficult to detect, for they can be of nearly any build and of either sex.
 Werewolves are prone to retain bipedal form in their wolf state, but wolfweres (wolves which can become men) always take normal wolf
 form. Both sorts are likely to be found in a pack. Werewolf packs can be family groups if they number 5 to 8. Family packs consist of a
 male, female and 3 to 6 young of 60% to 90% growth. The male will fight at +2 to hit and full damage each time he hits if the female is attacked.
 If the cubs are attacked the female will attack at + 3 to hit and do full damage possible each time she hits. The young fight at -4 to -1 to hit,
 according to their maturity, and inflict 2-5 points of damage/attack.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['surprise'] = 'Surprise opponents on 1-3.';
	}

	public function get_number_appearing() {
		$num = parent::get_number_appearing();
#		if ( ( $num > 4 ) && ( $num < 9 ) ) {
#			$num = 
#		}
		return $num;
	}


}
