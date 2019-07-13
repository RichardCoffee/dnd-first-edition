<?php

class DND_Monster_Hydra extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array();
	protected $frequency    = 'Uncommon';
	protected $heads        = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
	protected $movement     = array( 'foot' => 9 );
	protected $name         = 'Hydra';
#	protected $psionic      = 'Nil';
	protected $race         = 'Hydra';
	protected $reference    = 'Monster Manual page 53-54';
#	protected $resistance   = 'Standard';
	protected $size         = 'Large';
	protected $treasure     = 'B';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->maximum_hp = true;
		if ( $this->hit_dice === 0 ) {
			$this->hit_dice = ( $this->heads === 0 ) ? mt_rand( 5, 12 ) : $this->heads;
			$this->determine_damage();
		}
	}

	protected function determine_damage() {
		switch( $this->hit_dice ) {
			case 5:
			case 6:
				$max = 6;
				break;
			case 7:
			case 8:
			case 9:
			case 10:
				$max = 8;
				break;
			case 11:
			case 12:
			default:
				$max = 10;
		}
		for( $i = 1; $i <= $this->hit_dice; $i++ ) {
			$key = "Bite $i";
			$this->attacks[ $key ] = array( 1, $max, 0 );
			$this->damage[  $key ] = array( 1, $max, 0 );
		}
	}


}
