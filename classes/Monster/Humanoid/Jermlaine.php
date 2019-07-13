<?php

class DND_Monster_Humanoid_Jermlaine extends DND_Monster_Humanoid_Humanoid {


	protected $alignment    = 'Neutral Evil';
	protected $appearing    = array( 12, 4, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Dart' => [ 1, 2, 0 ], 'Spear' => [ 1, 4, 0 ] );
	protected $frequency    = 'Uncommon';
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Average';
	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Jermlaine';
#	protected $psionic      = 'Nil';
	protected $race         = 'Jermlaine';
	protected $reference    = 'Fiend Folio page 53';
#	protected $resistance   = 'Standard';
	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 7, 1 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->hd_value = 4;
	}

	protected function determine_specials() {
		$this->specials = array(
			'elder'     => '35 or more will be accompanied by an Elder.',
			'lair'      => "60% chance of being within 60' of their lair.",
			'treasure'  => 'Treasure: per 10 individuals O,Q; in lair C,Qx5,S,T',
			'detection' => '75% undetectable under normal conditions.',
			'surprise'  => 'Surprise opponents on a 1-5.',
			'defense'   => 'Treated as 4HD for magic effects and saving throws.',
			'senses'    => "30' infravision, keen hearing and smell.  Detect invisible: 50%",
		);
	}

	protected function determine_damage() {
		foreach( $this->attacks as $attack => $damage ) {
			$this->damage[ $attack ] = $damage;
		}
	}

	protected function get_fighter_data() {
		$data = parent::get_fighter_data();
		$data['weapons'] = array(
			'Dart'  => array( 'skill' => 'PF' ),
			'Spear' => array( 'skill' => 'PF' ),
		);
		return $data;
	}


}
