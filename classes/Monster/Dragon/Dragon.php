<?php

abstract class DND_Monster_Dragon_Dragon extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 4, 0 );
#	protected $armor_class  = 10;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 6, 0 ], 'Claw Left' => [ 1, 6, 0 ], 'Bite' => [ 4, 8, 0 ] );
	protected $co_speaking  = 0;
	protected $co_magic_use = 0;
	protected $co_sleeping  = 0;
	protected $frequency    = 'Rare';
	protected $hd_minimum   = 0;
	protected $hd_range     = array( 8, 9, 10 );
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
	protected $magic_use    = false;
	protected $movement     = array( 'foot' => 9, 'air' => 24 );
	protected $name         = 'Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-34';
#	protected $resistance   = 'Standard';
	protected $size         = 'Large';
	protected $sleeping     = false;
	protected $speaking     = false;
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		if ( $this->hit_dice === 0 ) {
			$roll = mt_rand( 1, 8 );
			switch( $roll ) {
				case 1:
				case 2:
					$this->hit_dice = $this->hd_range[0];
					break;
				case 8:
					$this->hit_dice = $this->hd_range[2];
					break;
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
				default:
					$this->hit_dice = $this->hd_range[1];
			}
		}
	}

	protected function determine_hit_points() {
		if ( ( $this->hit_points === 0 ) && ( $this->hit_dice > 0 ) ) {
			if ( $this->hd_minimum === 0 ) {
				$this->hd_minimum = mt_rand( 1, $this->hd_value );
			}
			for( $i = 1; $i <= $this->hit_dice; $i++ ) {
				$this->hit_points += mt_rand( $this->hd_minimum, $this->hd_value );
			}
		}
	}

	protected function determine_damage() {
		foreach( $this->attacks as $attack => $damage ) {
			$this->damage[ $attack ] = $damage;
		}
	}

	public function sleeping_chance() {
		return $this->co_sleeping . '%';
	}

	public function is_sleeping() {
		if ( $this->co_sleeping ) {
			$roll = mt_rand( 1, 100 );
			if ( ! ( $roll > $this->co_sleeping ) ) {
				$this->co_sleeping = false;
				$this->sleeping = true;
			}
		}
		return $this->sleeping;
	}

	public function command_line_display() {
		$line  = parent::command_line_display();
		$line .= "sleeping: " . $this->sleeping_chance() . "\n";
		return $line;
	}


}
