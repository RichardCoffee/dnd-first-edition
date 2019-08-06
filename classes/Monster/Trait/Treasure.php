<?php

trait DND_Monster_Trait_Treasure {


	private function get_experience_points_index() {
		if ( $this->hd_value < 8 ) return 0;
#		if ( $this->hd
	}

	private function get_experience_points_table() {
		return array(
			[    5,  1,    2,   25 ],
			[   10,  1,    4,   35 ],
			[   20,  2,    8,   45 ],
			[   35,  3,   15,   55 ],
			[   60,  4,   25,   65 ],
			[   90,  5,   40,   75 ],
			[  150,  6,   75,  125 ],
			[  225,  8,  125,  175 ],
			[  375, 10,  175,  275 ],
			[  600, 12,  300,  400 ],
			[  900, 14,  450,  600 ],
			[ 1300, 16,  700,  850 ],
			[ 1800, 18,  950, 1200 ],
			[ 2400, 20, 1250, 1600 ],
			[ 3000, 25, 1550, 2000 ],
			[ 4000, 30, 2100, 2500 ],
			[ 5000, 35, 2600, 3000 ]
		);
	}

	private function get_treasure_possibilities( $type ) {
		$multiply = $this->get_treasure_multipliers();
		$treasure = array();
		$table    = $this->get_treasure_table();
		if ( array_key_exists( $type, $table ) ) {
			$row = $table[ $type ];
			foreach( $row as $kind => $odds ) {
				$name = ucfirst( $kind );
				$format = '%2u%%: %ud%u';
				if ( $kind === 'special' ) {
					if ( $odds[2] === 1 ) {
						$format = '%1$2u%%: %2$u - ';
					} else {
						$format = '%2u%%: %ud%u ';
					}
				}
				if ( $odds[0] === 100 ) {
					$format = '%2$ud%3$u per individual';
				}
				$string = sprintf( $format, $odds[0], $odds[1], $odds[2] );
				switch( $kind ) {
					case 'gems':
					case 'jewelry':
						$string .= ' DMG 24, OS310';
						break;
					case 'special':
						$string .= 'DMG 120, OS311: ' . implode( ', ', $odds[3] );
						break;
					default:
						$string .= sprintf( ' x %u', $multiply[ $kind ] );
				}
				$treasure[] = sprintf( '%10s %s', $name, $string );
			}
		}
		return $treasure;
	}

	private function get_treasure_multipliers() {
		$mults = array(
			'copper'   => 1000,
			'silver'   => 1000,
			'electrum' => 1000,
			'gold'     => 1000,
			'platinum' => 100,
		);
		return apply_filters( 'monster_treasure_multipliers', $mults, $this );
	}

