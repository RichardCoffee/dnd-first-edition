<?php

class DND_Monster_Rat extends DND_Monster_Monster {


	protected $alignment    = 'Neutral (evil)';
	protected $appearing    = array( 1, 100, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 1, 0 ] );
#	protected $frequency    = 'Common';
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Ordinary Rat';
#	protected $psionic      = 'Nil';
	protected $race         = 'Rat';
	protected $reference    = 'Monster Manual II page 105';
#	protected $resistance   = 'Standard';
	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 2, 1 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->hd_value = 2;
	}

	protected function determine_specials() {
		$this->specials = array(
			'boolean_jermlaine' => '19% chance of being accompanied by Jermlaine (FF 53).',
			'boolean_disease'   => 'Bite has %5 chance of causing disease, ST applies.',
		);
	}

	public function special_boolean_jermlaine() {
		return ( mt_rand( 1, 100 ) < 20 ) ? true : false;
	}

	public function special_boolean_disease() {
		return ( mt_rand( 1, 100 ) < 6 ) ? true : false;
	}


}
