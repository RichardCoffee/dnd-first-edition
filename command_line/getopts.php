<?php

$opts = getopt( 'hr:s:t::', [ 'help', 'hold:', 'att:', 'mi:', 'weapon:' ] );

if ( ! $opts ) {
	$clargs = $argv;
	if ( count( $clargs ) > 1 ) {
		print_r($clargs);
		$parm = $argv[1];
		if ( isset( $chars[ $parm ] ) ) {
			if ( $chars[ $parm ]->weapon['current'] === 'Spell' ) {
				dnd1e_show_possible_spells( $chars[ $parm ] );
				exit;
			} else {
				dnd1e_show_possible_weapons( $chars[ $parm ] );
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
	                Also used with --weapon=name

	--mi=number     Set the monster's initiative.

	--weapon=name   Sets a character's weapon, where 'name' is the weapon to be set.  --att=name must also be present on the command line.

"
	);
	exit;
}

if ( isset( $opts['r'] ) ) {
	$range = $opts['r'];
}

if ( isset( $opts['s'] ) ) {
	$segment  = $opts['s'];
	$seg_diff = floor( $segment / 10 );
	$rounds  += $seg_diff;
	set_transient( 'dnd1e_segment', $segment );
}

if ( isset( $opts['t'] ) ) {
	dnd1e_show_possible_monster_treasure( $monster, $opts['t'] );
	exit;
}

$hold    = get_transient('dnd1e_hold');
if ( empty( $hold ) ) $hold = array();
$attack  = get_transient('dnd1e_attack');
if ( empty( $attack ) ) $attack = array();
$weapons = get_transient('dnd1e_weapons');
if ( empty( $weapons ) ) $weapons = array();


if ( isset( $opts['hold'] ) ) {
	$hold[ $opts['hold'] ] = $segment;
	set_transient( 'dnd1e_hold', $hold );
}

if ( isset( $opts['att'] ) ) {
	echo $opts['att']."\n";
	$name = $opts['att'];
	if ( isset( $hold[ $name ] ) ) {
		unset( $hold[ $name ] );
		set_transient( 'dnd1e_hold', $hold );
	}
	$attack[ $name ] = $segment;
	set_transient( 'dnd1e_attack', $attack );
	if ( isset( $opts['weapon'] ) ) {
		echo $opts['weapon']."\n";
		$weapons[ $name ] = "{$opts['weapon']}";
		set_transient( 'dnd1e_weapons', $weapons );
	}
}

if ( isset( $opts['mi'] ) ) {
	$monster->set_initiative( $opts['mi'] );
}

if ( ! empty( $opts ) ) print_r($opts);

