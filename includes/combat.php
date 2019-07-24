<?php

function dnd1e_load_combat_state( $chars ) {
	dnd1e_load_character_combat_state( $chars );
}

function dnd1e_load_character_combat_state( $chars ) {
	$combat = get_transient( 'dnd1e_combat' );
	if ( $combat ) {
		foreach( $chars as $name => $object ) {
			if ( isset( $combat[ $name ] ) ) {
				$object->segment = $combat[ $name ]['segment'];
				$object->set_current_weapon( $combat[ $name ]['weapon'] );
				$object->current_hp = $combat[ $name ]['current_hp'];
			}
		}
	}
}

function dnd1e_save_combat_state( $chars ) {
	$combat = dnd1e_save_character_combat_state( $chars );
	set_transient( 'dnd1e_combat', $combat );
}

function dnd1e_save_character_combat_state( $chars ) {
	$combat = array();
	foreach( $chars as $name => $object ) {
		$combat[ $name ] = array(
			'segment'    => $object->segment,
			'weapon'     => $object->weapon['current'],
			'current_hp' => $object->current_hp,
		);
	}
	return $combat;
}

function dnd1e_save_character_transients( $characters = array() ) {
	foreach( $characters as $name => $obj ) {
		$trans = 'dnd1e_' . get_class( $obj ) . '_' . $name;
		dnd1e_save_character_as_transient( $trans, $obj );
	}
}

function dnd1e_save_character_as_transient( $transient, DND_Character_Character $char ) {
	set_transient( $transient, $char );
}

function dnd1e_change_weapons( $char, $weapon, $segment ) {
	$rounds   = intval( $segment / 10 ) + 3;
	$sequence = dnd1e_get_attack_sequence( $rounds, $char->segment, $char->weapon['attacks'] );
	if ( $segment === 1 ) {
		$char->set_current_weapon( $weapon );
	} else if ( in_array( $segment, $sequence ) ) {
		if ( $char->set_current_weapon( $weapon ) ) {
			$char->segment = $segment;
		}
	} else {
		foreach( $sequence as $seggie ) {
			if ( $seggie > $segment ) {
				if ( $char->set_current_weapon( $weapon ) ) {
					$char->segment = $seggie;
				}
				break;
			}
		}
	}
}

function dnd1e_get_attack_sequence( $rounds, $cur, $attacks = array( 1, 1 ) ) {
	$seq = array();
	$seg = 10 / ( $attacks[0] / $attacks[1] );
	do {
		$seq[] = intval ( round( $cur ) );
		$cur  += $seg;
	} while( $cur < ( ( $rounds * 10 ) + 1 ) );
	return $seq;
}

function dnd1e_get_movement_sequence( $move = 12 ) {
	$segs = array( 1, 2, 3, 4, 5, 5, 6, 7, 8, 9, 10, 10 );
	switch( "$move" ) {
		case '1':
			$segs = array( 10 );
			break;
		case '2':
			$segs = array( 5, 10 );
			break;
		case '3':
			$segs = array( 3, 6, 9 );
			break;
		case '4':
			$segs = array( 2, 4, 6, 8 );
			break;
		case '5':
			$segs = array( 2, 4, 6, 8, 10 );
			break;
		case '5a':
			$segs = array( 1, 3, 5, 7, 9 );
			break;
		case '6':
			$segs = array( 2, 4, 5, 6, 8, 10 );
			break;
		case '6a':
			$segs = array( 1, 3, 5, 7, 9, 10 );
			break;
		case '7':
			$segs = array( 1, 2, 4, 6, 7, 8, 10 );
			break;
		case '8':
			$segs = array( 1, 2, 4, 5, 6, 8, 9, 10 );
			break;
		case '9':
			$segs = array( 1, 2, 3, 4, 6, 7, 8, 9, 10 );
			break;
		case '9a':
			$segs = array( 1, 2, 3, 4, 5, 6, 7, 8, 9 );
			break;
		case '10':
			$segs = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
			break;
		case '11':
			$segs = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10 );
			break;
		case '15':
			$segs = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10 );
			break;
		case '18':
			$segs = array( 1, 1, 2, 2, 3, 4, 4, 5, 5, 6, 6, 7, 8, 8, 9, 9, 10, 10 );
			break;
		case '24':
			$segs = array( 1, 1, 2, 2, 2, 3, 3, 4, 4, 4, 5, 5, 6, 6, 6, 7, 7, 8, 8, 8, 9, 9, 10, 10 );
			break;
		case '30':
			$segs = array( 1, 1, 1, 2, 2, 2, 3, 3, 3, 4, 4, 4, 5, 5, 5, 6, 6, 6, 7, 7, 7, 8, 8, 8, 9, 9, 9, 10, 10, 10 );
			break;
		case '33':
			$segs = array( 1, 1, 1, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 5, 5, 5, 6, 6, 6, 6, 7, 7, 7, 8, 8, 8, 9, 9, 9, 9, 10, 10, 10 );
			break;
		case '39':
			$segs = array( 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 6, 6, 6, 6, 7, 7, 7, 7, 8, 8, 8, 8, 9, 9, 9, 9, 10, 10, 10, 10 );
			break;
		case '12':
		default:
			$segs = array( 1, 2, 3, 4, 5, 5, 6, 7, 8, 9, 10, 10 );
	}
	return $segs;
}

