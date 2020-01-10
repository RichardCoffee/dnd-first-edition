<?php
/* Name: Skunk
 * Class: DND_Monster_Animal_Skunk
 * Encounter: {"CW":{"H":"U","F":"VR","S":"VR"},"TW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"U"},"TSW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"U"}}
 */

class DND_Monster_Animal_Skunk extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 6, 0 );
	protected $armor_class  = 8;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 1, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 2;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Skunk';
#	protected $psionic      = 'Nil';
	protected $race         = 'Skunk';
	protected $reference    = 'Monster Manual II page 110';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 4, 1, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Skunks are found in most temperate and subtropical regions, dwelling in lightly populated and uninhabited areas. While they will bite if cornered, their major attack and defense method is to back towards any threatening creatures and release a 1"x1"x1" cloud of stinking musk which will require all those within to make a saving throw vs. poison. Those who succeed must retreat immediately or count as failing to save. Those failing will be nauseated for 1d4 rounds and must retreat and retch. Each must also save again vs. poison or also be blinded for 1d4 rounds. The musk will cause normal clothing to smell so bad as to require burying or burning. Flesh, leather, metal, etc., must be washed repeatedly for several days in order to remove the horrid odor. (Vinegar will cut the stench in only 2 or 3 washings.)';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['squirt'] = 'Squirt is normally used insteade of bite.';
	}


}
