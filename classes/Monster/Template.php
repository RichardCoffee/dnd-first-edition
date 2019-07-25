<?php

class DND_Monster_Template extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
#	protected $armor_class  = 10;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 8, 0 ] );
#	public    $companions   = array();
#	protected $comparison   = array(); // used for weapon comparisons, such as the sword +1, +4 vs reptiles
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hit_dice     = 0;
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
#	protected $name         = 'Monster';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Monster';
#	protected $reference    = 'Monster Manual page';
#	protected $resistance   = 'Standard';
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
	}


}
