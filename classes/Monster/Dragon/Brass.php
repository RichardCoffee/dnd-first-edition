<?php

class DND_Monster_Dragon_Brass extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Chaotic Good (neutral tendencies)';
#	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 2;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 4, 0 ], 'Claw Left' => [ 1, 4, 0 ], 'Bite' => [ 4, 4, 0 ], 'Breath' => [ 1, 1, 0 ] );
	protected $co_speaking  = 30;
	protected $co_magic_use = 30;
	protected $co_sleeping  = 50;
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 6, 7, 8 );
	protected $in_lair      = 25;
#	protected $initiative   = 1;
	protected $intelligence = 'High';
#| protected $magic_user   = null;
#	protected $magic_use    = false;
	protected $movement     = array( 'foot' => 12, 'air' => 24 );
	protected $name         = 'Brass Dragon';
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
		$this->description = 'Sandy desert regions are the typical habitat of brass dragons, whose cavernous lairs are often found therein. Brass dragons are quite forward and officious, and they love to converse. They are rather selfish and tend towards neutrality because of this.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['breath1'] = "1st BW: Cone of Sleep Gas - 70' long, terminating diameter of 20'.";
		$this->specials['breath2'] = "2nd BW: Fear Gas Cloud - 40' wide, 50' long, 20' high.";
		add_filter( 'character_BW_saving_throw', [ $this, 'brass_dragon_breath_weapon_saving_throw' ], 10 );
	}

	protected function set_magic_user( $level = 0 ) {
		$this->magic_use = 'MagicUser';
		parent::set_magic_user();
	}

	protected function determine_magic_spells() {
		$needed = array( 'First' );
		if ( $this->hd_minimum > 1 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 2 ) $needed[] = 'First';
		if ( $this->hd_minimum > 3 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 4 ) $needed[] = 'First';
		if ( $this->hd_minimum > 5 ) $needed[] = 'Second';
		if ( $this->hd_minimum > 6 ) $needed[] = 'First';
		if ( $this->hd_minimum > 7 ) $needed[] = 'Second';
		return $needed;
		}
	}

	public function brass_dragon_breath_weapon_saving_throw( $base ) {
		$adj = 0;
		if ( $this->hit_dice === 6 ) {
			$adj = 2;
		} else if ( $this->hit_dice === 8 ) {
			$adj = -2;
		}
		return $adj;
	}


}
