<?php

function dnd1e_get_magic_items_table() {
	return array(
		'title' => 'Magic Items: 1d100',
		array( 'chance' => 20, 'text' => 'Potions (1d1000)',           'sub' => 'potions' ),
		array( 'chance' => 15, 'text' => 'Scrolls',                    'sub' => 'scrolls' ),
		array( 'chance' =>  5, 'text' => 'Rings (1d1000)',             'sub' => 'rings' ),
		array( 'chance' =>  1, 'text' => 'Rods',                       'sub' => 'rods' ),
		array( 'chance' =>  1, 'text' => 'Staves',                     'sub' => 'staves' ),
		array( 'chance' =>  3, 'text' => 'Wands',                      'sub' => 'wands' ),
		array( 'chance' =>  1, 'text' => 'Books and Tomes',            'sub' => 'books_tomes' ),
		array( 'chance' =>  2, 'text' => 'Jewels and Jewelry',         'sub' => 'jewels_jewelry' ),
		array( 'chance' =>  2, 'text' => 'Cloaks and Robes',           'sub' => 'cloaks_robes' ),
		array( 'chance' =>  2, 'text' => 'Boots and Gloves',           'sub' => 'boots_gloves' ),
		array( 'chance' =>  1, 'text' => 'Girdles and Helms',          'sub' => 'girdles_helms' ),
		array( 'chance' =>  2, 'text' => 'Bags and Bottles',           'sub' => 'bags_bottles' ),
		array( 'chance' =>  1, 'text' => 'Dusts and Stones',           'sub' => 'dusts_stones' ),
		array( 'chance' =>  1, 'text' => 'Household Items and Tools',  'sub' => 'items_tools' ),
		array( 'chance' =>  1, 'text' => 'Musical Instruments',        'sub' => 'instruments' ),
		array( 'chance' =>  2, 'text' => 'The Weird Stuff',            'sub' => 'weird_stuff' ),
		array( 'chance' => 15, 'text' => 'Armor and Shields (1d1000)', 'sub' => 'armor_shields' ),
		array( 'chance' => 11, 'text' => 'Swords',                     'sub' => 'swords' ),
		array( 'chance' => 14, 'text' => 'Miscellaneous Weapons',      'sub' => 'weapons' ),
	);
}

function dnd1e_get_sub_table_string( $sub ) {
	return "dnd1e_get_magic_{$sub}_table";
}

