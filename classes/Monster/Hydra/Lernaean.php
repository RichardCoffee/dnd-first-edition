<?php
/* Name: Lernaean Hydra
 * Class: DND_Monster_Hydra_Lernaean
 * Encounter: {"CW":{"S":"VR"},"TSW":{"S":"VR"}}
 */

class DND_Monster_Hydra_Lernaean extends DND_Monster_Hydra_Hydra {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
#	protected $armor_class  = 5;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
#	protected $attacks      = array();
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Very Rare';
#	protected $hd_minimum   = 8;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Lernaean Hydra';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Hydra';
#	protected $reference    = 'Monster Manual page 53-54';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
#	protected $treasure     = 'B';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );
#	protected $extra        = array();


	protected function determine_hit_dice() {
		parent::determine_hit_dice();
		$this->determine_damage();
		$this->description .= '
These creatures are very rare. The lernaean hydra is indistinguishable from a normal hydra until it is attacked. Every time one of the heads of these creatures is cut off or killed, it grows two new ones in 1-4 melee rounds unless fire is applied to the dead member or neck stump. Thus, a 5-headed lernaean hydra could grow to a 12-headed monster in a single combat, gaining the appropriate hit dice and attack potential in the process.';
		add_action( 'dnd1e_new_seg_enemy',  [ $this, 'lernaean_head_growth' ], 10, 2 );
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['growth'] = 'Each head killed becomes 2 new heads, maximum of 12.';
	}

	protected function lernaean_head_damage( $head, $segment, $type = '' ) {
		if ( $type === 'fire' ) {
			$this->extra[ $head ] = 0;
		} else {
			$this->extra[ $head ] = 0 - ( $segment + ( mt_rand( 1, 4 ) * 10 ) );
		}
	}

	public function lernaean_head_growth( $combat, $target ) {
		if ( ( $this === $target ) && ( count( $this->attacks ) < 12 ) ) {
#			$current = $this->weapon['current'];
			foreach( $this->extra as $head => $state ) {
				if ( $state > -1 ) continue;
				if ( abs( $state ) === $combat->segment ) {
					$this->reset_head( $head );
					if ( ! $this->reset_head() ) {
						$this->grow_new_head();
					}
					$this->segment = $combat->segment;
				}
			}
			$this->determine_damage();
			$this->initialize_sequence_attacks();
#			$this->weapon = $this->get_attack_info( $current );
			$this->weapon['attacks'][0] = count( $this->weapons['sequence'] );
		}
	}

	protected function reset_head( $head = '' ) {
		if ( $head ) {
			$this->extra[ $head ] = $this->hd_value;
			$this->current_hp   += $this->hd_value;
		} else {
			foreach( $this->extra as $key => $hp ) {
				if ( $hp > -1 ) continue;
				$this->extra[ $key ] = $this->hd_value;
				$this->current_hp   += $this->hd_value;
				return true;
			}
		}
		return false;
	}

	protected function grow_new_head() {
		$num = count( $this->extra );
		if ( $num < 12 ) {
			$key = "Head $num";
			$this->extra[ $key ] = $this->hd_value;
			$this->hit_dice      = max( $this->hit_dice, $num + 1 );
			$this->hit_points    = $this->hit_dice * $this->hd_value;
			$this->current_hp   += $this->hd_value;
		}
	}


}
