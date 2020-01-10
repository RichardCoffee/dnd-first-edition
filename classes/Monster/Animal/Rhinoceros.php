<?php
/* Name: Rhinoceros
 * Class: DND_Monster_Animal_Rhinoceros
 * Encounter: {}
 */

class DND_Monster_Animal_Rhinoceros extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 6, 0 );
	protected $armor_class  = 666666ted $armor_type   = 11;
	protected $attacks      = array( 'Horn' => [ 2, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Rhinoceros';
#	protected $psionic      = 'Nil';
	protected $race         = 'Rhinoceros';
	protected $reference    = 'Monster Manual page 81';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = mt_rand( 8, 9 );
		if ( $this->hit_dice === 9 ) $this->attacks['Horn'][1] = 6;
		$this->description = 'Rhinoceroses ore aggressive herbivores, by and large. A few types are less aggressive and will run away if they feel threatened, but most will charge. They have poor eyesight but keen senses of hearing and smell. If more than one-half the possible number are encountered, 1 or 2 will be young (from 30% to 60% mature).
Single horned rhinoceroses do 2d4 hit points of damage and have 8 hit dice. Two-horned rhinos have 9 hit dice and do more damage when they hit (2d6 points). A charging rhino does double damage. They will trample any opponent which is low enough for this action. Trampling inflicts 2d4 hit points of damage for each forefoot which hits.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['charge']  = 'Charging rhino does double damage.';
		$this->specials['trample'] = 'Trampling inflicts 2d4 hit points of damage for each forefoot which hits.';
	}


}
