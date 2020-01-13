<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/wordpress/get_file_data.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/wordpress/plugin.php' );

function get_character( $name ) {
	$file = CSV_PATH . $name . '.csv';
	if ( is_readable( $file ) ) {
		$temp = new DND_Character_Import_Kregen( $file );
		return $temp->character;
	}
	return false;
}

$char = get_character( 'Evandur' );
if ( $char ) {
	$treas = new DND_Treasure;
	$accs  = $treas->acc_get_accouterments( $char );
	print_r( $accs );
}

