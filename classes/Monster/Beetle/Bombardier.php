<?php
/* Name: Bombardier Beetle
 * Class: DND_Monster_Beetle_Bombardier
 * Encounter: {"CW":{"H":"R","F":"C","S":"R"},"TW":{"H":"R","F":"C","S":"R"},"TSW":{"H":"R","F":"C","S":"R"}}
 */

class DND_Monster_Beetle_Bombardier extends DND_Monster_Beetle_Beetle {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 3, 4, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;
#	protected $attacks      = array( 'Bite' => [ 2, 6, 0 ] );
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
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Giant Bombardier Beetle';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Beetle';
#	protected $reference    = 'Monster Manual page 8';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Medium ( 4' long )";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = "This beetle is usually found in wooded areas above ground. It feeds on offal and carrion primarily, gathering huge heaps of such material in which to lay its eggs. If this beetle is attacked or disturbed there is a 50% chance each melee round that it will turn its rear towards its attacker(s) and fire off an 8' X 8' X 8' cloud of reeking, reddish acidic vapor from its abdomen. This cloud causes 3d4 hit points of damoge to any creature within it. Furthermore, the sound caused by the release of the vapor has a 20% chance of stunning any creature with a sense of hearing within 16' radius, and a like chance for deafening any creature within the 16' radius which was not stunned. Stunning lasts for 2d4 melee rounds, plus an additional 2d4 melee rounds of deafness after stunning. Deafening lasts 2d6 melee rounds. The giant bombardier can fire its vapor cloud every third melee round, but not more often than twice in eight hours.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['boolean_acid'] = "50%/round: acid cloud - 8' x 8' x 8'";
	}


}
