<?php
/* Name: Dragon, Copper
 * Class: DND_Monster_Dragon_Copper
 * Encounter: {"TSW":{"M":"U","H":"R","D":"VR"},"TSF":{"S":"VR"},"TSS":{"S":"VR"}}
 */

class DND_Monster_Dragon_Copper extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Chaotic Good';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 1;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 4, 0 ], 'Claw Left' => [ 1, 4, 0 ], 'Bite' => [ 5, 4, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 45;
	protected $co_magic_use = 40;
	protected $co_sleeping  = 40;
	protected $frequency    = 'Uncommon to Rare';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 7, 8, 9 );
	protected $in_lair      = 35;
#	protected $initiative   = 1;
	protected $intelligence = 'High';
#| protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
#	protected $movement     = array( 'foot' => 9, 'air' => 24 );
	protected $name         = 'Copper Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,32';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 36' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'H,S';
#	protected $xp_value     = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->description = 'Copper dragons prefer to inhabit arid rocky regions, liking warmer climes in which to locate their cavern or cave lairs. They tend to be rather selfish, and thus many copper dragons are somewhat neutral in their outlook if gain is concerned.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "1st BW: Lightning Bolt - 5' wide, 70' long.";
		$this->specials['breath2'] = "2nd BW: Slow Gas Cloud - 20' wide, 30' long, 20' high.";
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
