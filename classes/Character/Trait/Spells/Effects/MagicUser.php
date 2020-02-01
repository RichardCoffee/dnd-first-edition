<?php

trait DND_Character_Trait_Spells_Effects_MagicUser {


	public function magicuser_first_armor( $spell, $target ) {
		# TODO: may need to test for other condition - see spell description: UA 51
		if ( $target->armor_type === 10 ) {
			$spell->add_filter( [ 'armor_type_replacement', 8, 10, 2 ] );
		} else {
			$spell->add_filter( [ 'armor_class_adjustments', 1, 10, 2 ] );
		}
	}

	public function armor_status( $effect ) {
		$filter = $effect->locate_filter('dissipation_hit_points');
		echo "\t Points: {$filter[1]}\n";
	}

	public function magicuser_second_mirror_image( $spell, $num ) {
		if ( ( $spell->get_name() === 'Mirror Image' ) && empty( $this->effects ) ) {
			$spell->effects['images'] = intval( $num );
		}
	}

	public function mirror_image_number( $string, $object, $spell ) {
		if ( $this === $object ) {
			if ( $spell->effects['images'] > 0 ) {
				$string .= $spell->effects['images'];
			}
		}
		return $string;
	}

	public function mirror_image_target( $damage, $target, $type, $spell ) {
		if ( $this === $target ) {
			if ( $spell->effects['images'] > 0 ) {
				$roll = mt_rand( 1, $spell->effects['images'] + 1 );
echo "mirror image target: $roll\n";
				if ( $roll > 1 ) {
					$spell->effects['images']--;
					if ( $spell->effects['images'] < 1 ) {
						$spell->remove_filter( 'dnd1e_damage_to_target' );
						$spell->remove_filter( 'dnd1e_object_status' );
					}
					return 0;
				}
			}
		}
		return $damage;
	}

	public function mirror_image_status( $effect ) {
		echo "\t Images: {$effect->effects['images']}\n";
	}


}
