<?php

trait DND_Monster_Trait_Experience {


	protected function determine_xp_value() {
		$xp = 0;
		if ( is_array( $this->xp_value ) ) {
			$xp  = $this->xp_value[0];
			$xp += ( $this->xp_value[1] * $this->hit_points );
			if ( array_key_exists( 2, $this->xp_value ) && array_key_exists( 3, $this->xp_value ) ) {
				if ( $this->hit_points > $this->xp_value[3] ) {
					$mod = $this->hit_points - $this->xp_value[3];
					$xp += ( $this->xp_value[2] * $mod );
				}
			}
		}
		if ( $xp < 1 ) {
			$xp = $this->default_xp_value();
		}
		$this->xp_value = $xp;
	}

	protected function default_xp_value() {
		$base = $this->initialize_xp_value();
		$xp   = $base[0];
		$xp  += $base[1] * $this->hit_points;
		$enum = new DND_Enum_Intelligence;
		$int  = $enum->position( $this->intelligence );
		if ( $int > 7 ) {
			$xp += $base[2];
		}
		if ( $this->magic_user ) {
			$xp += $base[3];
		}
		return $xp;
	}

	protected function initialize_xp_value() {
		static $table = [];
		if ( ! $table ) $table = $this->xp_table();
		$base = 0;
		if ( $this->hd_value > 6 ) {
			if ( $this->hit_dice > 20 ) {
				$base = 16;
			} else if ( ( $this->hit_dice / 2 ) > 5 ) {
				$base  = ( ceil( $this->hit_dice / 2 ) ) + 5;
			} else if ( $this->hit_dice === 10 ) {
				$base = 10;
			} else {
				$base  = $this->hit_dice;
				$base += ( $this->hp_extra ) ? 1 : 0;
			}
		}
		return $table[ $base ];
	}

	protected function xp_table() {
		return array(
			[    5,  1,    2,   25 ], #  0) up to 1-1
			[   10,  1,    4,   35 ], #  1) 1-1 to 1
			[   20,  2,    8,   45 ], #  2) 1+1 to 2
			[   35,  3,   15,   55 ], #  3) 2+1 to 3
			[   60,  4,   25,   65 ], #  4) 3+1 to 4
			[   90,  5,   40,   75 ], #  5) 4+1 to 5
			[  150,  6,   75,  125 ], #  6) 5+1 to 6
			[  225,  8,  125,  175 ], #  7) 6+1 to 7
			[  375, 10,  175,  275 ], #  8) 7+1 to 8
			[  600, 12,  300,  400 ], #  9) 8+1 to 9
			[  900, 14,  450,  600 ], # 10) 9+1 to 10+
			[ 1300, 16,  700,  850 ], # 11) 11 to 12+
			[ 1800, 18,  950, 1200 ], # 12) 13 to 14+
			[ 2400, 20, 1250, 1600 ], # 13) 15 to 16+
			[ 3000, 25, 1550, 2000 ], # 14) 17 to 18+
			[ 4000, 30, 2100, 2500 ], # 15) 19 to 20+
			[ 5000, 35, 2600, 3000 ], # 16) 21+
		);
	}


}
