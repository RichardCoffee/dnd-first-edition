<?php
/* Name: Rhea
 * Class: DND_Monster_Animal_Bird_Flightless_Rhea
 * Encounter: {"TSW":{"H":"R","F":"C","S":"R","P":"C","D":"U"}}
 */

class DND_Monster_Animal_Bird_Flightless_Rhea extends DND_Monster_Animal_Bird_Flightless_Flightless {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 2, 10, 0 );
#	protected $armor_class  = 7;
#	protected $armor_type   = 11;
#	protected $attacks      = array( 'Beak' => [ 1, 4, 0 ], 'Claws' => [ 2, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 1;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 18 );
	protected $name         = 'Rhea';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Flightless Bird';
#	protected $reference    = 'Monster Manual page 40';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'These large avian creatures are typified by the ostrich, emu, and rhea. They live in warm climates in open grasslands. The ostrich-sized have 3 hit dice, emu-like birds have 2 , and rhea-sized types 1 hit die. All flightless birds are non-aggressive and run from danger. If cornered they can peck (1d4 hit points) or kick (2d4 hit points).';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['attacks'] = 'Attacks are either/or, not both';
	}


}
