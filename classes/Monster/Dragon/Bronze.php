<?php

class DND_Monster_Dragon_Bronze extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Lawful Good';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 0;
#	protected $armor_type   = 11;
#	protected $attacks      = array( 'Claw Right' => [ 1, 6, 0 ], 'Claw Left' => [ 1, 6, 0 ], 'Bite' => [ 4, 8, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 60;
	protected $co_magic_use = 60;
	protected $co_sleeping  = 25;
#	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 0;
#	protected $hd_range     = array( 8, 9, 10 );
	protected $in_lair      = 45;
#	protected $initiative   = 1;
	protected $intelligence = 'Exceptional';
#| protected $magic_user   = null;
#	protected $magic_use    = false;
#	protected $movement     = array( 'foot' => 9, 'air' => 24 );
	protected $name         = 'Bronze Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,32';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 42' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'H,S,T';
#	protected $xp_value     = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->description = 'Bronze dragons prefer to dwell in subterranean lairs near substantial bodies of water such as lakes or seas. Despite their love of wealth, bronze dragons are basically of beneficent nature. They often assume the form of some animal in order to observe the affairs of humans.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "1st BW: Lightning Bolt - 5' wide, 100' long.";
		$this->specials['breath2'] = "2nd BW: Repulsion Gas Cloud - 30' wide, 20' long, 30' high.";
	}

	protected function set_magic_user( $level = 0 ) {
		$this->magic_use = 'MagicUser';
		parent::set_magic_user();
	}

	protected function determine_magic_spells() {
		$needed = array( 'First' );
		if ( $this->hd_minimum > 1 ) $needed[] = 'First';
		if ( $this->hd_minimum > 2 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 3 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 4 ) $needed[] = 'Third';
		if ( $this->hd_minimum > 5 ) $needed[] = 'Third';
		if ( $this->hd_minimum > 6 ) $needed[] = 'Fourth';
		if ( $this->hd_minimum > 7 ) $needed[] = 'Fourth';
		return $needed;
	}


}
