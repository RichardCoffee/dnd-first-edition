<?php

trait DND_Monster_Dragon_Mated {


	protected $mate     = null;
	protected $solitary = 0;
	protected $young    = array();


	private function check_for_existing_mate( &$args ) {
		if ( array_key_exists( 'mate', $args ) ) {
#			$this->mate = unserialize( $args['mate'] );
#			$this->solitary = 0;
#			unset( $args['mate'] );
		}
	}

	public function get_number_appearing() {
		$num = parent::get_number_appearing();
		if ( ( $num > 1 ) && ( ! $this->check_chance( $this->solitary ) ) ) {
			$dragons = array();
			$create  = get_class( $this );
			$this->determine_mate_stats();
			if ( $this->mate ) {
				$dragons[] = $this->mate;
				for( $i = 3; $i <= $num; $i++ ) {
					$age = mt_rand( 1, 2 );
					$dragons[] = new $create( [ 'hd_minimum' => $age, 'solitary' => 100 ] );
				}
			} else {
				$min = max( 1, $this->hd_minimum - 1 );
				$max = min( $this->hd_minimum + 1, 8 );
				for( $i = 2; $i <= $num; $i++ ) {
					$age = mt_rand( $min, $max );
					$dragons[] = new $create( [ 'hd_minimum' => $age, 'solitary' => 100 ] );
				}
			}
			return $dragons;
		}
		return $num;
	}

	private function determine_mate_stats() {
		if ( $this->hd_minimum > 4 ) {
			$create = get_class( $this );
			$data = array(
				'hd_minimum' => mt_rand( 5, 8 ),
				'hit_dice'   => $this->hit_dice,
				'solitary'   => 100,
			);
			$this->mate = new $create( $data );
			$this->solitary = 0;
			$this->specials_mate();
		}
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
