<?php
/* Name: Woolly Rhinoceros
 * Class: DND_Monster_Animal_Rhinoceros_Woolly
 * Encounter: {}
 */

class DND_Monster_Animal_Rhinoceros_Woolly extends DND_Monster_Animal_Rhinoceros_Rhinoceros {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Horn' => [ 2, 6, 0 ] );
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
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Woolly Rhinoceros';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Rhinoceros';
#	protected $reference    = 'Monster Manual page 81';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 10;
		$this->description = 'Woolly Rhinoceros: A large, very aggressive species of rhinoceros which roams the cold temperate and subarctic regions of the Pleistocene epoch, the woolly rhino conforms to the characteristics of its modern relatives.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['charge']  = 'Charging rhino does double damage.';
		$this->specials['trample'] = 'Trampling inflicts 2d4 hit points of damage for each forefoot which hits.';
	}


}
