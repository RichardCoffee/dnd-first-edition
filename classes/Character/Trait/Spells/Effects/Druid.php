<?php

trait DND_Character_Trait_Spells_Effects_Druid {


	/**  First level Faerie Fire spell  **/

	public function druid_first_faerie_fire( $spell, $target, $data ) {
		$spell->data = explode( ';', $data );
		return $spell->get_caster() . ' cast ' . $spell->get_name();
	}

	public function faerie_fire_notice( $combat, $spell ) {
		if ( $combat->segment === $spell->get_when() ) {
			$combat->messages[] = 'Faerie Fire requires targeting data.';
		}
	}

	public function faerie_fire_ac_adj( $adj, $target, $spell ) {
		if ( in_array( $target->get_key(), $spell->data ) ) {
			$adj -= 2;
		}
		return $adj;
	}


	/**  Second level Heat Metal spell  **/

	public function druid_second_heat_metal( $spell, $unused, $data ) {
		$spell->data = explode( ';', $data );
		return $spell->get_caster() . ' cast ' . $spell->get_name();
	}

	public function druid_heat_metal_effect( $combat, $object, $spell ) {
		if ( ( ( $combat->segment - $spell->when ) % 10 ) === 0 ) {
			foreach( $spell->data as $target ) {
				$possible = $combat->get_object( $target );
				if ( ! is_object( $possible ) )    continue;
				if ( ! ( $object === $possible ) ) continue;
				if ( ( $combat->segment - $spell->when > 9 ) && ( $combat->segment - $spell->when < 59 ) ) {
					$damage = mt_rand( 1, 4 );
					$combat->object_damage_with_origin( $this, $object, $damage, 'fire' );
					if ( ( $combat->segment - $spell->when > 19 ) && ( $combat->segment - $spell->when < 49 ) ) {
						$extra = mt_rand( 1, 4 );
						$combat->object_damage_with_origin( $this, $object, $extra, 'fire' );
						$damage += $extra;
					}
					$combat->messages[] = $object->get_key() . " took $damage points of heat damage";
				}
			}
		}
	}

	public function druid_heat_metal_status( $spell, $combat ) {
		$status = 'Mild Heat - no damage';
		if ( ( $combat->segment - $spell->when > 9 ) && ( $combat->segment - $spell->when < 59 ) ) {
			$status = 'Hot - doing 1d4 damage';
			if ( ( $combat->segment - $spell->when > 19 ) && ( $combat->segment - $spell->when < 49 ) ) {
				$status = 'Severe Heat - doing 2d4 damage';
			}
		}
		echo "\t Status: $status\n";
	}


	/**  Third level Protection from Fire spell  **/

	public function druid_third_protection_from_fire( $spell, $object, $data ) {
		if ( $spell->caster === $spell->target ) {
			$spell->remove_filter( 'dnd1e_object_all_saving_throws' );
			$spell->remove_filter( 'dnd1e_damage_to_target' );
		} else {
			$spell->remove_filter( 'dnd1e_absorption_hp' );
		}
		return $spell->get_caster() . ' cast ' . $spell->get_name() . ' on ' . $spell->get_target();
	}

	public function protection_from_fire_saving_throws( $num, $object, $type, $spell ) {
		if ( ( $object === $this ) && ( $type === 'fire' ) ) {
			$num -= 4;
		}
		return $num;
	}

	public function protection_from_fire_damage( $damage, $target, $type, $spell ) {
		if ( ( $target === $this ) && ( $type === 'fire' ) ) {
			$damage = intval( round( $damage / 2 ) );
		}
		return $damage;
	}


}
