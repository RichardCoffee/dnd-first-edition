<?php

trait DND_Monster_Dragon_Mated {


	protected $mate     = null;
	protected $solitary = 1;


	private function check_for_existing_mate( &$args ) {
		if ( isset( $args['mate'] ) ) {
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
			}
		} else {
			$num = 1;
			if ( $this->mate ) {
				$num = 2;
			} else if ( $this->solitary && ( $this->hd_minimum > 4 ) ) {
				if ( ! $this->check_chance( $this->solitary ) ) {
					$this->determine_mate_stats();
					$num = 2;
				} else {
					$this->solitary = 100;
				}
			}
		}
		return $num;
	}

	private function determine_mate_stats() {
		if ( $this->hd_minimum > 4 ) {
			$age = mt_rand( 5, 8 );
			$create = get_class( $this );
			$this->mate = new $create( [ 'hd_minimum' => $age, 'solitary' => 0 ] );
			$this->solitary = 0;
			$this->specials_mate();
		}
	}

	public function get_appearing_hit_points( $number = 1 ) {
		$hit_points = array( $this->hit_points );
		if ( $this->mate ) {
			$hit_points[] = array( $this->mate->hit_points, $this->mate->hit_points );
		}
		return $hit_points;
	}

	private function specials_mate() {
		if ( $this->mate && ( ! isset( $this->specials['mate'] ) ) ) {
			$this->specials['mate'] = sprintf( 'Mated Pair: HD %u, HP %u, Age %s', $this->mate->hit_dice, $this->mate->hit_points, $this->mate->get_dragon_age() );
		}
	}


}
