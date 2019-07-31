<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

#$test = new DND_Monster_Dragon_Bronze;
#$test = new DND_Monster_Dragon_Cloud(['solitary'=>1]);
$test = new DND_Monster_Dragon_Faerie;
#$test = new DND_Monster_Dragon_Mist;
#$test = new DND_Monster_Dragon_Shadow;
#$test = new DND_Monster_Giant_Spider;
#$test = new DND_Monster_Hydra;
#$test = new DND_Monster_Humanoid_Jermlaine;
#$test = new DND_Monster_Lycan_Wolf;
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Big_John.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Brandon.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'David.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Dayna.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Derryl.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Evandur.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Flint.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Gaius.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Ivan.csv', array( 'shield' => [ 'type' => 'Large' ] ) );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Krieg.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Logos.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Mary.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Meera.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Pointer.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Ragnor.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Rider.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Robb.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Saerwen.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Smurf.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Strider.csv' );   // Ranger
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Susan.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Susan2.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Tank.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Thorodon.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Tifa.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Trindle.csv', [ 'weap_dual' => [ 'Dagger', 'Dagger,Off-Hand' ] ] );
#$test = new DND_Character_Thief( [ 'level' => 10, 'stats' => [ 'dex' => 14 ] ] );

#echo $test->import_message."\n";
print_r($test->character);
#echo "num: ".$test->character->get_number_appearing()."\n";
#print_r( $test->character->logging_reduce_object( $test ) );
/*
$name = get_class( $test->character ) . '_' . $test->character->get_name();
dnd1e_transient( $name, $test->character );

$obj = dnd1e_transient( $name );

print_r( $obj ); //*/

$number = $test->get_number_appearing();
$appearing = array(
'number'     => $number,
'hit_points' => $test->get_appearing_hit_points( $number ),
);
print_r($appearing);
