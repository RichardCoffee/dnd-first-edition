<?php


/**  Swords  **/

$reptile = array(
'class'   => 'DND_Combat_Treasure_Items_Weapon',
'bonus'   => 1,
'effect'  => 'reptile',
'filters' => array(
array( 'dnd1e_to_hit_object', 'vulnerable_to_hit',    3, 10, 3 ),
array( 'dnd1e_origin_damage', 'vulnerable_to_damage', 3, 10, 4 ),
),
'gp'     =>  4000,
'link'   => 'DMG 164',
'name'   => 'Short Sword, Reptilean Phobia',
'owner'  => 'Evandur',
'prefix' => 'SSRP',
'symbol' => 'T-Rex head on pommel',
'type'   => array( 'Sword,Short' ),
'xp'     =>  800,
);
$dragon = array(
'class'   => 'DND_Combat_Treasure_Items_Weapon',
'bonus'   => 2,
'effect'  => 'dragon',
'filters' => array(
array( 'dnd1e_to_hit_object', 'vulnerable_to_hit',     2, 10, 3 ),
array( 'dnd1e_origin_damage', 'vulnerable_to_damage',  2, 10, 4 ),
array( 'dnd1e_damage_die',    'damage_die_multiplier', 3, 11, 3 ),
),
'gp'     =>  4500,
'link'   => 'DMG 164',
'name'   => 'Short Sword, Dragon Slayer',
'owner'  => 'Evandur',
'prefix' => 'SSDS',
'symbol' => 'Dragon head on pommel',
'target' => 'Green',
'type'   => array( 'Sword,Short' ),
'xp'     =>  900,
);
$planes = array(
'class'   => 'DND_Combat_Treasure_Items_Weapon',
'bonus'   => 1,
'effect'  => 'planes',
'filters' => array(
array( 'dnd1e_to_hit_object',  'vulnerable_to_hit',    0, 10, 3 ),
array( 'dnd1e_origin_damage',  'vulnerable_to_damage', 0, 10, 4 ),
array( 'vulnerable_to_hit',    'sword_of_the_planes',  0, 10, 3 ),
array( 'vulnerable_to_damage', 'sword_of_the_planes',  0, 10, 3 ),
),
'gp'     =>  30000,
'link'   => 'https://www.d20pfsrd.com/magic-items/magic-weapons/specific-magic-weapons/sword-of-the-planes/',
'name'   => 'Sword of the Planes',
'owner'  => 'Tank',
'prefix' => 'SLPN',
'symbol' => 'circle with four radiating arrows',
'type'   => array( 'Sword,Long' ),
'xp'     =>  2000,
);
$shifter = array(
'class'   => 'DND_Combat_Treasure_Items_Weapon',
'bonus'   => 1,
'effect'  => 'shifter',
'filters' => array(
array( 'dnd1e_to_hit_object', 'vulnerable_to_hit',    3, 10, 3 ),
array( 'dnd1e_origin_damage', 'vulnerable_to_damage', 3, 10, 4 ),
),
'gp'     =>  3500,
'link'   => 'DMG 164',
'owner'  => 'Krieg',
'prefix' => 'SBSP',
'symbol' => 'red man with two white squiggly outlines',
'type'   => array( 'Sword,Broad' ),
'xp'     =>  700,
), //*/
$vulnerable = array(
'class'   => 'DND_Combat_Treasure_Items_Armor',
'bonus'   => 1,
'filters' => array(
array( 'dnd1e_critical_hit', 'vulnerability', '', 10, 1 ),
),
'gp'     => 1500,
'name'   => 'Plate mail of Vulnerability',
'owner'  => 'Tank',
'prefix' => 'PMVL',
'type'   => array( 'Plate' ),
);
