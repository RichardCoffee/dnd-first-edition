<?php

trait DND_Character_Trait_Spells_Effects_MagicUser {


	/**  First level Armor spell  **/

	public function magicuser_first_armor( $spell, $target, $data ) {
		if ( $target->armor_type === 10 ) {
			$spell->add_filter( [ 'dnd1e_armor_type',  8, 10, 2 ] );
		} else {
			# TODO: may need to test for other conditions - see spell description: UA 51-52
			if ( ( ( $target instanceOf DND_Character_Character || $target instanceOf DND_Monster_Humanoid ) && ( $target->armor['bonus'] === 0 ) ) || $target instanceOf DND_Monster_Monster ) {
				$spell->add_filter( [ 'dnd1e_armor_class_adj', 1, 10, 2 ] );
			}
		}
		return $spell->get_caster() . ' cast ' . $spell->get_name() . ' on ' . $spell->get_target();
	}

	public function armor_status( $spell, $combat ) {
		$filter = $spell->locate_filter('dissipation_hit_points');
		list( $name, $points, $priority, $argn ) = $filter;
		echo "\t Points: $points\n";
	}


	/**  Second level Mirror Image spell  **/

	public function magicuser_second_mirror_image( $spell, $target, $num ) {
		if ( ( $spell->get_name() === 'Mirror Image' ) && empty( $spell->data ) ) {
			$spell->data = intval( $num );
			return sprintf( '%d images were generated', $spell->get_data() );
		}
		return $spell->get_caster() . ' cast ' . $spell->get_name();
	}

	public function mirror_image_number( $string, $object, $spell ) {
		if ( $this === $object ) {
			if ( $spell->data > 0 ) {
				$string .= $spell->data;
			}
		}
		return $string;
	}

	public function mirror_image_target( $damage, $target, $type, $spell ) {
		if ( $this === $target ) {
			if ( $spell->data > 0 ) {
				$roll = mt_rand( 1, $spell->data + 1 );
				if ( $roll > 1 ) {
					$spell->data--;
					if ( $spell->data < 1 ) {
						$spell->remove_filter( 'dnd1e_damage_to_target' );
						$spell->remove_filter( 'dnd1e_object_status' );
					}
					return 0;
				}
			}
		}
		return $damage;
	}

	public function mirror_image_status( $spell, $combat ) {
		echo "\t Images: {$spell->data}\n";
	}


	/**  Fourth level Heat Metal spell  **/

	public function magicuser_fourth_heat_metal( $spell, $object, $data ) {
		$spell->data = explode( ';', $data );
		return $spell->get_caster() . ' cast ' . $spell->get_name();
	}

	public function magicuser_heat_metal_effect( $combat, $object, $spell ) {
		if ( ( ( $combat->segment - $spell->when ) % 10 ) === 0 ) {
			foreach( $spell->data as $target ) {
				$possible = $combat->get_object( $target );
				if ( ! is_object( $possible ) )    continue;
				if ( ! ( $object === $possible ) ) continue;
				if ( ( $combat->segment - $spell->when > 9 ) && ( $combat->segment - $spell->when < 59 ) ) {
					$combat->resolve_damage( array( 'origin' => $this, 'target' => $object, 'damage' => mt_rand( 1, 6 ), 'type' => 'fire' ) );
					if ( ( $combat->segment - $spell->when > 19 ) && ( $combat->segment - $spell->when < 49 ) ) {
						$combat->resolve_damage( array( 'origin' => $this, 'target' => $object, 'damage' => mt_rand( 1, 6 ), 'type' => 'fire' ) );
					}
				}
			}
		}
	}

	public function magicuser_heat_metal_status( $spell, $combat ) {
		$status = 'Mild Heat - no damage';
		if ( ( $combat->segment - $spell->when > 9 ) && ( $combat->segment - $spell->when < 59 ) ) {
			$status = 'Hot - doing 1d6 damage';
			if ( ( $combat->segment - $spell->when > 19 ) && ( $combat->segment - $spell->when < 49 ) ) {
				$status = 'Severe Heat - doing 2d6 damage';
			}
		}
		echo "\t Status: $status\n";
	}


}
