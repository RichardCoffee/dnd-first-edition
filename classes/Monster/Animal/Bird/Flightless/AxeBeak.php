<?php
/* Name: Axe Beak
 * Class: DND_Monster_Animal_Bird_Flightless_AxeBeak
 * Encounter: {}
 */

class DND_Monster_Animal_Bird_Flightless_AxeBeak extends DND_Monster_Animal_Bird_Flightless_Flightless {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 6, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 3, 0 ], 'Claw Left' => [ 1, 3, 0 ], 'Bite' => [ 2, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
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
#	protected $movement     = array( 'foot' => 18 );
	protected $name         = 'Axe Beak';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Flightless Bird';
	protected $reference    = 'Monster Manual page 6';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (7'+ tall)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 3;
		$this->description = 'Axe beaks are prehistoric carnivorous flightless birds. They ore very fast runners and aggressively hunt during daylight. An axe beak resembles an ostrich in its lower portions, with a strong neck and a heavy, sharp beak.';
	}

	protected function determine_specials() {
		parent::determine_specials();
#		$this->specials['index'] = 'Special Attack';
	}


}
