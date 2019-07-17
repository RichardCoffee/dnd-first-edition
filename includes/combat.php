<?php


function dnd1e_load_combat_state( $chars ) {
	$combat = get_transient( 'dnd1e_combat' );
	if ( $combat ) {
		foreach( $chars as $name => $object ) {
			if ( isset( $combat[ $name ] ) ) {
				$object->segment = $combat[ $name ]['segment'];
				$object->set_current_weapon( $combat[ $name ]['weapon'] );
				$object->current_hp = $combat[ $name ]['hit_points'];
			}
		}
	}
}

function dnd1e_save_combat_state( $chars ) {
	$combat = array();
	foreach( $chars as $name => $object ) {
		$combat[ $name ] = array(
			'segment'    => $object->segment,
			'weapon'     => $object->weapon['current'],
			'hit_points' => $object->current_hp,
		);
	}
	set_transient( 'dnd1e_combat', $combat );
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

function dnd1e_get_attack_sequence( $rounds, $cur, $attacks = array( 1, 1 ) ) {
	$seq = array();
	$seg = 10 / ( $attacks[0] / $attacks[1] );
	do {
		$seq[] = round( $cur );
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
		case '12':
		default:
			$segs = array( 1, 2, 3, 4, 5, 5, 6, 7, 8, 9, 10, 10 );
	}
	return $segs;
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
