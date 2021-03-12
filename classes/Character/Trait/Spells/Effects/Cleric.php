<?php

trait DND_Character_Trait_Spells_Effects_Cleric {


	public function cleric_first_command( $spell, $target, $unused ) {
		$int = DND_Enum_Intelligence;
		if ( ( $int->pos( $target->intelligence ) > 12 ) || ( $target->hit_dice > 5 ) ) {
			$roll = $target->saving_throw( $spell->get_against(), $spell->get_effect() );
			return sprintf( '%s gets a saving throw vs %s of %u', $target->get_key(), $spell->get_against(), $roll );
		}
		return $spell->get_caster() . ' cast ' . $spell->get_name() . ' on ' . $spell->get_target();
	}

	public function cleric_first_cure_light_wounds( $spell, $target, $heal ) {
#		$target->assign_damage( 0 - $heal );
		$target->current_hp = max( $target->hit_points, $target->current_hp + $heal );
		$spell->data = 'completed';
		return sprintf( '%s has been healed of %d hit points of damage and is now at %d', $target->get_key(), $heal, $target->hit_points );
	}

	public function cure_wounds_check_target( $healer, $wounded, $combat, $spell ) {
		if ( $wounded->current_hp < $wounded->hit_points ) return true;
		$combat->messages[] = $wounded->get_key() . " is not wounded!";
		return false;
	}

	public function cure_wounds_notice( $combat, $spell ) {
		if ( $combat->segment === $spell->get_when() ) {
			if ( $spell->data && ( $spell->data === 'completed' ) ) return;
			$combat->messages[] = $spell->get_name() . ' requires the number of hit points healed.';
		}
	}


}
