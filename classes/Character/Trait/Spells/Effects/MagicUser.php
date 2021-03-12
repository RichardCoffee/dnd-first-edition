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

	public function magicuser_first_armor_post( $spell, $target, $data ) {
		$target->determine_armor_class();
	}

	public function magicuser_armor_status( $spell, $combat, $display = false ) {
		$filter = $spell->locate_filter('dissipation_hit_points');
		list( $name, $points, $priority, $argn ) = $filter;
		if ( $display ) {
			echo "\t Points: $points\n";
		}
		return $points;
	}


	/**  First level Magic Missile spell  **/

	public function magicuser_first_magic_missile( $spell, $target = null, $data = array() ) {
		if ( $data ) {
			$info = explode( '^', $data );
			if ( ( count( $info ) > 0 ) && ( count( $info ) % 2 === 0 ) ) {
				$combat = dnd1e()->combat(); //  since it doesn't get passed...
				do {
					$target = array_shift( $info );
					$damage = array_shift( $info );
					$combat->resolve_damage( array( 'target' => $target, 'damage' => $damage ) );
				} while ( count( $info ) > 0 );
			}
		}
		return false;
	}


	/**  Second level Mirror Image spell  **/

	public function magicuser_second_mirror_image( $spell, $target, $num ) {
		if ( ( $spell->get_name() === 'Mirror Image' ) && empty( $spell->data ) ) {
			$spell->data = intval( $num );
			return sprintf( '%d images were generated', $spell->get_data() );
		}
		return $spell->get_caster() . ' cast ' . $spell->get_name();
	}

	public function magicuser_mirror_image_number( $string, $object, $spell ) {
		if ( $this === $object ) {
			if ( $spell->data > 0 ) {
				$string .= $spell->data;
			}
		}
		return $string;
	}

	public function magicuser_mirror_image_target( $damage, $target, $type, $spell ) {
		if ( $this === $target ) {
			if ( $spell->data > 0 ) {
				$roll = mt_rand( 1, $spell->data + 1 );
				if ( $roll > 1 ) {
					$spell->data--;
					if ( $spell->data < 1 ) {
						$spell->remove_filter( 'dnd1e_damage_to_target' );
						$spell->remove_filter( 'dnd1e_object_status' );
					}
					$combat = dnd1e()->combat();
					$combat->messages[] = "A " . $spell->get_caster() . " mirror image was destroyed.  {$spell->data} image(s) left";
					return 0;
				}
			}
		}
		return $damage;
	}

	public function magicuser_mirror_image_status( $spell, $combat, $display = false ) {
		if ( $display ) {
			echo "\t Images: {$spell->data}\n";
		}
		return $spell->data;
	}


	/**  Third level Sepia Snake Sigil  **/

	public function magicuser_third_sepia_snake_sigil( $spell, $target, $data ) {
		$combat = dnd1e()->combat();
		if ( $combat ) {
			$caster = $combat->get_object( $spell->caster );
			if ( is_object( $caster ) ) {
				$args = array(
					'attacks'      => array( 'Bite' => [ 0, 0, 0 ] ),
					'hit_dice'     => $caster->get_level( 'magic' ),
					'intelligence' => 'Non-',
					'name'         => 'Sepia Snake Sigil',
					'race'         => 'Third level spell',
					'reference'    => 'Unearthed Arcana, page 56',
					'segment'      => $combat->segment,
				);
				$snake = new DND_Monster_Template( $args );
				$snake->extra = array( 'spell' => $spell, 'target' => $target );
				$combat->add_to_party( $snake );
			}
		}
	}

	public function magicuser_sepia_snake_sigil_effect( $damage, $origin, $target, $type ) {
		if ( $origin instanceOf DND_Monster_Template ) {
			if ( $type === 'hit' ) {
			}
		}
	}


	/**  Fourth level Heat Metal spell  **/

	public function magicuser_fourth_heat_metal( $spell, $object, $data ) {
		$spell->data = explode( ';', $data );
		return $spell->get_caster() . ' cast ' . $spell->get_name();
	}

	public function magicuser_heat_metal_effect( $combat, $object, $spell ) {
		$current = $combat->segment - $spell->when;
		if ( ( $current % 10 ) === 0 ) {
			foreach( $spell->data as $target ) {
				$possible = $combat->get_object( $target );
				if ( ! is_object( $possible ) )    continue;
				if ( ! ( $object === $possible ) ) continue;
				if ( ( $current > 9 ) && ( $current < 59 ) ) {
					$combat->resolve_damage( array( 'origin' => $this, 'target' => $object, 'damage' => mt_rand( 1, 6 ), 'type' => 'fire' ) );
					if ( ( $current > 19 ) && ( $current < 49 ) ) {
						$combat->resolve_damage( array( 'origin' => $this, 'target' => $object, 'damage' => mt_rand( 1, 6 ), 'type' => 'fire' ) );
					}
				}
			}
		}
	}

	public function magicuser_heat_metal_status( $spell, $combat, $display = false ) {
		$status = 'Mild Heat - no damage';
		$damage = array( 0, 0, 'fire' );
		if ( ( $combat->segment - $spell->when > 9 ) && ( $combat->segment - $spell->when < 59 ) ) {
			$status = 'Hot - doing 1d6 damage';
			$damage = array( 1, 6, 'fire' );
			if ( ( $combat->segment - $spell->when > 19 ) && ( $combat->segment - $spell->when < 49 ) ) {
				$status = 'Severe Heat - doing 2d6 damage';
				$damage = array( 2, 6, 'fire' );
			}
		}
		if ( $display ) {
			echo "\t Status: $status\n";
		}
		return $damage;
	}


}
