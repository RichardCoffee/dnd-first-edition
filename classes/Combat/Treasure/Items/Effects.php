<?php

trait DND_Combat_Treasure_Items_Effects {


	/**  Effects functions  **/

	public function process_effect() {
		global $wp_current_filter;
		$args   = func_get_args();
		$filter = $this->locate_filter( $wp_current_filter[ array_key_last( $wp_current_filter ) ] );
		list ( $name, $func, $delta, $priority, $argn ) = $filter;
		$args[] = $delta;
		return call_user_func_array( [ $this, $func ], $args );
	}

	protected function track_quantity( $damage, $origin, $delta ) {
		if ( $origin->get_key() === $this->owner ) {
			$this->quan--;
			if ( $this->quan < 1 ) {
				$this->turn_off();
				$this->owner = 'delete_me';
			}
		}
		return $damage;
	}

	protected function vulnerable_to_hit( $number, $origin, $target, $delta ) {
		if ( $origin->get_key() === $this->owner ) {
			if ( $this->check_vulnerability( $target, $this->effect ) ) {
				$number -= apply_filters( 'dnd1e_vulnerable_hit', $delta, $origin, $target );
			}
		}
		return $number;
	}

	protected function vulnerable_to_damage( $damage, $origin, $target, $type, $delta ) {
		if ( $origin->get_key() === $this->owner ) {
			if ( $this->check_vulnerability( $target, $this->effect ) ) {
				$damage += apply_filters( 'dnd1e_vulnerable_dam', $delta, $origin, $target );
			}
		}
		return $damage;
	}

	protected function check_vulnerability( $target, $effect ) {
		if ( $target instanceOf DND_Monster_Monster ) {
			return in_array( $this->effect, $target->vulnerable );
		} else {
			switch( $this->effect ) {
				case 'magic':
					if ( ! empty( $target->spells ) ) return true;
					$multi = explode( '/', $target->get_class() );
					if ( ! empty( array_intersect( $multi, [ 'Cleric', 'Druid', 'Illusionist', 'Magic User' ] ) ) ) return true;
					break;
				default:
					$combat = dnd1e()->combat;
					$combat->messages[] = "No current check for character '{$this->effect}' vulnerability.";
			}
		}
		return false;
	}


}
