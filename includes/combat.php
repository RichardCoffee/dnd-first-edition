<?php

function dnd1e_load_characters( $list ) {
print_r( $list);
	$base    = 'DND_Character_';
	$objects = array();
	foreach( $list as $name => $data ) {
		$load = $base . $data['class'];
		$file = CSV_PATH . $name . '.csv';
		$objects[ $name ] = new $load;
	}
	return $objects;
}
