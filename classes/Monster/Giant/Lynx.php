<?php

class DND_Monster_Giant_Lynx extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 2, 0 ], 'Claw Left' => [ 1, 2, 0 ], 'Bite' => [ 1, 4, 0 ] );
	protected $frequency    = 'Rare';
	protected $hp_extra     = 2;
	protected $in_lair      = 5;
#	protected $initiative   = 1;
	protected $intelligence = 'Very';
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Giant Lynx';
#	protected $psionic      = 'Nil';
	protected $race         = 'Lynx';
	protected $reference    = 'Monster Manual page 63';
#	protected $resistance   = 'Standard';
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->hit_dice = 2;
	}

	protected function determine_specials() {
		$this->specials = array(
			'physical'     => "Climbs well, swims good, can leap up to 15'",
			'rear_claws'   => 'If both front claws hit, gets two rear claw attacks at 1-3/1-3.',
			'detect_traps' => 'Will detect traps 75% of the time.',
			'detection'    => '90% chance of remaining undetected when hiding.',
			'surprise'     => 'Surprise opponents on 1-5.',
		);
	}

	protected function determine_damage() {
		foreach( $this->attacks as $attack => $damage ) {
			$this->damage[ $attack ] = $damage;
		}
	}


}
