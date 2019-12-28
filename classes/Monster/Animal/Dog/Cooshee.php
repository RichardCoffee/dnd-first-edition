<?php
/* Name: Cooshee
 * Class: DND_Monster_Animal_Dog_Cooshee
 * Encounter: {"CW":{"H":"VR","F":"R","S":"VR"},"TW":{"H":"VR","F":"R","S":"VR"},"TSW":{"H":"VR","F":"R","S":"VR"}}
 */

class DND_Monster_Animal_Dog_Cooshee extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 8, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 4, 6 ] );
#	protected $description  = '';
	protected $frequency    = 'Rare';
	protected $hp_extra     = 3;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
	protected $movement     = array( 'foot' => 15, 'sprint' => 21 );
	protected $name         = 'Cooshee';
#	protected $psionic      = 'Nil';
	protected $race         = 'Elven Dog';
	protected $reference    = 'Monster Manual II page 26';
#	protected $resistance   = 'Standard';
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 110, 4 );


	protected function determine_hit_dice() {
		$this->hit_dice = 3;
		$this->description = "A cooshee is the size of the largest common dog. It has a greenish coat with brown spots. The typical cooshee weighs over 168 pounds and often attains 3lO pounds. Its paws are huge with heavy claws, and it's tail is curled and held above the back.";
	}

	protected function determine_specials() {
		$this->specials = array(
			'sprint'    => 'Can reach movement speed of 21" in straight line',
			'attack'    => 'Can knock down opponents before attack, for no dex bonus and +2 to hit.',
			'detection' => '75% undetectable under normal conditions.',
		);
	}


}
