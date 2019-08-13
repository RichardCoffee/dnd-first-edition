<?php
/* Name: Rat
 * Class: DND_Monster_Animal_Rat
 * Encounter: {"CC":{"M":"R","H":"U","F":"C","S":"C","P":"C","D":"U"},"CW":{"M":"R","H":"U","F":"C","S":"C","P":"C","D":"U"},"TC":{"M":"R","H":"U","F":"C","S":"C","P":"C","D":"U"},"TW":{"M":"R","H":"U","F":"C","S":"C","P":"C","D":"U"},"TSC":{"M":"R","H":"U","F":"C","S":"C","P":"C","D":"U"},"TSW":{"M":"R","H":"U","F":"C","S":"C","P":"C","D":"U"}}
 */

class DND_Monster_Animal_Rat extends DND_Monster_Monster {


	protected $alignment    = 'Neutral (evil)';
	protected $appearing    = array( 1, 100, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 1, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 2;
	protected $hit_dice     = 1;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Ordinary Rat';
#	protected $psionic      = 'Nil';
	protected $race         = 'Rat';
	protected $reference    = 'Monster Manual II page 105';
#	protected $resistance   = 'Standard';
	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 2, 1 );


	protected function determine_hit_dice() {
		$this->description = 'Rats of all sizes and colors are found everywhere from forest wilderness to city sewers. Although cowardly, a trapped or cornered rat will fight ferociously. When starved, rat packs will attack anything alive in order to feed. As is true of giant rats, typical rodents of this sort have a filthy bite with a 5% chance of causing a serious disease unless a save vs. poison indicates otherwise. Normal rats fear fire, but, when driven by hunger, they will sometimes brave it.';
	}

	protected function determine_specials() {
		$this->specials = array(
			'boolean_jermlaine' => '19% chance of being accompanied by Jermlaine (FF 53).',
			'boolean_disease'   => 'Bite has %5 chance of causing disease, Saving Throw versus Poison.',
		);
	}

	public function special_boolean_jermlaine() {
		return $this->check_chance( 19 );
	}

	public function special_boolean_disease() {
		return $this->check_chance( 5 );
	}


}
