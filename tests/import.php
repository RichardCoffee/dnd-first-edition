<?php

require_once( 'setup.php' );

#$test = new DND_Monster_Dragon_Bronze;
#$test = new DND_Monster_Dragon_Cloud;
#$test = new DND_Monster_Dragon_Faerie;
#$test = new DND_Monster_Dragon_Mist;
#$test = new DND_Monster_Dragon_Shadow;
#$test = new DND_Monster_Giant_Spider;
#$test = new DND_Monster_Hydra;
#$test = new DND_Monster_Humanoid_Jermlaine;
#$test = new DND_Monster_Lycan_Wolf;
#$test = new DND_Monster_Troll_Troll;
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Big_John.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Brandon.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'David.csv' );    // Ranger
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Dayna.csv' );    // Cleric/Magic User
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Derryl.csv' );   // Cleric
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Evandur.csv' );  // Fighter
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Flint.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Gaius.csv' );    // Druid
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Ivan.csv', array( 'shield' => [ 'type' => 'Large' ] ) );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Krieg.csv' );    // Barbarian
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Logos.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Mary.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Meera.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Pointer.csv' );  // Ranger/Thief
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Ragnor.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Rider.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Robb.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Saerwen.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Smurf.csv' );    // Illusionist
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Strider.csv' );   // Ranger
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Susan.csv' );    // Cleric/Thief
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Tank.csv' );     // Fighter
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Thorodon.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Tifa.csv' );
$test = new DND_Character_Import_Kregen( CSV_PATH . 'Zao.csv' );
#$test = new DND_Character_Import_Kregen( CSV_PATH . 'Trindle.csv', [ 'weap_dual' => [ 'Dagger', 'Dagger,Off-Hand' ] ] );
#$test = new DND_Character_Thief( [ 'level' => 10, 'stats' => [ 'dex' => 14 ] ] );


#echo "R:{$test->character->fight->current_hp}\n";
#echo "T:{$test->character->thief->current_hp}\n";
#echo "RT:{$test->character->current_hp}\n";
#echo $test->import_message."\n";
print_r($test->character);
#echo "num: ".$test->character->get_number_appearing()."\n";
#print_r( $test->character->logging_reduce_object( $test ) );
#print_r( $test->character->logging_reduce_object( $test->character ) );
#print_r( $test->character->logging_reduce_object( $test->character->fight ) );
/*
$num = $test->get_number_appearing();
echo "num: $num  sol: {$test->solitary} {$test->mate}\n";
$serial = serialize( $test );
$obj = unserialize( $serial );
echo "{$obj->mate}\n"; //*/
/*
$name = get_class( $test->character ) . '_' . $test->character->get_name();
dnd1e_transient( $name, $test->character );
$obj = dnd1e_transient( $name );
print_r( $obj ); //*/
/*
$number = $test->get_number_appearing();
$appearing = array(
'number'     => $number,
'hit_points' => $test->get_appearing_hit_points( $number ),
);
print_r($appearing); //*/

#echo "{$test} hp: {$test->hit_points}\n";
#dnd1e_transient( 'test', $test );
