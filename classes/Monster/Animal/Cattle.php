<?php
/* Name: Cattle
 * Class: DND_Monster_Animal_Cattle
 * Encounter: {"TC":{"M":"R","H":"C","F":"R","S":"R","P":"C","D":"R"},"TW":{"M":"R","H":"C","F":"R","S":"R","P":"C","D":"R"},"TSC":{"M":"R","H":"C","F":"R","S":"R","P":"C","D":"R"},"TSW":{"M":"R","H":"C","F":"R","S":"R","P":"C","D":"R"}}
 */

class DND_Monster_Animal_Cattle extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 20, 10, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Hooves' => [ 1, 4, 0 ] );
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
	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Cattle';
#	protected $psionic      = 'Nil';
	protected $race         = 'Cattle';
	protected $reference    = 'Monster Manual page 12';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = mt_rand( 1, 4 );
		$this->description = 'Wild cattle roam many wilderness areas, and they ore frequently encountered. They are likely to flee any threat, although the males of the herd are likely (75%) to attack if the intruders come upon the herd before it has a chance to run away (see BULL). There is also a 25% chance that a herd of wild cattle will stampede directly at the party. If cattle stampede and there is no cover (rocks, trees, logs, a wall, etc.) then roll two 4-sided dice for each member of the party in the path of the stampede in order to find how many cattle trample each party member. Trampling causes 1-4 hit points of damage per creature trampling.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['stampede'] = 'Stampede - see description';
	}


}
