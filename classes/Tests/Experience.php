<?php

class DND_Tests_Experience {

	protected $hd_minimum   = 1;
	protected $hd_value     = 8;
	protected $hit_dice     = 1;
	protected $hit_points   = 0;
	protected $hp_extra     = 0;
	protected $intelligence = 'Non-';
	protected $magic_user   = null;
	protected $maximum_hp   = false;
	protected $xp_value     = array( 0, 0, 0, 0 );


	use DND_Monster_Trait_Experience { initialize_xp_value as init_xpv; }
	use DND_Trait_ParseArgs;


	public function __construct( $args = array() ) {
		$this->parse_args( $args );
	}

	protected function calculate_hit_points( $appearing = false ) {
		$hit_points = 0;
		if ( $this->maximum_hp ) {
			$hit_points = ( $this->hit_dice * $this->hd_value ) + $this->hp_extra;
		} else {
			for( $i = 1; $i <= $this->hit_dice; $i++ ) {
				$hit_points += mt_rand( $this->hd_minimum, $this->hd_value );
			}
			$hit_points += $this->hp_extra;
		}
		return $hit_points;
	}

	public function show_experience_points() {
		$this->hit_points = $this->calculate_hit_points();
		$this->determine_xp_value();
		echo "\nHD: {$this->hit_dice}\tHP: {$this->hit_points}\tXP: $this->xp_value\n";
	}

	protected function initialize_xp_value() {
		$base = $this->init_xpv();
		print_r( $base );
		return $base;
	}



}
