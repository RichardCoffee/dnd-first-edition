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

if ( ! function_exists( 'dnd1e' ) ) {
	function dnd1e( $force = false ) {
		static $library;
		if ( empty( $library ) ) {
			$library = new DND_Plugin_Library;
		}
		if ( $force ) {
			#  force log entry during ajax call
			$library->logging_force = $force;
		}
		return $library;
	}
}

/** array_column() introduced in PHP 7.0.0  **/
if ( ! function_exists( 'array_column' ) ) {
	function array_column( array $input, $column_key ) {
		$result = array();
		foreach( $input as $item ) {
			if ( array_key_exists( $column_key, $item ) ) {
				$result[] = $item[ $column_key ];
			}
		}
		return $result;
	}
}

/** array_key_first() introduced in PHP 7.3.0  **/
if ( ! function_exists( 'array_key_first' ) ) {
	function array_key_first( array $arr ) {
		foreach( $arr as $key => $unused ) {
			return $key;
		}
		return NULL;
	}
}

if ( ! function_exists( 'dnd1e_transient' ) ) {
	function dnd1e_transient( $name, $data = null, $expire = YEAR_IN_SECONDS ) {
		$entry = "dnd1e_$name";
		if ( $data ) {
			set_transient( $entry, $data, $expire );
		} else {
			return dnd1e()->unserialize( get_transient( $entry ), [ 'DND_Combat', 'DND_Monster_Monster', 'DND_Character_Character' ] );
		}
	}
}

# https://stackoverflow.com/questions/5911067/compare-object-properties-and-show-diff-in-php
function obj_diff( $obj1, $obj2 ) {
	$a1 = (array)$obj1;
	$a2 = (array)$obj2;
	$r = array();
	foreach ($a1 as $k => $v) {
		if (array_key_exists($k, $a2)) {
			if ( is_object($v) ) {
				$rad = obj_diff($v, $a2[$k]);
				if (count($rad)) { $r[$k] = $rad; }
			}else if (is_array($v)){
				$rad = obj_diff($v, $a2[$k]);
				if (count($rad)) { $r[$k] = $rad; }
			// required to avoid rounding errors due to the
			// conversion from string representation to double
			} else if (is_double($v)){
				if (abs($v - $a2[$k]) > 0.000000000001) {
					$r[$k] = array($v, $a2[$k]);
				}
			} else {
				if ($v != $a2[$k]) {
					$r[$k] = array($v, $a2[$k]);
				}
			}
		} else {
			$r[$k] = array($v, null);
		}
	}
	return $r;
}
