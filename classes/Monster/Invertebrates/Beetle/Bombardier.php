<?php
/* Name: Bombardier Beetle
 * Class: DND_Monster_Invertebrates_Beetle_Bombardier
 * Encounter: {"CW":{"H":"R","F":"C","S":"R"},"TW":{"H":"R","F":"C","S":"R"},"TSW":{"H":"R","F":"C","S":"R"}}
 */

class DND_Monster_Invertebrates_Beetle_Bombardier extends DND_Monster_Invertebrates_Beetle_Beetle {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 3, 4, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Bite' => [ 2, 6, 0 ], 'Acid' => [ 3, 4, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 2;
#	protected $hit_points   = 0;
	protected $hp_extra     = 2;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Giant Bombardier Beetle';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Beetle';
#	protected $reference    = 'Monster Manual page 8';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = "Medium ( 4' long )";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
#	protected $treasure     = 'Nil';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );
	protected $extra        = array( 'Acid' => 0, 'last' => 0, 'when' => 0 );


	protected function determine_hit_dice() {
		$this->description = "This beetle is usually found in wooded areas above ground. It feeds on offal and carrion primarily, gathering huge heaps of such material in which to lay its eggs. If this beetle is attacked or disturbed there is a 50% chance each melee round that it will turn its rear towards its attacker(s) and fire off an 8' X 8' X 8' cloud of reeking, reddish acidic vapor from its abdomen. This cloud causes 3d4 hit points of damoge to any creature within it.  Furthermore, the sound caused by the release of the vapor has a 20% chance of stunning any creature with a sense of hearing within 16' radius, and a like chance for deafening any creature within the 16' radius which was not stunned.  Stunning lasts for 2d4 melee rounds, plus an additional 2d4 melee rounds of deafness after stunning. Deafening lasts 2d6 melee rounds.  The giant bombardier can fire its vapor cloud every third melee round, but not more often than twice in eight hours.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['boolean_acid'] = "Acid cloud - 8' x 8' x 8'";
		$this->specials['boolean_stun'] = "Acid AoE: 20% chance to stun+deaf, otherwise 20% chance to deafen.";
	}


	/**  Override functions  **/

	public function determine_attack_weapon( $seg = 0 ) {
		parent::determine_attack_weapon( $seg );
		if ( ( $seg === $this->segment ) && ( array_key_exists( $this->weapon['current'], $this->extra ) ) ) {
			$this->extra[ $this->weapon['current'] ]++;
			$this->extra['last'] = $seg;
		}
	}

	protected function is_sequence_attack( $check ) {
		if ( $check === 'Acid' ) return false;
		return true;
	}

	protected function non_sequence_chance( $segment ) {
		if ( ( $this->extra['Acid'] > 1 ) || ( ( $this->extra['last'] > 0 ) && ( ( $segment - $this->extra['last'] ) < 30 ) ) ) {
			return 0;
		}
		return parent::non_sequence_chance( $segment );
	}


	/**  Effect functions  **/

	public function giant_bombardier_beetle_stun_effect( $target, $segment ) {
		$data = array(
			'name'      => 'Bombardier Stun',
			'duration'  => sprintf( "%u rounds", ( mt_rand( 1, 4 ) + mt_rand( 1, 4 ) ) ),
			'caster'    => $this->get_key(),
			'target'    => $target->get_key(),
			'condition' => 'this_target_only',
			'filters'   => array(
				array( 'target_stunned', 1, 10, 2 ),
			),
			'secondary' => array( $this->get_key(), $target->get_key(), 'deafsec' ),
		);
		$effect = new DND_Combat_Effect( $data );
		$effect->set_when( $segment );
		$this->extra['when'] = $effect->get_ends() + 1;
		return $effect;
	}

	public function giant_bombardier_beetle_deafsec_effect( $target, $segment ) {
		$data = array(
			'name'      => 'Bombardier Deafen Secondary',
			'duration'  => sprintf( "%u rounds", ( mt_rand( 1, 4 ) + mt_rand( 1, 4 ) ) ),
			'caster'    => $this->get_key(),
			'target'    => $target->get_key(),
			'condition' => 'this_target_only',
			'filters'   => array(
				array( 'target_deaf', 1, 10, 2 ),
			),
		);
		$effect = new DND_Combat_Effect( $data );
		$effect->set_when( $this->extra['when'] );
		return $effect;
	}

	public function giant_bombardier_beetle_deaf_effect( $target, $segment ) {
		$data = array(
			'name'      => 'Bombardier Deafen',
			'duration'  => sprintf( "%u rounds", ( mt_rand( 1, 6 ) + mt_rand( 1, 6 ) ) ),
			'caster'    => $this->get_key(),
			'target'    => $target->get_key(),
			'condition' => 'this_target_only',
			'filters'   => array(
				array( 'target_deaf', 1, 10, 2 ),
			),
		);
		$effect = new DND_Combat_Effect( $effect );
		$effect->set_when( $segment );
		return $effect;
	}


}
