<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );

require( DND_FIRST_EDITION_DIR . '/functions.php' );

#$test = new DND_Character_Barbarian;
#$test->import_kregen_csv( CSV_PATH . 'Krieg.csv' );
$test = new DND_Character_Cleric;
$test->import_kregen_csv( CSV_PATH . 'Susan.csv' );
#$test = new DND_Character_Fighter;
#$test->import_kregen_csv( CSV_PATH . 'Tank.csv' );
#$test = new DND_Character_FighterMagicUser;
#$test->import_kregen_csv( CSV_PATH . 'Saerwen.csv' );
#$test = new DND_Character_Paladin;
#$test->import_kregen_csv( CSV_PATH . 'Ivan.csv' );
#$test = new DND_Character_Ranger;
#$test->import_kregen_csv( CSV_PATH . 'Strider.csv' );
#$test->import_kregen_csv( CSV_PATH . 'David.csv' );

print_r( $test );
#echo "M:{$test->name} F:{$test->fight->name} MU:{$test->magic->name}\n";
#echo "M:{$test->race} F:{$test->fight->race} MU:{$test->magic->race}\n";
#echo "F:{$test->fight->level}:{$test->fight->experience} MU:{$test->magic->level}:{$test->magic->experience}\n";
#print_r( $test->armor );
#print_r( $test->hit_points );
#print_r( $test->stats );
#print_r( $test->weapon );
#print_r( $test->weapons );
#print_r( $test->fight->weap_profs );
#print_r( $test->magic->weap_profs );
#print_r( $test->weap_profs );
#print_r( $test->magic->spells );
