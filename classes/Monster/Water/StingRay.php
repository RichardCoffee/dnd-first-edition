<?php
/* Name: Sting Ray
 * Class: DND_Monster_Water_StingRay
 * Encounter: {"TSS":{"D":"C"}}
 */

class DND_Monster_Water_StingRay extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 3, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Tail' => [ 1, 3, 0 ] );
#	protected $frequency    = 'Common';
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Non-';
	protected $movement     = array( 'water' => 9 );
	protected $name         = 'Sting Ray';
#	protected $psionic      = 'Nil';
	protected $race         = 'Ray';
	protected $reference    = 'Monster Manual page 80';
#	protected $resistance   = 'Standard';
	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
	}

	protected function determine_specials() {
		$this->specials = array(
			'tail_spine' => 'ST vs poison, fail causes 5d4 damage plus paralyzation for number of turns equal to points of damage taken.',
		);
	}


}
