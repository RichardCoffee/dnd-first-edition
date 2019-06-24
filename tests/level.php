<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );

require( DND_FIRST_EDITION_DIR . '/functions.php' );

$susan  = new DND_Character_Cleric( [ 'experience' => 60190 ] );
echo " Susan:  7 - " . $susan->level . "\n";
$derryl = new DND_Character_Cleric( [ 'experience' => 41038 ] );
echo "Derryl:  6 - " . $derryl->level . "\n";
$dayna  = new DND_Character_Cleric( [ 'experience' => 1127200 ] );
echo " Dayna: 13 - " . $dayna->level . "\n";
$alvin  = new DND_Character_Cleric( [ 'experience' => 13647 ] );
echo " Alvin:  5 - " . $alvin->level . "\n";
$brand  = new DND_Character_Cleric( [ 'experience' => 30653 ] );
echo " Brand:  6 - " . $brand->level . "\n";
$logos  = new DND_Character_Cleric( [ 'experience' => 5684 ] );
echo " Logos:  3 - " . $logos->level . "\n";
$ragnor = new DND_Character_Cleric( [ 'experience' => 243111 ] );
echo "Ragnor:  9 - " . $ragnor->level . "\n";
$novice = new DND_Character_Cleric( [ 'experience' => 111 ] );
echo "Novice:  1 - " . $novice->level . "\n";

