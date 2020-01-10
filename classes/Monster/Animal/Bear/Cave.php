<?php
/* Name: Cave Bear
 * Class: DND_Monster_Animal_Bear_Cave
 * Encounter: {"CW":{"M":"U","H":"U","F":"VR"},"TW":{"M":"U","H":"U","F":"VR"}}
 */

class DND_Monster_Animal_Bear_Cave extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 2, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Right Claw' => [ 1, 8, 0 ], 'Left Claw' => [ 1, 8, 0 ], 'Bite' => [ 1, 12, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
	protected $hp_extra     = 6;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Cave Bear';
#	protected $psionic      = 'Nil';
	protected $race         = 'Bear';
	protected $reference    = 'Monster Manual page 8';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (12'+ tall)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 6;
		$this->description = 'All of these ursoids are omnivorous, although the gigantic cave bear tends towards a diet of meat. All have excellent hearing and smell but rather poor eyesight. Size shown is average for the variety, and larger individuals will be correspondingly more powerful. The grizzly bear is a brown bear of very aggressive disposition. Black bears are usually not aggressive, brown bears are, and cave bears are quite aggressive. If a bear scores a paw hit with an 18 or better it also hugs for additional damage as indicated. The brown and cave bears will continue to fight for 1-4 melee rounds after reaching 0 to -8 hit points. At -9 or greater damage, they are killed immediately.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['hugs'] = 'On claw hit of 18+, does bear hug for 2d8 damage';
	}


}
