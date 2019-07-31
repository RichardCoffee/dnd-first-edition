<?php

class DND_Monster_Dragon_Faerie extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Chaotic Good';
	protected $appearing    = array( 1, 6, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 2, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 90;
	protected $co_magic_use = 100;
	protected $co_druid     = 65;
	protected $co_sleeping  = 40;
	private   $faerie       = array();
	protected $frequency    = 'Very Rare';
#	protected $hd_minimum   = 0;
#	protected $hd_range     = array( 8, 9, 10 );
#	protected $hd_value     = 8;
	protected $in_lair      = 25;
#	protected $initiative   = 1;
	protected $intelligence = 'High to Genius';
#| protected $magic_user   = null;
#	protected $magic_use    = 'MagicUser';
	protected $movement     = array( 'foot' => 6, 'air' => 24 );
	protected $name         = 'Faerie Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual II page 29-30,32';
#	protected $resistance   = 'Standard';
	protected $saving       = array( 'fight' );
	protected $size         = "Small, 1' to 1 1/2' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'S,T,U';
	protected $xp_value     = array( 280, 4 );


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->determine_magic_resistance();
		$this->description = 'This chaotic offshoot of the pseudodragon lives in peaceful, tangled forests in all climes, often with a group of sprites or pixies.';
		$this->description.= '  Faerie dragons enjoy swimming and diving. They can hover and are maneuverability class A. They eat fruit, roots, tubers, nuts, honey, and grains and may go to great lengths to get a fresh apple pie.';
		$this->description.= "  Faerie dragons appear as thin, miniature dragons with long, prehensile tails, butterfly wings, and huge smiles. Their colors range through the spectrum from red forthe very young to purple for ancient individuals. Females' hides shine with a bright golden tinge in the sunlight, while males have a silver tinge.";
	}

	protected function determine_hit_dice() {
		$this->hit_dice = 4;
	}

	protected function determine_hit_points() {
		if ( $this->hit_points === 0 ) {
			$this->hd_minimum = mt_rand( 1, $this->hd_value );
			$this->hit_points = ( $this->hd_minimum * 2 ) - mt_rand( 0, 1 );
		}
		$this->load_faerie_dragon_aspects();
	}

	protected function calculate_dragon_hit_points( $hit_dice ) {
		$minimum = mt_rand( 1, $this->hd_value );
		return ( $minimum * 2 ) - mt_rand( 0, 1 );
	}

	private function load_faerie_dragon_aspects() {
		$this->faerie = array(
			array(),
			array( 'color' => 'Red',        'mr' => 12, 'mu' =>  2, 'd' =>  3 ),
			array( 'color' => 'Red-Orange', 'mr' => 24, 'mu' =>  4, 'd' =>  4 ),
			array( 'color' => 'Orange',     'mr' => 35, 'mu' =>  6, 'd' =>  5 ),
			array( 'color' => 'Yellow',     'mr' => 48, 'mu' =>  8, 'd' =>  6 ),
			array( 'color' => 'Green',      'mr' => 60, 'mu' => 10, 'd' =>  8 ),
			array( 'color' => 'Blue-Green', 'mr' => 72, 'mu' => 12, 'd' => 10 ),
			array( 'color' => 'Blue',       'mr' => 84, 'mu' => 14, 'd' => 12 ),
			array( 'color' => 'Purple',     'mr' => 96, 'mu' => 16, 'd' => 14 ),
		);
	}

	protected function determine_magic_resistance() {
		$this->resistance = $this->faerie[ $this->hd_minimum ]['mr'];
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "BW: Euphoria gas - 2 foot diameter cloud";
		$this->specials['defense'] = 'Invisibility at will, AC: 1';
	}

	protected function set_magic_user( $level = 0 ) {
		$level = $this->faerie[ $this->hd_minimum ]['mu'];
		if ( $this->check_chance( $this->co_druid ) ) {
			$this->co_druid = 100;
			$this->magic_use = 'Druid';
			$level = $this->faerie[ $this->hd_minimum ]['d'];
			$this->saving[] = 'cleric';
		} else {
			$this->co_druid = 0;
		}
		parent::set_magic_user( $level );
	}

	protected function determine_magic_spells() {
		if ( $this->magic_use === 'MagicUser' ) {
			$needed = $this->determine_magic_spells_magic_user();
		} else {
			$needed = $this->determine_magic_spells_druid();
		}
		return $needed;
	}

	protected function determine_magic_spells_magic_user() {
		$needed = array( 'First', 'First' );
		if ( $this->hd_minimum > 1 ) { $needed = array_merge( $needed, [ 'First',  'Second', 'Second' ] ); }
		if ( $this->hd_minimum > 2 ) { $needed = array_merge( $needed, [ 'First',  'First',  'Third',  'Third' ] ); }
		if ( $this->hd_minimum > 3 ) { $needed = array_merge( $needed, [ 'Second', 'Third',  'Fourth', 'Fourth' ] ); }
		if ( $this->hd_minimum > 4 ) { $needed = array_merge( $needed, [ 'Second', 'Fifth',  'Fifth' ] ); }
		if ( $this->hd_minimum > 5 ) { $needed = array_merge( $needed, [ 'Third',  'Fourth', 'Fourth', 'Fifth',   'Fifth', 'Sixth' ] ); }
		if ( $this->hd_minimum > 6 ) { $needed = array_merge( $needed, [ 'First',  'Second', 'Third',  'Sixth',   'Seventh' ] ); }
		if ( $this->hd_minimum > 7 ) { $needed = array_merge( $needed, [ 'Fourth', 'Fifth',  'Sixth',  'Seventh', 'Eighth' ] ); }
		return $needed;
	}

	protected function determine_magic_spells_druid() {
		$needed = array( 'First', 'First', 'First', 'Second', 'Second', 'Third' );
		if ( $this->hd_minimum > 1 ) { $needed = array_merge( $needed, [ 'First',  'Third' ] ); }
		if ( $this->hd_minimum > 2 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 3 ) $needed[] = 'Fourth';
		if ( $this->hd_minimum > 4 ) { $needed = array_merge( $needed, [ 'Second', 'Third',  'Fourth' ] ); }
		if ( $this->hd_minimum > 5 ) { $needed = array_merge( $needed, [ 'First',  'Fourth', 'Fifth',  'Fifth' ] ); }
		if ( $this->hd_minimum > 6 ) { $needed = array_merge( $needed, [ 'Second', 'Third',  'Fourth', 'Fifth', 'Sixth', 'Sixth', 'Seventh' ] ); }
		if ( $this->hd_minimum > 7 ) { $needed = array_merge( $needed, [ 'First',  'Second', 'Third',  'Third', 'Fourth', 'Fourth', 'Fifth', 'Fifth', 'Sixth', 'Sixth', 'Seventh', 'Seventh' ] ); }
		return $needed;
	}


}
