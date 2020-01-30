<?php
/* Name: Dragon, Blue
 * Class: DND_Monster_Dragon_Blue
 * Encounter: {"TSW":{"P":"VR","D":"VR"},"TSF":{"S":"VR"},"TSS":{"S":"VR"}}
 */

class DND_Monster_Dragon_Blue extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Lawful Evil';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 2;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 6, 0 ], 'Claw Left' => [ 1, 6, 0 ], 'Bite' => [ 3, 8, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 60;
	protected $co_magic_use = 30;
	protected $co_sleeping  = 30;
#	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 0;
#	protected $hd_range     = array( 8, 9, 10 );
	protected $in_lair      = 50;
#	protected $initiative   = 1;
	protected $intelligence = 'Very';
#	protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
#	protected $movement     = array( 'foot' => 9, 'air' => 24 );
	protected $name         = 'Blue Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,31';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 42' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'H,S';
#	protected $xp_value     = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->description = 'Blue dragons typically prefer deserts and arid lands; like others of their kind their lair is always some vast cave or underground cavern.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "BW: Lightning Bolt - 5' wide, 100' long.";
	}

	protected function determine_magic_spells() {
		$needed = array( 'First' );
		if ( $this->hd_minimum > 1 ) $needed[] = 'First';
		if ( $this->hd_minimum > 2 ) $needed[] = 'First';
		if ( $this->hd_minimum > 3 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 4 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 5 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 6 ) $needed[] = 'Third';
		if ( $this->hd_minimum > 7 ) $needed[] = 'Third';
		return $needed;
	}


}
