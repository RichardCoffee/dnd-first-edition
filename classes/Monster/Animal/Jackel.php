<?php
/* Name: Jackel
 * Class: DND_Monster_Animal_Jackel
 * Encounter: {"CC":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"CW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"TC":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"TW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"TSC":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"TSW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"}}
 */

class DND_Monster_Animal_Jackel extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 6, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 2, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 4;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Jackel';
#	protected $psionic      = 'Nil';
	protected $race         = 'Jackel';
	protected $reference    = 'Monster Manual page 55';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Jackals are small, dog-like scavengers found in warm regions. They are not particularly fierce nor are they brave.';
	}

	protected function determine_specials() {
		parent::determine_specials();
#		$this->specials['index'] = 'Special Attack';
	}


}
