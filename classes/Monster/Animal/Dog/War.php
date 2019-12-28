<?php
/* Name: War Dog
 * Class: DND_Monster_Animal_Dog_War
 * Encounter: {}
 */

class DND_Monster_Animal_Dog_War extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
	protected $hp_extra     = 2;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'War Dog';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dog';
	protected $reference    = 'Monster Manual page 28';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 2;
		$this->description = 'These are simply large dogs which are trained to fight. They are loyal to their masters and ferocious in attack. They are typically protected by light studded leather armor and a spiked collar. The number appearing depends on their masters.';
	}


}
