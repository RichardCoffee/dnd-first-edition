<?php
/* Name: Manticore
 * Class: DND_Monster_Sphinx_Manticore
 * Encounter: {"CW":{"M":"U","H":"VR","F":"U","S":"VR","P":"VR","D":"VR"},"TW":{"M":"U","H":"VR","F":"U","S":"VR","D":"VR"},"TSW":{"M":"U","H":"VR","F":"U","S":"VR","P":"VR","D":"VR"},"CF":{"S":"VR"},"CS":{"S":"VR"},"TF":{"S":"VR"},"TS":{"S":"VR"},"TSF":{"S":"VR"},"TSS":{"S":"VR"}}
 */

class DND_Monster_Sphinx_Manticore extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
	protected $alignment    = 'Lawful Evil';
	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Claw Right' => [ 1, 3, 0 ], 'Claw Left' => [ 1, 3, 0 ], 'Bite' => [ 1, 8, 0 ], 'Spikes' => [ 1, 6, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
	protected $hp_extra     = 3;
	protected $in_lair      = 20;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 12, 'air' => 18 );
	protected $name         = 'Manticore';
#	protected $psionic      = 'Nil';
	protected $race         = 'Sphinx';
	protected $reference    = 'Monster Manual page 65(64)';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'E';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array();
	protected $extra        = array( 'Spikes' => 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 6;
		$this->description = "Manticores prefer dismal lairs, so they are typically found in caves or underground. They range in all climes, although they enjoy warm places more than cold. The favorite prey of manticores is man, and they are usually encountered outside their lairs hunting for human victims. Their tusks are of the same weight and value as those of elephants. A manticore attacks first by loosing a volley of 6 of its iron toil spikes (18' range as a light crossbow, 1-6 hit points damage per hit). They can fire four such volleys.
Description: The coloration of the manticore is that of its various parts - lion-colored body, bat-brown wings, human flesh head.";
		if ( $this->extra['Spikes'] > 3 ) {
			unset( $this->attacks['Spikes'] );
		}
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['spikes'] = 'Tail spikes: Can fire four volleys of six bolts each.';
	}

	public function determine_attack_weapon( $seg = 0 ) {
		parent::determine_attack_weapon( $seg );
		if ( ( $seg === $this->segment ) && ( $this->weapon['current'] === 'Spikes' ) ) {
			$this->extra['Spikes']++;
		}
	}

	protected function get_weapon_info( $weapon = 'Spell' ) {
		$weapon = ( $weapon === 'Spikes' ) ? 'Crossbow,Light' : $weapon;
		return parent::get_weapon_info( $weapon );
	}

	protected function get_attack_info( $new ) {
		$info = parent::get_attack_info( $new );
		if ( $info && ( $new === 'Spikes' ) ) {
			$info['attacks'][0] = 6;
		}
		return $info;
	}

	protected function is_sequence_attack( $check ) {
		if ( $check === 'Spikes' ) return false;
		return parent::is_sequence_attack( $check );
	}


}
