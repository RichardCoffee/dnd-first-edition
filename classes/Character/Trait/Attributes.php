<?php

trait DND_Character_Trait_Attributes {


	protected function parse_strength_percentage( $str ) {
		$perc = -1;
		if ( is_string( $str ) ) {
			$arr = explode( '/', $str );
			if ( isset( $arr[1] ) ) {
				$perc = (int)$arr[1];
				if ( $arr[1] === '00' ) {
					$perc = 100;
				}
			}
		}
		return $perc;
	}

	protected function get_strength_to_hit_bonus( $str, $perc = -1 ) {
		$bonus = 0;
		switch( $str ) {
			case 3:
				$bonus = -3;
				break;
			case 4:
			case 5:
				$bonus = -2;
				break;
			case 6:
			case 7:
				$bonus = -1;
				break;
			case 17:
			case 18:
				$bonus = 1;
				if ( $perc === 100 ) {
					$bonus = 3;
				} else if ( $perc > 50 ) {
					$bonus = 2;
				}
				break;
			case 19:
			case 20:
				$bonus = 3;
				break;
			case 21:
			case 22:
				$bonus = 4;
				break;
			case 23:
				$bonus = 5;
				break;
			case 24:
				$bonus = 6;
				break;
			case 25:
				$bonus = 7;
				break;
			default:
		}
		return $bonus;
	}

	protected function get_strength_damage_bonus( $str, $perc = -1 ) {
		$bonus = 0;
		switch( $str ) {
			case 3:
			case 4:
			case 5:
				$bonus = -1;
				break;
			case 16:
			case 17:
				$bonus = 1;
				break;
			case 18:
				$bonus = 2;
				if ( $perc === 100 ) {
					$bonus = 6;
				} else if ( $perc > 90 ) {
					$bonus = 5;
				} else if ( $perc > 75 ) {
					$bonus = 4;
				} else if ( $perc > 0 ) {
					$bonus = 3;
				}
				break;
			case 19:
				$bonus = 7;
				break;
			case 20:
				$bonus = 8;
				break;
			case 21:
				$bonus = 9;
				break;
			case 22:
				$bonus = 10;
				break;
			case 23:
				$bonus = 11;
				break;
			case 24:
				$bonus = 12;
				break;
			case 25:
				$bonus = 14;
				break;
			default:
		}
		return $bonus;
	}

	protected function get_missile_to_hit_adjustment( $dex ) {
		$bonus = 0;
		switch( $dex ) {
			case 3:
				$bonus = -3;
				break;
			case 4:
				$bonus = -2;
				break;
			case 5:
				$bonus = -1;
				break;
			case 16:
				$bonus = 1;
				break;
			case 17:
				$bonus = 2;
				break;
			case 18:
			case 19:
			case 20:
				$bonus = 3;
				break;
			case 21:
			case 22:
			case 23:
				$bonus = 4;
				break;
			case 24:
			case 25:
				$bonus = 5;
				break;
			default:
		}
		return $bonus;
	}

	protected function get_armor_class_dexterity_adjustment( $dex ) {
		$bonus = 0;
		switch( $dex ) {
			case 3:
				$bonus = 4;
				break;
			case 4:
				$bonus = 3;
				break;
			case 5:
				$bonus = 2;
				break;
			case 6:
				$bonus = 1;
				break;
			case 15:
				$bonus = -1;
				break;
			case 16:
				$bonus = -2;
				break;
			case 17:
				$bonus = -3;
				break;
			case 18:
			case 19:
			case 20:
				$bonus = -4;
				break;
			case 21:
			case 22:
			case 23:
				$bonus = -5;
				break;
			case 24:
			case 25:
				$bonus = -6;
				break;
			default:
		}
		return $bonus;
	}


}
