<?php

$cast = dnd1e_transient('cast');
if ( ! $cast ) $cast = array();
$hold = dnd1e_transient('hold');
if ( ! $hold ) $hold = array();

$opts = getopt( 'hr:s:t::', [ 'att:', 'help', 'hit:', 'hold:', 'mi:', 'pre:' ] );

if ( ! $opts ) {
	if ( count( $argv ) > 1 ) {
		$name = $argv[1];
		if ( isset( $chars[ $name ] ) ) {
			if ( count( $argv ) > 2 ) {
				if ( intval( $argv[2] ) ) {
					$spell = dnd1e_get_numbered_spell( $chars[ $name ], $argv[2] );
					if ( $spell ) {
						echo "\n{$argv[1]}\n";
						$target = ( isset( $argv[3] ) ) ? $argv[3] : $name;
						dnd1e_start_casting_spell( $name, $spell, $segment, $target );
					}
				} else {
					dnd1e_change_weapons( $chars[ $name ], $argv[2], $segment );
				}
			} else if ( $chars[ $name ]->weapon['current'] === 'Spell' ) {
				dnd1e_show_possible_spells( $chars[ $name ] );
				exit;
			} else {
				dnd1e_show_possible_weapons( $chars[ $name ] );
				exit;
			}
		}
	}
}

if ( isset( $opts['h'] ) || isset( $opts['help'] ) ) {
	printf("
	-h, --help      Display this help screen.

	-rn             Control missile weapon range, where n = range in feet.

	-sn             Set the combat segment, where n = the segment.

	-t              Show monster treasure, if any.

	--hold=name     Place a character's attack on hold.  Indicate the monster is holding it's attack by using a name value of 'Monster'.

	--att=name      Remove character from hold list, because the character is attacking on this segment.

	--hit=name:#    Use to record damage to a character, format is <name>:<damge>.  Use a negative number to indicate healing.

	--mi=number     Set the monster's initiative.

	--name=name     Used to indicate a character's name.

	--pre=name:#    Use this when a character casts a spell before combat.

"
	);
	exit;
}

if ( isset( $opts['r'] ) ) {
	$range = $opts['r'];
}

if ( isset( $opts['s'] ) ) {
	foreach( $chars as $name => $body ) {
		$sequence = dnd1e_get_attack_sequence( $rounds, $body->segment, $body->weapon['attacks'] );
		foreach( $sequence as $seggie ) {
			if ( $seggie === $segment ) {
				if ( ( ( $seggie - $body->segment ) % 10 ) === 0 ) {
					$body->segment = $seggie;
					break;
				}
			}
		}
	}
	$segment  = intval( $opts['s'] );
	dnd1e_transient( 'segment', $segment );
}
$seg_diff = floor( $segment / 10 );
$rounds  += $seg_diff;


if ( isset( $opts['t'] ) ) {
	dnd1e_show_possible_monster_treasure( $monster, $opts['t'] );
	exit;
}

if ( isset( $opts['hold'] ) ) {
	$hold[ $opts['hold'] ] = $segment;
	dnd1e_transient( 'hold', $hold );
}

if ( isset( $opts['att'] ) ) {
	$name = $opts['att'];
	if ( isset( $hold[ $name ] ) ) {
		unset( $hold[ $name ] );
		dnd1e_transient( 'hold', $hold );
	}
	$chars[ $name ]->segment = $segment;
}

if ( isset( $opts['hit'] ) ) {
print_r($opts);
	$sitrep = explode( ':', $opts['hit'] );
print_r($sitrep);
	$name   = $sitrep[0];
	if ( isset( $chars[ $name ] ) ) {
		$damage = intval( $sitrep[1] );
		$chars[ $name ]->current_hp -= $damage;
		$chars[ $name ]->check_temporary_hit_points( $damage );
	} else if ( ( $name === 'Monster' ) || ( $name === $monster->name ) ) {
		$cnt  = count( $sitrep );
		if ( $cnt === 2 ) {
			$damage = intval( $sitrep[1] );
			$monster->current_hp -= $damage;
		} else if ( $cnt === 3 ) {
			$target = intval( $sitrep[1] );
			$damage = intval( $sitrep[2] );
			dnd1e_damage_to_monster( $monster, $target, $damage );
		}
	}
}

if ( isset( $opts['mi'] ) ) {
	$monster->initiative = intval( $opts['mi'] );
}

if ( isset( $opts['pre'] ) ) {
	if ( $segment < 2 ) {
		$sitrep = explode( ':', $opts['pre'] );
print_r($sitrep);
		$name   = $sitrep[0];
		if ( isset( $chars[ $name ] ) ) {
			$number = intval( $sitrep[1] );
			if ( $number ) {
				$spell = dnd1e_get_numbered_spell( $chars[ $name ], $number );
				if ( $spell ) {
					$target = ( isset( $sitrep[2] ) ) ? $sitrep[2] : $name;
					$spell['target'] = $target;
					$spell['caster'] = $name;
					dnd1e_finish_casting_spell( $spell, 1 );
					echo "\n$name has cast {$spell['name']} on $target\n\n";
					exit;
				}
			}
		}
	}
}

#if ( ! empty( $opts ) ) print_r($opts);

