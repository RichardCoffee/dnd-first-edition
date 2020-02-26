<?php

trait DND_Character_Trait_Dual {


	protected $weap_twins = array();
	private   $weap_flag  = 'all';


	public function set_dual_flag( $new ) {
		if ( in_array( $new, [ 'all', 'primary', 'secondary' ], true ) ) {
			$this->weap_flag = $new;
		}
	}

	public function get_dual_flag() {
		return $this->weap_flag;
	}

	public function set_dual_weapons( $one, $two ) {
		if ( stripos( $two, 'off-hand' ) ) {
			if ( array_key_exists( $one, $this->weapons ) && array_key_exists( $two, $this->weapons ) ) {
				$this->weap_dual = [ $one, $two ];
				return true;
			}
		}
		return false;
	}

	public function set_primary_weapon() {
		$this->set_dual_weapon_slot('primary');
	}

	public function set_dual_weapon() {
		$this->set_dual_weapon_slot('secondary');
	}

	protected function set_dual_weapon_slot( $idx ) {
		if ( array_key_exists( $idx, $this->weap_twins ) ) {
			$key = ( array_key_exists( 'key', $this->weapon ) ) ? $this->weapon['key'] : false;
			$this->weapon = $this->weap_twins[ $idx ];
			if ( $key ) dnd1e()->combat->deactivate_weapon( $key, $this );
			if ( array_key_exists( 'key', $this->weapon ) ) dnd1e()->combat->activate_gear_item( $this->weapon['key'] );
		}
	}

	protected function set_current_weapon_dual( $weapon ) {
		if ( in_array( $weapon['current'], $this->weap_dual ) ) {
			if ( stripos( $weapon['current'], 'off-hand' ) ) {
/*				if ( ! array_key_exists( 'primary', $this->weap_twins ) ) {
					$this->weap_twins['primary'] = $this->get_merged_weapon_info( $this->weap_dual[0] );
				} //*/
#				$prime = $this->get_weapon_attacks_per_round( $this->get_weapon_info( $this->weap_dual[0] ) );
				$prime = $this->weap_twins['primary']['attacks'];
				if ( $prime[1] === $weapon['attacks'][1] ) {
					$weapon['attacks'][0] += $prime[0];
				} else {
					$weapon['attacks'][0] += ( $prime[1] === 2 ) ? ( $weapon['attacks'][0] + $prime[0] ) : ( $prime[0] * 2 ) ;
					$weapon['attacks'][1] += ( $prime[1] === 2 ) ? 1 : 0;
				}
				$this->weap_twins['secondary'] = $weapon;
				return $this->weap_twins['primary'];
			} else {
				$this->weap_twins['primary'] = $weapon;
			}
		} else {
			$this->weap_twins = array();
		}
		return $weapon;
	}

	public function get_to_hit_number( $target, $range = -1 ) {
		if ( $this->weap_flag === 'secondary' ) {
			$to_hit  = $this->weapon_to_hit_number( $this->weap_twins['secondary'], $target, $range );
			$to_hit -= apply_filters( 'dnd1e_secondary_to_hit_opponent', 0, $this );
		} else {
			$to_hit = parent::get_to_hit_number( $target, $range );
		}
		return $to_hit;
	}

	public function get_weapon_damage_bonus( $target = null, $range = -1 ) {
		if ( $this->weap_flag === 'secondary' ) {
			$bonus = $this->weapon_damage_bonus( $this->weap_twins['secondary'], $target, $range );
			$bonus = apply_filters( 'dnd1e_seconday_damage_bonus', $bonus, $this, $target );
		} else {
			$bonus = parent::get_weapon_damage_bonus( $target, $range );
		}
		return $bonus;
	}

	public function get_dual_attack_sequence( $rounds, $which = 'primary' ) {
		$this->weap_flag = $which;
		$seq = $this->get_attack_sequence( $rounds );
		return $seq;
	}

	public function get_attack_sequence( $rounds, $weapon = array() ) {
		if ( count( $this->weap_twins ) < 2 ) return parent::get_attack_sequence( $rounds, $this->weapon );
		$init = parent::get_attack_sequence( $rounds, $this->weap_twins['secondary'] );
		if ( $this->weap_flag === 'all' ) return $init;
		$primary   = array();
		$secondary = array();
		$state     = 'p';
		$count     = 0;
		$cycle     = $this->weap_twins['secondary']['attacks'][0];
		foreach( $init as $seg ) {
			if ( $state === 'p' ) {
				$primary[] = $seg;
				$state = 's';
			} else if ( $state === 's' ) {
				$secondary[] = $seg;
				$state = 'p';
			}
			$count++;
			if ( $count === $cycle ) {
				$count = 0;
				$state = 'p';
			}
		}
		if ( $this->weap_flag === 'secondary' ) return $secondary;
		if ( $this->weap_flag === 'primary' )   return $primary;
		return $init;
	}


}
