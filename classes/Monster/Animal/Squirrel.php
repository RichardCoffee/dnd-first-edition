<?php
/* Name: Squirrel
 * Class: DND_Monster_Animal_Squirrel
 * Encounter: {"CC":{"M":"U","H":"C","F":"C","S":"U","P":"C","D":"U"},"CW":{"M":"U","H":"C","F":"C","S":"U","P":"C","D":"U"},"TC":{"M":"U","H":"C","F":"C","S":"U","P":"C","D":"U"},"TW":{"M":"U","H":"C","F":"C","S":"U","P":"C","D":"U"}}
 */

class DND_Monster_Animal_Squirrel extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 6, 0 );
	protected $armor_class  = 8;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 1, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 1;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Squirrel';
#	protected $psionic      = 'Nil';
	protected $race         = 'Squirrel';
	protected $reference    = 'Monster Manual II page 114';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Common gray or red squirrels will bite only in self defense.';
	}

	protected function determine_specials() {
		parent::determine_specials();
#		$this->specials['index'] = 'Special Attack';
	}


}
