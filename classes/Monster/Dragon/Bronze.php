<?php
/* Name: Dragon, Bronze
 * Class: DND_Monster_Dragon_Bronze
 * Encounter: {"TW":{"M":"VR"},"TSW":{"M":"VR"},"TF":{"S":"R"},"TS":{"S":"R"},"TSF":{"S":"R"},"TSS":{"S":"R"}}
 */

class DND_Monster_Dragon_Bronze extends DND_Monster_Dragon_Dragon {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
	protected $alignment    = 'Lawful Good';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 0;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 6, 0 ], 'Claw Left' => [ 1, 6, 0 ], 'Bite' => [ 4, 8, 0 ], 'BW: Lightning Bolt' => [ 1, 1, 0 ], 'BW: Repulsion' => [ 1, 1, 0 ] );
	protected $co_speaking  = 60;
	protected $co_magic_use = 60;
	protected $co_sleeping  = 25;
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
#	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 0;
#	protected $hd_range     = array( 8, 9, 10 );
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
	protected $in_lair      = 45;
#	protected $initiative   = 1;
	protected $intelligence = 'Exceptional';
#	protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 9, 'air' => 24 );
	protected $name         = 'Bronze Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,32';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = "Large, 42' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $specials     = array();
#	protected $spells       = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'H,S,T';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array();
	protected $extra        = array( 'BW: Lightning Bolt' => 0, 'BW: Repulsion' => 0 );

	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->description = 'Bronze dragons prefer to dwell in subterranean lairs near substantial bodies of water such as lakes or seas. Despite their love of wealth, bronze dragons are basically of beneficent nature. They often assume the form of some animal in order to observe the affairs of humans.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "1st BW: Lightning Bolt - 5' wide, 100' long.";
		$this->specials['breath2'] = "2nd BW: Repulsion Gas Cloud - 30' wide, 20' long, 30' high.";
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
