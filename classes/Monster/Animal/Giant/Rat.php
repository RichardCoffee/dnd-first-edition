<?php
/* Name: Giant Rat
 * Class: DND_Monster_Animal_Giant_Rat
 * Encounter: {"CC":{"M":"R","H":"U","F":"U","S":"C","P":"C","D":"R"},"CW":{"M":"R","H":"U","F":"U","S":"C","P":"C","D":"R"},"TC":{"M":"R","H":"U","F":"U","S":"C","P":"C","D":"R"},"TW":{"M":"R","H":"U","F":"U","S":"C","P":"C","D":"R"},"TSC":{"M":"R","H":"U","F":"U","S":"C","P":"C","D":"R"},"TSW":{"M":"R","H":"U","F":"U","S":"C","P":"C","D":"R"}}
 */

class DND_Monster_Animal_Giant_Rat extends DND_Monster_Monster {


	protected $alignment    = 'Neutral (evil)';
	protected $appearing    = array( 5, 10, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 3, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 4;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
	protected $in_lair      = 10;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 12, 'swim' => 6 );
	protected $name         = 'Giant Rat';
#	protected $psionic      = 'Nil';
	protected $race         = 'Rat';
	protected $reference    = 'Monster Manual page 80';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Small';
#	protected $specials     = array();
	protected $treasure     = 'C';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Rats of all sorts are common, and the giant Sumatran sort are a plague in many places such as crypts and dungeons. Their burrows honeycomb many graveyards, where they seek to cheat ghouls of their prizes by tunneling to newly interred corpses.
Any creature bitten by a giant rat has a 5% chance per wound inflicted of contacting a serious disease. If such infection is indicated the victim is diseased unless a saving throw versus poison is successful.
Giant rats will avoid attacking strong parties unless commanded to fight by such creatures as wererats or vampires. They are fearful of fire and flee from it. Giant rats swim quite well, and they can attack in water as well.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['disease'] = '5% chance per bite for disease.  Check after combat is over.';
		$this->specials['jermlaine'] = '37% chance of being accompanied by Jermlaine (FF 53)';
	}


}
