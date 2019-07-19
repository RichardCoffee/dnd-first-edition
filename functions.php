<?php

function dnd_first_edition_class_loader( $class ) {
	if ( substr( $class, 0, 4 ) === 'DND_' ) {
		$load = str_replace( '_', '/', substr( $class, ( strpos( $class, '_' ) + 1 ) ) );
		$file = DND_FIRST_EDITION_DIR . '/classes/' . $load . '.php';
		if ( is_readable( $file ) ) {
			include $file;
		}
	}
}
spl_autoload_register( 'dnd_first_edition_class_loader' ); //*/

/** array_key_first() introduced in PHP 7.3.0  **/
if ( ! function_exists( 'array_key_first' ) ) {
	function array_key_first( array $arr ) {
		foreach( $arr as $key => $unused ) {
			return $key;
		}
		return NULL;
	}
}

if ( ! function_exists( 'replicate' ) ) {
	function replicate( $pattern = '', $iterations = 1 ) {
		$string = $pattern;
		for( $i = 1; $i < $iterations; $i++ ) {
			$string .= $pattern;
		}
		return $string;
	}
}
