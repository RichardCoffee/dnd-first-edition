<?php

function dnd1e_get_function_stack() {
	$functions  = array();
	$call_trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
	foreach( $call_trace as $call ) {
		if ( array_key_exists( 'function', $call ) ) $functions[] = $call['function'];
	}
	return $functions;
}
