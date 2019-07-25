<?php

class DND_Monster_Spider_Giant extends DND_Monster_Spider_Spider {


	protected $alignment    = 'Chaotic Evil';
	protected $appearing    = array( 1, 8, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
	protected $frequency    = 'Uncommon';
	protected $hp_extra     = 4;
	protected $in_lair      = 70;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
	protected $movement     = array( 'foot' => 3, 'web' => 12 );
	protected $name         = 'Giant Spider';
#	protected $psionic      = 'Nil';
	protected $race         = 'Spider';
	protected $reference    = 'Monster Manual page 88';
#	protected $resistance   = 'Standard';
	protected $size         = 'Large';
#	protected $specials     = array();
	protected $treasure     = 'C';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->hit_dice = 4;
	}

	protected function determine_specials() {
		$this->specials = array(
			'bite_poison' => 'Bite victim must save versus poison or die.',
		);
	}


}
