<?php

class DND_Monster_Lycan_Wolf extends DND_Monster_Lycan_Lycan {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 3, 6, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
#	protected $frequency    = 'Common';
	protected $hp_extra     = 3;
	protected $in_lair      = 25;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Werewolf';
#	protected $psionic      = 'Nil';
	protected $race         = 'Lycan';
	protected $reference    = 'Monster Manual page 62';
#	protected $resistance   = 'Standard';
#	protected $size         = 'Medium';
#	protected $specials     = array();
	protected $treasure     = 'B';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->hit_dice = 4;
	}

	protected function determine_specials() {
		$this->specials['surprise'] = 'Surprise opponents on 1-3.';
		parent::determine_specials();
	}


}
