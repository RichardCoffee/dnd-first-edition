<?php
/* Name: Dire Wolf
 * Class: DND_Monster_Wolf_Dire
 * Encounter: {"CC":{"M":"VR","H":"R","F":"R","S":"VR","P":"R","D":"R"},"CW":{"M":"VR","H":"R","F":"R","S":"VR","P":"R","D":"R"},"TC":{"M":"VR","H":"R","F":"R","S":"VR","P":"R","D":"R"},"TW":{"M":"VR","H":"R","F":"R","S":"VR","P":"R","D":"R"},"TSC":{"M":"VR","H":"R","F":"R","S":"VR","P":"R","D":"R"},"TSW":{"M":"VR","H":"R","F":"R","S":"VR","P":"R","D":"R"}}
 */

class DND_Monster_Wolf_Dire extends DND_Monster_Wolf_Wolf {

#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 3, 4, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Rare';
	protected $hit_dice     = 3;
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_points   = 0;
	protected $hp_extra     = 3;
#	protected $in_lair      = 10;
#	protected $initiative   = 1;
#	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 18 );
	protected $name         = 'Dire Wolf';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Wolf';
#	protected $reference    = 'Monster Manual page 99';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );

	protected function determine_hit_dice() {
		$this->description = 'This variety of wolf is simply a huge specimen typical of the Pleistocene Epoch. They conform to the characteristics of normal wolves.';
	}

}
