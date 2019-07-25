<?php

function dnd1e_get_combat_string( DND_Character_Character $char, DND_Monster_Monster $monster, $range ) {
	$name = $char->get_name();
	$line = sprintf( '%12s',    sprintf( '%7s(%d)', $name, $char->get_hit_points() ) );
	$weapon = dnd1e_get_combat_weapon( $char );
	if ( ( substr( $weapon, 0, 3) === 'Bow' ) && ( $range < 31 ) ) {
		$weapon .= ": Damage*2";
	} else if ( ( substr( $weapon, 0, 5) === 'Cross' ) && ( $range < 61 ) ) {
		$weapon .= ": D*2";
	}
	$line.= sprintf( ': %-20s', substr( $weapon, 0, 19 ) );
	$line.= sprintf( '%2d  ',   max( 2, $char->get_to_hit_number() ) );
	$line.= sprintf( '%5s+',    $char->get_weapon_damage( $monster->size ) );
	$line.= sprintf( '%-2u   ', $char->get_weapon_damage_bonus( $range ) );
	return $line;
}

function dnd1e_get_combat_weapon( DND_Character_Character $char ) {
	$weapon = $char->weapon['current'];
	if ( $weapon === 'Spell' ) {
		$cast = get_transient( 'dnd1e_cast' );
		if ( $cast ) {
			$name = $char->get_name();
			if ( isset( $cast[ $name ] ) ) {
				$weapon .= ':' . $cast[ $name ]['spell'];
			}
		}
	}
	return $weapon;
}

function dnd1e_get_mapped_movement_sequence( $movement = 12 ) {
	$test = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
	$str  = '|';
	$move = dnd1e_get_movement_sequence( $movement );
	foreach( $test as $seg ) {
		$cnt = count( array_keys( $move, $seg ) );
		switch( $cnt ) {
			case 0:
				$str .= '-|';
				break;
			case 1:
				$str .= ( $seg === 10 ) ? '0|' : $seg . '|';
				break;
			default:
				$str .= '@|';
		}
	}
	return $str;
}

function dnd1e_get_adjusted_movement_map( $map, $segment ) {
	$mod = $segment % 10;
	switch( $mod ) {
		case 1:
			break;
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
			$cnt = ( $mod * 2 ) - 1;
			$map = str_repeat( '-', $cnt ) . substr( $map, $cnt );
			break;
		case 0:
			$map = str_repeat( '-', 19 ) . substr( $map, 19 );
			break;
		default:
	}
	return $map;
}

function dnd1e_get_mapped_attack_sequence( $rounds, $seq ) {
	$map  = '|';
	$cur  = $cnt = 0;
	$keys = 1;
	foreach( $seq as $att ) {
		if ( $keys > 1 ) {
			$keys = 1;
			continue;
		}
		if ( ( $cnt++ % 10 === 0 ) && ( $cnt > 1 ) ) $map .='^|';
		$step = $att - $cur;
		for( $i = 1; $i < $step; $i++ ) {
			$map .= '-|';
			if ( $cnt++ % 10 === 0 ) $map .='^|';
		}
		$keys = count( array_keys( $seq, ( $att % 10 ) ) );
		$map .= ( ( $keys > 1 ) ? '@' : $att % 10 ) . '|';
		$cur  = $att;
	}
	$end = ( $rounds * 10 ) + 1;
	for( $i = $cur; $i < $end; $i++ ) {
		if ( ( $cnt++ % 10 === 0 ) && ( $cnt > 1 ) ) $map .='^|';
		$map .= '-|';
	}
	return $map;
}

function dnd1e_show_possible_spells( DND_Character_Character $char ) {
	$list = $char->get_spell_list();
	if ( empty( $list ) ) {
		echo "\n{$char->name} has NO spells!\n\n";
	} else {
		echo "\n{$char->name} has Spells!\n\n";
		if ( isset( $list['multi'] ) ) {
			$start = 1;
			foreach( $list as $key => $spells ) {
				if ( $key === 'multi' ) continue;
				echo "$key Spells\n";
				$start = dnd1e_show_numbered_spell_list( $spells, $start );
			}
		} else {
			dnd1e_show_numbered_spell_list( $list );
		}
	}
}

function dnd1e_show_numbered_spell_list( $spells, $start = 1 ) {
	foreach( $spells as $level => $list ) {
		echo "\t$level level spells\n";
		foreach( $list as $name => $info ) {
			echo "\t\t$start) $name\n";
			$start++;
		}
	}
	return $start;
}

function dnd1e_get_numbered_spell( DND_Character_Character $char, $number ) {
	$number = intval( $number );
	if ( $number ) {
		$list = $char->get_spell_list();
		if ( $list ) {
			$index = 1;
			if ( ! isset( $list['multi'] ) ) {
				$list = array( 'Single' => $list );
			}
			foreach( $list as $type => $listing ) {
				foreach( $listing as $level => $spells ) {
					foreach( $spells as $spell => $data ) {
						if ( $index === $number ) {
							return $char->locate_magic_spell( $spell, $type );
						}
						$index++;
					}
				}
			}
		}
	}
	return false;
}

function dnd1e_show_possible_weapons( $char ) {
	echo "\n{$char->name} has these weapons available:\n\n";
	foreach( $char->weapons as $weapon => $info ) {
		echo "\t$weapon ({$info['skill']})\n";
	}
	echo "\n";
}

function dnd1e_show_casting_spell( $spell, $segment ) {
	echo " casting {$spell['name']} {$spell['page']}";
	if ( isset( $spell['reversible'] ) ) echo " Reversible";
	if ( isset( $spell['range']      ) ) echo "\n\t\t         Range: {$spell['range']}";
	if ( isset( $spell['duration']   ) ) echo "\n\t\t      Duration: {$spell['duration']}";
	if ( isset( $spell['aoe']        ) ) echo "\n\t\tArea of Effect: {$spell['aoe']}";
	if ( isset( $spell['special']    ) ) echo "\n\t\t       Special: {$spell['special']}";
}
