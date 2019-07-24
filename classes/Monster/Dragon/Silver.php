<?php

class DND_Monster_Dragon_Silver extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Lawful Good';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = -1;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 6, 0 ], 'Claw Left' => [ 1, 6, 0 ], 'Bite' => [ 5, 6, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 75;
	protected $co_magic_use = 75;
	protected $co_sleeping  = 15;
	protected $frequency    = 'Very Rare';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 9, 10, 11 );
	protected $in_lair      = 55;
#	protected $initiative   = 1;
	protected $intelligence = 'Exceptional';
#| protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
#	protected $movement     = array( 'foot' => 9, 'air' => 24 );
	protected $name         = 'Silver Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,34';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 48' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'H,T';
#	protected $xp_value     = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->description = 'Silver dragons select mountain peaks, clouds, and similar locales in which to establish their abode. It is claimed that this dragon can be found in the home of the King of Good Dragons as well as behind other winds as well. Much as o gold dragon, these creatures are able to polymorph themselves in order to appear as an animal or human (typically a kindly old man or fair domsel if the lotter).';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "1st BW: Cone of Frost - 80' long by 30' base diameter.";
		$this->specials['breath2'] = "2nd BW: Paralyzing Gas Cloud - 40' wide, 50' long, 20' high.";
		$this->specials['spells']  = '25% have spell books.';
	}

	protected function determine_magic_spells() {
		$needed = array( 'First', 'First' );
		if ( $this->hd_minimum > 1 ) { $needed[] = 'Second'; $needed[] = 'Second'; }
		if ( $this->hd_minimum > 2 ) $needed[] = 'Third';
		if ( $this->hd_minimum > 3 ) $needed[] = 'Third';
		if ( $this->hd_minimum > 4 ) $needed[] = 'Fourth';
		if ( $this->hd_minimum > 5 ) $needed[] = 'Fourth';
		if ( $this->hd_minimum > 6 ) $needed[] = 'Fifth';
		if ( $this->hd_minimum > 7 ) $needed[] = 'Fifth';
		return $needed;
	}


}
