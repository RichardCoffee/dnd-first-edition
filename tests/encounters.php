<?php

require_once( 'setup.php' );

$enc = new DND_Combat_Encounters;

#$listing = $enc->get_monster_list();
$listing = $enc->get_random_encounter( 'TC:F', 15 );
#$listing = $enc->get_terrain_list();
#$listing = $enc->get_water_list();

print_r($listing);
#echo "\n$listing\n\n";
