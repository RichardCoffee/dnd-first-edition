<?php
/* Name: Giant Stag
 * Class: DND_Monster_Giant_Stag
 * Encounter: {"TW":{"M":"R"}}
 */

class DND_Monster_Giant_Stag extends DND_Monster_Animal_Stag {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 2, 0 );
#	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Antlers' => [ 4, 4, 0 ], 'Right Forehoove' => [ 1, 4, 0 ], 'Left Forehoove' => [ 1, 4, 0 ] );
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
	protected $movement     = array( 'foot' => 21 );
	protected $name         = 'Giant Stag';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Deer';
#	protected $reference    = 'Monster Manual page 90';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 3;
		$this->description = "Stags are herbivores found in temperate forests and meadowlands. They are the aggressive males of a herd which numbers 4-8 times the number of stags encountered. These creatures will defend the herd against all but the most fearsome opponents. A stag can attack with its branching antlers or by lashing out with its sharp forehooves.
Giant Stag: These creatures are simply very large stags. They otherwise conform to the general characteristics of stags. A typical giant stag is 7' tall at the shoulder and weighs over 1,500 pounds.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['attacks'] = 'Attack will be either Antlers or Forehooves, not both.';
	}


}
