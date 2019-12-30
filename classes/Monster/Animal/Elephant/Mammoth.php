<?php
/* Name: Mammoth
 * Class: DND_Monster_Animal_Elephant_Mammoth
 * Encounter: {}
 */

class DND_Monster_Animal_Elephant_Mammoth extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 12, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Right Tusk' => [ 3, 6, 0 ], 'Left Tusk' => [ 3, 6, 0 ], 'Trunk' => [ 2, 8, 0 ], 'Right Foot' => [ 2, 6, 0 ], 'Left Foot' => [ 2, 6, 0 ] );
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
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Mammoth';
#	protected $psionic      = 'Nil';
	protected $race         = 'Elephant';
	protected $reference    = 'Monster Manual page 64';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (10' to 14' tall)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 13;
		$this->description = 'There are several varieties of mammoth, including the woolly and imperial - the latter sort being the largest. They inhabit climes ronging from subarctic to subtropical of the Pleistocene epoch. These massive herbivores are quite aggressive if threatened.
As with elephants (q.v.) and mastodons, the mammoth has 5 attack forms, but in general can apply no more than 2 versus a single opponent.
The tusks of the mammoth are 50% heavier than those of the elephont, and their value is proportionately higher.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['multiple'] = 'No more than 2 attacks per opponent.';
	}


}
