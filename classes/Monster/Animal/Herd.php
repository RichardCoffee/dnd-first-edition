<?php
/* Name: Herd Animal
 * Class: DND_Monster_Animal_Herd
 * Encounter: {"CC":{"M":"VR","H":"R","F":"U","S":"U","P":"C","D":"R"},"CW":{"M":"VR","H":"R","F":"U","S":"U","P":"C","D":"R"},"TC":{"M":"VR","H":"R","F":"U","S":"U","P":"C","D":"R"},"TW":{"M":"VR","H":"R","F":"U","S":"U","P":"C","D":"R"},"TSC":{"M":"VR","H":"R","F":"U","S":"U","P":"C","D":"R"},"TSW":{"M":"VR","H":"R","F":"U","S":"U","P":"C","D":"R"}}
 */

class DND_Monster_Animal_Herd extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 20, 10, 0 );
	protected $armor_class  = 8;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 8, 0 ] );
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
	protected $movement     = array( 'foot' => 15, 'stampede' => 24 );
	protected $name         = 'Herd Animal';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Monster';
#	protected $reference    = 'Monster Manual page';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = mt_rand( 1, 5 );
		$this->description = "Herd animals live in all climes - musk oxen and reindeer at the North Pole, giraffe and antelopes at the equator. The smallest will have but 1 hit die, the largest will have 5. Attacks are simply a matter of the animals' in question modes of defense (horns, butting, hooves, flight). Damage is a factor of defense (attack) mode and size/strength. As herd animals are not aggressive, they will stampede away from what they perceive to be the greatest threat to their safety. Humans or humanoids of about man-size or less, will be trampled to death if caught in the path of a stampede.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['stampede'] = 'Stampede, 2d4 per segment';
	}


}
