<?php

trait DND_Monster_Dragon_Mated {


	protected $mate     = null;
	protected $solitary = 1;
	protected $young    = array();


	private function check_for_existing_mate( &$args ) {
		if ( array_key_exists( 'mate', $args ) ) {
			$this->mate = unserialize( $args['mate'] );
			$this->solitary = 0;
			unset( $args['mate'] );
		}
	}

	public function get_number_appearing() {
		if ( ( $this->solitary === 1 ) ) {
			$num = parent::get_number_appearing();
			if ( $num === 1 ) {
				$this->solitary = 100;
			} else {
				$this->determine_mate_stats();
				if ( $this->mate ) {
					$enemy = array( $this->mate );
					for( $i = 3; $i <= $num; $i++ ) {
						$enemy[] = $this->determine_young_stats();
					}
					return $enemy;
				}
			}
		} else {
			$num = 1;
			if ( $this->mate ) {
				$num = 2;
				$this->solitary = 0;
			} else if ( $this->solitary && ( $this->hd_minimum > 4 ) ) {
				if ( $this->check_chance( $this->solitary ) ) {
					$this->solitary = 100;
				} else {
					$this->determine_mate_stats();
					$num = 2;
					$this->solitary = 0;
				}
			} else {
				$this->solitary = 100;
			}
		}
		return $num;
	}

	private function determine_mate_stats() {
		if ( $this->hd_minimum > 4 ) {
			$age = mt_rand( 5, 8 );
			$create = get_class( $this );
			$this->mate = new $create( [ 'hd_minimum' => $age, 'solitary' => 100 ] );
			$this->solitary = 0;
			$this->specials_mate();
		}
	}

	private function determine_young_stats() {
		$age = mt_rand( 1, 2 );
		$create = get_class( $this );
		$young  = new $create( [ 'hd_minimum' => $age, 'solitary' => 100 ] );
		return $young;
	}

	public function get_appearing_hit_points( $number = 1 ) {
		$hit_points = array( $this->hit_points );
		if ( $this->mate ) {
			$hit_points[] = [ $this->mate->hit_points, $this->mate->hit_points ];
			$number--;
		}
		for( $i = 1; $i < $number; $i++ ) {
			$hp = $this->calculate_hit_points( true );
			$hit_points[] = [ $hp, $hp ];
		}
		return $hit_points;
	}

	private function specials_mate() {
		if ( $this->mate && ( ! array_key_exists( 'mate', $this->specials ) ) ) {
			$this->specials['mate'] = sprintf( 'Mated Pair: HD %u, HP %u, Age %s', $this->mate->hit_dice, $this->mate->hit_points, $this->mate->get_dragon_age() );
		}
	}


}
