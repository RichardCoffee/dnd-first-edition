<?php
/* Name: Mastodon
 * Class: DND_Monster_Animal_Elephant_Mastodon
 * Encounter: {}
 */

class DND_Monster_Animal_Elephant_Mastodon extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 12, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Right Tusk' => [ 2, 8, 0 ], 'Left Tusk' => [ 2, 8, 0 ], 'Trunk' => [ 2, 6, 0 ], 'Right Foot' => [ 2, 6, 0 ], 'Left Foot' => [ 2, 6, 0 ] );
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
	protected $name         = 'Mastodon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Elephant';
	protected $reference    = 'Monster Manual page 64';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (10' tall)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 12;
		$this->description = 'Mastodons dwell in nearly any climate, from near arctic to tropical. These huge herbivores are distantly related to elephants, but their body is somewhat lower and longer. They are common on Pleistocene plains.
Although the mastodon has 5 attack modes ( 2 tusks, 1 trunk, 2 forefeet), they cannot employ more than 2 of them at one time against a single opponent. For details of attack limitations and other data see ELEPHANT.
Their tusks are of the same weight and value as those of elephants.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['multiple'] = 'No more than 2 attacks per opponent.';
	}


}
