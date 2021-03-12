<?php

function add_special_gear( $combat ) {
	$gear = array(
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Potion',
			'gp'     =>  350,
			'name'   => 'Polymorph Self',
			'owner'  => 'Strider',
			'prefix' => 'PPMS',
			'symbol' => 'green person with white squiggly outline',
			'xp'     =>  200,
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Potion',
			'gp'     =>  500,
			'name'   => 'Neutralize Poison',
			'owner'  => 'Strider',
			'prefix' => 'PNTP',
			'symbol' => 'red drop',
			'xp'     =>  300,
		), //*/
/*		array(
			'class' => 'DND_Combat_Treasure_Items_Ring',
			'type' => array( 'Ring' ),
			'gp' => 15000,
			'link' => 'DMG 129-130',
			'name' => 'Shooting Stars',
			'owner' => 'Assistant 2',
			'prefix' => 'RSTA',
			'xp' => 3000,
		), //*/
/*		array(
			'class'   => 'DND_Combat_Treasure_Items_Misc',
			'charges' =>  73,
			'gp'      =>  2500,
			'name'    => 'Wind Fan: Gust of Wind (12th) PH 75',
			'owner'   => 'Trindle',
			'prefix'  => 'WFGW',
			'type'    =>  array( 'Wind Fan' ),
			'xp'      =>  500,
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Armor',
			'bonus'  =>  5,
			'gp'     =>  20500, // 3500, 7500, 12500, 16500, 20500
			'name'   => 'Chain mail +5',
			'owner'  => 'Evandur',
			'prefix' => 'CMP5',
			'type'   =>  array( 'Chain' ),
			'xp'     =>  6000, // 600, 1200, 2000, 4000, 6000
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Armor',
			'bonus'  =>  1,
			'gp'     =>  2500, // 2500, 6000, 9500
			'name'   => 'Ring Mail +1',
			'owner'  => 'Guard 32',
			'prefix' => 'RMP1',
			'type'   =>  array( 'Ring' ),
			'xp'     =>  400, // 400, 800, 1200
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Armor',
			'bonus'  =>  3,
			'gp'     =>  9500, // 2500, 6000, 9500
			'name'   => 'Ring Mail +3',
			'owner'  => 'Guard 28',
			'prefix' => 'RMP3',
			'type'   =>  array( 'Ring' ),
			'xp'     =>  1200, // 400, 800, 1200
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Armor',
			'bonus'  => 3,
			'gp'     => 10000, // 2500, 5000, 10000, 15000
			'name'   => 'Studded Leather +3',
			'owner'  => 'Krieg',
			'prefix' => 'SLP3',
			'type'   => array( 'Studded' ),
			'xp'     => 1250, // 400, 800, 1250, 2000
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Shield',
			'bonus'  =>  1,
			'gp'     =>  2500, // 2500, 5000, 8000, 12000, 17500
			'name'   => 'Small Shield +1',
			'owner'  => 'Assistant 3',
			'prefix' => 'SHS1',
			'type'   =>  array( 'Small' ),
			'xp'     =>  250, // 250. 500. 800. 1200. 1750
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Shield',
			'bonus'  =>  3,
			'gp'     =>  8000, // 2500, 5000, 8000, 12000, 17500
			'name'   => 'Large Shield +3',
			'owner'  => 'Assistant 12',
			'prefix' => 'SHL3',
			'type'   =>  array( 'Large' ),
			'xp'     =>  800, // 250. 500. 800. 1200. 1750
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Shield',
			'bonus'  =>  1,
			'gp'     =>  2500, // 2500, 5000, 8000, 12000, 17500
			'name'   => 'Large Shield +1',
			'owner'  => 'Guard 28',
			'prefix' => 'SHL1',
			'type'   =>  array( 'Large' ),
			'xp'     =>  250, // 250. 500. 800. 1200. 1750
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Ammo',
			'bonus'  => 1,
			'gp'     => 300, // 300
			'name'   => 'Bolt +1',
			'owner'  => 'Tank',
			'prefix' => 'BTP1',
			'quan'   => 16,
			'type'   => array( 'Bolt' ),
			'user'   => array( 'Crossbow,Light', 'Crossbow,Heavy' ),
			'xp'     => 50, // 50
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'  => 2,
			'gp'     => 1500, // 750, 1500, 3000, 3750, 5250
			'name'   => 'Dagger +2',
			'owner'  => 'Trindle',
			'prefix' => 'DGP2',
			'type'   => array( 'Dagger', 'Dagger,Thrown', 'Dagger,Off-Hand' ),
			'xp'     => 200, // 100, 200, 400, 500, 700
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'  => -1,
			'gp'     =>  438, // 1750
			'name'   => 'Hand Axe -1, Cursed',
			'owner'  => 'Assistant 19',
			'prefix' => 'AXC1',
			'type'   =>  array( 'Axe,Hand', 'Axe,Throwing', 'Cursed' ),
			'xp'     => '~', // 300
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'  => 2,
			'gp'     => 5000, // 2500
			'name'   => 'Hammer +2',
			'owner'  => 'Derryl',
			'prefix' => 'HMP2',
			'type'   => array( 'Hammer' ),
			'xp'     => 600, // 300
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'  => 2,
			'gp'     => 5000, // 2500
			'name'   => 'Lucern Hammer +2',
			'owner'  => 'Derryl',
			'prefix' => 'LHP2',
			'type'   => array( 'Hammer,Lucern' ),
			'xp'     => 600, // 300
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'  => 2,
			'gp'     => 1500, // 750, 1500, 3000, 3750, 5250
			'name'   => 'Knife +2',
			'owner'  => 'Krieg',
			'prefix' => 'KNP2',
			'type'   => array( 'Knife', 'Knife, Thrown' ),
			'xp'     => 200, // 100, 200, 400, 500, 700
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'  => 1,
			'gp'     => 3000, // 3000
			'name'   => 'Spear +1',
			'owner'  => 'Tank',
			'prefix' => 'SPR1',
			'type'   => array( 'Spear', 'Spear,Thrown' ),
			'xp'     => 500, // 500
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'  => 2,
			'gp'     => 5000, // 2500
			'name'   => 'Two Handed Sword +2',
			'owner'  => 'Ivan',
			'prefix' => 'S2P2',
			'type'   => array( 'Sword,Two Handed' ),
			'xp'     => 1000, // 500
		), //*/
/*		array(
			'class'   => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'   =>  1,
			'ego'     =>  5,
			'filters' =>  array(
			),
			'gp'     =>  22000,
			'link'   => 'DMG 164-165',
			'name'   => 'Broad Sword of Dancing',
			'owner'  => 'Subchief 25',
			'prefix' => 'SBDC',
			'type'   =>  array( 'Sword,Broad' ),
			'xp'     =>  4400,
		), //*/
/*		array(
			'class'   => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'   => 1,
			'effect'  => 'magic',
			'filters' => array(
				array( 'dnd1e_to_hit_object', 'vulnerable_to_hit',    2, 10, 3 ),
				array( 'dnd1e_origin_damage', 'vulnerable_to_damage', 2, 10, 4 ),
			),
			'gp'     =>  22000,
			'link'   => 'DMG 164-165',
			'name'   => 'Magic Phobia',
			'owner'  => 'Assistant 7',
			'prefix' => 'SLMP',
			'symbol' => 'four small interlocking circles',
			'type'   => array( 'Sword,Long' ),
			'xp'     =>  4400,
		), //*/
/*		array(
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
			'name'   => 'Long Sword, Dragon Slayer',
			'owner'  => 'Trindle',
			'prefix' => 'SLDS',
			'symbol' => 'Dragon head on pommel',
			'target' => 'Shadow',
			'type'   => array( 'Sword,Long' ),
			'xp'     =>  900,
		), //*/
/*		array(
			'class'   => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'   => 1,
			'effect'  => 'planes',
			'filters' => array(
				array( 'dnd1e_to_hit_object',  'vulnerable_to_hit',    0, 10, 3 ),
				array( 'dnd1e_origin_damage',  'vulnerable_to_damage', 0, 10, 4 ),
				array( 'dnd1e_vulnerable_hit', 'sword_of_the_planes',  0, 10, 3 ),
				array( 'dnd1e_vulnerable_dam', 'sword_of_the_planes',  0, 10, 3 ),
			),
			'gp'     =>  30000,
			'link'   => 'https://www.d20pfsrd.com/magic-items/magic-weapons/specific-magic-weapons/sword-of-the-planes/',
			'name'   => 'Sword of the Planes',
			'owner'  => 'Ivan',
			'prefix' => 'SBPN',
			'symbol' => 'circle with four radiating arrows',
			'type'   => array( 'Sword,Bastard' ),
			'xp'     =>  2000,
		), //*/
/*		array(
			'class'   => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'   => 1,
			'effect'  => 'wounding',
			'filters' => array(
				array( 'dnd1e_origin_damage', 'sword_of_wounding', 0, 10, 4 ),
				array( 'dnd1e_new_segment',   'sow_new_segment',   0, 10, 1 ),
			),
			'gp'     =>  22000,
			'link'   => 'DMG 165',
			'name'   => 'Long Sword of Wounding',
			'owner'  => 'Trindle',
			'prefix' => 'SLWO',
			'symbol' => 'red pommel',
			'type'   => array( 'Sword,Long' ),
			'xp'     =>  4000,
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'  => -2,
			'gp'     => 500,
			'name'   => 'Long Sword -2, Cursed',
			'owner'  => 'Trindle',
			'prefix' => 'SLC2',
			'type'   => array( 'Sword,Long', 'Cursed' ),
			'xp'     => 0,
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Weapon',
			'bonus'  => 2,
			'gp'     => 500,
			'name'   => 'Long Sword +2, Cursed Berserking',
			'owner'  => 'Ivan',
			'prefix' => 'SLCB',
			'type'   => array( 'Sword,Long', 'Cursed' ),
			'xp'     => 0,
		), //*/
/*		array(
			'class'  => 'DND_Combat_Treasure_Items_Legacy',
			'align'  => 'Neutral',
			'name'   => 'Axe of Exile',
			'owner'  => 'Fundin',
			'prefix' => 'AXEX',
			'type'   => array( 'Axe,Hand', 'Axe,Throwing' ),
		), //*/
	);
	if ( $gear ) $combat->import_gear( $gear );
}

function add_party_weapons( $combat ) {
	$allowed = array(
		'Derryl' => 'Bow,Long',
		'Fundin' => 'Halberd',
		'Gaius'  => 'Voulge',
	);
	foreach( $combat->party as $name => $char ) {
		if ( array_key_exists( $name, $allowed ) ) {
			$char->add_to_allowed_weapons( $allowed[ $name ] );
		}
	}
	if ( array_key_exists( 'Trindle', $combat->party ) ) {
		$combat->party['Trindle']->set_dual_weapons( 'Dagger', 'Dagger,Off-Hand' );
#		$combat->party['Trindle']->set_current_weapon( 'Dagger,Off-Hand' );
	}
}

add_party_weapons( $combat );
add_special_gear( $combat );
