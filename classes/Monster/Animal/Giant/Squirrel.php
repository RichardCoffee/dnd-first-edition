<?php
/* Name: Giant Squirrel
 * Class: DND_Monster_Animal_Giant_Squirrel
 * Encounter: {"TW":{"M":"U","F":"R"}}
 */

class DND_Monster_Animal_Giant_Squirrel extends DND_Monster_Animal_Squirrel {


	protected $alignment    = 'Neutral (evil)';
	protected $appearing    = array( 1, 12, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 3, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 1;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
	protected $hp_extra     = 1;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Giant Squirrel';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Squirrel';
#	protected $reference    = 'Monster Manual II page 114';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Small (2' long)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 20, 2, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Giant black squirrels are found only in old, dark forests possessed by Evil. These creatures are malicious and will attack weak or helpless creatures. They will steal from careless individuals if given the opportunity, taking small, shiny objects (coins, rings, jewelry, flasks, etc.) to secrete in their nests. Lairs are always in hollows of trees 2-10 feet or more above the ground. Treasure is incidental only.';
	}

	protected function determine_specials() {
		parent::determine_specials();
#		$this->specials['index'] = 'Special Attack';
	}


}
