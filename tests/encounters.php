<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/includes.php' );

$enc = new DND_Encounters;

#$listing = $enc->get_monster_list();
$listing = $enc->get_random_encounter( 'TC:F', 15 );
#$listing = $enc->get_terrain_list();
#$listing = $enc->get_water_list();

print_r($listing);
#echo "\n$listing\n\n";
