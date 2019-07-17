<?php

$cast = get_transient('dnd1e_cast');
if ( ! $cast ) $cast = array();
$hold = get_transient('dnd1e_hold');
if ( ! $hold ) $hold = array();
#$attack = get_transient('dnd1e_attack');
#if ( ! $attack ) $attack = array();
#$weapons = get_transient('dnd1e_weapons');
#if ( ! $weapons ) $weapons = array();

$opts = getopt( 'hr:s:t::', [ 'att:', 'help', 'hit:', 'hold:', 'mi:' ] );

if ( ! $opts ) {
	if ( count( $argv ) > 1 ) {
		$name = $argv[1];
		if ( isset( $chars[ $name ] ) ) {
			if ( count( $argv ) > 2 ) {
				if ( intval( $argv[2] ) ) {
					$spell = dnd1e_get_numbered_spell( $chars[ $name ], $argv[2] );
					echo "\n{$argv[1]}\n";
					print_r( $spell );
					$cast[ $name ] = array( 'spell' => $spell['name'], 'when' => $segment + intval( $spell['data']['cast'] ) );
					set_transient( 'dnd1e_cast', $cast );
				} else {
					$seq = dnd1e_get_attack_sequence( $rounds, $chars[ $name ]->segment, $chars[ $name ]->weapon['attacks'] );
					if ( ( $segment === 1 ) || ( in_array( $segment, $seq ) ) ) {
						$chars[ $name ]->set_current_weapon( $argv[2] );
					} else {
						foreach( $seq as $seg ) {
							if ( $seg > $segment ) {
								if ( $chars[ $name ]->set_current_weapon( $argv[2] ) ) {
									$chars[ $name ]->segment = $seg;
								}
								break;
							}
						}
					}
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

"
	);
	exit;
}

if ( isset( $opts['r'] ) ) {
	$range = $opts['r'];
}

if ( isset( $opts['s'] ) ) {
	foreach( $chars as $name => $body ) {
		if ( $segment === $body->segment ) {
			$seq = dnd1e_get_attack_sequence( $rounds, $body->segment, $body->weapon['attacks'] );
			foreach( $seq as $seg ) {
				if ( ( $seg === $segment ) && ( ( ( $seg - $segment ) % 10 ) === 0 ) ) {
					$body->segment = $seg;
					break;
				}
			}
		}
	}
	$segment  = intval( $opts['s'] );
	set_transient( 'dnd1e_segment', $segment );
}
$seg_diff = floor( $segment / 10 );
$rounds  += $seg_diff;


if ( isset( $opts['t'] ) ) {
	dnd1e_show_possible_monster_treasure( $monster, $opts['t'] );
	exit;
}

if ( isset( $opts['hold'] ) ) {
	$hold[ $opts['hold'] ] = $segment;
	set_transient( 'dnd1e_hold', $hold );
}

if ( isset( $opts['att'] ) ) {
	$name = $opts['att'];
	if ( isset( $hold[ $name ] ) ) {
		unset( $hold[ $name ] );
		set_transient( 'dnd1e_hold', $hold );
	}
	$chars[ $name ]->segment = $segment;
}

if ( isset( $opts['hit'] ) ) {
	$sitrep = explode( ':', $opts['hit'] );
	$name   = $sitrep[0];
	$damage = intval( $sitrep[1] );
	if ( isset( $chars[ $name ] ) && ( $damage !== 0 ) ) {
		$chars[ $name ]->current_hp -= $damage;
	} else if ( ( $name === 'Monster' ) || ( $name === $monster->name ) ) {
		$monster->current_hp -= $damage;
	}
}

if ( isset( $opts['mi'] ) ) {
	$monster->set_initiative( $opts['mi'] );
}

#if ( ! empty( $opts ) ) print_r($opts);

