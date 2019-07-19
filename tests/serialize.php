<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

$test = new DND_Monster_Dragon_Bronze;
#$test = new DND_Character_Cleric;
#$test->import_kregen_csv( CSV_PATH . 'Brandon.csv' );
#$test = new DND_Character_Fighter;
#$test->import_kregen_csv( CSV_PATH . 'Evandur.csv' );

print_r( $test );

$base = serialize( $test );

print_r( $base );

$obj = unserialize( $base );

print_r( $obj );

$diff = obj_diff( $test, $obj );

print_r( $diff );
