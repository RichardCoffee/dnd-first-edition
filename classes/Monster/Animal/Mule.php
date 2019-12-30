<?php
/* Name: Mule
 * Class: DND_Monster_Animal_Mule
 * Encounter: {"CC":{"M":"R","H":"C","F":"R","S":"C","P":"C"},"CW":{"M":"R","H":"C","F":"R","S":"C","P":"C"},"TC":{"M":"R","H":"C","F":"R","S":"C","P":"C"},"TW":{"M":"R","H":"C","F":"R","S":"C","P":"C"},"TSC":{"M":"R","H":"C","F":"R","S":"C","P":"C"},"TSW":{"M":"R","H":"C","F":"R","S":"C","P":"C"}}
 */

class DND_Monster_Animal_Mule extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 6, 0 ] );
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
	protected $name         = 'Mule';
#	protected $psionic      = 'Nil';
	protected $race         = 'Mule';
	protected $reference    = 'Monster Manual page 71';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 3;
		$this->description = 'Mules are generally sterile hybrids between horses and donkeys. They are strong and agile, thus able to negotiate dungeons well in most cases.  Mules can be very stubborn and uncooperative at times, and they are likely to bite or kick their own handler if in a contrary mood. They are not panicked by fire, but strange smells may cause them to bolt away, or begin to bray loudly. A mule can carry 2000 gold pieces in weight at normal speed, 6000 at one-half speed.';
	}

	protected function determine_specials() {
		parent::determine_specials();
#		$this->specials['index'] = 'Special Attack';
	}


}
