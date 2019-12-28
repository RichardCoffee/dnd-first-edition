<?php
/* Name: Camel
 * Class: DND_Monster_Animal_Camel
 * Encounter: {"CC":{"H":"R","F":"R","S":"R","P":"C","D":"C"},"CW":{"H":"R","F":"R","S":"R","P":"C","D":"C"},"TC":{"H":"R","F":"R","S":"R","P":"C","D":"C"},"TW":{"H":"R","F":"R","S":"R","P":"C","D":"C"},"TSC":{"H":"R","F":"R","S":"R","P":"C","D":"C"},"TWC":{"H":"R","F":"R","S":"R","P":"C","D":"C"}}
 */

class DND_Monster_Animal_Camel extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 12, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 3;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Animal to Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 21 );
	protected $name         = 'Wild Camel';
#	protected $psionic      = 'Nil';
	protected $race         = 'Camel';
	protected $reference    = 'Monster Manual page 12';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
#		$this->hit_dice = 3;
		$this->description = 'Single humped camels (dromedaries) are found only in very warm desert areas. The double humped (boctrian) sort are able to abide cold and even non-desert regions. All camels are able to go for up to two weeks without food or water. They can carry loads up to 6,000 gold pieces weight, although this reduces their speed to 5"; if loaded between 4,000 and 5,000 gold pieces, their speed is 15" maximum. (The bactrian camel is 3" slower than the dromedary, so reduce its movement accordingly).
Camels can attack by biting (they can kick, but do not typically do so). They tend to be nasty tempered and may spit at persons coming to ride or use them similarly - 50% chance to do so, 25% chance of blinding for 1-3 melee rounds if they do spit.
Horses tend to dislike the odor of camels.';
	}

	protected function determine_specials() {
		$this->specials['spitting'] = 'Spitting - see description.';
	}


}
