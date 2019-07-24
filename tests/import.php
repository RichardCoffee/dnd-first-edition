<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

#$test = new DND_Monster_Dragon_Bronze;
#$test = new DND_Monster_Dragon_Cloud(['solitary'=>1]);
#$test = new DND_Monster_Dragon_Faerie;
#$test = new DND_Monster_Dragon_Mist;
$test = new DND_Monster_Dragon_Shadow;
#$test = new DND_Monster_Giant_Spider;
#$test = new DND_Monster_Hydra;
#$test = new DND_Monster_Humanoid_Jermlaine;
#$test = new DND_Monster_Lycan_Wolf;
#$test = new DND_Character_Barbarian;
#$test->import_kregen_csv( CSV_PATH . 'Krieg.csv' );
#$test = new DND_Character_Cleric;
#$test->import_kregen_csv( CSV_PATH . 'Brandon.csv' );
#$test->import_kregen_csv( CSV_PATH . 'Derryl.csv' );
#$test->import_kregen_csv( CSV_PATH . 'Logos.csv' );
#$test->import_kregen_csv( CSV_PATH . 'Susan.csv' );
#$test = new DND_Character_ClericMagicUser;
#$test->import_kregen_csv( CSV_PATH . 'Dayna.csv' );
#$test = new DND_Character_ClericThief;
#$test->import_kregen_csv( CSV_PATH . 'Susan2.csv' );
#$test = new DND_Character_Druid;
#$test->import_kregen_csv( CSV_PATH . 'Gaius.csv' );
#$test = new DND_Character_Fighter;
#$test->import_kregen_csv( CSV_PATH . 'Evandur.csv' );
#$test->import_kregen_csv( CSV_PATH . 'Flint.csv' );
#$test->import_kregen_csv( CSV_PATH . 'Tank.csv' );
#$test = new DND_Character_FighterMagicUser;
#$test->import_kregen_csv( CSV_PATH . 'Saerwen.csv' );
#$test = new DND_Character_FighterThief( [ 'weap_dual' => [ 'Dagger', 'Dagger,Off-Hand' ] ] );
#$test->import_kregen_csv( CSV_PATH . 'Trindle.csv' );
#$test = new DND_Character_MagicUser;
#$test->import_kregen_csv( CSV_PATH . 'Big_John.csv' );
#$test->import_kregen_csv( CSV_PATH . 'Mary.csv' );
#$test = new DND_Character_Paladin( array( 'shield' => [ 'type' => 'Large' ] ) );
#$test->import_kregen_csv( CSV_PATH . 'Ivan.csv' );
#$test = new DND_Character_Ranger;
#$test->import_kregen_csv( CSV_PATH . 'Strider.csv' );
#$test->import_kregen_csv( CSV_PATH . 'David.csv' );
#$test = new DND_Character_RangerThief;
#$test->import_kregen_csv( CSV_PATH . 'Pointer.csv' );
#$test = new DND_Character_Thief( [ 'level' => 10, 'stats' => [ 'dex' => 14 ] ] );

#$test->set_current_weapon('Bow,Long');
#$test->set_current_weapon('Dagger,Off-Hand');
#$test->set_current_weapon('Sword,Short');
#$test->set_current_weapon('Sword,Two Handed');
#$test->set_current_weapon('Voulge');
#echo $test->get_to_hit_number( 5, 5, 80 )."\n";
print_r( $test );
#echo "num: ".$test->get_number_appearing()."\n";
#print_r( $test->logging_reduce_object( $test ) );
#echo "M:{$test->name} F:{$test->fight->name} MU:{$test->magic->name}\n";
#echo "M:{$test->race} F:{$test->fight->race} MU:{$test->magic->race}\n";
#echo "F:{$test->fight->level}:{$test->fight->experience} MU:{$test->magic->level}:{$test->magic->experience}\n";
#print_r( $test->armor );
#print_r( $test->hit_points );
#print_r( $test->stats );
#print_r( $test->weapon );
#print_r( $test->weapons );
#print_r( $test->magic->spells );

#$name = 'dnd1e_'.get_class($test).'_'.str_replace(' ','_',$test->name);
#set_transient( $name, $test );

#$obj = get_transient( $name );

#print_r($obj);
