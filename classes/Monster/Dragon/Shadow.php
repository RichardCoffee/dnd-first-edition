<?php

class DND_Monster_Dragon_Shadow extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Neutral Evil';
	protected $appearing    = array( 1, 2, 0 );
	protected $armor_class  = -2;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 4, 1 ], 'Claw Left' => [ 1, 4, 1 ], 'Bite' => [ 3, 4, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 100;
	protected $co_magic_use = 100;
	protected $co_sleeping  = 5;
	protected $frequency    = 'Very Rare';
	protected $hd_extra     = 1;
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 4, 5, 6 );
	protected $in_lair      = 40;
#	protected $initiative   = 1;
	protected $intelligence = 'Very to Genius';
#| protected $magic_user   = null;
	protected $magic_use    = 'Illusionist';
	protected $movement     = array( 'foot' => 18, 'air' => 24 );
	protected $name         = 'Shadow Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual II page 55-56, 58';
	protected $resistance   = 20;
	protected $size         = "Large, 20' to 30' long";
#	protected $sleeping     = false;
#	protected $speaking     = false;
#	protected $spells       = array();
	protected $treasure     = 'X,Y,Z';
	protected $xp_value     = array( 3450, 5, 50, 36 );

	use DND_Monster_Dragon_Mated;


	public function __construct( $args = array() ) {
		$this->solitary = 75;
		$this->check_for_existing_mate();
		$this->determine_intelligence();
		parent::__construct( $args );
		$this->description = 'The shadow dragon is nocturnal, subterranean, or found on planes of dimness such as Shadowland.';
		$this->description.= ' The species is also independent and solitary. Only occasionally will a mated pair be encountered.';
		$this->description.= ' The female lays a clutch of 5-8 eggs in a dark place. and the first one to hatch quickly devours the others.';
		$this->description.= ' Shadow dragons cannot abide either very hot climes or arctic conditions, but they thrive in cooler temperate regions.  Shadow dragons prefer to walk rather than fly, for they are poor flyers and tire in a few turns.';
	}

	protected function determine_intelligence() {
		if ( $this->intelligence === 'Very to Genius' ) {
			$roll = mt_rand( 11, 18 );
			switch( $roll ) {
				case 11:
				case 12:
					$this->intelligence = 'Very';
					break;
				case 13:
				case 14:
					$this->intelligence = 'Highly';
					break;
				case 15:
				case 16:
					$this->intelligence = 'Exceptional';
					break;
				case 17:
				case 18:
					$this->intelligence = 'Genius';
			}
			if ( $roll < 17 ) {
				$this->co_magic_use = 0;
			}
		}
	}

	protected function determine_hit_dice() {
		if ( $this->hit_dice === 0 ) {
			$roll = mt_rand( 1, 8 );
			switch( $roll ) {
				case 1:
				case 2:
					$this->hit_dice = $this->hd_range[0];
					break;
				case 7:
				case 8:
					$this->hit_dice = $this->hd_range[2];
					break;
				case 3:
				case 4:
				case 5:
				case 6:
				default:
					$this->hit_dice = $this->hd_range[1];
			}
		}
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['sense']   = "Poor vision in bright light.  Ultravision 60', Infravision 180'.";
		$this->specials['breath1'] = "BW: Misty Vapors Cloud - 30' wide, 90' long, 30' high.";
		$this->specials['defense'] = 'Assume gaseous form at will, with AC:-2 and Magic Resistance 30%';
		$this->specials_mate();
	}

	protected function determine_magic_spells() {
		$needed = array();
		if ( $this->hd_minimum > 5 ) { $needed[] = 'First';  $needed[] = 'First';  }
		if ( $this->hd_minimum > 6 ) { $needed[] = 'Second'; $needed[] = 'Second'; }
		if ( $this->hd_minimum > 7 ) { $needed[] = 'Third';  $needed[] = 'Third';  }
		if ( $this->hd_minimum > 8 ) { $needed[] = 'Fourth'; $needed[] = 'Fourth'; }
		return $needed;
	}


}
