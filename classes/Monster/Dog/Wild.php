<?php
/* Name: Wild Dog
 * Class: DND_Monster_Dog_Wild
 * Encounter: {"CW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"TW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"TSW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"}}
 */

class DND_Monster_Dog_Wild extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 4, 16, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
	protected $hp_extra     = 1;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Wild Dog';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dog';
	protected $reference    = 'Monster Manual page 28';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Packs of wild dogs inhabit most regions, and their ranges will sometimes overlap those of wolves. If well-fed they will simply avoid contact. They can be tamed only if separated from their pack.';
	}


}
