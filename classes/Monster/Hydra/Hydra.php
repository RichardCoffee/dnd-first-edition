<?php
/* Name: Hydra
 * Class: DND_Monster_Hydra_Hydra
 * Encounter: {"CW":{"M":"VR","F":"VR","S":"U","P":"VR"},"TW":{"M":"VR","F":"VR","S":"U","P":"VR"},"TSW":{"M":"VR","F":"VR","S":"U","P":"VR"}}
 */

class DND_Monster_Hydra_Hydra extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array();
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
	protected $hd_minimum   = 8;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Hydra';
#	protected $psionic      = 'Nil';
	protected $race         = 'Hydra';
	protected $reference    = 'Monster Manual page 53-54';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'B';
	protected $vulnerable   = array( 'reptile' );
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );
	protected $extra        = array();


	protected function determine_hit_dice() {
		if ( $this->hit_dice === 0 ) {
			$this->hit_dice = mt_rand( 5, 12 );
			for( $i = 1; $i <= $this->hit_dice; $i++ ) {
				$key = "Head $i";
				$this->extra[ $key ] = $this->hd_value;
			}
		}
		$this->determine_damage();
		$this->description = "Hydrae are reptilian monsters found in marshes, swamps, and similar places, as well as in subterranean lairs. Their large, four-legged bodies are surmounted by from 5 to 12 heads (roll an 8 sided die to determine number). Each head has 1 hit die of a full 8 hit points. When all of a hydra's heads are killed, the body dies, but not until each and every head is killed.  The hydra attacks according to the number of heads it has, each head being considered as a hit die. Thus, a hydra of 7 heads attacks as a monster of 7 hit dice. It is possible for the hydra to attack several opponents at once, and up to 4 heads are able to attack the same target simultaneously.  Damage scored is based on the number of heads the hydra has: hydrae of 5 or 6 heads do 1-6 hit points of damage/attack, those with 7 to 10 heads score 1-8 points of damage, and hydrae with 11 or 12 heads do 1-10 hit points of damage.
Description: Hydrae are gray brown to blackish brawn with lighter underbellies tinged towards yellow or tan. Their eyes are amber to orange. The teeth are yellowish white.";
	}

	protected function determine_damage() {
		$max = 6;
		if ( $this->hit_dice > 6 )  $max = 8;
		if ( $this->hit_dice > 10 ) $max = 10;
		$this->attacks = array();
		for( $i = 1; $i <= $this->hit_dice; $i++ ) {
			$key = "Head $i";
			if ( $this->extra[ $key ] < 1 ) continue;
			$this->attacks[ $key ] = array( 1, $max, 0 );
		}
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['heads'] = 'Up to 4 heads can attack the same target.';
	}


	/**  Override functions  **/

	public function assign_damage( $damage, $segment = 0, $type = '' ) {
		$cnt  = count( $this->attacks );
		$head = mt_rand( 1, $cnt );
		$list = array_keys( $this->attacks );
		$key  = $list[ $head - 1 ];
		$this->extra[ $key ] -= $damage;
		if ( $this->extra[ $key ] < 1 ) {
			$next = array_key_next( $this->weapon['current'], $this->attacks );
			$this->determine_damage();
			$this->initialize_sequence_attacks();
			if ( $key === $this->weapon['current'] ) {
				$this->weapon = $this->get_attack_info( $next );
			} else {
				$this->weapon = $this->get_attack_info( $this->weapon['current'] );
			}
			if ( $this instanceOf DND_Monster_Hydra_Lernaean ) {
				$this->lernaean_head_damage( $key, $segment, $type );
			}
		}
		$this->current_hp = array_sum(
			array_filter(
				$this->extra,
				function( $a ) {
					if ( $a > 0 ) return true;
					return false;
				}
			)
		);
	}

	protected function set_sequence_weapon( $new ) {
		if ( empty( $this->weapon ) || ( $this->weapon['current'] === 'none' ) ) {
			$this->weapon = $this->get_attack_info( array_key_first( $this->attacks ) );
		} else {
			$next = array_key_next( $this->weapon['current'], $this->attacks );
			$this->weapon = $this->get_attack_info( $next );
		}
	}

	public function check_for_weapon_change( $seg ) { }


}
