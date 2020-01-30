<?php
/* Name: Dragon, Green
 * Class: DND_Monster_Dragon_Green
 * Encounter: {"CW":{"H":"VR","F":"R","S":"VR"},"TW":{"H":"VR","F":"R","S":"VR"},"TSW":{"H":"VR","F":"R","S":"VR"},"CF":{"S":"VR"},"CS":{"S":"VR"},"TF":{"S":"VR"},"TS":{"S":"VR"},"TSF":{"S":"VR"},"TSS":{"S":"VR"}}
 */

class DND_Monster_Dragon_Green extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Lawful Evil';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 2;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 6, 0 ], 'Claw Left' => [ 1, 6, 0 ], 'Bite' => [ 2, 10, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 45;
	protected $co_magic_use = 20;
	protected $co_sleeping  = 40;
#	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 7, 8, 9 );
	protected $in_lair      = 40;
#	protected $initiative   = 1;
	protected $intelligence = 'Average to Very';
#	protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
#	protected $movement     = array( 'foot' => 9, 'air' => 24 );
	protected $name         = 'Green Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,33';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 36' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'H';
#	protected $xp_value     = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->description = 'The race of green dragons prefer to locate their underground lairs in or near woods or forests of the bleaker wilder sort if possible. They are very nasty tempered and thoroughly evil.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "BW: Chlorine Gas Cloud - 40' wide, 50' long, 30' high.";
	}

	protected function determine_magic_spells() {
		$needed = array( 'First' );
		if ( $this->hd_minimum > 1 ) $needed[] = 'First';
		if ( $this->hd_minimum > 2 ) $needed[] = 'First';
		if ( $this->hd_minimum > 3 ) $needed[] = 'First';
		if ( $this->hd_minimum > 4 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 5 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 6 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 7 ) $needed[] = 'Second';
		return $needed;
	}


}
