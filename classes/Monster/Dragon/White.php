<?php

class DND_Monster_Dragon_White extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Chaotic Evil';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 3;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 4, 0 ], 'Claw Left' => [ 1, 4, 0 ], 'Bite' => [ 2, 8, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 20;
	protected $co_magic_use = 5;
	protected $co_sleeping  = 60;
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 5, 6, 7 );
	protected $in_lair      = 20;
#	protected $initiative   = 1;
	protected $intelligence = 'Average (Low)';
#| protected $magic_user   = null;
#	protected $magic_use    = false;
	protected $movement     = array( 'foot' => 12, 'air' => 30 );
	protected $name         = 'White Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,34';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 24' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'E,O,S';
#	protected $xp_value     = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->description = 'White dragons favor chilly or cold regions in which to dwell. They lair in icy caves or deep subterranean places. Although not as intelligent as most other dragons, they are as evil and greedy as any.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "BW: Cone of Cold - 70' long, 25' base.";
	}

	protected function set_magic_user( $level = 0 ) {
		$this->magic_use = 'MagicUser';
		parent::set_magic_user();
	}

	protected function determine_magic_spells() {
		$needed = array();
		if ( $this->hd_minimum > 1 ) $needed[] = 'First';
		if ( $this->hd_minimum > 3 ) $needed[] = 'First';
		if ( $this->hd_minimum > 5 ) $needed[] = 'First';
		if ( $this->hd_minimum > 7 ) $needed[] = 'First';
		return $needed;
	}


}