function dnd1e_get_magic_potions_table() {
	return array(
		'title' => 'Potions: 1d1000',
		array( 'chance' => 20, 'text' => 'Animal Control',           'xp' => 250, 'gp' =>   400, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Clairaudience',            'xp' => 250, 'gp' =>   400, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Clairvoyance',             'xp' => 300, 'gp' =>   500, 'link' => 'DMG' ),
		array( 'chance' => 30, 'text' => 'Climbing',                 'xp' => 300, 'gp' =>   500, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Cursed/Poison',            'xp' => '~', 'gp' => '~~~', 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Delusion',                 'xp' => '~', 'gp' =>   150, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Diminution',               'xp' => 300, 'gp' =>   500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Dragon Control - White',   'xp' => 700, 'gp' =>  5000, 'link' => 'DMG 124' ),
		array( 'chance' =>  2, 'text' => 'Dragon Control - Black',   'xp' => 700, 'gp' =>  6000, 'link' => 'DMG 124' ),
		array( 'chance' =>  3, 'text' => 'Dragon Control - Green',   'xp' => 700, 'gp' =>  7000, 'link' => 'DMG 124' ),
		array( 'chance' =>  2, 'text' => 'Dragon Control - Blue',    'xp' => 700, 'gp' =>  8000, 'link' => 'DMG 124' ),
		array( 'chance' =>  1, 'text' => 'Dragon Control - Red',     'xp' => 700, 'gp' =>  9000, 'link' => 'DMG 124' ),
		array( 'chance' =>  2, 'text' => 'Dragon Control - Brass',   'xp' => 700, 'gp' =>  5000, 'link' => 'DMG 124' ),
		array( 'chance' =>  2, 'text' => 'Dragon Control - Copper',  'xp' => 700, 'gp' =>  6000, 'link' => 'DMG 124' ),
		array( 'chance' =>  1, 'text' => 'Dragon Control - Bronze',  'xp' => 700, 'gp' =>  7000, 'link' => 'DMG 124' ),
		array( 'chance' =>  1, 'text' => 'Dragon Control - Silver',  'xp' => 700, 'gp' =>  8000, 'link' => 'DMG 124' ),
		array( 'chance' =>  1, 'text' => 'Dragon Control - Gold',    'xp' => 700, 'gp' =>  9000, 'link' => 'DMG 124' ),
		array( 'chance' =>  2, 'text' => 'Dragon Control - Evil',    'xp' => 700, 'gp' =>  9000, 'link' => 'DMG 124' ),
		array( 'chance' =>  1, 'text' => 'Dragon Control - Good',    'xp' => 700, 'gp' =>  9000, 'link' => 'DMG 124' ),
		array( 'chance' => 10, 'text' => 'Elixir of Health',         'xp' => 350, 'gp' =>  2000, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Elixir of Madness',        'xp' => '~', 'gp' => '~~~', 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Elixir of Youth',          'xp' => 500, 'gp' => 10000, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'ESP',                      'xp' => 500, 'gp' =>   850, 'link' => 'DMG' ),
		array( 'chance' => 50, 'text' => 'Extra-Healing',            'xp' => 400, 'gp' =>   800, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Fire Breath',              'xp' => 400, 'gp' =>  4000, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Fire Resistance',          'xp' => 250, 'gp' =>   400, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Flying',                   'xp' => 500, 'gp' =>   750, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Gaseous Form',             'xp' => 300, 'gp' =>   400, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Giant Control: Hill',      'xp' => 600, 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Giant Control: Stone',     'xp' => 600, 'gp' =>  2000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Giant Control: Frost',     'xp' => 600, 'gp' =>  3000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Giant Control: Fire',      'xp' => 600, 'gp' =>  4000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Giant Control: Cloud',     'xp' => 600, 'gp' =>  5000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Giant Control: Storm',     'xp' => 600, 'gp' =>  6000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Giant Strength: Hill',     'xp' => 550, 'gp' =>   900, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Giant Strength: Stone',    'xp' => 550, 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Giant Strength: Frost',    'xp' => 550, 'gp' =>  1100, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Giant Strength: Fire',     'xp' => 550, 'gp' =>  1200, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Giant Strength: Cloud',    'xp' => 550, 'gp' =>  1300, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Giant Strength: Storm',    'xp' => 550, 'gp' =>  1400, 'link' => 'DMG' ),
		array( 'chance' => 15, 'text' => 'Growth',                   'xp' => 250, 'gp' =>   300, 'link' => 'DMG' ),
		array( 'chance' => 40, 'text' => 'Healing',                  'xp' => 200, 'gp' =>   400, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Heroism(F)',               'xp' => 300, 'gp' =>   500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Human Control: Dwarves',   'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
		array( 'chance' =>  2, 'text' => 'Human Control: Elves/Half-Elves', 'xp' => 500, 'gp' => 900, 'link' => 'DMG 125' ),
		array( 'chance' =>  2, 'text' => 'Human Control: Gnomes',    'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
		array( 'chance' =>  2, 'text' => 'Human Control: Halflings', 'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
		array( 'chance' =>  2, 'text' => 'Human Control: Half-Orcs', 'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
		array( 'chance' =>  6, 'text' => 'Human Control: Humans',    'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
		array( 'chance' =>  3, 'text' => 'Human Control: Humanoids', 'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
		array( 'chance' =>  1, 'text' => 'Human Control: Elves/Half-Elves/Humans', 'xp' =>  500, 'gp' => 900, 'link' => 'DMG 125' ),
		array( 'chance' => 20, 'text' => 'Invisibility',             'xp' => 250, 'gp' =>   500, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Invulnerability(F)',       'xp' => 350, 'gp' =>   500, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Levitation',               'xp' => 250, 'gp' =>   400, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Longevity',                'xp' => 500, 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' => 30, 'text' => 'Neutralize Poison',        'xp' => 300, 'gp' =>   500, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Oil of Acid Resistance',   'xp' => 500, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Oil of Disenchantment',    'xp' => 750, 'gp' =>  3500, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Oil of Elemental Invulnerability*', 'xp' => 500, 'gp' => 5000, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Oil of Etherealness',       'xp' => 600, 'gp' =>  1500, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Oil of Fiery Burning',      'xp' => 500, 'gp' =>  4000, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Oil of Fumbling**',         'xp' => '~', 'gp' =>  1000, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Oil of Impact',             'xp' => 750, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Oil of Slipperiness',       'xp' => 400, 'gp' =>   750, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Oil of Timelessness',       'xp' => 500, 'gp' =>  2000, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Philter of Glibness',       'xp' => 500, 'gp' =>  2500, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Philtre of Love',           'xp' => 200, 'gp' =>   300, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Philtre of Persuasiveness', 'xp' => 400, 'gp' =>   850, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Philter of Stammering and Stuttering**', 'xp' => '~', 'gp' => 1500, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Plant Control',             'xp' => 250, 'gp' =>   300, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Polymorph Self',            'xp' => 200, 'gp' =>   350, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Rainbow Hues',              'xp' => 200, 'gp' =>   800, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Speed',                     'xp' => 200, 'gp' =>   450, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Super-Heroism (F)',         'xp' => 450, 'gp' =>   750, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Sweet Water',               'xp' => 200, 'gp' =>   250, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Treasure Finding',          'xp' => 600, 'gp' =>  2000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Ghasts',    'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Ghosts',    'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Ghouls',    'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Shadows',   'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Skeletons', 'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Spectres',  'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Wights',    'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Wraiths',   'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Vampires',  'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Undead Control: Zombies',   'xp' => 700, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Ventriloquism',             'xp' => 200, 'gp' =>   800, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Vitality',                  'xp' => 300, 'gp' =>  2500, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Water Breathing',           'xp' => 400, 'gp' =>   900, 'link' => 'DMG' ),
		array( 'chance' => 35, 'text' => "DM's choice",               'xp' => '~', 'gp' => '~~~', 'link' => '' ),
	);
}

function dnd1e_get_magic_scrolls_table() {
	return array(
		'title' => 'Scrolls:  1d100 - 01-63 M, 64-70 I / 71-93 C, 94-00 D',
		array( 'chance' => 10, 'text' => '1 spell -- 1d4' ),
		array( 'chance' =>  6, 'text' => '1 spell -- 1d6' ),
		array( 'chance' =>  3, 'text' => '1 spell -- (1d8/1d6)+1' ),
		array( 'chance' =>  5, 'text' => '2 spells - 1d4' ),
		array( 'chance' =>  3, 'text' => '2 spells - 1d8/1d6' ),
		array( 'chance' =>  5, 'text' => '3 spells - 1d4' ),
		array( 'chance' =>  3, 'text' => '3 spells - 1d8/1d6' ),
		array( 'chance' =>  4, 'text' => '4 spells - 1d6' ),
		array( 'chance' =>  3, 'text' => '4 spells - 1d8/1d6' ),
		array( 'chance' =>  4, 'text' => '5 spells - 1d6' ),
		array( 'chance' =>  3, 'text' => '5 spells - 1d8/1d6' ),
		array( 'chance' =>  3, 'text' => '6 spells - 1d6' ),
		array( 'chance' =>  2, 'text' => '6 spells - (1d6/1d4)+2' ),
		array( 'chance' =>  3, 'text' => '7 spells - 1d8/1d6' ),
		array( 'chance' =>  2, 'text' => '7 spells - (1d8/1d6)+1' ),
		array( 'chance' =>  1, 'text' => '7 spells - (1d6/1d4)+3' ),
		array( 'chance' =>  2, 'text' => 'Protection - Acid',          'xp' => 2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Cold',          'xp' => 2000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Demons',        'xp' => 2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Devils',        'xp' => 2500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Dragon Breath', 'xp' => 2000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Electricity',   'xp' => 1500, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Protection - Elementals',    'xp' => 1500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Fire',          'xp' => 2000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Gas',           'xp' => 2000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Protection - Lyconthropes',  'xp' => 1000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Magic',         'xp' => 1500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Petrification', 'xp' => 2000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Plants',        'xp' => 1000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Poison',        'xp' => 1000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Possession',    'xp' => 2000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Undead',        'xp' => 1500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Protection - Water',         'xp' => 1500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Curse**' ),
	);
}

function dnd1e_get_magic_rings_table() {
	return array(
		'title' => 'Rings: 1d1000',
		array( 'chance' => 10, 'text' => 'Animal Friendship', 'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Blinking',          'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Chameleon Power',   'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' => 30, 'text' => 'Charisma',          'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 129' ),
		array( 'chance' => 10, 'text' => 'Contrariness: Flying',          'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
		array( 'chance' => 10, 'text' => 'Contrariness: Invisibility',    'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
		array( 'chance' => 10, 'text' => 'Contrariness: Levitation',      'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
		array( 'chance' => 10, 'text' => 'Contrariness: Shocking Grasp',  'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
		array( 'chance' => 10, 'text' => 'Contrariness: Spell Turning',   'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
		array( 'chance' => 10, 'text' => 'Contrariness: Strength(18/00)', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
		array( 'chance' => 60, 'text' => 'Delusion',          'xp' => '~~', 'gp' =>  2000, 'link' => 'DMG 128' ),
		array( 'chance' =>  2, 'text' => 'Djinni Summoning',  'xp' => 3000, 'gp' => 20000, 'link' => 'DMG 128' ),
		array( 'chance' =>  1, 'text' => 'Elemental Command: Air   (Invisibility)',    'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 128' ),
		array( 'chance' =>  1, 'text' => 'Elemental Command: Earth (Feather Falling)', 'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 128-129' ),
		array( 'chance' =>  1, 'text' => 'Elemental Command: Fire  (Fire Resistance)', 'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 128-129' ),
		array( 'chance' =>  1, 'text' => 'Elemental Command: Water (Water Walking)',   'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 128-129' ),
		array( 'chance' => 60, 'text' => 'Feather Falling',   'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
		array( 'chance' => 60, 'text' => 'Fire Resistance',   'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
		array( 'chance' => 30, 'text' => 'Free Action',       'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
		array( 'chance' => 70, 'text' => 'Invisibility',      'xp' => 1500, 'gp' =>  7500, 'link' => 'DMG 129' ),
		array( 'chance' => 20, 'text' => 'Jumping',           'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' => 30, 'text' => 'Mammal Control',    'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
		array( 'chance' => 10, 'text' => 'Mind Shielding',    'xp' =>  500, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' => 70, 'text' => 'Protection +1',     'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
		array( 'chance' => 12, 'text' => 'Protection +2',     'xp' => 2500, 'gp' => 12000, 'link' => 'DMG 129' ),
		array( 'chance' =>  1, 'text' => 'Protection +2, 5-foot radius protection',  'xp' => 3000, 'gp' => 15000, 'link' => 'DMG 129' ),
		array( 'chance' =>  7, 'text' => 'Protection +3',     'xp' => 4000, 'gp' => 20000, 'link' => 'DMG 129' ),
		array( 'chance' =>  1, 'text' => 'Protection +3, 5-foot radius protection',  'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 129' ),
		array( 'chance' =>  6, 'text' => 'Protection +4 on AC, +2 to saving throws', 'xp' => 4800, 'gp' => 24000, 'link' => 'DMG 129' ),
		array( 'chance' =>  3, 'text' => 'Protection +6 on AC, +1 to saving throws', 'xp' => 6000, 'gp' => 30000, 'link' => 'DMG 129' ),
		array( 'chance' => 10, 'text' => 'Ram, Ring of the*',       'xp' =>  750, 'gp' =>  7500, 'link' => '' ),
		array( 'chance' =>  9, 'text' => 'Regeneration (1hp/rd)',   'xp' => 5000, 'gp' => 40000, 'link' => 'DMG 129' ),
		array( 'chance' =>  1, 'text' => 'Regeneration (vampiric)', 'xp' => 5000, 'gp' => 40000, 'link' => 'DMG 129' ),
		array( 'chance' => 10, 'text' => 'Shocking Grasp',          'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Shooting Stars',          'xp' => 3000, 'gp' => 15000, 'link' => 'DMG 129-130' ),
		array( 'chance' => 20, 'text' => 'Spell Storing (1d4+2)',   'xp' => 2500, 'gp' => 22500, 'link' => 'DMG 130' ),
		array( 'chance' => 40, 'text' => 'Spell Turning',           'xp' => 2000, 'gp' => 17500, 'link' => 'DMG 130' ),
		array( 'chance' => 15, 'text' => 'Sustenance',              'xp' =>  500, 'gp' =>  3500, 'link' => '' ),
		array( 'chance' => 60, 'text' => 'Swimming',                'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 130' ),
		array( 'chance' =>  5, 'text' => 'Telekinesis: 25 lbs',     'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
		array( 'chance' =>  5, 'text' => 'Telekinesis: 50 lbs',     'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
		array( 'chance' =>  4, 'text' => 'Telekinesis: 100 lbs',    'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
		array( 'chance' =>  2, 'text' => 'Telekinesis: 200 lbs',    'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
		array( 'chance' =>  1, 'text' => 'Telekinesis: 400 lbs',    'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
		array( 'chance' => 10, 'text' => 'Truth',                   'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' => 60, 'text' => 'Warmth',                  'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG' ),
		array( 'chance' => 50, 'text' => 'Water Walking',           'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 131' ),
		array( 'chance' => 80, 'text' => 'Weakness',                'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 131' ),
		array( 'chance' =>  4, 'text' => 'Wishes, Multiple (2d4)',  'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 129' ),
		array( 'chance' =>  8, 'text' => 'Wishes, Three',           'xp' => 3000, 'gp' => 15000, 'link' => 'DMG 130' ),
		array( 'chance' => 10, 'text' => 'Wizardry* (MU)',          'xp' => 4000, 'gp' => 50000, 'link' => 'DMG 131' ),
		array( 'chance' => 10, 'text' => 'X-Ray Vision',            'xp' => 4000, 'gp' => 35000, 'link' => 'DMG 131' ),
	);
}

function dnd1e_get_magic_rods_table() {
	return array(
		'title' => 'Rods',
		array( 'chance' => 10, 'text' => 'Absorption (C,MU)',     'xp' =>  7500, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Alertness',             'xp' =>  7000, 'gp' => 50000, 'link' => '' ),
		array( 'chance' =>  3, 'text' => 'Beguiling (C,MU,T)',    'xp' =>  5000, 'gp' => 30000, 'link' => 'DMG' ),
		array( 'chance' => 29, 'text' => 'Cancellation',          'xp' => 10000, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Rod of Captivation',    'xp' =>  5000, 'gp' => 30000, 'link' => 'OS 321' ),
		array( 'chance' =>  5, 'text' => 'Flailing',              'xp' =>  2000, 'gp' => 20000, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Lordly Might (F)',      'xp' =>  6000, 'gp' => 20000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Passage',               'xp' =>  5000, 'gp' => 50000, 'link' => '' ),
		array( 'chance' =>  5, 'text' => 'Resurrection (C)',      'xp' => 10000, 'gp' => 35000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Rulership',             'xp' =>  8000, 'gp' => 35000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Scepter of Entrapment', 'xp' =>  3000, 'gp' => 45000, 'link' => 'http://flockhart.virtualave.net/afal/ScepterEntrapment.html' ),
		array( 'chance' =>  6, 'text' => 'Security',              'xp' =>  3000, 'gp' => 30000, 'link' => '' ),
		array( 'chance' =>  5, 'text' => 'Smiting (C,MU)',        'xp' =>  4000, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Splendor',              'xp' =>  2500, 'gp' => 25000, 'link' => '' ),
		array( 'chance' =>  6, 'text' => 'Terror',                'xp' =>  3000, 'gp' => 15000, 'link' => '' ),
		'note0' => 'Charges: 50 - ( 1d10 - 1 )',
	);
}

function dnd1e_get_magic_staves_table() {
	return array(
		'title' => 'Staves',
		array( 'chance' =>  5, 'text' => 'Command (C,M)',       'xp' =>  5000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Curing (C)',          'xp' =>  6000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Mace',                'xp' =>  1500, 'gp' => 12500, 'link' => '' ),
		array( 'chance' =>  5, 'text' => 'Magi (M)',            'xp' => 15000, 'gp' => 75000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Power (M)',           'xp' => 12000, 'gp' => 60000, 'link' => 'DMG' ),
		array( 'chance' => 15, 'text' => 'Serpent (C)',         'xp' =>  7000, 'gp' => 35000, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Slinging (Priest)',   'xp' =>  2000, 'gp' => 10000, 'link' => '' ),
		array( 'chance' => 20, 'text' => 'Striking (C,M)',      'xp' =>  6000, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Thunder & Lightning', 'xp' =>  8000, 'gp' => 20000, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Withering',           'xp' =>  8000, 'gp' => 35000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Woodlands (D)',       'xp' =>  8000, 'gp' => 40000, 'link' => '' ),
		'note0' => 'Charges: 25 - ( 1d6 - 1 )',
	);
}

function dnd1e_get_magic_wands_table() {
	return array(
		'title' => 'Wands',
		array( 'chance' =>  2, 'text' => 'Conjuration (M)',           'xp' => 7000, 'gp' => 35000, 'link' => 'DMG' ),
#		array( 'chance' => 30, 'text' => 'Earth and Stone 	1,000 	10,000-15,000', 'xp' => 1000, 'gp' => , 'link' => '' ),
		array( 'chance' =>  5, 'text' => 'Enemy Detection',           'xp' => 2000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Fear (C,M)',                'xp' => 3000, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Fire (M)',                  'xp' => 4500, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Flame Extinguishing',       'xp' => 1500, 'gp' => 10000, 'link' => '' ),
		array( 'chance' =>  4, 'text' => 'Frost (M)',                 'xp' => 6000, 'gp' => 50000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Illumination',              'xp' => 2000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Illusion (M)',              'xp' => 3000, 'gp' => 20000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Lightning (M)',             'xp' => 4000, 'gp' => 30000, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Magic Detection',           'xp' => 2500, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Magic Missiles',            'xp' => 4000, 'gp' => 35000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Metal/Mineral Detection',   'xp' => 1500, 'gp' =>  7500, 'link' => 'DMG' ),
		array( 'chance' => 11, 'text' => 'Negation',                  'xp' => 3500, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Paralyzation (M)',          'xp' => 3500, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Polymorphing (M)',          'xp' => 3500, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Secret Door/Trap Location', 'xp' => 5000, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Size Alteration',           'xp' => 3000, 'gp' => 20000, 'link' => '' ),
		array( 'chance' =>  8, 'text' => 'Wonder',                    'xp' => 6000, 'gp' => 10000, 'link' => 'DMG' ),
		'note0' => 'Charges: 100 - ( 1d20 - 1 )',
	);
}

function dnd1e_get_magic_books_tomes_table() {
	return array(
		'title' => 'Books, Librams, Manuals, and Tomes',
		array( 'chance' => 15, 'text' => "Boccob's Blessed Book (M)",            'xp' => 4500, 'gp' => 35000, 'link' => '' ),
		array( 'chance' =>  5, 'text' => 'Book of Exalted Deeds (C)',            'xp' => 8000, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Book of Infinite Spells',              'xp' => 9000, 'gp' => 50000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Book of Vile Darkness (C)',            'xp' => 8000, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Libram of Gainful Conjuration (M)',    'xp' => 8000, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Libram of Ineffable Damnation (M)',    'xp' => 8000, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Libram of Silver Magic (M)',           'xp' => 8000, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Manual of Bodily Health',              'xp' => 5000, 'gp' => 50000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Manual of Gainful Exercise',           'xp' => 5000, 'gp' => 50000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Manual of Golems (C,M)',               'xp' => 3000, 'gp' => 30000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Manual of Puissant Skill at Arms (F)', 'xp' => 8000, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Manual of Quickness in Action',        'xp' => 5000, 'gp' => 50000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Manual of Stealthy Pilfering (T)',     'xp' => 8000, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Tome of Clear Thought',                'xp' => 8000, 'gp' => 48000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Tome of Leadership and Influence',     'xp' => 7500, 'gp' => 40000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Tome of Understanding',                'xp' => 8000, 'gp' => 43500, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Vacuous Grimoire',                     'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
	);
}

function dnd1e_get_magic_jewels_jewelry_table() {
	return array(
		'title' => 'Jewels, Jewelry, and Phylacteries',
		array( 'chance' =>  2, 'text' => 'Amulet of Inescapable Location',             'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Amulet of Life Protection',                  'xp' => 5000, 'gp' => 20000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Amulet of the Planes',                       'xp' => 6000, 'gp' => 30000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Amulet of Proof Against Detection/Location', 'xp' => 4000, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Amulet Versus Undead: C5',                   'xp' => 1000, 'gp' =>  1000, 'link' => 'https://something-s-rotten-in-faerun.obsidianportal.com/items/amulet-versus-undead' ),
		array( 'chance' =>  1, 'text' => 'Beads of Force (1d4+4)',                     'xp' =>  200, 'gp' =>  1000, 'link' => 'https://roll20.net/compendium/dnd5e/Bead of Force' ),
		array( 'chance' =>  7, 'text' => 'Brooch of Shielding',                        'xp' => 1000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Gem of Brightness',                          'xp' => 2000, 'gp' => 17500, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Gem of Insight',                             'xp' => 3000, 'gp' => 30000, 'link' => 'https://www.tradingcarddb.com/GalleryP.cfm/pid/194938/-Gem-of-Insight' ),
		array( 'chance' =>  1, 'text' => 'Gem of Seeing',                              'xp' => 2000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Jewel of Attacks',                           'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Jewel of Flawlessness',                      'xp' => '~~', 'gp' => '1000/facet', 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Medallion of ESP',                           'xp' => 2000, 'gp' => 20000, 'link' => 'DMG 149' ),
		array( 'chance' =>  2, 'text' => 'Medallion of Thought Projection',            'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Necklace of Adaptation',                     'xp' => 1000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Necklace of Missiles (special)',             'xp' => '100/missile', 'gp' => '200/missile', 'link' => 'DMG 149' ),
		array( 'chance' =>  6, 'text' => 'Necklace of Prayer Beads (C) (special)',     'xp' => '500/bead', 'gp' => '3000/bead', 'link' => 'DMG 149' ),
		array( 'chance' =>  2, 'text' => 'Necklace of Strangulation',                  'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Pearl of Power* (M)',                        'xp' =>  200, 'gp' =>  2000, 'link' => 'DMG 150' ),
		array( 'chance' =>  1, 'text' => 'Pearl of the Sirines',                       'xp' =>  900, 'gp' =>  4500, 'link' => 'https://www.dandwiki.com/wiki/SRD:Pearl_of_the_Sirenes' ),
		array( 'chance' =>  2, 'text' => 'Pearl of Wisdom (C)',                        'xp' =>  500, 'gp' =>  5000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Periapt of Foul Rotting',                    'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Periapt of Health',                          'xp' => 1000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  7, 'text' => 'Periapt of Proof Against Poison',            'xp' => 1500, 'gp' => 12500, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Periapt of Wound Closure',                   'xp' => 1000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Phylactery of Faithfulness (C)',             'xp' => 1000, 'gp' =>  7500, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Phylactery of Long Years (C)',               'xp' => 3000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Phylactery of Monstrous Attention (C)',      'xp' => '~~', 'gp' =>  2000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Scarab of Death',                            'xp' => '~~', 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Scarab of Enraging Enemies',                 'xp' => 1000, 'gp' =>  8000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Scarab of Insanity',                         'xp' => 1500, 'gp' => 11000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Scarab of Protection',                       'xp' => 2500, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Scarab Versus Golems**',                     'xp' => '**', 'gp' => 15000, 'link' => 'http://worldofmor.us/rules/DMG/DD01048.htm' ),
		array( 'chance' =>  3, 'text' => 'Talisman of Pure Good (C)',                  'xp' => 3500, 'gp' => 27500, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Talisman of the Sphere (M)',                 'xp' =>  100, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Talisman of Ultimate Evil (C)',              'xp' => 3500, 'gp' => 32500, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Talisman of Zagy',                           'xp' => 1000, 'gp' => 10000, 'link' => 'DMG' ),
		'note01' => ' * roll % for effect - see description',
		'note02' => '** roll 1d20: 1-6 Flesh 400xp, 7-11 Clay 500xp, 12-15 Stone 600xp, 16-17 Iron 800xp, 18-19 Flesh/Clay/Wood 900xp, 20 Any golem 1,250xp',
	);
}

function dnd1e_get_magic_cloaks_robes_table() {
	return array(
		'title' => 'Cloaks and Robes',
		array( 'chance' =>  4, 'text' => 'Cloak of Arachnida',                 'xp' => 3000, 'gp' => 25000, 'link' => '' ),
		array( 'chance' =>  4, 'text' => 'Cloak of Displacement',              'xp' => 3000, 'gp' => 17500, 'link' => 'DMG' ),
		array( 'chance' =>  9, 'text' => 'Cloak of Elvenkind',                 'xp' => 1000, 'gp' =>  6000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Cloak of Manta Ray',                 'xp' => 2000, 'gp' => 12500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Cloak of Poisonousness',             'xp' => '~~', 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' => 15, 'text' => 'Cloak of Protection +1',             'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 140' ),
		array( 'chance' => 12, 'text' => 'Cloak of Protection +2',             'xp' => 2000, 'gp' => 20000, 'link' => 'DMG 140' ),
		array( 'chance' =>  8, 'text' => 'Cloak of Protection +3',             'xp' => 3000, 'gp' => 30000, 'link' => 'DMG 140' ),
		array( 'chance' =>  4, 'text' => 'Cloak of Protection +4',             'xp' => 4000, 'gp' => 40000, 'link' => 'DMG 140' ),
		array( 'chance' =>  2, 'text' => 'Cloak of Protection +5',             'xp' => 5000, 'gp' => 50000, 'link' => 'DMG 140' ),
		array( 'chance' =>  9, 'text' => 'Cloak of the Bat',                   'xp' => 1500, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Robe of the Archmagi (M)',           'xp' => 6000, 'gp' => 65000, 'link' => 'DMG' ),
		array( 'chance' =>  7, 'text' => 'Robe of Blending',                   'xp' => 3500, 'gp' => 35000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Robe of Eyes (M)',                   'xp' => 4500, 'gp' => 50000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Robe of Powerlessness (M)',          'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Robe of Scintillating Colors (C,M)', 'xp' => 2750, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Robe of Stars (M)',                  'xp' => 4000, 'gp' => 12000, 'link' => '' ),
		array( 'chance' =>  8, 'text' => 'Robe of Useful Items (M)',           'xp' => 1500, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Robe of Vermin (M)',                 'xp' => '~~', 'gp' =>  1000, 'link' => '' ),
	);
}

function dnd1e_get_magic_boots_gloves_table() {
	return array(
		'title' => 'Boots, Bracers, and Gloves',
		array( 'chance' =>  2, 'text' => 'Boots of Dancing',                       'xp' => '~~', 'gp' =>  5000, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Boots of Elvenkind',                     'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG' ),
		array( 'chance' =>  8, 'text' => 'Boots of Levitation',                    'xp' => 2000, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  7, 'text' => 'Boots of Speed',                         'xp' => 2500, 'gp' => 20000, 'link' => 'DMG' ),
		array( 'chance' =>  7, 'text' => 'Boots of Striding and Springing',        'xp' => 2500, 'gp' => 20000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Boots of the North',                     'xp' => 1500, 'gp' =>  7500, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Boots of Varied Tracks',                 'xp' => 1500, 'gp' =>  7500, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Boots, Winged',                          'xp' => 2000, 'gp' => 20000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Bracers of Archery (F)',                 'xp' => 1000, 'gp' => 10000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Bracers of Brachiation',                 'xp' => 1000, 'gp' => 10000, 'link' => '' ),
		array( 'chance' =>  2, 'text' => 'Bracers of Defense AC 8',                'xp' =>  500, 'gp' =>  3000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Bracers of Defense AC 7',                'xp' => 1000, 'gp' =>  6000, 'link' => 'DMG' ),
		array( 'chance' =>  7, 'text' => 'Bracers of Defense AC 6',                'xp' => 1500, 'gp' =>  9000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Bracers of Defense AC 5',                'xp' => 2000, 'gp' => 12000, 'link' => 'DMG' ),
		array( 'chance' =>  7, 'text' => 'Bracers of Defense AC 4',                'xp' => 2500, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Bracers of Defense AC 3',                'xp' => 3000, 'gp' => 18000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Bracers of Defense AC 2',                'xp' => 3500, 'gp' => 21000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Bracers of Defenselessness',             'xp' => '~~', 'gp' =>  2000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Gauntlets of Dexterity',                 'xp' => 1000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Gauntets of Fumbling',                   'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Gauntlets of Ogre Power (C,T,F)',        'xp' => 1000, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Gauntlets of Swimming/Climbing (C,T,F)', 'xp' => 1000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Gloves of Missile Snaring',              'xp' => 1500, 'gp' => 10000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Slippers of Spider Climbing',            'xp' => 1000, 'gp' => 10000, 'link' => '' ),
	);
}

function dnd1e_get_magic_girdles_helms_table() {
	return array(
		array( 'chance' =>  1, 'text' => 'Girdle of Dwarvenkind',                    'xp' => 3500, 'gp' => 20000, 'link' => '' ),
		array( 'chance' =>  5, 'text' => 'Girdle of Femininity/Masculinity (C,T,F)', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Girdle of Hill Giant Strength (C,T,F)',    'xp' => 2000, 'gp' => 25000, 'link' => 'DMG 144' ),
		array( 'chance' =>  4, 'text' => 'Girdle of Stone Giant Strength (C,T,F)',   'xp' => 2000, 'gp' => 25000, 'link' => 'DMG 144' ),
		array( 'chance' =>  4, 'text' => 'Girdle of Frost Giant Strength (C,T,F)',   'xp' => 2000, 'gp' => 25000, 'link' => 'DMG 144' ),
		array( 'chance' =>  3, 'text' => 'Girdle of Fire Giant Strength (C,T,F)',    'xp' => 2000, 'gp' => 25000, 'link' => 'DMG 144' ),
		array( 'chance' =>  2, 'text' => 'Girdle of Cloud Giant Strength (C,T,F)',   'xp' => 2000, 'gp' => 25000, 'link' => 'DMG 144' ),
		array( 'chance' =>  1, 'text' => 'Girdle of Storm Giant Strength (C,T,F)',   'xp' => 2000, 'gp' => 25000, 'link' => 'DMG 144' ),
		array( 'chance' =>  1, 'text' => 'Girdle of Many Pouches',     'xp' => 1000, 'gp' => 10000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Hat of Disguise',            'xp' => 1000, 'gp' =>  7500, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Hat of Stupidity',           'xp' => '~~', 'gp' =>  1000, 'link' => '' ),
		array( 'chance' =>  5, 'text' => 'Helm of Brilliance',         'xp' => 2500, 'gp' => 60000, 'link' => 'DMG' ),
		array( 'chance' => 21, 'text' => 'Helm of Comprehending Languages and Reading Magic', 'xp' => 1000, 'gp' => 12500, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Helm of Opposite Alignment', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Helm of Telepathy',          'xp' => 3000, 'gp' => 35000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Helm of Teleportation',      'xp' => 2500, 'gp' => 30000, 'link' => 'DMG' ),
		array( 'chance' => 20, 'text' => 'Helm of Underwater Action',  'xp' => 1000, 'gp' => 10000, 'link' => 'DMG' ),
	);
}

function dnd1e_get_magic_bags_bottles_table() {
	return array(
		'title' => 'Bags, Bottles, Pouches, and Containers',
		array( 'chance' =>  6, 'text' => 'Alchemy Jug',        'xp' => 3000, 'gp' => 12000, 'link' => 'DMG' ),
		array( 'chance' =>  9, 'text' => 'Bag of Beans',       'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Bag of Devouring',   'xp' => '~~', 'gp' =>  1500, 'link' => 'DMG' ),
		array( 'chance' => 15, 'text' => 'Bag of Holding',     'xp' => 5000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Bag of Transmuting', 'xp' => '~~', 'gp' =>   500, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Bag of Tricks',      'xp' => 2500, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Beaker of Plentiful Potions',           'xp' => 1500, 'gp' => 12500, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => "Bucknard's Everfull Purse sp/ep/gp*",   'xp' => 1500, 'gp' => 15000, 'link' => 'DMG 139' ),
		array( 'chance' =>  8, 'text' => "Bucknard's Everfull Purse cp/ep/pp*",   'xp' => 2500, 'gp' => 25000, 'link' => 'DMG 139' ),
		array( 'chance' =>  2, 'text' => "Bucknard's Everfull Purse cp/ep/gems*", 'xp' => 4000, 'gp' => 40000, 'link' => 'DMG 139' ),
		array( 'chance' =>  9, 'text' => 'Decanter of Endless Water', 'xp' => 1000, 'gp' =>  3000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Efreeti Bottle',            'xp' => 9000, 'gp' => 45000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Eversmoking Bottle',        'xp' =>  500, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Flask of Curses',           'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => "Heward's Handy Haversack",  'xp' => 3000, 'gp' => 30000, 'link' => '' ),
		array( 'chance' =>  6, 'text' => 'Iron Flask',                'xp' => '~~', 'gp' => '~~~', 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Portable Hole',             'xp' => 5000, 'gp' => 50000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Pouch of Accessibility',    'xp' => 1500, 'gp' => 12500, 'link' => '' ),
		array( 'chance' =>  3, 'text' => "DM's choice",               'xp' => '~~', 'gp' => '~~~', 'link' => '' ),
		'note1' => '* 26 of each type listed, gems are base 10gp.',
	);
}

function dnd1e_get_magic_dusts_stones_table() {
	return array(
		'title' => 'Candles, Dusts, Ointments, Incense, and Stones',
		array( 'chance' => 10, 'text' => 'Candle of Invocation (C)',       'xp' => 1000, 'gp' => 5000, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Dust of Appearance',             'xp' => 1000, 'gp' => 4000, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Dust of Disappearance',          'xp' => 2000, 'gp' => 8000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Dust of Dryness',                'xp' => 1000, 'gp' => 8000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Dust of Illusion*',              'xp' => 1000, 'gp' => '100', 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Dust of Tracelessness*',         'xp' => 500, 'gp' => '200', 'link' => '' ),
		array( 'chance' =>  2, 'text' => 'Dust of Sneezing and Choking',   'xp' => '~~', 'gp' => 1000, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Incense of Meditation (C)',      'xp' => 500, 'gp' => 7500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Incense of Obsession (C)',       'xp' => '~~', 'gp' => 500, 'link' => 'DMG' ),
		array( 'chance' => 14, 'text' => 'Ioun Stones**',                  'xp' => 300, 'gp' => 5000, 'link' => 'DMG 146' ),
		array( 'chance' => 16, 'text' => "Keoghtom's Ointment",            'xp' => 500, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => "Nolzur's Marvelous Pigments***", 'xp' => 500, 'gp' => 3000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => "Philosopher's Stone",            'xp' => 1000, 'gp' => 10000, 'link' => '' ),
#		array( 'chance' =>  1, 'text' => 'Smoke Powder***',                'xp' => '~~', 'gp' => 30000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Sovereign Glue****',             'xp' => 1000, 'gp' => 1000, 'link' => '' ),
		array( 'chance' =>  4, 'text' => 'Stone of Controlling Earth Elementals', 'xp' => 1500, 'gp' => 12500, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Stone of Good Luck (Luckstone)', 'xp' => 3000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Stone of Weight (Loadstone)',    'xp' => '~~', 'gp' => 1000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Universal Solvent',              'xp' => 1000, 'gp' => 7000, 'link' => '' ),
		'note1' => '   * 1d20 pinches will be found, gp is per pinch.',
		'note2' => '  ** 1d10 stones will be found, xp/gp is per stone, roll type for each stone',
		'note3' => ' *** 1d4 pots will be found, xp/gp is per pot.',
		'note4' => '**** 1d6 ounces will be found, xp/gp is per ounce.',
	);
}

function dnd1e_get_magic_items_tools_table() {
		return array(
		'title' => 'Household Items and Tools',
		array( 'chance' =>  8, 'text' => 'Bowl Commanding Water Elementals (M)',   'xp' => 4000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Bowl of Watery Death (M)',               'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  8, 'text' => 'Brazier Commanding Fire Elementals (M)', 'xp' => 4000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Brazier of Sleep Smoke (M)',             'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Broom of Animated Attack',               'xp' => '~~', 'gp' =>  3000, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Broom of Flying',                        'xp' => 2000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Carpet of Flying',                       'xp' => 7500, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  8, 'text' => 'Censer Controlling Air Elementals (M)',  'xp' => 4000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Censer of Summoning Hostile Air Elementals (M)', 'xp' => '~~', 'gp' => 1000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Mattock of the Titans (F)',        'xp' => 3500, 'gp' =>  7000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Maul of the Titans (F)',           'xp' => 4000, 'gp' => 12000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Mirror of Life Trapping (M)',      'xp' => 2500, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Mirror of Mental Prowess',         'xp' => 5000, 'gp' => 50000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Mirror of Opposition',             'xp' => '~~', 'gp' =>  2000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => "Murlynd's Spoon",                  'xp' =>  750, 'gp' =>  4000, 'link' => '' ),
		array( 'chance' => 14, 'text' => 'Rope of Climbing',                 'xp' => 1000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Rope of Constriction',             'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG' ),
		array( 'chance' => 10, 'text' => 'Rope of Entanglement',             'xp' => 1500, 'gp' => 12000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Rug of Smothering',                'xp' => '~~', 'gp' =>  1500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Rug of Welcome (M)',               'xp' => 6500, 'gp' => 45000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Saw of Mighty Cutting (F)',        'xp' => 2000, 'gp' => 12500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Spade of Colossal Excavation (F)', 'xp' => 1000, 'gp' =>  6500, 'link' => 'DMG' ),
	);
}

function dnd1e_get_magic_instruments_table() {
	return array(
		'title' => 'Musical Instruments',
#		array( 'chance' =>  1, 'text' => 'Anstruth Harp (B)',         'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 147-148' ),
		array( 'chance' =>  1, 'text' => 'Canaith Mandolin (B)',      'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 147-148' ),
		array( 'chance' =>  3, 'text' => 'Chime of Interruption',     'xp' => 2000, 'gp' => 20000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Chime of Opening',          'xp' => 3500, 'gp' => 20000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Chime of Hunger',           'xp' => '~~', 'gp' => '~~~', 'link' => 'DMG' ),
#		array( 'chance' =>  1, 'text' => 'Cli Lyre (B)',              'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 147-148' ),
		array( 'chance' =>  1, 'text' => 'Doss Lute (B)',             'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 147-148' ),
		array( 'chance' =>  3, 'text' => 'Drums of Deafening',        'xp' => '~~', 'gp' =>   500, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Drums of Panic',            'xp' => 6500, 'gp' => 35000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Fochlucan Bandore (B)',     'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 147-148' ),
		array( 'chance' =>  1, 'text' => 'Harp of Charming',          'xp' => 5000, 'gp' => 25000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Harp of Discord',           'xp' => '~~', 'gp' => 20000, 'link' => '' ),
		array( 'chance' =>  3, 'text' => 'Horn of Blasting',          'xp' => 1000, 'gp' => 55000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Horn of Bubbles',           'xp' => '~~', 'gp' => '~~~', 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Horn of Collapsing',        'xp' => 1500, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Horn of Fog',               'xp' =>  400, 'gp' =>  4000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Horn of Goodness (Evil)',   'xp' =>  750, 'gp' =>  3250, 'link' => '' ),
		array( 'chance' => 12, 'text' => 'Horn of the Tritons (C,F)', 'xp' => 2000, 'gp' => 17500, 'link' => 'DMG' ),
		array( 'chance' => 21, 'text' => 'Horn of Valhalla',          'xp' => 1000, 'gp' => 15000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Lyre of Building',          'xp' => 5000, 'gp' => 30000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Mac-Fuirmidh Cittern (B)',  'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 147-148' ),
#		array( 'chance' =>  1, 'text' => 'Ollamh Harp (B)',           'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 147-148' ),
		array( 'chance' =>  3, 'text' => 'Pipes of Haunting',         'xp' =>  400, 'gp' =>  5000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Pipes of Pain',             'xp' => '~~', 'gp' => 10000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Pipes of Sounding',         'xp' => 1000, 'gp' => 10000, 'link' => '' ),
		array( 'chance' => 18, 'text' => 'Pipes of the Sewers',       'xp' => 2000, 'gp' =>  8500, 'link' => 'DMG' ),
	);
} //*/

function dnd1e_get_magic_weird_stuff_table() {
	return array(
		'title' => 'The Weird Stuff',
		array( 'chance' =>  2, 'text' => 'Apparatus of Kwalish',        'xp' => 8000, 'gp' => 35000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Boat, Folding',               'xp' => 10000, 'gp' => 25000, 'link' => 'DMG' ),
		array( 'chance' =>  5, 'text' => 'Crystal Ball (M)',            'xp' => 1000, 'gp' => 5000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Crystal Hypnosis Ball (M)',   'xp' => '~~', 'gp' => 3000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Cube of Force',               'xp' => 3000, 'gp' => 20000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Cube of Frost Resistance',    'xp' => 2000, 'gp' => 14000, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => 'Cubic Gate',                  'xp' => 5000, 'gp' => 17500, 'link' => 'DMG' ),
		array( 'chance' =>  2, 'text' => "Daern's Instant Fortress",    'xp' => 7000, 'gp' => 27500, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Deck of Illusions',           'xp' => 1500, 'gp' => 15000, 'link' => '' ),
		array( 'chance' =>  4, 'text' => 'Deck of Many Things',         'xp' => '~~', 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  4, 'text' => 'Eyes of Charming (M)',        'xp' => 4000, 'gp' => 24000, 'link' => 'DMG' ),
		array( 'chance' =>  7, 'text' => 'Eyes of Minute Seeing',       'xp' => 2000, 'gp' => 12500, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Eyes of the Basilisk',        'xp' => 12500, 'gp' => 50000, 'link' => 'DMG 143' ),
		array( 'chance' =>  7, 'text' => 'Eyes of the Eagle',           'xp' => 3500, 'gp' => 18000, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Eyes of the Gorgon',          'xp' => '~~', 'gp' => '~~', 'link' => 'DMG 143' ),
		array( 'chance' => 15, 'text' => 'Figurine of Wondrous Power*', 'xp' => 100, 'gp' => 1000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Glowing Globe',               'xp' => 100, 'gp' => 200, 'link' => 'http://flockhart.virtualave.net/afal/glowingglobe.html' ),
		array( 'chance' =>  2, 'text' => 'Horseshoes of a Zephyr',      'xp' => 1500, 'gp' => 7500, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Horseshoes of Speed',         'xp' => 2000, 'gp' => 10000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Iron Bands of Bilarro',       'xp' => 750, 'gp' => 5000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Lens of Detection',           'xp' => 250, 'gp' => 1500, 'link' => '' ),
		array( 'chance' => 15, 'text' => "Quaal's Feather Token**",     'xp' => 1000, 'gp' => '2000', 'link' => 'DMG 151' ),
		array( 'chance' =>  1, 'text' => 'Quiver of Ehlonna',           'xp' => 1500, 'gp' => 10000, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Sheet of Smallness',          'xp' => 1500, 'gp' => 12500, 'link' => '' ),
		array( 'chance' =>  1, 'text' => 'Sphere of Annihilation',      'xp' => 4000, 'gp' => 30000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Stone Horse',                 'xp' => 2000, 'gp' => 12000, 'link' => '' ),
		array( 'chance' =>  3, 'text' => 'Well of Many Worlds',         'xp' => 6000, 'gp' => 12000, 'link' => 'DMG' ),
		array( 'chance' =>  1, 'text' => 'Wind Fan',                    'xp' => 500, 'gp' => 2500, 'link' => '' ),
		array( 'chance' => 10, 'text' => 'Wings of Flying',             'xp' => 750, 'gp' => 7500, 'link' => 'DMG' ),
		'note1' => ' * roll % for type, xp/gp is per hit die of figurine.',
		'note2' => '** roll 1d20 for type of token.',
	);
}

function dnd1e_get_magic_armor_shields_table() {
	return array(
		'title' => 'Armor and Shields: 1d1000',
		array( 'chance' => 24, 'text' => 'Banded +1',       'xp' =>  700, 'gp' =>   4000, 'link' => 'DMG' ),
		array( 'chance' => 18, 'text' => 'Banded +2',       'xp' => 1500, 'gp' =>   8500, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Banded +3',       'xp' => 2250, 'gp' =>  14500, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Banded +4',       'xp' => 3000, 'gp' =>  19000, 'link' => 'DMG' ),
		array( 'chance' => 30, 'text' => 'Brigandine +1',   'xp' =>  500, 'gp' =>   3000, 'link' => '' ),
		array( 'chance' => 18, 'text' => 'Brigandine +2',   'xp' => 1100, 'gp' =>   6750, 'link' => '' ),
		array( 'chance' =>  6, 'text' => 'Brigandine +3',   'xp' => 1650, 'gp' =>  10500, 'link' => '' ),
		array( 'chance' => 24, 'text' => 'Bronze Plate +1', 'xp' =>  700, 'gp' =>   4500, 'link' => 'DMG' ),
		array( 'chance' => 18, 'text' => 'Bronze Plate +2', 'xp' => 1500, 'gp' =>   9500, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Bronze Plate +3', 'xp' => 2250, 'gp' =>  15000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Bronze Plate +4', 'xp' => 3000, 'gp' =>  19500, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Bronze Plate +5', 'xp' => 3750, 'gp' =>  25500, 'link' => 'DMG' ),
		array( 'chance' => 30, 'text' => 'Chain Mail +1',   'xp' =>  600, 'gp' =>   3500, 'link' => 'DMG' ),
		array( 'chance' => 24, 'text' => 'Chain Mail +2',   'xp' => 1200, 'gp' =>   7500, 'link' => 'DMG' ),
		array( 'chance' => 18, 'text' => 'Chain Mail +3',   'xp' => 2000, 'gp' =>  12500, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Chain Mail +4',   'xp' => 4000, 'gp' =>  16500, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Chain Mail +5',   'xp' => 6000, 'gp' =>  20500, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Field Plate +1',  'xp' =>  900, 'gp' =>  15000, 'link' => 'UA' ),
		array( 'chance' => 10, 'text' => 'Field Plate +2',  'xp' => 1800, 'gp' =>  30000, 'link' => 'UA' ),
		array( 'chance' =>  8, 'text' => 'Field Plate +3',  'xp' => 2700, 'gp' =>  50000, 'link' => 'UA' ),
		array( 'chance' =>  4, 'text' => 'Field Plate +4',  'xp' => 3600, 'gp' =>  80000, 'link' => 'UA' ),
		array( 'chance' =>  2, 'text' => 'Field Plate +5',  'xp' => 4800, 'gp' => 120000, 'link' => 'UA' ),
		array( 'chance' =>  6, 'text' => 'Full Plate +1',   'xp' => 1000, 'gp' =>  30000, 'link' => 'UA' ),
		array( 'chance' =>  5, 'text' => 'Full Plate +2',   'xp' => 2000, 'gp' =>  50000, 'link' => 'UA' ),
		array( 'chance' =>  4, 'text' => 'Full Plate +3',   'xp' => 3000, 'gp' =>  80000, 'link' => 'UA' ),
		array( 'chance' =>  2, 'text' => 'Full Plate +4',   'xp' => 4000, 'gp' => 120000, 'link' => 'UA' ),
		array( 'chance' =>  1, 'text' => 'Full Plate +5',   'xp' => 5000, 'gp' => 200000, 'link' => 'UA' ),
		array( 'chance' => 48, 'text' => 'Leather +1',      'xp' =>  300, 'gp' =>   2000, 'link' => 'DMG' ),
		array( 'chance' => 36, 'text' => 'Leather +2',      'xp' =>  600, 'gp' =>   5000, 'link' => 'DMG' ),
		array( 'chance' => 24, 'text' => 'Leather +3',      'xp' => 1000, 'gp' =>  10000, 'link' => 'DMG' ),
		array( 'chance' => 18, 'text' => 'Plate Mail +1',   'xp' =>  800, 'gp' =>   5000, 'link' => 'DMG' ),
		array( 'chance' => 15, 'text' => 'Plate Mail +2',   'xp' => 1750, 'gp' =>  10500, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Plate Mail +3',   'xp' => 2750, 'gp' =>  15500, 'link' => 'DMG' ),
		array( 'chance' =>  9, 'text' => 'Plate Mail +4',   'xp' => 3500, 'gp' =>  20500, 'link' => 'DMG' ),
		array( 'chance' =>  3, 'text' => 'Plate Mail +5',   'xp' => 4500, 'gp' =>  27500, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Plate Mail of Etherealness',  'xp' => 5000, 'gp' => 30000, 'link' => 'DMG' ),
		array( 'chance' => 30, 'text' => 'Plate Mail of Vulnerability', 'xp' => '~~', 'gp' =>  1500, 'link' => 'DMG' ),
		array( 'chance' => 42, 'text' => 'Ring Mail +1',       'xp' =>  400, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' => 28, 'text' => 'Ring Mail +2',       'xp' =>  800, 'gp' =>  6000, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Ring Mail +3',       'xp' => 1200, 'gp' =>  9500, 'link' => 'DMG' ),
		array( 'chance' => 36, 'text' => 'Scale Mail +1',      'xp' =>  500, 'gp' =>  3000, 'link' => 'DMG' ),
		array( 'chance' => 24, 'text' => 'Scale Mail +2',      'xp' => 1100, 'gp' =>  6750, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Scale Mail +3',      'xp' => 1650, 'gp' => 10500, 'link' => 'DMG' ),
		array( 'chance' => 24, 'text' => 'Splint Mail +1',     'xp' =>  700, 'gp' =>  4000, 'link' => 'DMG' ),
		array( 'chance' => 18, 'text' => 'Splint Mail +2',     'xp' => 1500, 'gp' =>  8500, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Splint Mail +3',     'xp' => 2250, 'gp' => 14500, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Splint Mail +4',     'xp' => 3000, 'gp' => 19000, 'link' => 'DMG' ),
		array( 'chance' => 42, 'text' => 'Studded Leather +1', 'xp' =>  400, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' => 30, 'text' => 'Studded Leather +2', 'xp' =>  400, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' => 18, 'text' => 'Studded Leather +3', 'xp' =>  400, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' => 24, 'text' => 'Studded Leather +4', 'xp' =>  400, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' => 54, 'text' => 'Shield +1',          'xp' =>  250, 'gp' =>  2500, 'link' => 'DMG' ),
		array( 'chance' => 30, 'text' => 'Shield +2',          'xp' =>  500, 'gp' =>  5000, 'link' => 'DMG' ),
		array( 'chance' => 24, 'text' => 'Shield +3',          'xp' =>  800, 'gp' =>  8000, 'link' => 'DMG' ),
		array( 'chance' => 12, 'text' => 'Shield +4',          'xp' => 1200, 'gp' => 12000, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Shield +5',          'xp' => 1750, 'gp' => 17500, 'link' => 'DMG' ),
		array( 'chance' =>  6, 'text' => 'Shield, large, +1, +4 vs. missiles', 'xp' =>  400, 'gp' => 4000, 'link' => 'DMG' ),
		array( 'chance' => 18, 'text' => 'Shield +1, missile attractor',       'xp' => '~~', 'gp' =>  750, 'link' => 'DMG' ),
	);
}

function dnd1e_get_magic_swords_table() {
	return array(
		'title' => 'Swords - this table is not yet available. DMG 123, table III.G.',
/*
1 	Sun Blade 	3,000 	20,000
5	2-7 	Sword +1, +2 vs. magic-using & enchanted creatures 	600 	3,000
5	8-10 	Sword +1, +3 vs. lycanthropes & shape-changers 	700 	3,500
5	11-12 	Sword +1, +3 vs. regenerating creatures 	800 	4,000
5	13 	Sword +1, +4 vs. reptiles 	800 	4,000
5	14-15 	Sword +1, Cursed 	~~ 	1,000
4	16 	Sword +1, Flame Tongue 	900 	4,500
1	17 	Sword +1, Luck Blade 	1,000 	5,000
4	18 	Sword +2, Dragon Slayer 	900 	4,500
4	19 	Sword +2, Giant Slayer 	900 	4,500
1	1 	Sword +2, Nine Lives Stealer 	1,600 	8,000
3	2-3 	Sword +3, Frost Brand 	1,600 	8,000
1	4 	Sword +4, Defender 	3,000 	15,000
1	5 	Sword +5, Defender 	3,600 	18,000
1	6 	Sword +5, Holy Avenger 	4,000 	20,000
5	7-8 	Sword -2, Cursed 	~~ 	500
1	9 	Sword of Dancing 	4,400 	22,000
1	10 	Sword of Life Stealing 	5,000 	25,000
1	11 	Sword of Sharpness 	7,000 	35,000
12 	Sword of the Planes 	2,000 	30,000
1	13 	Sword of Wounding 	4,400 	22,000
4	14-16 	Sword, Cursed Berserking 	~~ 	500
17-18 	Sword, Short, Quickness (+2) 	1,000 	17,500
1	19 	Sword, Vorpal Weapon 	10,000 	50,000
*/
	);
}

function dnd1e_get_magic_weapons_table() {
	return array(
		'title' => 'Miscellaneous Weapons - this table is not yet available. DMG 124, table III.H.',
	);
}

/*
', 'xp' => , 'gp' => , 'link' => 'DMG' ),
array( 'chance' => 30, 'text' => '
*/


/*
array( 'chance' => 11, 'text' => 'Swords' ),
array( 'chance' => 14, 'text' => 'Miscellaneous Weapons' ),
*/




