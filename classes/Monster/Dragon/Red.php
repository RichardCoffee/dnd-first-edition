<?php
/* Name: Dragon, Red
 * Class: DND_Monster_Dragon_Red
 * Encounter: {"CW":{"M":"R","H":"R","F":"VR"},"TW":{"M":"R","H":"R","F":"VR"},"TSW":{"M":"R","H":"R","F":"VR"},"TF":{"S":"R"},"TS":{"S":"R"},"TSF":{"S":"R"},"TSS":{"S":"R"}}
 */

class DND_Monster_Dragon_Red extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Chaotic Evil';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = -1;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 8, 0 ], 'Claw Left' => [ 1, 8, 0 ], 'Bite' => [ 3, 10, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 75;
	protected $co_magic_use = 40;
	protected $co_sleeping  = 20;
#	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 9, 10, 11 );
	protected $in_lair      = 60;
#	protected $initiative   = 1;
	protected $intelligence = 'Exceptional';
#	protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
#	protected $movement     = array( 'foot' => 9, 'air' => 24 );
	protected $name         = 'Red Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,33-34';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 48' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'H,S,T';
#	protected $xp_value     = array();


	public function __construct( $args = array() ) {
		add_filter( 'dnd1e_rejected_spells', [ $this, 'rejected_spells' ], 10, 2 );
		parent::__construct( $args );
		$this->description = 'The red dragon is usually found dwelling in great hills or mountainous regions. As with most others of this species, they make their lairs in subterranean coves and similar places. They are very greedy and avaricious. Of all evil dragons, this sort is the worst, save for Tiamat herself.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "BW: Cone of Fire - 90' long by 30' base diameter.";
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

	public function rejected_spells( $rejects, $object ) {
		if ( $this === $object ) {
			$mine = array( 'Hold Portal', 'Jump', "Tenser's Floating Disc", 'Write' );
			foreach( $mine as $reject ) {
				if ( ! in_array( $reject, $rejects ) ) $rejects[] = $reject;
			}
		}
		return $rejects;
	}


}