	private function get_treasure_table() {
		return array(
			'A' => array(
				'copper'   => [ 25, 1,  6 ],
				'silver'   => [ 30, 1,  6 ],
				'electrum' => [ 35, 1,  6 ],
				'gold'     => [ 40, 1, 10 ],
				'platinum' => [ 25, 1,  4 ],
				'gems'     => [ 60, 4, 10 ],
				'jewelry'  => [ 50, 3, 10 ],
				'special'  => [ 30, 3,  1, [ 'any', 'any', 'any' ] ],
			),
			'B' => array(
				'copper'   => [ 50, 1, 8 ],
				'silver'   => [ 25, 1, 6 ],
				'electrum' => [ 25, 1, 4 ],
				'gold'     => [ 25, 1, 3 ],
				'gems'     => [ 30, 1, 8 ],
				'jewelry'  => [ 20, 1, 4 ],
				'special'  => [ 10, 1, 1, [ 'sword/armor/misc weapon' ] ],
			),
			'C' => array(
				'copper'   => [ 20, 1, 12 ],
				'silver'   => [ 30, 1,  6 ],
				'electrum' => [ 10, 1,  4 ],
				'gems'     => [ 25, 1,  6 ],
				'jewelry'  => [ 20, 1,  3 ],
				'special'  => [ 10, 2,  1, [ 'any', 'any' ] ],
			),
			'D' => array(
				'copper'   => [ 10, 1,  8 ],
				'silver'   => [ 15, 1,  3 ],
				'electrum' => [ 15, 1,  8 ],
				'gold'     => [ 50, 1,  6 ],
				'gems'     => [ 30, 1, 10 ],
				'jewelry'  => [ 25, 1,  6 ],
				'special'  => [ 15, 3,  1, [ 'any', 'any', 'potion' ] ],
			),
			'E' => array(
				'copper'   => [  5, 1, 10 ],
				'silver'   => [ 25, 1, 12 ],
				'electrum' => [ 25, 1,  6 ],
				'gold'     => [ 25, 1,  8 ],
				'gems'     => [ 15, 1, 12 ],
				'jewelry'  => [ 10, 1,  8 ],
				'special'  => [ 25, 4,  1, [ 'any', 'any', 'any', 'scroll' ] ],
			),
			'F' => array(
				'silver'   => [ 10, 1, 20 ],
				'electrum' => [ 15, 1, 12 ],
				'gold'     => [ 40, 1, 10 ],
				'platinum' => [ 35, 1,  8 ],
				'gems'     => [ 20, 3, 10 ],
				'jewelry'  => [ 10, 1, 10 ],
				'special'  => [ 30, 5,  1, [ 'no swords/misc weapons', 'no swords/misc weapons','no swords/misc weapons', 'potion', 'scroll' ] ],
			),
			'G' => array(
				'gold'     => [ 15, 10,  4 ],
				'platinum' => [ 50,  1, 20 ],
				'gems'     => [ 30,  5,  4 ],
				'jewelry'  => [ 25,  1, 10 ],
				'special'  => [ 35,  5, 1, [ 'any', 'any', 'any', 'any', 'scroll' ] ],
			),
			'H' => array(
				'copper'   => [ 25,  5,   6 ],
				'silver'   => [ 40,  1, 100 ],
				'electrum' => [ 40, 10,   4 ],
				'gold'     => [ 55, 10,   6 ],
				'platinum' => [ 25,  5,  10 ],
				'gems'     => [ 50,  1, 100 ],
				'jewelry'  => [ 50, 10,   4 ],
				'special'  => [ 15,  6,   1, [ 'any', 'any', 'any', 'any', 'potion', 'scroll' ] ],
			),
			'I' => array(
				'platinum' => [ 30, 3,  6 ],
				'gems'     => [ 55, 2, 10 ],
				'jewelry'  => [ 50, 1, 12 ],
				'special'  => [ 15, 1,  1, [ 'any' ] ],
			),
			'J' => array(
				'copper'   => [ 100, 3, 8 ],
			),
			'K' => array(
				'silver'   => [ 100, 3, 6 ],
			),
			'L' => array(
				'electrum' => [ 100, 2, 6 ],
			),
			'M' => array(
				'gold'     => [ 100, 2, 4 ],
			),
			'N' => array(
				'platinum' => [ 100, 1, 6 ],
			),
			'O' => array(
				'copper'   => [ 25, 1, 4 ],
				'silver'   => [ 20, 1, 3 ],
			),
			'P' => array(
				'silver'   => [ 30, 1, 6 ],
				'electrum' => [ 25, 1, 2 ],
			),
			'Q' => array(
				'gems'     => [ 50, 1, 4 ],
			),
			'R' => array(
				'gold'     => [ 40,  1,  4 ],
				'platinum' => [ 50, 10,  6 ],
				'gems'     => [ 55,  4,  8 ],
				'jewelry'  => [ 45,  1, 12 ],
			),
			'S' => array(
				'special'  => [ 40, 2, 4, [ 'potions' ] ],
			),
			'T' => array(
				'special'  => [ 50, 1, 4, [ 'scrolls' ] ],
			),
			'U' => array(
				'gems'     => [ 90, 10, 8 ],
				'jewelry'  => [ 80,  5, 6 ],
				'special'  => [ 70,  6, 1, [ 'ring', 'rod/staff/wand', 'misc magic', 'armor/shield', 'sword', 'misc weapons' ] ],
			),
			'V' => array(
				'special'  => [ 70, 12, 1, [ 'ringX2', 'rod/staff/wandX2', 'misc magicX2', 'armor/shieldX2', 'swordX2', 'misc weaponsX2' ] ],
			),
			'W' => array(
				'gold'     => [ 60,  5, 6 ],
				'platinum' => [ 15,  1, 8 ],
				'gems'     => [ 60, 10, 8 ],
				'jewelry'  => [ 50,  5, 8 ],
				'special'  => [ 55,  1, 1, [ 'map' ] ],
			),
			'X' => array(
				'special'  => [ 55, 2, 1, [ 'misc magic', 'potion' ] ],
			),
			'Y' => array(
				'gold'     => [ 70, 2, 6 ],
			),
			'Z' => array(
				'copper'   => [ 20,  1, 3 ],
				'silver'   => [ 25,  1, 4 ],
				'electrum' => [ 25,  1, 4 ],
				'gold'     => [ 30,  1, 4 ],
				'platinum' => [ 30,  1, 6 ],
				'gems'     => [ 55, 10, 6 ],
				'jewelry'  => [ 50,  5, 6 ],
				'special'  => [ 30,  3, 1, [ 'magic', 'magic', 'magic' ] ],
			),
		);
	}




}
