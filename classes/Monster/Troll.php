<?php

class DND_Monster_Troll extends DND_Monster_Monster {


	protected $alignment    = 'Chaotic Evil';
	protected $appearing    = array( 1, 12, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 4, 4 ], 'Claw Left' => [ 1, 4, 4 ], 'Bite' => [ 2, 6, 0 ] );
	protected $frequency    = 'Uncommon';
	protected $hp_extra     = 6;
	protected $in_lair      = 40;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Troll';
#	protected $psionic      = 'Nil';
	protected $race         = 'Troll';
	protected $reference    = 'Monster Manual page 95';
#	protected $resistance   = 'Standard';
	protected $size         = "L (9'+ tall)";
#	protected $specials     = array();
	protected $treasure     = 'D';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->hit_dice = 6;
		$this->description = "Troll hide is a nauseating moss green, mottled green and gray, or putrid gray. The writhing hair-like growth upon a troll's head is greenish black or iron gray. The eyes of a troll are dull black.";
	}

	protected function determine_specials() {
		$this->specials = array(
			'attitude' => 'Knows no fear and attacks unceasingly.',
			'senses'   => "90' Infravision",
			'defense'  => 'Regenerates 3 hp per round, begins 3 rounds after taking damage.',
		);
	}


}
