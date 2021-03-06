<?php

if ( ! defined( 'MINUTES_IN_SECONDS' ) ) {
	define( 'MINUTE_IN_SECONDS', 60 );
	define( 'HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS );
	define( 'DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS );
	define( 'WEEK_IN_SECONDS',    7 * DAY_IN_SECONDS );
	define( 'MONTH_IN_SECONDS',  30 * DAY_IN_SECONDS );
	define( 'YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS );
}

function commandline_errors($errNo, $errStr, $errFile, $errLine) {
	if (error_reporting() == 0) return;
	$msg = "$errStr in $errFile on line $errLine";
	if ( ( $errNo == E_NOTICE ) || ( $errNo == E_WARNING ) || ( $errNo == E_USER_ERROR ) ) {
		throw new ErrorException($msg, $errNo);
	} else {
		echo $msg;
	}
}
set_error_handler('commandline_errors');

define( 'DND_TRANSIENT_DIR', DND_FIRST_EDITION_DIR . '/../transients/' );

function delete_transient( $transient ) {
	$file = DND_TRANSIENT_DIR . clean_transient_name( $transient );
	if ( file_exists( $file ) ) {
		unlink( $file );
	}
}

function get_transient( $transient ) {
	$value = false;
	$file = DND_TRANSIENT_DIR . clean_transient_name( $transient );
	if ( file_exists( $file ) ) {
		$trans = file_get_contents( $file );
		$value = unserialize( $trans );
	}
	return $value;
}

function set_transient( $transient, $value, $expiration = 0 ) {
	$file = DND_TRANSIENT_DIR . clean_transient_name( $transient );
	file_put_contents( $file, serialize( $value ) );
}

function clean_transient_name( $string ) {
	return str_replace( ' ', '_', $string );
}

