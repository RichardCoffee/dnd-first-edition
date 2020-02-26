<?php
/* Name: Cooshee
 * Class: DND_Monster_Animal_Dog_Cooshee
 * Encounter: {"CW":{"H":"VR","F":"R","S":"VR"},"TW":{"H":"VR","F":"R","S":"VR"},"TSW":{"H":"VR","F":"R","S":"VR"}}
 */

class DND_Monster_Animal_Dog_Cooshee extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 8, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Knock' => [ 0, 0, 0 ], 'Bite' => [ 1, 4, 6 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
	protected $hp_extra     = 3;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 15, 'sprint' => 21 );
	protected $name         = 'Cooshee';
#	protected $psionic      = 'Nil';
	protected $race         = 'Elven Dog';
	protected $reference    = 'Monster Manual II page 26';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
#	protected $treasure     = 'Nil';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
	protected $xp_value     = array( 110, 4 );


	protected function determine_hit_dice() {
		$this->hit_dice = 3;
		$this->description = "A cooshee, or elven dog, is found only in woodlands or meadows frequented by elves. Most commonly these beasts are found in company with sylvan elves. A cooshee moves quickly, and, when chasing something in a straight line, its speed is even greater (21\"). When fighting it will strike with its huge forepaws to knock 2-footed creatures of human size or smaller off their feet. This attack is determined normally before biting. Prone opponents are, of course, then more easily bitten (no dexterity bonus, +2 to hit). Elven dogs avoid others of the canine species. Their bark can be heard for a mile or more, but they bark only to warn their masters.\n
A cooshee is the size of the largest common dog. It has a greenish coat with brown spots. The typical cooshee weighs over 168 pounds and often attains 31O pounds. Its paws are huge with heavy claws, and it's tail is curled and held above the back.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials = array_merge(
			$this->specials,
			array(
				'sprint'    => 'Can reach movement speed of 21" in straight line',
				'attack'    => 'Can knock down opponents prone before attack.',
				'detection' => '75% undetectable under normal conditions.',
			)
		);
	}


	/**  Override functions  **/

	public function determine_attack_weapon( $segment = 0 ) {
		if ( ( ( $segment - $this->segment ) %10 ) === 0 ) {
			$this->set_sequence_weapon( 'Knock' );
		} else {
			$this->set_sequence_weapon( 'Bite' );
		}
	}

	protected function cycle_weapon_sequence( $segment ) {
		$this->determine_attack_weapon( $segment );
	}

	public function get_attack_sequence( $rounds, $unused = array() ) {
		$segment  = $this->segment;
		$seqent   = array();
		do {
			$seqent[] = round( $segment );
			$seqent[] = round( $segment + 1 );
			$segment += 10;
		} while( $segment < ( ( $rounds * 10 ) + 1 ) );
		return $seqent;
	}


	/**  Knock attack functions  **/

	public function cooshee_knock_effect( $target, $segment ) {
		$data = array(
			'name'      => 'Cooshee Knock',
			'caster'    => $this->get_key(),
			'target'    => $target->get_key(),
			'condition' => 'this_target_only',
			'filters'   => array(
				array( 'target_prone', 10, 10, 2 ),
			),
			'when' => $segment,
			'ends' => $segment + 10,
		);
		return new DND_Combat_Effect( $data );
	}


}
