<?php

function dnd1e_combat() {
	if ( defined( 'ABSPATH' ) ) {
		return DND_Combat::instance();
	} else {
		return DND_CommandLine::instance();
	}
}

function dnd1e_save_character_transients( $characters = array() ) {
	foreach( $characters as $name => $obj ) {
		$trans = get_class( $obj ) . '_' . $name;
		dnd1e_save_character_as_transient( $trans, $obj );
	}
}

function dnd1e_save_character_as_transient( $transient, DND_Character_Character $char ) {
	dnd1e_transient( $transient, $char );
}
