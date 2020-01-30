<?php
/* Name: Dragon, Black
 * Class: DND_Monster_Dragon_Black
 * Encounter: {"TW":{"M":"VR","S":"VR"},"TSW":{"M":"VR","S":"VR"},"TF":{"S":"VR"},"TS":{"S":"VR"},"TSF":{"S":"VR"},"TSS":{"S":"VR"}}
 */

class DND_Monster_Dragon_Black extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Neutral Evil';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 3;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 4, 0 ], 'Claw Left' => [ 1, 4, 0 ], 'Bite' => [ 3, 6, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 30;
	protected $co_magic_use = 10;
	protected $co_sleeping  = 50;
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 6, 7, 8 );
	protected $in_lair      = 30;
#	protected $initiative   = 1;
	protected $intelligence = 'Average';
#	protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
	protected $movement     = array( 'foot' => 12, 'air' => 24 );
	protected $name         = 'Black Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,31';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 30' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'H';
#	protected $xp_value     = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->description = 'The black dragon is typically found in miasmal swamps or marshes, although they also inhabit subterranean lairs as well, for black dragons always seek to lair in deep, dark caves.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "BW: Spitting Acid - 5' wide, 60' long.";
	}

	protected function determine_magic_spells() {
		return array_pad( array(), $this->hd_minimum, 'First' );
	}


}
