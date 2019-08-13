<?php
/* Name: Dragon, Mist
 * Class: DND_Monster_Dragon_Mist
 * Encounter: {"TW":{"F":"VR","S":"VR"},"TSW":{"F":"VR","S":"VR"},"TF":{"S":"R"},"TS":{"S":"R"},"TSF":{"S":"R"},"TSS":{"S":"R"}}
 */

class DND_Monster_Dragon_Mist extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 2, 0 );
	protected $armor_class  = 1;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 4, 0 ], 'Claw Left' => [ 1, 4, 0 ], 'Bite' => [ 2, 12, 0 ], 'Tail Lash' => [ 2, 4, 0 ], 'Breath' => [ 1, 1, 0 ] );
	private   $cleric       = null;
	protected $co_speaking  = 100;
	protected $co_magic_use = 100;
	protected $co_sleeping  = 20;
	private   $druid        = null;
#	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 9, 10, 11 );
	protected $in_lair      = 35;
#	protected $initiative   = 1;
	protected $intelligence = 'Exceptional';
#| protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
	protected $movement     = array( 'foot' => 6, 'air' => 33 );
	protected $name         = 'Mist Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual II page 55-56, 58';
#	protected $resistance   = 'Standard';
	protected $saving       = array( 'fight', 'cleric' );
	protected $size         = "Large, 51' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'X,Y,Z';
	protected $xp_value     = array( 3450, 5, 50, 36 );


	public function __construct( $args = array() ) {
		$this->solitary = 90;
		parent::__construct( $args );
		$this->description = 'Mist dragons resemble gold dragons in body form. They are semitransparent even in material form and have a grayish-white to blue-white color.  These creatures are found only near waterfalls, seacoasts, or in areas where rainfall is heavy, i.e., rain forests.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "BW: Misty Vapors Cloud - 30' wide, 90' long, 30' high.";
		$this->specials['defense'] = 'Assume gaseous form at will, with AC:-2 and Magic Resistance 30%';
		$this->specials['sleep']   = sprintf( 'Use sleeping (%u%%) to determine if found in gaseous form.', $this->co_sleeping );
	}

	protected function set_magic_user( $level = 0 ) {
		parent::set_magic_user();
		$this->cleric = new DND_Character_Cleric( [ 'level' => $this->hit_dice ] );
		$this->druid  = new DND_Character_Druid(  [ 'level' => $this->hit_dice ] );
	}

	protected function determine_magic_spells() {
		return true;
	}

	protected function add_magic_spells( $list ) {
		$this->spells[ 'V. Young' ] = $this->magic_user->get_magic_spell_info( 'First', 'Precipitation' );
		if ( $this->hd_minimum > 1 ) $this->spells['Young']     = $this->cleric->get_magic_spell_info(     'First',  'Create Water' );
		if ( $this->hd_minimum > 2 ) $this->spells['Sub-Adult'] = $this->magic_user->get_magic_spell_info( 'Third',  'Water Breathing' );
		if ( $this->hd_minimum > 3 ) $this->spells['Yng Adult'] = $this->magic_user->get_magic_spell_info( 'Second', 'Zephyr' );
		if ( $this->hd_minimum > 4 ) $this->spells['Adult']     = $this->druid->get_magic_spell_info(      'First',  'Predict Weather' );
		if ( $this->hd_minimum > 5 ) $this->spells['Old']       = $this->druid->get_magic_spell_info(      'Third',  'Cloudburst' );
		if ( $this->hd_minimum > 6 ) $this->spells['Very Old']  = $this->magic_user->get_magic_spell_info( 'Third',  'Gust of Wind' );
		if ( $this->hd_minimum > 7 ) $this->spells['Ancient']   = $this->magic_user->get_magic_spell_info( 'Fifth',  'Airy Water' );
	}


}
