<?php

class DND_Monster_Dragon_Cloud extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Lawful Good';
#	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 0;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 10, 0 ], 'Claw Left' => [ 1, 10, 0 ], 'Bite' => [ 3, 12, 0 ], 'Tail' => [ 3, 4, 0 ], 'Breath' => [ 1, 1, 0 ] );
	private   $cleric       = null;
	protected $co_speaking  = 100;
	protected $co_magic_use = 100;
	protected $co_sleeping  = 75;
	private   $druid        = null;
	protected $frequency    = 'Very Rare';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 12, 13, 14 );
	private   $illusionist  = null;
	protected $in_lair      = 25;
#	protected $initiative   = 1;
	protected $intelligence = 'Genius';
#| protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
	protected $movement     = array( 'foot' => 6, 'air' => 39 );
	protected $name         = 'Cloud Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual II page 55-56,56';
#	protected $resistance   = 'Standard';
	protected $size         = "Large, 66' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'H,S,T';
	protected $xp_value     = array( 6100, 10, 100, 48 );

	use DND_Monster_Dragon_Mated;


	public function __construct( $args = array() ) {
		$this->solitary = 95;
		$this->check_for_existing_mate( $args );
		parent::__construct( $args );
		$this->description = 'Cloud dragons are sky-dwelling creatures. While some live in caves which are shrouded by clouds, most (75%) dwell on cloud islands and lair there (cf., "Cloud Giant"). They dislike intrusion and will either avoid contact with or attack unwanted visitors.  Cloud dragons appear to be fringed and frilled gold dragons.';
		$this->description.= '  Coloration depends on surroundings and mood, ranging from dark gray (angry) through pearlywhite (neutral) to golden or rose-colored (satisfied or very pleased). In solid form they have a translucent, opaline coloration with color specks reflecting mood.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "BW: Repulsion Gas Cloud - 30' wide, " . sprintf( '%3u', $this->hit_dice * 10 ) . "' long, 30' high.";
		$this->specials['defense'] = 'Assume gaseous form at will, with AC:-3 and Magic Resistance 50%';
		$this->specials['sleep']   = sprintf( 'Use sleeping (%u%%) to determine if found in gaseous form.', $this->co_sleeping );
		$this->specials_mate();
	}

	protected function set_magic_user( $level = 0 ) {
		parent::set_magic_user();
		$this->cleric      = new DND_Character_Cleric(      [ 'level' => $this->hit_dice ] );
		$this->druid       = new DND_Character_Druid(       [ 'level' => $this->hit_dice ] );
		$this->illusionist = new DND_Character_Illusionist( [ 'level' => $this->hit_dice ] );
	}

	protected function determine_magic_spells() {
		return true;
	}

	protected function add_magic_spells( $list ) {
		$this->spells[ 'V. Young' ] = $this->illusionist->get_magic_spell_info( 'Second', 'Fog Cloud' );
		if ( $this->hd_minimum > 1 ) $this->spells['Young']     = $this->magic_user->get_magic_spell_info( 'First',   'Precipitation' );
		if ( $this->hd_minimum > 2 ) $this->spells['Sub-Adult'] = $this->magic_user->get_magic_spell_info( 'Second',  'Stinking Cloud' );
		if ( $this->hd_minimum > 3 ) $this->spells['Yng Adult'] = $this->magic_user->get_magic_spell_info( 'Third',   'Cloudburst' );
		if ( $this->hd_minimum > 4 ) $this->spells['Adult']     = $this->druid->get_magic_spell_info(      'Third',   'Call Lightning' );
		if ( $this->hd_minimum > 5 ) $this->spells['Old']       = $this->druid->get_magic_spell_info(      'Sixth',   'Weather Summoning' );
		if ( $this->hd_minimum > 6 ) $this->spells['Very Old']  = $this->cleric->get_magic_spell_info(     'Seventh', 'Control Weather' );
		if ( $this->hd_minimum > 7 ) $this->spells['Ancient']   = $this->druid->get_magic_spell_info(      'Fifth',   'Control Winds' );
	}


}
