<?php
/* Name: Asiatic Elephant
 * Class: DND_Monster_Animal_Elephant_Asiatic
 * Encounter: {"TSC":{"H":"R","S":"R","P":"C","F":"C","D":"R"},"TSW":{"H":"R","S":"R","P":"C","F":"C","D":"R"}}
 */

class DND_Monster_Animal_Elephant_Asiatic extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 20, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Right Tusk' => [ 2, 6, 0 ], 'Left Tusk' => [ 2, 6, 0 ], 'Trunk' => [ 2, 6, 0 ], 'Right Foot' => [ 2, 6, 0 ], 'Left Foot' => [ 2, 6, 0 ] );
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
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Asiatic Elephant';
#	protected $psionic      = 'Nil';
	protected $race         = 'Elephant';
	protected $reference    = 'Monster Manual page 37';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (9'+ tall)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 10;
		$this->description = 'The elephant is found only in warm climates. They attack by means of a stab with two tusks, a grab and squeeze with their trunk, and then two tramplings with their front feet. One opponent can be subject to no more than two of these attacks at the same time but several opponents con be fought simultaneously - 6 or more man-sized opponents for example. Ogre-sized opponents will not be affected by trunk attacks. Elephants are relatively intelligent and will not trunk-attack creatures which will harm their trunk, i.e. spikey, hat, etc. They fear fire. An elephant can easily break open a great gate by pushing unless the gate is spiked to prevent this. They can be trained to carry equipment and/or men.
Elephant tusks have a value of 100 to 600 gold piece value each. Each gold piece of value equols one-quarter pound of weight.
If mare than one-half the possible number is encountered, there will be young animals in the herd - from 1 to 4, 20% to 70% mature. If a single animal is encountered it will be a rogue bull, with no fewer than 6 hit points per die, and a very nasty and aggressive temper. Rogues will attack 90% of the time.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['multiple'] = 'No more than 2 attacks per opponent.';
	}


}
