<?php
/* Name: Stag
 * Class: DND_Monster_Animal_Stag
 * Encounter: {"TW":{"H":"U","F":"C","P":"C"}}
 */

class DND_Monster_Animal_Stag extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Right Forehoove' => [ 1, 3, 0 ], 'Left Forehoove' => [ 1, 3, 0 ], 'Antlers' => [ 2, 4, 0 ] );
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
	protected $movement     = array( 'foot' => 24 );
	protected $name         = 'Stag';
#	protected $psionic      = 'Nil';
	protected $race         = 'Deer';
	protected $reference    = 'Monster Manual page 90';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 3;
		$this->description = 'Stags are herbivores found in temperate forests and meadowlands. They are the aggressive males of a herd which numbers 4-8 times the number of stags encountered. These creatures will defend the herd against all but the most fearsome opponents. A stag can attack with its branching antlers or by lashing out with its sharp forehooves.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['attacks'] = 'Attack will be either Antlers or Forehooves, not both.';
	}

	protected function is_sequence_attack( $check ) {
		if ( $check === 'Antlers' ) return false;
		return true;
	}


}