function dnd1e_update_movement_transient( $segment, $obj ) {
	$moves = get_transient( 'dnd1e_movement' );
	if ( ! $moves ) $moves = array();
	$sequence = dnd1e_get_movement_sequence( $obj->movement );
	$seg = $segment % 10;
	$seg = ( $seg === 0 ) ? 10 : $seg;
	$cnt = count( array_keys( $sequence, $seg ) );
	if ( $cnt ) {
		$name = $obj->get_name();
		$moves[] = $name . ( ( $cnt > 1 ) ? sprintf( ' x %u', $cnt ) : '' );
		set_transient( 'dnd1e_movement', $moves );
	}
}

function dnd1e_get_character_attackers( $chars, $rounds, $segment ) {
	$rank = array();
	$cast = get_transient('dnd1e_cast');
	foreach( $chars as $name => $body ) {
		$sequence = dnd1e_get_attack_sequence( $rounds, $body->segment, $body->weapon['attacks'] );
		if ( in_array( $segment, $sequence ) ) {
			$rank[] = $body;
		} else if ( $cast && ( isset( $cast[ $name ] ) ) ) {
			if ( $segment > $cast[ $name ]['when'] ) {
				unset( $cast[ $name ] );
				set_transient( 'dnd1e_cast', $cast );
			} else {
				$rank[] = $body;
			}
		}
	}
	return $rank;
}

function dnd1e_get_monster_attackers( $monster, $att_seq, $segment ) {
	$rank = array();
/*	if ( $monster instanceOf DND_Monster_Humanoid_Humaniod ) {
		foreach( $monster->attacks as $type => $damage ) {
			if ( in_array( $segment, $att_seq[ $type ] ) ) {
				$rank_obj = new StdClass;
				$rank_obj->name = $monster->name . " ($type)";
				$rank_obj->stats = array( 'dex' => intval( round( ( ( 10 - $monster->armor_class ) * 1.5 ) + 3 ) ) );
				$rank_obj->initiative = array( 'actual' => $monster->initiative );
				$rank[] = $rank_obj;
			}
		}
	} else {*/
		foreach( $att_seq as $type => $attack ) {
			if ( in_array( $segment, $attack ) ) {
				$rank_obj = new StdClass;
				$rank_obj->name = $monster->name . " ($type)";
				$rank_obj->stats = array( 'dex' => round( ( ( 10 - $monster->armor_class ) * 1.5 ) + 3 ) );
				$rank_obj->initiative = array( 'actual' => $monster->initiative );
				$rank[] = $rank_obj;
			}
		}
#	}
	return $rank;
}

function dnd1e_rank_attackers( &$chars, $segment ) {
	$hold = get_transient( 'dnd1e_hold' );
	$cast = get_transient( 'dnd1e_cast' );
	usort( $chars, function( $a, $b ) use ( $hold, $cast, $segment ) {
		$aname = ( $a instanceOf DND_Character_Character ) ? $a->get_name() : $a->name;
		$bname = ( $b instanceOf DND_Character_Character ) ? $b->get_name() : $b->name;
		if ( ! empty( $hold ) ) {
			if ( isset( $hold[ $aname ] ) && isset( $hold[ $bname ] ) ) {
			} else if ( isset( $hold[ $aname ] ) ) {
				return -1;
			} else if ( isset( $hold[ $bname ] ) ) {
				return 1;
			}
		}
		if ( ! empty( $cast ) ) {
			if ( isset( $cast[ $aname ] ) && isset( $cast[ $bname ] ) ) {
			} else if ( isset( $cast[ $aname ] ) && ( $cast[ $aname ]['when'] !== $segment ) ) {
				return -1;
			} else if ( isset( $cast[ $bname ] ) && ( $cast[ $bname ]['when'] !== $segment )  ) {
				return 1;
			}
		}
		if ( $a->stats['dex'] === $b->stats['dex'] ) {
			if ( $a->initiative['actual'] === $b->initiative['actual'] ) {
				return 0;
			} else if ( $a->initiative['actual'] > $b->initiative['actual'] ) {
				return -1;
			} else {
				return 1;
			}
		} else if ( $a->stats['dex'] > $b->stats['dex'] ) {
			return -1;
		} else {
			return 1;
		}
	} );
}

