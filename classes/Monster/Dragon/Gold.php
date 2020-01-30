<?php
/* Name: Dragon, Gold
 * Class: DND_Monster_Dragon_Gold
 * Encounter: {"CC":{"M":"VR","H":"VR","F":"VR","S":"VR","P":"VR","D":"VR"},"CW":{"M":"VR","H":"VR","F":"VR","S":"VR","P":"VR","D":"VR"},"TC":{"M":"VR","H":"VR","F":"VR","S":"VR","P":"VR","D":"VR"},"TW":{"M":"VR","H":"VR","F":"VR","S":"VR","P":"VR","D":"VR"},"TSC":{"M":"VR","H":"VR","F":"VR","S":"VR","P":"VR","D":"VR"},"TSW":{"M":"VR","H":"VR","F":"VR","S":"VR","P":"VR","D":"VR"},"CF":{"S":"VR"},"CS":{"S":"VR"},"TF":{"S":"VR"},"TS":{"S":"VR"},"TSF":{"S":"VR"},"TSS":{"S":"VR"}}
 */

class DND_Monster_Dragon_Gold extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Lawful Good';
	protected $appearing    = array( 1, 3, 0 );
	protected $armor_class  = -2;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 8, 0 ], 'Claw Left' => [ 1, 8, 0 ], 'Bite' => [ 6, 6, 0 ], 'BW: Cone of Fire' => [ 1, 1, 0 ], 'BW: Chlorine' => [ 1, 1, 0 ] );
	protected $co_speaking  = 90;
	protected $co_magic_use = 100;
	protected $co_sleeping  = 10;
	protected $frequency    = 'Very Rare';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 10, 11, 12 );
	protected $in_lair      = 65;
#	protected $initiative   = 1;
	protected $intelligence = 'Genius';
#	protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
	protected $movement     = array( 'foot' => 12, 'air' => 30 );
	protected $name         = 'Gold Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,32-33';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 54' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'H,R,S,T';
#	protected $xp_value     = array();
	protected $extra        = array( 'BW: Cone of Fire' => 0, 'BW: Chlorine' => 0 );


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->description = 'Gold dragons are able to dwell in any clime, but their lairs are always of solid stone - whether a cave or a castle. Although they love precious metals and gems and use jewels and pearls as nourishment, all gold dragons are lawful, just and good. They are able to assume the form of animals or the guise of humanity, for they can polymorph themselves without harm. It is in some other form that they are typically encountered.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "1st BW: Cone of Fire - 90' long, terminating diameter of 30'.";
		$this->specials['breath2'] = "2nd BW: Chlorine Gas Cloud - 40' wide, 50' long, 30' high.";
		$this->specials['ability'] = 'Polymorph self - three times per day.';
		$this->specials['spells']  = '50% have spell books.';
	}

	protected function determine_magic_spells() {
		$needed = array( 'First' );
		if ( $this->hd_minimum > 1 )   $needed[] = 'First';
		if ( $this->hd_minimum > 2 ) { $needed[] = 'Second'; $needed[] = 'Second'; }
		if ( $this->hd_minimum > 3 ) { $needed[] = 'Third';  $needed[] = 'Third';  }
		if ( $this->hd_minimum > 4 ) { $needed[] = 'Fourth'; $needed[] = 'Fourth'; }
		if ( $this->hd_minimum > 5 ) { $needed[] = 'Fifth';  $needed[] = 'Fifth';  }
		if ( $this->hd_minimum > 6 )   $needed[] = 'Sixth';
		if ( $this->hd_minimum > 7 )   $needed[] = 'Sixth';
		return $needed;
	}


}
