<?php

define( 'DND_TRANSIENT_DIR', DND_FIRST_EDITION_DIR . '/command_line/transients/' );

function delete_transient( $transient ) {
	$file = DND_TRANSIENT_DIR . clean_transient_name( $transient );
	if ( file_exists( $file ) ) {
		unlink( $file );
	}
}

function get_transient( $transient ) {
	$return = '';
	$file = DND_TRANSIENT_DIR . clean_transient_name( $transient );
	if ( file_exists( $file ) ) {
		$trans  = file_get_contents( $file );
		$return = json_decode( $trans, true );
	}
	return $return;
}

function set_transient( $transient, $value, $expiration = 0 ) {
	$file = DND_TRANSIENT_DIR . clean_transient_name( $transient );
	file_put_contents( $file, json_encode( $value ) );
}

function clean_transient_name( $string ) {
	return str_replace( ' ', '_', $string );
}
