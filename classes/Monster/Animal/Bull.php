<?php
/* Name: Cattle
 * Class: DND_Monster_Animal_Bull
 * Encounter: {}
 */

class DND_Monster_Animal_Bull extends DND_Monster_Animal_Cattle {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 20, 0 );
#	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Charge' => [ 3, 4, 0 ], 'Hooves' => [ 1, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 4;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Bull';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Cattle';
	protected $reference    = 'Monster Manual page 11';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (5' at shoulder)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
#		$this->hit_dice = mt_rand( 1, 4 );
		$this->description = "The bull is a dangerous opponent, being aggressive and easily aroused to anger. There is a 75% chance that if approached within 8 it will attack. A charging bull will do 3-12 points of damage upon impact with an additional 1-4 points of trampling damage. A charge must cover at least 30'. Such animals as the wild ox and the aurochs fall under this general class. When a herd is present there will be several bulls which will defend the rest.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['charge'] = 'Charge - see description';
	}


}
