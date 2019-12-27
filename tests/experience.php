<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );

$args = array(
	'hd_value'     => 8,
	'hit_dice'     => 1,
	'hp_extra'     => 2,
	'intelligence' => 'Non-',
	'magic_user'   => null,
);
for( $i = 8; $i < 22; $i++ ) {
	$args['hit_dice'] = $i;
	$exp = new DND_Tests_Experience( $args );
	$exp->show_experience_points();
}