function dnd1e_start_casting_spell( $caster, $spell, $segment, $target ) {
	$cast = get_transient( 'dnd1e_cast' );
	$hold = get_transient( 'dnd1e_hold' );
	$len  = ( strpos( $spell['cast'], 'segment' ) ) ? intval( $spell['cast'] ) : intval( $spell['cast'] ) * 10;
	$cast[ $caster ] = array(
		'spell'  => $spell['name'],
		'when'   => $segment + $len,
		'target' => $target,
	);
	set_transient( 'dnd1e_cast', $cast );
	if ( isset( $hold[ $caster ] ) ) {
		unset( $hold[ $caster ] );
		set_transient( 'dnd1e_hold', $hold );
	}
}

function dnd1e_finish_casting_spell( $spell, $segment ) {
	if ( isset( $spell['filters'] ) ) {
		$spell['segment'] = $segment;
		if ( isset( $spell['duration'] ) ) {
			$length = ( strpos( $spell['duration'], 'segment' ) ) ? intval( $spell['duration'] ) : intval( $spell['duration'] ) * 10;
			$length = ( strpos( $spell['duration'], 'turn'    ) ) ? intval( $spell['duration'] ) * 100  : $length;
			$length = ( strpos( $spell['duration'], 'hour'    ) ) ? intval( $spell['duration'] ) * 1000 : $length;
			$spell['ends'] = $segment + $length;
		}
		dnd1e_add_ongoing_spell_effects( $spell );
	}
}

function dnd1e_add_ongoing_spell_effects( $spell ) {
print_r($spell);
	$ongoing = get_transient( 'dnd1e_ongoing' );
	if ( ! $ongoing ) $ongoing = array();
	$ongoing[ $spell['name'] ] = $spell;
	set_transient( 'dnd1e_ongoing', $ongoing );
}

function dnd1e_apply_ongoing_spell_effects( $segment ) {
	$ongoing = get_transient( 'dnd1e_ongoing' );
	if ( ! $ongoing ) $ongoing = array();
	foreach( $ongoing as $name => $spell ) {
		if ( isset( $spell['ends'] ) && ( $segment > $spell['ends'] ) ) {
			unset( $ongoing[ $name ] );
			continue;
		}
		$filters = $spell['filters'];
		// TODO: take aoe into account
		foreach( $filters as $filter ) {
			add_filter( $filter[0], function( $value, $b = null, $c = null, $d = null ) use ( $filter, $spell ) {
				if ( isset( $spell['condition'] ) ) {
					$condition = $spell['condition'];
					foreach( [ $b, $c, $d ] as $obj ) {
						if ( ( gettype( $obj ) === 'object' ) && method_exists( $obj, $condition ) ) {
							if ( ! $obj->$condition( $filter[0], $spell, $obj ) ) {
								return $value;
							}
						}
					}
				}
				return $value + $filter[1];
			}, $filter[2], $filter[3] );
		}
	}
	set_transient( 'dnd1e_ongoing', $ongoing );
}

function dnd1e_damage_to_monster( $monster, $target, $damage ) {
	if ( $target === 1 ) {
		$monster->current_hp -= $damage;
	} else {
		$appearing = get_transient( 'dnd1e_appearing' );
		$index = $target - 2;
		$appearing['hit_points'][ $index ][0] -= $damage;
		$appearing['hit_points'][ $index ][0] = min( $appearing['hit_points'][ $index ][0], $appearing['hit_points'][ $index ][1] );
		set_transient( 'dnd1e_appearing', $appearing );
	}



}

function dnd1e_import_kregen_characters( $list ) {
	$base    = 'DND_Character_';
	$objects = array();
	foreach( $list as $name => $data ) {
		$load = $base . $data['class'];
		$file = CSV_PATH . $name . '.csv';
		$info = ( isset( $data['data'] ) ) ? $data['data'] : array();
		$objects[ $name ] = new $load( $info );
		$objects[ $name ]->import_kregen_csv( $file );
	}
	return $objects;
}
