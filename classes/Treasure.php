<?php

class DND_Treasure {



	public function get_sub_table_name( $roll = 0 ) {
		$roll = intval( $roll, 10 );
		$next = '';
		if ( $roll ) {
			$main = $this->get_items_table();
			foreach( $main as $item ) {
				if ( ! is_array( $item ) ) continue;
				$roll -= $item['chance'];
				if ( $roll < 1 ) {
					$next = $item['sub'];
					break;
				}
			}
		}
		return $next;
	}

	/**  Command Line  **/

	public function show_possible_monster_treasure( $enemy, $possible = '' ) {
		$monster = null;
		if ( is_array( $enemy ) ) {
			$monster = array_pop( $enemy );
		} else if ( is_object( $enemy ) ) {
			$monster = $enemy;
		}
		$treasure = $monster->get_treasure( $possible );
		echo "\n";
		if ( is_array( $treasure ) ) {
			foreach( $treasure as $item ) {
				echo "$item\n";
			}
		} else {
			echo "$treasure\n";
		}
		echo "\n";
	}

	public function show_treasure_table( $table = 'items' ) {
		$table = strtolower( $table );
		$func  = $this->get_sub_table_string( $table );
		$items = $this->$func();
		$forms = ( in_array( $table , [ 'potions', 'rings', 'armor_shields' ] ) ) ? [ '%03u', '  %1$03u  ' ] : [ '%02u', '  %1$02u ' ];
		$perc  = 1;
		foreach( $items as $key => $item ) {
			if ( ! is_array( $item ) ) {
				if ( $key === 'title' ) echo "\n";
				echo "\t$item\n";
				continue;
			}
			$rg_end  = $perc + $item['chance'] - 1;
			$format  = ( $perc === $rg_end ) ? $forms[1] : "{$forms[0]}-{$forms[0]}";
			$format .= ' : %3$-30s';
			$line = sprintf( $format, $perc, $rg_end, $item['text'] );
			echo "  $line\n";
			$perc += $item['chance'];
		}
		echo "\n";
	}

	public function show_treasure_item( $table, $roll ) {
		$func = $this->get_sub_table_string( $table );
		$sec  = $this->$func();
		$roll = intval( $roll );
		$pick = '';
		foreach( $sec as $key => $item ) {
			if ( ! is_array( $item ) ) {
				if ( $key === 'title' ) echo "\n";
				echo "\t$item\n";
				continue;
			}
			$roll -= $item['chance'];
			if ( $roll < 1 ) {
				echo "  {$item['text']}   {$item['xp']}xp  {$item['gp']}gp  {$item['link']}\n\n";
				$roll = 1000000;
			}
		}
		echo "\n";
	}

	/**  Tables  **/

	public function get_items_table() {
		return array(
			'title' => 'Magic Items: 1d100',
			array( 'chance' => 20, 'text' => 'Potions (d1000)',            'sub' => 'potions' ),
			array( 'chance' => 15, 'text' => 'Scrolls',                    'sub' => 'scrolls' ),
			array( 'chance' =>  5, 'text' => 'Rings (d1000)',              'sub' => 'rings' ),
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
			array( 'chance' => 15, 'text' => 'Armor and Shields (d1000)',  'sub' => 'armor_shields' ),
			array( 'chance' => 11, 'text' => 'Swords',                     'sub' => 'swords' ),
			array( 'chance' => 14, 'text' => 'Miscellaneous Weapons (d1000)', 'sub' => 'weapons' ),
		);
	}

	protected function get_sub_table_string( $sub ) {
		return "get_{$sub}_table";
	}

	protected function get_potions_table() {
		return array(
			'title' => 'Potions: 1d1000',
			array( 'chance' => 20, 'text' => 'Animal Control',           'xp' => 250, 'gp' =>   400, 'link' => 'DMG 124' ),
			array( 'chance' => 20, 'text' => 'Clairaudience',            'xp' => 250, 'gp' =>   400, 'link' => 'DMG 124' ),
			array( 'chance' => 20, 'text' => 'Clairvoyance',             'xp' => 300, 'gp' =>   500, 'link' => 'DMG 124' ),
			array( 'chance' => 30, 'text' => 'Climbing',                 'xp' => 300, 'gp' =>   500, 'link' => 'DMG 124' ),
			array( 'chance' => 20, 'text' => 'Cursed/Poison',            'xp' => '~', 'gp' => '~~~', 'link' => 'DMG 126' ),
			array( 'chance' => 10, 'text' => 'Delusion',                 'xp' => '~', 'gp' =>   150, 'link' => 'DMG 124' ),
			array( 'chance' => 20, 'text' => 'Diminution',               'xp' => 300, 'gp' =>   500, 'link' => 'DMG 124' ),
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
			array( 'chance' => 20, 'text' => 'ESP',                      'xp' => 500, 'gp' =>   850, 'link' => 'DMG 124' ),
			array( 'chance' => 50, 'text' => 'Extra-Healing',            'xp' => 400, 'gp' =>   800, 'link' => 'DMG 125' ),
			array( 'chance' => 10, 'text' => 'Fire Breath',              'xp' => 400, 'gp' =>  4000, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Fire Resistance',          'xp' => 250, 'gp' =>   400, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Flying',                   'xp' => 500, 'gp' =>   750, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Gaseous Form',             'xp' => 300, 'gp' =>   400, 'link' => 'DMG 125' ),
			array( 'chance' =>  5, 'text' => 'Giant Control: Hill',      'xp' => 600, 'gp' =>  1000, 'link' => 'DMG 125' ),
			array( 'chance' =>  4, 'text' => 'Giant Control: Stone',     'xp' => 600, 'gp' =>  2000, 'link' => 'DMG 125' ),
			array( 'chance' =>  4, 'text' => 'Giant Control: Frost',     'xp' => 600, 'gp' =>  3000, 'link' => 'DMG 125' ),
			array( 'chance' =>  4, 'text' => 'Giant Control: Fire',      'xp' => 600, 'gp' =>  4000, 'link' => 'DMG 125' ),
			array( 'chance' =>  2, 'text' => 'Giant Control: Cloud',     'xp' => 600, 'gp' =>  5000, 'link' => 'DMG 125' ),
			array( 'chance' =>  1, 'text' => 'Giant Control: Storm',     'xp' => 600, 'gp' =>  6000, 'link' => 'DMG 125' ),
			array( 'chance' =>  6, 'text' => 'Giant Strength: Hill',     'xp' => 550, 'gp' =>   900, 'link' => 'DMG 125' ),
			array( 'chance' =>  4, 'text' => 'Giant Strength: Stone',    'xp' => 550, 'gp' =>  1000, 'link' => 'DMG 125' ),
			array( 'chance' =>  4, 'text' => 'Giant Strength: Frost',    'xp' => 550, 'gp' =>  1100, 'link' => 'DMG 125' ),
			array( 'chance' =>  3, 'text' => 'Giant Strength: Fire',     'xp' => 550, 'gp' =>  1200, 'link' => 'DMG 125' ),
			array( 'chance' =>  2, 'text' => 'Giant Strength: Cloud',    'xp' => 550, 'gp' =>  1300, 'link' => 'DMG 125' ),
			array( 'chance' =>  1, 'text' => 'Giant Strength: Storm',    'xp' => 550, 'gp' =>  1400, 'link' => 'DMG 125' ),
			array( 'chance' => 15, 'text' => 'Growth',                   'xp' => 250, 'gp' =>   300, 'link' => 'DMG 125' ),
			array( 'chance' => 40, 'text' => 'Healing',                  'xp' => 200, 'gp' =>   400, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Heroism(F)',               'xp' => 300, 'gp' =>   500, 'restrict' => 'F', 'link' => 'DMG 125' ),
			array( 'chance' =>  2, 'text' => 'Human Control: Dwarves',   'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
			array( 'chance' =>  2, 'text' => 'Human Control: Elves/Half-Elves', 'xp' => 500, 'gp' => 900, 'link' => 'DMG 125' ),
			array( 'chance' =>  2, 'text' => 'Human Control: Gnomes',    'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
			array( 'chance' =>  2, 'text' => 'Human Control: Halflings', 'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
			array( 'chance' =>  2, 'text' => 'Human Control: Half-Orcs', 'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
			array( 'chance' =>  6, 'text' => 'Human Control: Humans',    'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
			array( 'chance' =>  3, 'text' => 'Human Control: Humanoids', 'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
			array( 'chance' =>  1, 'text' => 'Human Control: Elves/Half-Elves/Humans', 'xp' =>  500, 'gp' => 900, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Invisibility',             'xp' => 250, 'gp' =>   500, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Invulnerability(F)',       'xp' => 350, 'gp' =>   500, 'restrict' => 'F', 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Levitation',               'xp' => 250, 'gp' =>   400, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Longevity',                'xp' => 500, 'gp' =>  1000, 'link' => 'DMG 125' ),
			array( 'chance' => 30, 'text' => 'Neutralize Poison',        'xp' => 300, 'gp' =>   500, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Oil of Acid Resistance',   'xp' => 500, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Oil of Disenchantment',    'xp' => 750, 'gp' =>  3500, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Oil of Elemental Invulnerability*', 'xp' => 500, 'gp' => 5000, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Oil of Etherealness',       'xp' => 600, 'gp' =>  1500, 'link' => 'DMG 125' ),
			array( 'chance' => 10, 'text' => 'Oil of Fiery Burning',      'xp' => 500, 'gp' =>  4000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Oil of Fumbling**',         'xp' => '~', 'gp' =>  1000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Oil of Impact',             'xp' => 750, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Oil of Slipperiness',       'xp' => 400, 'gp' =>   750, 'link' => 'DMG 126' ),
			array( 'chance' => 10, 'text' => 'Oil of Timelessness',       'xp' => 500, 'gp' =>  2000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Philter of Glibness',       'xp' => 500, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Philtre of Love',           'xp' => 200, 'gp' =>   300, 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Philtre of Persuasiveness', 'xp' => 400, 'gp' =>   850, 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Philter of Stammering and Stuttering**', 'xp' => '~', 'gp' => 1500, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Plant Control',             'xp' => 250, 'gp' =>   300, 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Polymorph Self',            'xp' => 200, 'gp' =>   350, 'link' => 'DMG 126' ),
			array( 'chance' => 10, 'text' => 'Rainbow Hues',              'xp' => 200, 'gp' =>   800, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Speed',                     'xp' => 200, 'gp' =>   450, 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Super-Heroism (F)',         'xp' => 450, 'gp' =>   750, 'restrict' => 'F', 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Sweet Water',               'xp' => 200, 'gp' =>   250, 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Treasure Finding',          'xp' => 600, 'gp' =>  2000, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Ghasts',    'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Ghosts',    'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Ghouls',    'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Shadows',   'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Skeletons', 'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Spectres',  'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Wights',    'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Wraiths',   'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Vampires',  'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' =>  2, 'text' => 'Undead Control: Zombies',   'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' => 10, 'text' => 'Ventriloquism',             'xp' => 200, 'gp' =>   800, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Vitality',                  'xp' => 300, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Water Breathing',           'xp' => 400, 'gp' =>   900, 'link' => 'DMG 126' ),
			array( 'chance' => 35, 'text' => "DM's choice",               'xp' => '~', 'gp' => '~~~', 'link' => '' ),
		);
	}

	protected function get_scrolls_table() {
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
			array( 'chance' =>  2, 'text' => 'Protection - Acid',          'xp' => 2500, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Cold',          'xp' => 2000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Demons',        'xp' => 2500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Devils',        'xp' => 2500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Dragon Breath', 'xp' => 2000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Electricity',   'xp' => 1500, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Protection - Elementals',    'xp' => 1500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Fire',          'xp' => 2000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Gas',           'xp' => 2000, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Protection - Lyconthropes',  'xp' => 1000, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Magic',         'xp' => 1500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Petrification', 'xp' => 2000, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Plants',        'xp' => 1000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Poison',        'xp' => 1000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Possession',    'xp' => 2000, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Undead',        'xp' => 1500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Water',         'xp' => 1500, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Curse**' ),
		);
	}

	protected function get_rings_table() {
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
			array( 'chance' => 60, 'text' => 'Warmth',                  'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 130' ),
			array( 'chance' => 50, 'text' => 'Water Walking',           'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 131' ),
			array( 'chance' => 80, 'text' => 'Weakness',                'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 131' ),
			array( 'chance' =>  4, 'text' => 'Wishes, Multiple (2d4)',  'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 129' ),
			array( 'chance' =>  8, 'text' => 'Wishes, Three',           'xp' => 3000, 'gp' => 15000, 'link' => 'DMG 130' ),
			array( 'chance' => 10, 'text' => 'Wizardry* (MU)',          'xp' => 4000, 'gp' => 50000, 'restrict' => 'M', 'link' => 'DMG 131' ),
			array( 'chance' => 10, 'text' => 'X-Ray Vision',            'xp' => 4000, 'gp' => 35000, 'link' => 'DMG 131' ),
		);
	}

	protected function get_rods_table() {
		return array(
			'title' => 'Rods',
			array( 'chance' => 10, 'text' => 'Absorption (C,MU)',     'xp' =>  7500, 'gp' => 40000, 'restrict' => 'CM', 'link' => 'DMG 131' ),
			array( 'chance' =>  5, 'text' => 'Alertness',             'xp' =>  7000, 'gp' => 50000, 'link' => '' ),
			array( 'chance' =>  3, 'text' => 'Beguiling (C,MU,T)',    'xp' =>  5000, 'gp' => 30000, 'restrict' => 'CMT', 'link' => 'DMG 131-132' ),
			array( 'chance' => 29, 'text' => 'Cancellation',          'xp' => 10000, 'gp' => 15000, 'link' => 'DMG 132' ),
			array( 'chance' =>  3, 'text' => 'Rod of Captivation',    'xp' =>  5000, 'gp' => 30000, 'link' => 'OS 321' ),
			array( 'chance' =>  5, 'text' => 'Flailing',              'xp' =>  2000, 'gp' => 20000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Lordly Might (F)',      'xp' =>  6000, 'gp' => 20000, 'restrict' => 'F', 'link' => 'DMG 132' ),
			array( 'chance' =>  4, 'text' => 'Passage',               'xp' =>  5000, 'gp' => 50000, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Resurrection (C)',      'xp' => 10000, 'gp' => 35000, 'restrict' => 'C', 'link' => 'DMG 132' ),
			array( 'chance' =>  3, 'text' => 'Rulership',             'xp' =>  8000, 'gp' => 35000, 'link' => 'DMG 132' ),
			array( 'chance' =>  3, 'text' => 'Scepter of Entrapment', 'xp' =>  3000, 'gp' => 45000, 'link' => 'http://flockhart.virtualave.net/afal/ScepterEntrapment.html' ),
			array( 'chance' =>  6, 'text' => 'Security',              'xp' =>  3000, 'gp' => 30000, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Smiting (C,MU)',        'xp' =>  4000, 'gp' => 15000, 'restrict' => 'CM', 'link' => 'DMG 132' ),
			array( 'chance' =>  3, 'text' => 'Splendor',              'xp' =>  2500, 'gp' => 25000, 'link' => '' ),
			array( 'chance' =>  6, 'text' => 'Terror',                'xp' =>  3000, 'gp' => 15000, 'link' => '' ),
			'note00' => 'Charges: 50 - ( 1d10 - 1 )',
		);
	}

	protected function get_staves_table() {
		return array(
			'title' => 'Staves',
			array( 'chance' =>  5, 'text' => 'Command (C,M)',       'xp' =>  5000, 'gp' => 25000, 'restrict' => 'CM', 'link' => 'DMG 132-133' ),
			array( 'chance' => 10, 'text' => 'Curing (C)',          'xp' =>  6000, 'gp' => 25000, 'restrict' => 'C',  'link' => 'DMG 133' ),
			array( 'chance' => 10, 'text' => 'Mace',                'xp' =>  1500, 'gp' => 12500, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Magi (M)',            'xp' => 15000, 'gp' => 75000, 'restrict' => 'M',  'link' => 'DMG 133' ),
			array( 'chance' =>  5, 'text' => 'Power (M)',           'xp' => 12000, 'gp' => 60000, 'restrict' => 'M',  'link' => 'DMG 133' ),
			array( 'chance' => 15, 'text' => 'Serpent (C)',         'xp' =>  7000, 'gp' => 35000, 'restrict' => 'C',  'link' => 'DMG 133' ),
			array( 'chance' => 10, 'text' => 'Slinging (C)',        'xp' =>  2000, 'gp' => 10000, 'restrict' => 'C',  'link' => '' ),
			array( 'chance' => 20, 'text' => 'Striking (C,M)',      'xp' =>  6000, 'gp' => 15000, 'restrict' => 'CM', 'link' => 'DMG 133' ),
			array( 'chance' =>  5, 'text' => 'Thunder & Lightning', 'xp' =>  8000, 'gp' => 20000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Withering',           'xp' =>  8000, 'gp' => 35000, 'link' => 'DMG 133' ),
			array( 'chance' =>  5, 'text' => 'Woodlands (D)',       'xp' =>  8000, 'gp' => 40000, 'restrict' => 'D', 'link' => '' ),
			'note00' => 'Charges: 25 - ( 1d6 - 1 )',
		);
	}

	protected function get_wands_table() {
		return array(
			'title' => 'Wands',
			array( 'chance' =>  2, 'text' => 'Conjuration (M)',           'xp' => 7000, 'gp' => 35000, 'restrict' => 'M', 'link' => 'DMG 134' ),
#			array( 'chance' => 30, 'text' => 'Earth and Stone 	1,000 	10,000-15,000', 'xp' => 1000, 'gp' => , 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Enemy Detection',           'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 134' ),
			array( 'chance' =>  4, 'text' => 'Fear (C,M)',                'xp' => 3000, 'gp' => 15000, 'restrict' => 'CM', 'link' => 'DMG 134' ),
			array( 'chance' =>  4, 'text' => 'Fire (M)',                  'xp' => 4500, 'gp' => 25000, 'restrict' => 'M', 'link' => 'DMG 134' ),
			array( 'chance' =>  6, 'text' => 'Flame Extinguishing',       'xp' => 1500, 'gp' => 10000, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Frost (M)',                 'xp' => 6000, 'gp' => 50000, 'restrict' => 'M', 'link' => 'DMG 134' ),
			array( 'chance' =>  6, 'text' => 'Illumination',              'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 134' ),
			array( 'chance' =>  5, 'text' => 'Illusion (M)',              'xp' => 3000, 'gp' => 20000, 'restrict' => 'M', 'link' => 'DMG 134' ),
			array( 'chance' =>  4, 'text' => 'Lightning (M)',             'xp' => 4000, 'gp' => 30000, 'restrict' => 'M', 'link' => 'DMG 134' ),
			array( 'chance' => 12, 'text' => 'Magic Detection',           'xp' => 2500, 'gp' => 25000, 'link' => 'DMG 134-135' ),
			array( 'chance' =>  6, 'text' => 'Magic Missiles',            'xp' => 4000, 'gp' => 35000, 'link' => 'DMG 135' ),
			array( 'chance' =>  6, 'text' => 'Metal/Mineral Detection',   'xp' => 1500, 'gp' =>  7500, 'link' => 'DMG 135' ),
			array( 'chance' => 11, 'text' => 'Negation',                  'xp' => 3500, 'gp' => 15000, 'link' => 'DMG 135' ),
			array( 'chance' =>  4, 'text' => 'Paralyzation (M)',          'xp' => 3500, 'gp' => 25000, 'restrict' => 'M', 'link' => 'DMG 135' ),
			array( 'chance' =>  4, 'text' => 'Polymorphing (M)',          'xp' => 3500, 'gp' => 25000, 'restrict' => 'M', 'link' => 'DMG 135' ),
			array( 'chance' =>  3, 'text' => 'Secret Door/Trap Location', 'xp' => 5000, 'gp' => 40000, 'link' => 'DMG 135' ),
			array( 'chance' =>  6, 'text' => 'Size Alteration',           'xp' => 3000, 'gp' => 20000, 'link' => '' ),
			array( 'chance' =>  8, 'text' => 'Wonder',                    'xp' => 6000, 'gp' => 10000, 'link' => 'DMG 135' ),
			'note00' => 'Charges: 100 - ( 1d20 - 1 )',
		);
	}

	protected function get_books_tomes_table() {
		return array(
			'title' => 'Books, Librams, Manuals, and Tomes',
			array( 'chance' => 15, 'text' => "Boccob's Blessed Book (M)",            'xp' => 4500, 'gp' => 35000, 'restrict' => 'M', 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Book of Exalted Deeds (C)',            'xp' => 8000, 'gp' => 40000, 'restrict' => 'C', 'link' => 'DMG 137' ),
			array( 'chance' =>  5, 'text' => 'Book of Infinite Spells',              'xp' => 9000, 'gp' => 50000, 'link' => 'DMG 137-138' ),
			array( 'chance' =>  5, 'text' => 'Book of Vile Darkness (C)',            'xp' => 8000, 'gp' => 40000, 'restrict' => 'C', 'link' => 'DMG 138' ),
			array( 'chance' =>  5, 'text' => 'Libram of Gainful Conjuration (M)',    'xp' => 8000, 'gp' => 40000, 'restrict' => 'M', 'link' => 'DMG 148' ),
			array( 'chance' =>  5, 'text' => 'Libram of Ineffable Damnation (M)',    'xp' => 8000, 'gp' => 40000, 'restrict' => 'M', 'link' => 'DMG 148' ),
			array( 'chance' =>  5, 'text' => 'Libram of Silver Magic (M)',           'xp' => 8000, 'gp' => 40000, 'restrict' => 'M', 'link' => 'DMG 148' ),
			array( 'chance' =>  5, 'text' => 'Manual of Bodily Health',              'xp' => 5000, 'gp' => 50000, 'link' => 'DMG 148' ),
			array( 'chance' =>  5, 'text' => 'Manual of Gainful Exercise',           'xp' => 5000, 'gp' => 50000, 'link' => 'DMG 148' ),
			array( 'chance' =>  5, 'text' => 'Manual of Golems (C,M)',               'xp' => 3000, 'gp' => 30000, 'restrict' => 'CM', 'link' => 'DMG 148' ),
			array( 'chance' =>  5, 'text' => 'Manual of Puissant Skill at Arms (F)', 'xp' => 8000, 'gp' => 40000, 'restrict' => 'F', 'link' => 'DMG 148' ),
			array( 'chance' =>  5, 'text' => 'Manual of Quickness in Action',        'xp' => 5000, 'gp' => 50000, 'link' => 'DMG 148-149' ),
			array( 'chance' =>  5, 'text' => 'Manual of Stealthy Pilfering (T)',     'xp' => 8000, 'gp' => 40000, 'restrict' => 'T', 'link' => 'DMG 149' ),
			array( 'chance' =>  5, 'text' => 'Tome of Clear Thought',                'xp' => 8000, 'gp' => 48000, 'link' => 'DMG 154' ),
			array( 'chance' =>  5, 'text' => 'Tome of Leadership and Influence',     'xp' => 7500, 'gp' => 40000, 'link' => 'DMG 154' ),
			array( 'chance' =>  5, 'text' => 'Tome of Understanding',                'xp' => 8000, 'gp' => 43500, 'link' => 'DMG 154' ),
			array( 'chance' => 10, 'text' => 'Vacuous Grimoire',                     'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 154' ),
		);
	}

	protected function get_jewels_jewelry_table() {
		return array(
			'title' => 'Jewels, Jewelry, and Phylacteries',
			array( 'chance' =>  2, 'text' => 'Amulet of Inescapable Location',             'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 136' ),
			array( 'chance' =>  1, 'text' => 'Amulet of Life Protection',                  'xp' => 5000, 'gp' => 20000, 'link' => 'DMG 136' ),
			array( 'chance' =>  2, 'text' => 'Amulet of the Planes',                       'xp' => 6000, 'gp' => 30000, 'link' => 'DMG 136' ),
			array( 'chance' =>  3, 'text' => 'Amulet of Proof Against Detection/Location', 'xp' => 4000, 'gp' => 15000, 'link' => 'DMG 136' ),
			array( 'chance' =>  1, 'text' => 'Amulet Versus Undead: C5',                   'xp' => 1000, 'gp' =>  1000, 'link' => 'https://something-s-rotten-in-faerun.obsidianportal.com/items/amulet-versus-undead' ),
			array( 'chance' =>  1, 'text' => 'Beads of Force (1d4+4)',                     'xp' =>  200, 'gp' =>  1000, 'link' => 'https://roll20.net/compendium/dnd5e/Bead of Force' ),
			array( 'chance' =>  7, 'text' => 'Brooch of Shielding',                        'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 139' ),
			array( 'chance' =>  1, 'text' => 'Gem of Brightness',                          'xp' => 2000, 'gp' => 17500, 'link' => 'DMG 144' ),
			array( 'chance' =>  1, 'text' => 'Gem of Insight',                             'xp' => 3000, 'gp' => 30000, 'link' => 'https://www.tradingcarddb.com/GalleryP.cfm/pid/194938/-Gem-of-Insight' ),
			array( 'chance' =>  1, 'text' => 'Gem of Seeing',                              'xp' => 2000, 'gp' => 25000, 'link' => 'DMG 144' ),
			array( 'chance' =>  1, 'text' => 'Jewel of Attacks',                           'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 148' ),
			array( 'chance' =>  1, 'text' => 'Jewel of Flawlessness',                      'xp' => '~~', 'gp' => '1000/facet', 'link' => 'DMG 148' ),
			array( 'chance' =>  3, 'text' => 'Medallion of ESP',                           'xp' => 2000, 'gp' => 20000, 'link' => 'DMG 149' ),
			array( 'chance' =>  2, 'text' => 'Medallion of Thought Projection',            'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 149' ),
			array( 'chance' =>  3, 'text' => 'Necklace of Adaptation',                     'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 149' ),
			array( 'chance' =>  4, 'text' => 'Necklace of Missiles (special)',             'xp' => '100/missile', 'gp' => '200/missile', 'link' => 'DMG 149' ),
			array( 'chance' =>  6, 'text' => 'Necklace of Prayer Beads (C) (special)',     'xp' => '500/bead', 'gp' => '3000/bead', 'restrict' => 'C', 'link' => 'DMG 150' ),
			array( 'chance' =>  2, 'text' => 'Necklace of Strangulation',                  'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 150' ),
			array( 'chance' =>  2, 'text' => 'Pearl of Power* (M)',                        'xp' =>  200, 'gp' =>  2000, 'restrict' => 'M', 'link' => 'DMG 150' ),
			array( 'chance' =>  1, 'text' => 'Pearl of the Sirines',                       'xp' =>  900, 'gp' =>  4500, 'link' => 'https://www.dandwiki.com/wiki/SRD:Pearl_of_the_Sirenes' ),
			array( 'chance' =>  2, 'text' => 'Pearl of Wisdom (C)',                        'xp' =>  500, 'gp' =>  5000, 'restrict' => 'C', 'link' => 'DMG 150' ),
			array( 'chance' =>  2, 'text' => 'Periapt of Foul Rotting',                    'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 150' ),
			array( 'chance' =>  3, 'text' => 'Periapt of Health',                          'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 150' ),
			array( 'chance' =>  7, 'text' => 'Periapt of Proof Against Poison',            'xp' => 1500, 'gp' => 12500, 'link' => 'DMG 150' ),
			array( 'chance' =>  4, 'text' => 'Periapt of Wound Closure',                   'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 150' ),
			array( 'chance' =>  6, 'text' => 'Phylactery of Faithfulness (C)',             'xp' => 1000, 'gp' =>  7500, 'restrict' => 'C', 'link' => 'DMG 150' ),
			array( 'chance' =>  4, 'text' => 'Phylactery of Long Years (C)',               'xp' => 3000, 'gp' => 25000, 'restrict' => 'C', 'link' => 'DMG 150-151' ),
			array( 'chance' =>  2, 'text' => 'Phylactery of Monstrous Attention (C)',      'xp' => '~~', 'gp' =>  2000, 'restrict' => 'C', 'link' => 'DMG 151' ),
			array( 'chance' =>  1, 'text' => 'Scarab of Death',                            'xp' => '~~', 'gp' =>  2500, 'link' => 'DMG 152' ),
			array( 'chance' =>  3, 'text' => 'Scarab of Enraging Enemies',                 'xp' => 1000, 'gp' =>  8000, 'link' => 'DMG 152' ),
			array( 'chance' =>  2, 'text' => 'Scarab of Insanity',                         'xp' => 1500, 'gp' => 11000, 'link' => 'DMG 152-153' ),
			array( 'chance' =>  6, 'text' => 'Scarab of Protection',                       'xp' => 2500, 'gp' => 25000, 'link' => 'DMG 153' ),
			array( 'chance' =>  1, 'text' => 'Scarab Versus Golems**',                     'xp' => '**', 'gp' => 15000, 'link' => 'http://worldofmor.us/rules/DMG/DD01048.htm' ),
			array( 'chance' =>  3, 'text' => 'Talisman of Pure Good (C)',                  'xp' => 3500, 'gp' => 27500, 'restrict' => 'C:G', 'link' => 'DMG 154' ),
			array( 'chance' =>  1, 'text' => 'Talisman of the Sphere (M)',                 'xp' =>  100, 'gp' => 10000, 'restrict' => 'M', 'link' => 'DMG 154' ),
			array( 'chance' =>  2, 'text' => 'Talisman of Ultimate Evil (C)',              'xp' => 3500, 'gp' => 32500, 'restrict' => 'C:E', 'link' => 'DMG 154' ),
			array( 'chance' =>  6, 'text' => 'Talisman of Zagy',                           'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 154' ),
			'note01' => ' * roll % for effect - see description',
			'note02' => '** roll 1d20: 1-6 Flesh 400xp, 7-11 Clay 500xp, 12-15 Stone 600xp, 16-17 Iron 800xp, 18-19 Flesh/Clay/Wood 900xp, 20 Any golem 1,250xp',
		);
	}

	protected function get_cloaks_robes_table() {
		return array(
			'title' => 'Cloaks and Robes',
			array( 'chance' =>  4, 'text' => 'Cloak of Arachnida',                 'xp' => 3000, 'gp' => 25000, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Cloak of Displacement',              'xp' => 3000, 'gp' => 17500, 'link' => 'DMG 139-140' ),
			array( 'chance' =>  9, 'text' => 'Cloak of Elvenkind',                 'xp' => 1000, 'gp' =>  6000, 'link' => 'DMG 140' ),
			array( 'chance' =>  4, 'text' => 'Cloak of Manta Ray',                 'xp' => 2000, 'gp' => 12500, 'link' => 'DMG 140' ),
			array( 'chance' =>  2, 'text' => 'Cloak of Poisonousness',             'xp' => '~~', 'gp' =>  2500, 'link' => 'DMG 140' ),
			array( 'chance' => 15, 'text' => 'Cloak of Protection +1',             'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 140' ),
			array( 'chance' => 12, 'text' => 'Cloak of Protection +2',             'xp' => 2000, 'gp' => 20000, 'link' => 'DMG 140' ),
			array( 'chance' =>  8, 'text' => 'Cloak of Protection +3',             'xp' => 3000, 'gp' => 30000, 'link' => 'DMG 140' ),
			array( 'chance' =>  4, 'text' => 'Cloak of Protection +4',             'xp' => 4000, 'gp' => 40000, 'link' => 'DMG 140' ),
			array( 'chance' =>  2, 'text' => 'Cloak of Protection +5',             'xp' => 5000, 'gp' => 50000, 'link' => 'DMG 140' ),
			array( 'chance' =>  9, 'text' => 'Cloak of the Bat',                   'xp' => 1500, 'gp' => 15000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Robe of the Archmagi (M)',           'xp' => 6000, 'gp' => 65000, 'restrict' => 'M', 'link' => 'DMG 151' ),
			array( 'chance' =>  7, 'text' => 'Robe of Blending',                   'xp' => 3500, 'gp' => 35000, 'link' => 'DMG 151' ),
			array( 'chance' =>  1, 'text' => 'Robe of Eyes (M)',                   'xp' => 4500, 'gp' => 50000, 'restrict' => 'M', 'link' => 'DMG 151' ),
			array( 'chance' =>  1, 'text' => 'Robe of Powerlessness (M)',          'xp' => '~~', 'gp' =>  1000, 'restrict' => 'M', 'link' => 'DMG 151-152' ),
			array( 'chance' =>  1, 'text' => 'Robe of Scintillating Colors (C,M)', 'xp' => 2750, 'gp' => 25000, 'restrict' => 'CM', 'link' => 'DMG 152' ),
			array( 'chance' =>  4, 'text' => 'Robe of Stars (M)',                  'xp' => 4000, 'gp' => 12000, 'restrict' => 'M', 'link' => '' ),
			array( 'chance' =>  8, 'text' => 'Robe of Useful Items (M)',           'xp' => 1500, 'gp' => 15000, 'restrict' => 'M', 'link' => 'DMG 152' ),
			array( 'chance' =>  4, 'text' => 'Robe of Vermin (M)',                 'xp' => '~~', 'gp' =>  1000, 'restrict' => 'M', 'link' => '' ),
		);
	}

	protected function get_boots_gloves_table() {
		return array(
			'title' => 'Boots, Bracers, and Gloves',
			array( 'chance' =>  2, 'text' => 'Boots of Dancing',                       'xp' => '~~', 'gp' =>  5000, 'link' => 'DMG 138' ),
			array( 'chance' => 12, 'text' => 'Boots of Elvenkind',                     'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 138' ),
			array( 'chance' =>  8, 'text' => 'Boots of Levitation',                    'xp' => 2000, 'gp' => 15000, 'link' => 'DMG 138' ),
			array( 'chance' =>  7, 'text' => 'Boots of Speed',                         'xp' => 2500, 'gp' => 20000, 'link' => 'DMG 138' ),
			array( 'chance' =>  7, 'text' => 'Boots of Striding and Springing',        'xp' => 2500, 'gp' => 20000, 'link' => 'DMG 138' ),
			array( 'chance' =>  1, 'text' => 'Boots of the North',                     'xp' => 1500, 'gp' =>  7500, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Boots of Varied Tracks',                 'xp' => 1500, 'gp' =>  7500, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Boots, Winged',                          'xp' => 2000, 'gp' => 20000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Bracers of Archery (F)',                 'xp' => 1000, 'gp' => 10000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Bracers of Brachiation',                 'xp' => 1000, 'gp' => 10000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Bracers of Defense AC 8',                'xp' =>  500, 'gp' =>  3000, 'link' => 'DMG 138' ),
			array( 'chance' =>  4, 'text' => 'Bracers of Defense AC 7',                'xp' => 1000, 'gp' =>  6000, 'link' => 'DMG 138' ),
			array( 'chance' =>  7, 'text' => 'Bracers of Defense AC 6',                'xp' => 1500, 'gp' =>  9000, 'link' => 'DMG 138' ),
			array( 'chance' =>  6, 'text' => 'Bracers of Defense AC 5',                'xp' => 2000, 'gp' => 12000, 'link' => 'DMG 138' ),
			array( 'chance' =>  7, 'text' => 'Bracers of Defense AC 4',                'xp' => 2500, 'gp' => 15000, 'link' => 'DMG 138' ),
			array( 'chance' =>  6, 'text' => 'Bracers of Defense AC 3',                'xp' => 3000, 'gp' => 18000, 'link' => 'DMG 138' ),
			array( 'chance' =>  5, 'text' => 'Bracers of Defense AC 2',                'xp' => 3500, 'gp' => 21000, 'link' => 'DMG 138' ),
			array( 'chance' =>  4, 'text' => 'Bracers of Defenselessness',             'xp' => '~~', 'gp' =>  2000, 'link' => 'DMG 138-139' ),
			array( 'chance' =>  4, 'text' => 'Gauntlets of Dexterity',                 'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 144' ),
			array( 'chance' =>  3, 'text' => 'Gauntets of Fumbling',                   'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 144' ),
			array( 'chance' =>  4, 'text' => 'Gauntlets of Ogre Power (C,T,F)',        'xp' => 1000, 'gp' => 15000, 'restrict' => 'CTF', 'link' => 'DMG 144' ),
			array( 'chance' =>  5, 'text' => 'Gauntlets of Swimming/Climbing (C,T,F)', 'xp' => 1000, 'gp' => 10000, 'restrict' => 'CTF', 'link' => 'DMG 144' ),
			array( 'chance' =>  1, 'text' => 'Gloves of Missile Snaring',              'xp' => 1500, 'gp' => 10000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Slippers of Spider Climbing',            'xp' => 1000, 'gp' => 10000, 'link' => '' ),
		);
	}

	protected function get_girdles_helms_table() {
		return array(
			array( 'chance' =>  1, 'text' => 'Girdle of Dwarvenkind',                    'xp' => 3500, 'gp' => 20000, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Girdle of Femininity/Masculinity (C,T,F)', 'xp' => '~~', 'gp' =>  1000, 'restrict' => 'CTF', 'link' => 'DMG 144' ),
			array( 'chance' =>  6, 'text' => 'Girdle of Hill Giant Strength (C,T,F)',    'xp' => 2000, 'gp' => 25000, 'restrict' => 'CTF', 'link' => 'DMG 144' ),
			array( 'chance' =>  4, 'text' => 'Girdle of Stone Giant Strength (C,T,F)',   'xp' => 2000, 'gp' => 25000, 'restrict' => 'CTF', 'link' => 'DMG 144' ),
			array( 'chance' =>  4, 'text' => 'Girdle of Frost Giant Strength (C,T,F)',   'xp' => 2000, 'gp' => 25000, 'restrict' => 'CTF', 'link' => 'DMG 144' ),
			array( 'chance' =>  3, 'text' => 'Girdle of Fire Giant Strength (C,T,F)',    'xp' => 2000, 'gp' => 25000, 'restrict' => 'CTF', 'link' => 'DMG 144' ),
			array( 'chance' =>  2, 'text' => 'Girdle of Cloud Giant Strength (C,T,F)',   'xp' => 2000, 'gp' => 25000, 'restrict' => 'CTF', 'link' => 'DMG 144' ),
			array( 'chance' =>  1, 'text' => 'Girdle of Storm Giant Strength (C,T,F)',   'xp' => 2000, 'gp' => 25000, 'restrict' => 'CTF', 'link' => 'DMG 144' ),
			array( 'chance' =>  1, 'text' => 'Girdle of Many Pouches',     'xp' => 1000, 'gp' => 10000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Hat of Disguise',            'xp' => 1000, 'gp' =>  7500, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Hat of Stupidity',           'xp' => '~~', 'gp' =>  1000, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Helm of Brilliance',         'xp' => 2500, 'gp' => 60000, 'link' => 'DMG 144-145' ),
			array( 'chance' => 21, 'text' => 'Helm of Comprehending Languages and Reading Magic', 'xp' => 1000, 'gp' => 12500, 'link' => 'DMG 145' ),
			array( 'chance' => 10, 'text' => 'Helm of Opposite Alignment', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 145' ),
			array( 'chance' => 10, 'text' => 'Helm of Telepathy',          'xp' => 3000, 'gp' => 35000, 'link' => 'DMG 145' ),
			array( 'chance' =>  5, 'text' => 'Helm of Teleportation',      'xp' => 2500, 'gp' => 30000, 'link' => 'DMG 145' ),
			array( 'chance' => 20, 'text' => 'Helm of Underwater Action',  'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 145' ),
		);
	}

	protected function get_bags_bottles_table() {
		return array(
			'title' => 'Bags, Bottles, Pouches, and Containers',
			array( 'chance' =>  6, 'text' => 'Alchemy Jug',        'xp' => 3000, 'gp' => 12000, 'link' => 'DMG 136' ),
			array( 'chance' =>  9, 'text' => 'Bag of Beans',       'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 136' ),
			array( 'chance' =>  3, 'text' => 'Bag of Devouring',   'xp' => '~~', 'gp' =>  1500, 'link' => 'DMG 136-137' ),
			array( 'chance' => 15, 'text' => 'Bag of Holding',     'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 137' ),
			array( 'chance' =>  3, 'text' => 'Bag of Transmuting', 'xp' => '~~', 'gp' =>   500, 'link' => 'DMG 137' ),
			array( 'chance' =>  6, 'text' => 'Bag of Tricks',      'xp' => 2500, 'gp' => 15000, 'link' => 'DMG 137' ),
			array( 'chance' =>  6, 'text' => 'Beaker of Plentiful Potions',           'xp' => 1500, 'gp' => 12500, 'link' => 'DMG 137' ),
			array( 'chance' => 10, 'text' => "Bucknard's Everfull Purse sp/ep/gp*",   'xp' => 1500, 'gp' => 15000, 'link' => 'DMG 139' ),
			array( 'chance' =>  8, 'text' => "Bucknard's Everfull Purse cp/ep/pp*",   'xp' => 2500, 'gp' => 25000, 'link' => 'DMG 139' ),
			array( 'chance' =>  2, 'text' => "Bucknard's Everfull Purse cp/ep/gems*", 'xp' => 4000, 'gp' => 40000, 'link' => 'DMG 139' ),
			array( 'chance' =>  9, 'text' => 'Decanter of Endless Water', 'xp' => 1000, 'gp' =>  3000, 'link' => 'DMG 141' ),
			array( 'chance' =>  3, 'text' => 'Efreeti Bottle',            'xp' => 9000, 'gp' => 45000, 'link' => 'DMG 142' ),
			array( 'chance' =>  3, 'text' => 'Eversmoking Bottle',        'xp' =>  500, 'gp' =>  2500, 'link' => 'DMG 142-143' ),
			array( 'chance' =>  3, 'text' => 'Flask of Curses',           'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 144' ),
			array( 'chance' =>  1, 'text' => "Heward's Handy Haversack",  'xp' => 3000, 'gp' => 30000, 'link' => '' ),
			array( 'chance' =>  6, 'text' => 'Iron Flask',                'xp' => '~~', 'gp' => '~~~', 'link' => 'DMG 147' ),
			array( 'chance' =>  3, 'text' => 'Portable Hole',             'xp' => 5000, 'gp' => 50000, 'link' => 'DMG 151' ),
			array( 'chance' =>  1, 'text' => 'Pouch of Accessibility',    'xp' => 1500, 'gp' => 12500, 'link' => '' ),
			array( 'chance' =>  3, 'text' => "DM's choice",               'xp' => '~~', 'gp' => '~~~', 'link' => '' ),
			'note01' => '* 26 of each type listed, gems are base 10gp.',
		);
	}

	protected function get_dusts_stones_table() {
		return array(
			'title' => 'Candles, Dusts, Ointments, Incense, and Stones',
			array( 'chance' => 10, 'text' => 'Candle of Invocation (C)',       'xp' => 1000, 'gp' => 5000, 'restrict' => 'C', 'link' => 'DMG 139' ),
			array( 'chance' => 12, 'text' => 'Dust of Appearance',             'xp' => 1000, 'gp' => 4000, 'link' => 'DMG 142' ),
			array( 'chance' => 12, 'text' => 'Dust of Disappearance',          'xp' => 2000, 'gp' => 8000, 'link' => 'DMG 142' ),
			array( 'chance' =>  1, 'text' => 'Dust of Dryness',                'xp' => 1000, 'gp' => 8000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Dust of Illusion*',              'xp' => 1000, 'gp' => '100', 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Dust of Tracelessness*',         'xp' => 500, 'gp' => '200', 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Dust of Sneezing and Choking',   'xp' => '~~', 'gp' => 1000, 'link' => 'DMG 142' ),
			array( 'chance' => 10, 'text' => 'Incense of Meditation (C)',      'xp' => 500, 'gp' => 7500, 'restrict' => 'C', 'link' => 'DMG 146' ),
			array( 'chance' =>  2, 'text' => 'Incense of Obsession (C)',       'xp' => '~~', 'gp' => 500, 'restrict' => 'C', 'link' => 'DMG 146' ),
			array( 'chance' => 14, 'text' => 'Ioun Stones**',                  'xp' => 300, 'gp' => 5000, 'link' => 'DMG 146' ),
			array( 'chance' => 16, 'text' => "Keoghtom's Ointment",            'xp' => 500, 'gp' => 10000, 'link' => 'DMG 148' ),
			array( 'chance' =>  4, 'text' => "Nolzur's Marvelous Pigments***", 'xp' => 500, 'gp' => 3000, 'link' => 'DMG 150' ),
			array( 'chance' =>  1, 'text' => "Philosopher's Stone",            'xp' => 1000, 'gp' => 10000, 'link' => '' ),
#			array( 'chance' =>  1, 'text' => 'Smoke Powder***',                'xp' => '~~', 'gp' => 30000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Sovereign Glue****',             'xp' => 1000, 'gp' => 1000, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Stone of Controlling Earth Elementals', 'xp' => 1500, 'gp' => 12500, 'link' => 'DMG 153' ),
			array( 'chance' =>  4, 'text' => 'Stone of Good Luck (Luckstone)', 'xp' => 3000, 'gp' => 25000, 'link' => 'DMG 153' ),
			array( 'chance' =>  4, 'text' => 'Stone of Weight (Loadstone)',    'xp' => '~~', 'gp' => 1000, 'link' => 'DMG 153' ),
			array( 'chance' =>  1, 'text' => 'Universal Solvent',              'xp' => 1000, 'gp' => 7000, 'link' => '' ),
			'note01' => '   * 1d20 pinches will be found, gp is per pinch.',
			'note02' => '  ** 1d10 stones will be found, xp/gp is per stone, roll type for each stone',
			'note03' => ' *** 1d4 pots will be found, xp/gp is per pot.',
			'note04' => '**** 1d6 ounces will be found, xp/gp is per ounce.',
		);
	}

	protected function get_items_tools_table() {
		return array(
			'title' => 'Household Items and Tools',
			array( 'chance' =>  8, 'text' => 'Bowl Commanding Water Elementals (M)',   'xp' => 4000, 'gp' => 25000, 'restrict' => 'M', 'link' => 'DMG 138' ),
			array( 'chance' =>  2, 'text' => 'Bowl of Watery Death (M)',               'xp' => '~~', 'gp' =>  1000, 'restrict' => 'M', 'link' => 'DMG 138' ),
			array( 'chance' =>  8, 'text' => 'Brazier Commanding Fire Elementals (M)', 'xp' => 4000, 'gp' => 25000, 'restrict' => 'M', 'link' => 'DMG 139' ),
			array( 'chance' =>  2, 'text' => 'Brazier of Sleep Smoke (M)',             'xp' => '~~', 'gp' =>  1000, 'restrict' => 'M', 'link' => 'DMG 139' ),
			array( 'chance' =>  2, 'text' => 'Broom of Animated Attack',               'xp' => '~~', 'gp' =>  3000, 'link' => 'DMG 139' ),
			array( 'chance' => 12, 'text' => 'Broom of Flying',                        'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 139' ),
			array( 'chance' =>  6, 'text' => 'Carpet of Flying*',                      'xp' => 7500, 'gp' => 25000, 'link' => 'DMG 139' ),
			array( 'chance' =>  8, 'text' => 'Censer Controlling Air Elementals (M)',  'xp' => 4000, 'gp' => 25000, 'restrict' => 'M', 'link' => 'DMG 139' ),
			array( 'chance' =>  2, 'text' => 'Censer of Summoning Hostile Air Elementals (M)', 'xp' => '~~', 'gp' => 1000, 'link' => 'DMG 139' ),
			array( 'chance' =>  2, 'text' => 'Mattock of the Titans (F)',        'xp' => 3500, 'gp' =>  7000, 'restrict' => 'F', 'link' => 'DMG 149' ),
			array( 'chance' =>  2, 'text' => 'Maul of the Titans (F)',           'xp' => 4000, 'gp' => 12000, 'restrict' => 'F', 'link' => 'DMG 149' ),
			array( 'chance' =>  2, 'text' => 'Mirror of Life Trapping (M)',      'xp' => 2500, 'gp' => 25000, 'restrict' => 'M', 'link' => 'DMG 149' ),
			array( 'chance' =>  2, 'text' => 'Mirror of Mental Prowess',         'xp' => 5000, 'gp' => 50000, 'link' => 'DMG 149' ),
			array( 'chance' =>  2, 'text' => 'Mirror of Opposition',             'xp' => '~~', 'gp' =>  2000, 'link' => 'DMG 149' ),
			array( 'chance' =>  2, 'text' => "Murlynd's Spoon",                  'xp' =>  750, 'gp' =>  4000, 'link' => '' ),
			array( 'chance' => 14, 'text' => 'Rope of Climbing',                 'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 152' ),
			array( 'chance' =>  6, 'text' => 'Rope of Constriction',             'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 152' ),
			array( 'chance' => 10, 'text' => 'Rope of Entanglement',             'xp' => 1500, 'gp' => 12000, 'link' => 'DMG 152' ),
			array( 'chance' =>  2, 'text' => 'Rug of Smothering',                'xp' => '~~', 'gp' =>  1500, 'link' => 'DMG 152' ),
			array( 'chance' =>  2, 'text' => 'Rug of Welcome (M)',               'xp' => 6500, 'gp' => 45000, 'restrict' => 'M', 'link' => 'DMG 152' ),
			array( 'chance' =>  2, 'text' => 'Saw of Mighty Cutting (F)',        'xp' => 2000, 'gp' => 12500, 'restrict' => 'F', 'link' => 'DMG 152' ),
			array( 'chance' =>  2, 'text' => 'Spade of Colossal Excavation (F)', 'xp' => 1000, 'gp' =>  6500, 'restrict' => 'F', 'link' => 'DMG 153' ),
			'note01' => '* roll percentage for size',
		);
	}

	protected function get_instruments_table() {
		return array(
			'title' => 'Musical Instruments',
#			array( 'chance' =>  1, 'text' => 'Anstruth Harp (B)',         'xp' => 5000, 'gp' => 25000, 'restrict' => 'B', 'link' => 'DMG 147-148' ),
			array( 'chance' =>  1, 'text' => 'Canaith Mandolin (B)',      'xp' => 5000, 'gp' => 25000, 'restrict' => 'B', 'link' => 'DMG 147-148' ),
			array( 'chance' =>  3, 'text' => 'Chime of Interruption',     'xp' => 2000, 'gp' => 20000, 'link' => '' ),
			array( 'chance' =>  6, 'text' => 'Chime of Opening',          'xp' => 3500, 'gp' => 20000, 'link' => 'DMG 139' ),
			array( 'chance' =>  3, 'text' => 'Chime of Hunger',           'xp' => '~~', 'gp' => '~~~', 'link' => 'DMG 139' ),
#			array( 'chance' =>  1, 'text' => 'Cli Lyre (B)',              'xp' => 5000, 'gp' => 25000, 'restrict' => 'B', 'link' => 'DMG 147-148' ),
			array( 'chance' =>  1, 'text' => 'Doss Lute (B)',             'xp' => 5000, 'gp' => 25000, 'restrict' => 'B', 'link' => 'DMG 147-148' ),
			array( 'chance' =>  3, 'text' => 'Drums of Deafening',        'xp' => '~~', 'gp' =>   500, 'link' => 'DMG 142' ),
			array( 'chance' =>  6, 'text' => 'Drums of Panic',            'xp' => 6500, 'gp' => 35000, 'link' => 'DMG 142' ),
			array( 'chance' =>  1, 'text' => 'Fochlucan Bandore (B)',     'xp' => 5000, 'gp' => 25000, 'restrict' => 'B', 'link' => 'DMG 147-148' ),
			array( 'chance' =>  1, 'text' => 'Harp of Charming',          'xp' => 5000, 'gp' => 25000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Harp of Discord',           'xp' => '~~', 'gp' => 20000, 'link' => '' ),
			array( 'chance' =>  3, 'text' => 'Horn of Blasting',          'xp' => 1000, 'gp' => 55000, 'link' => 'DMG 145' ),
			array( 'chance' =>  6, 'text' => 'Horn of Bubbles',           'xp' => '~~', 'gp' => '~~~', 'link' => 'DMG 145' ),
			array( 'chance' =>  3, 'text' => 'Horn of Collapsing',        'xp' => 1500, 'gp' => 25000, 'link' => 'DMG 145-146' ),
			array( 'chance' =>  1, 'text' => 'Horn of Fog',               'xp' =>  400, 'gp' =>  4000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Horn of Goodness (Evil)',   'xp' =>  750, 'gp' =>  3250, 'restrict' => ':E', 'link' => '' ),
			array( 'chance' => 12, 'text' => 'Horn of the Tritons (C,F)', 'xp' => 2000, 'gp' => 17500, 'restrict' => 'CF', 'link' => 'DMG 146' ),
			array( 'chance' => 21, 'text' => 'Horn of Valhalla*',         'xp' => 1000, 'gp' => 15000, 'link' => 'DMG 146' ),
			array( 'chance' =>  3, 'text' => 'Lyre of Building',          'xp' => 5000, 'gp' => 30000, 'link' => 'DMG 148' ),
			array( 'chance' =>  1, 'text' => 'Mac-Fuirmidh Cittern (B)',  'xp' => 5000, 'gp' => 25000, 'restrict' => 'B', 'link' => 'DMG 147-148' ),
#			array( 'chance' =>  1, 'text' => 'Ollamh Harp (B)',           'xp' => 5000, 'gp' => 25000, 'restrict' => 'B', 'link' => 'DMG 147-148' ),
			array( 'chance' =>  3, 'text' => 'Pipes of Haunting',         'xp' =>  400, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Pipes of Pain',             'xp' => '~~', 'gp' => 10000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Pipes of Sounding',         'xp' => 1000, 'gp' => 10000, 'link' => '' ),
			array( 'chance' => 18, 'text' => 'Pipes of the Sewers',       'xp' => 2000, 'gp' =>  8500, 'link' => 'DMG 151' ),
			'note01' => '* roll d20 for type of horn',
		);
	} //*/

	protected function get_weird_stuff_table() {
		return array(
			'title' => 'The Weird Stuff',
			array( 'chance' =>  2, 'text' => 'Apparatus of Kwalish',        'xp' =>  8000, 'gp' => 35000, 'link' => 'DMG 136' ),
			array( 'chance' =>  1, 'text' => 'Boat, Folding',               'xp' => 10000, 'gp' => 25000, 'link' => 'DMG 137' ),
			array( 'chance' =>  5, 'text' => 'Crystal Ball (M)',            'xp' =>  1000, 'gp' =>  5000, 'restrict' => 'M', 'link' => 'DMG 140' ),
			array( 'chance' =>  1, 'text' => 'Crystal Hypnosis Ball (M)',   'xp' =>  '~~', 'gp' =>  3000, 'restrict' => 'M', 'link' => 'DMG 141' ),
			array( 'chance' =>  2, 'text' => 'Cube of Force',               'xp' =>  3000, 'gp' => 20000, 'link' => 'DMG 141' ),
			array( 'chance' =>  2, 'text' => 'Cube of Frost Resistance',    'xp' =>  2000, 'gp' => 14000, 'link' => 'DMG 141' ),
			array( 'chance' =>  2, 'text' => 'Cubic Gate',                  'xp' =>  5000, 'gp' => 17500, 'link' => 'DMG 141' ),
			array( 'chance' =>  2, 'text' => "Daern's Instant Fortress",    'xp' =>  7000, 'gp' => 27500, 'link' => 'DMG 141' ),
			array( 'chance' =>  1, 'text' => 'Deck of Illusions',           'xp' =>  1500, 'gp' => 15000, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Deck of Many Things',         'xp' =>  '~~', 'gp' => 10000, 'link' => 'DMG 141-142' ),
			array( 'chance' =>  4, 'text' => 'Eyes of Charming (M)',        'xp' =>  4000, 'gp' => 24000, 'restrict' => 'M', 'link' => 'DMG 143' ),
			array( 'chance' =>  7, 'text' => 'Eyes of Minute Seeing',       'xp' =>  2000, 'gp' => 12500, 'link' => 'DMG 143' ),
			array( 'chance' =>  1, 'text' => 'Eyes of the Basilisk',        'xp' => 12500, 'gp' => 50000, 'link' => 'DMG 143' ),
			array( 'chance' =>  7, 'text' => 'Eyes of the Eagle',           'xp' =>  3500, 'gp' => 18000, 'link' => 'DMG 143' ),
			array( 'chance' =>  3, 'text' => 'Eyes of the Gorgon',          'xp' =>  '~~', 'gp' =>  '~~', 'link' => 'DMG 143' ),
			array( 'chance' => 15, 'text' => 'Figurine of Wondrous Power*', 'xp' =>   100, 'gp' =>  1000, 'link' => 'DMG 143-144' ),
			array( 'chance' =>  1, 'text' => 'Glowing Globe',               'xp' =>   100, 'gp' =>   200, 'link' => 'http://flockhart.virtualave.net/afal/glowingglobe.html' ),
			array( 'chance' =>  2, 'text' => 'Horseshoes of a Zephyr',      'xp' =>  1500, 'gp' =>  7500, 'link' => 'DMG 146' ),
			array( 'chance' =>  3, 'text' => 'Horseshoes of Speed',         'xp' =>  2000, 'gp' => 10000, 'link' => 'DMG 146' ),
			array( 'chance' =>  1, 'text' => 'Iron Bands of Bilarro',       'xp' =>   750, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Lens of Detection',           'xp' =>   250, 'gp' =>  1500, 'link' => '' ),
			array( 'chance' => 15, 'text' => "Quaal's Feather Token**",     'xp' =>  1000, 'gp' =>  2000, 'link' => 'DMG 151' ),
			array( 'chance' =>  1, 'text' => 'Quiver of Ehlonna',           'xp' =>  1500, 'gp' => 10000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Sheet of Smallness',          'xp' =>  1500, 'gp' => 12500, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Sphere of Annihilation',      'xp' =>  4000, 'gp' => 30000, 'link' => 'DMG 153' ),
			array( 'chance' =>  1, 'text' => 'Stone Horse',                 'xp' =>  2000, 'gp' => 12000, 'link' => '' ),
			array( 'chance' =>  3, 'text' => 'Well of Many Worlds',         'xp' =>  6000, 'gp' => 12000, 'link' => 'DMG 154' ),
			array( 'chance' =>  1, 'text' => 'Wind Fan',                    'xp' =>   500, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Wings of Flying',             'xp' =>   750, 'gp' =>  7500, 'link' => 'DMG 154' ),
			'note01' => ' * roll % for type, xp/gp is per hit die of figurine.',
			'note02' => '** roll 1d20 for type of token.',
		);
	}

	protected function get_armor_shields_table() {
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
			'note00' => 'Roll for size: 1d100 - 01-65: Human, 66-85: Elven, 86-95: Dwarven, 96-00: Gnome/Halfling',
		);
	}

	protected function get_swords_table() {
		return array(
			'title' => 'Swords',
			array( 'chance' =>  1, 'text' => 'Sun Blade', 'xp' => 3000, 'gp' => 20000, 'link' => 'DMG' ),
			array( 'chance' =>  7, 'text' => 'Sword +1, +2 vs. magic-using & enchanted creatures', 'xp' => 600, 'gp' => 3000, 'link' => 'DMG 164' ),
			array( 'chance' =>  7, 'text' => 'Sword +1, +3 vs. lycanthropes & shape-changers',     'xp' => 700, 'gp' => 3500, 'link' => 'DMG 164' ),
			array( 'chance' =>  7, 'text' => 'Sword +1, +3 vs. regenerating creatures',            'xp' => 800, 'gp' => 4000, 'link' => 'DMG 164' ),
			array( 'chance' =>  7, 'text' => 'Sword +1, +4 vs. reptiles',     'xp' =>   800, 'gp' =>  4000, 'link' => 'DMG 164' ),
			array( 'chance' =>  7, 'text' => 'Sword +1, Cursed',              'xp' =>  '~~', 'gp' =>  1000, 'link' => 'DMG 165' ),
			array( 'chance' =>  5, 'text' => 'Sword +1, Flame Tongue',        'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Sword +1, Luck Blade',          'xp' =>  1000, 'gp' =>  5000, 'link' => 'DMG 164' ),
			array( 'chance' =>  5, 'text' => 'Sword +2, Dragon Slayer',       'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164' ),
			array( 'chance' =>  5, 'text' => 'Sword +2, Giant Slayer',        'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Sword +2, Nine Lives Stealer',  'xp' =>  1600, 'gp' =>  8000, 'link' => 'DMG 164' ),
			array( 'chance' =>  4, 'text' => 'Sword +3, Frost Brand',         'xp' =>  1600, 'gp' =>  8000, 'link' => 'DMG 164' ),
			array( 'chance' =>  2, 'text' => 'Sword +4, Defender',            'xp' =>  3000, 'gp' => 15000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Sword +5, Defender',            'xp' =>  3600, 'gp' => 18000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Sword +5, Holy Avenger (LG)',   'xp' =>  4000, 'gp' => 20000, 'link' => 'DMG 164' ),
			array( 'chance' =>  8, 'text' => 'Sword -2, Cursed',              'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  1, 'text' => 'Sword of Dancing',              'xp' =>  4400, 'gp' => 22000, 'link' => 'DMG 164-165' ),
			array( 'chance' =>  1, 'text' => 'Sword of Life Stealing',        'xp' =>  5000, 'gp' => 25000, 'link' => 'DMG 164' ),
			array( 'chance' =>  2, 'text' => 'Sword of Sharpness (Chaotic)',  'xp' =>  7000, 'gp' => 35000, 'link' => 'DMG 164' ),
			array( 'chance' => 14, 'text' => 'Sword of the Planes',           'xp' =>  2000, 'gp' => 30000, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Sword of Wounding',             'xp' =>  4000, 'gp' => 22000, 'link' => 'DMG 165' ),
			array( 'chance' =>  6, 'text' => 'Sword, Cursed Berserking',      'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  5, 'text' => 'Sword, Short, Quickness (+2)',  'xp' =>  1000, 'gp' => 17500, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Sword, Vorpal Weapon (Lawful)', 'xp' => 10000, 'gp' => 50000, 'link' => 'DMG 165' ),
			'note00' => 'Use table in DMG 165 to test for unusual swords.',
	);
}

	public function get_weapons_table() {
#	protected function get_weapons_table() {
		return array(
			'title' => 'Miscellaneous Weapons: 1d1000',
			array( 'chance' => 60, 'text' => 'Arrow**, 2d12 in number',  'xp' =>   20, 'gp' =>   120, 'link' => 'DMG 167' ),
			array( 'chance' => 30, 'text' => 'Arrow**, 2d8 in number',   'xp' =>   20, 'gp' =>   120, 'link' => 'DMG 167' ),
			array( 'chance' => 15, 'text' => 'Arrow**, 2d6 in number',   'xp' =>   20, 'gp' =>   120, 'link' => 'DMG 167' ),
			array( 'chance' =>  5, 'text' => 'Arrow of Direction',       'xp' => 2500, 'gp' => 17500, 'link' => '' ),
			array( 'chance' =>  3, 'text' => 'Arrow of Slaying',         'xp' =>  250, 'gp' =>  2500, 'link' => 'DMG 167' ),
			array( 'chance' => 60, 'text' => 'Axe*',                     'xp' =>  300, 'gp' =>  1750, 'link' => 'DMG 167' ),
			array( 'chance' =>  5, 'text' => 'Axe +2, Throwing',         'xp' =>  750, 'gp' =>  4500, 'link' => 'DMG 167' ),
			array( 'chance' =>  5, 'text' => 'Axe of Hurling*',          'xp' => 1500, 'gp' => 15000, 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Battle Axe*',              'xp' =>  400, 'gp' =>  2500, 'link' => 'DMG' ),
			array( 'chance' => 60, 'text' => 'Bolt**, 2d10 in number',   'xp' =>   50, 'gp' =>   300, 'link' => 'DMG 167' ),
			array( 'chance' => 30, 'text' => 'Bolt**, 2d8 in number',    'xp' =>   50, 'gp' =>   300, 'link' => 'DMG 167' ),
			array( 'chance' => 15, 'text' => 'Bolt**, 2d6 in number',    'xp' =>   50, 'gp' =>   300, 'link' => 'DMG 167' ),
			array( 'chance' => 25, 'text' => 'Bow*',                     'xp' =>  500, 'gp' =>  3500, 'link' => 'DMG 167' ),
			array( 'chance' => 30, 'text' => 'Bullet, Sling**',          'xp' =>    0, 'gp' =>     0, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Crossbow of Accuracy, +3', 'xp' => 2000, 'gp' => 12000, 'link' => 'DMG 167' ),
			array( 'chance' =>  5, 'text' => 'Crossbow of Distance',     'xp' => 1500, 'gp' =>  7500, 'link' => 'DMG 167' ),
			array( 'chance' =>  5, 'text' => 'Crossbow of Speed',        'xp' => 1500, 'gp' =>  7500, 'link' => 'DMG 167' ),
			array( 'chance' => 60, 'text' => 'Dagger +1, +2 vs. S',      'xp' =>  100, 'gp' =>   750, 'link' => '' ),
			array( 'chance' => 30, 'text' => 'Dagger +2, +3 vs. L',      'xp' =>  250, 'gp' =>  2000, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Dagger +2, Longtooth',     'xp' =>  300, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Dagger of Throwing*',      'xp' =>  250, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' =>  3, 'text' => 'Dagger of Venom',          'xp' =>  350, 'gp' =>  3000, 'link' => 'DMG 167' ),
			array( 'chance' =>  8, 'text' => 'Dart** (3d4)',             'xp' =>    0, 'gp' =>     0, 'link' => '' ),
			array( 'chance' =>  3, 'text' => 'Dart of Homing',           'xp' =>  450, 'gp' =>  4500, 'link' => '' ),
			array( 'chance' => 40, 'text' => 'Flail*',                   'xp' =>  450, 'gp' =>  4000, 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Hammer*',                  'xp' =>  300, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Hammer +3, Dwarven Thrower', 'xp' =>1500,'gp' => 15000, 'link' => 'DMG 167' ),
			array( 'chance' =>  2, 'text' => 'Hammer of Thunderbolts',   'xp' => 2500, 'gp' => 25000, 'link' => 'DMG 167-168' ),
			array( 'chance' =>  5, 'text' => 'Hornblade	* 	*',          'xp' =>    0, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Javelin*',                 'xp' =>  375, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Javelin of Lightning',     'xp' =>  250, 'gp' =>  3000, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Javelin of Piercing',      'xp' =>  250, 'gp' =>  3000, 'link' => '' ),
			array( 'chance' => 40, 'text' => 'Knife*',                   'xp' =>    0, 'gp' =>     0, 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Knife, Buckle*',           'xp' =>  100, 'gp' =>  1000, 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Lance*',                   'xp' =>    0, 'gp' =>     0, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Net of Entrapment',        'xp' => 1000, 'gp' =>  7500, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Net of Snaring',           'xp' => 1000, 'gp' =>  6000, 'link' => '' ),
			array( 'chance' => 30, 'text' => 'Mace*',                    'xp' =>  350, 'gp' =>  3000, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Mace of Disruption',       'xp' => 1750, 'gp' => 17500, 'link' => 'DMG 168' ),
			array( 'chance' => 25, 'text' => 'Military Pick*',           'xp' =>  350, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Morning Star*',            'xp' =>  400, 'gp' =>  3000, 'link' => '' ),
			array( 'chance' =>  8, 'text' => 'Pole Arm* 	*',             'xp' =>    0, 'gp' =>     0, 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Quarterstaff*',            'xp' =>  250, 'gp' =>  1500, 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Scimitar*',                'xp' =>  375, 'gp' =>  3000, 'link' => 'DMG 168' ),
			array( 'chance' =>  5, 'text' => 'Scimitar of Speed*',       'xp' => 2500, 'gp' =>  9000, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Sling of Seeking +2',      'xp' =>  700, 'gp' =>  7000, 'link' => 'DMG 168' ),
			array( 'chance' => 50, 'text' => 'Spear*',                   'xp' =>  500, 'gp' =>  3000, 'link' => 'DMG 168' ),
			array( 'chance' => 15, 'text' => 'Spear, Cursed Backbiter',  'xp' =>    0, 'gp' =>  1000, 'link' => 'DMG 168' ),
			array( 'chance' => 34, 'text' => 'Sword, Long*',             'xp' =>    0, 'gp' =>     0, 'link' => 'DMG' ),
			array( 'chance' => 10, 'text' => 'Sword, Broad*',            'xp' =>    0, 'gp' =>     0, 'link' => 'DMG' ),
			array( 'chance' =>  3, 'text' => 'Sword, Short*',            'xp' =>    0, 'gp' =>     0, 'link' => 'DMG' ),
			array( 'chance' =>  2, 'text' => 'Sword, Bastard*',          'xp' =>    0, 'gp' =>     0, 'link' => 'DMG' ),
			array( 'chance' =>  1, 'text' => 'Sword, Two-Handed*',       'xp' =>    0, 'gp' =>     0, 'link' => 'DMG' ),
			array( 'chance' =>  5, 'text' => 'Trident (Military Fork)*', 'xp' => 1500, 'gp' => 12500, 'link' => 'DMG 168' ),
			array( 'chance' =>  5, 'text' => 'Trident of Fish Command',  'xp' =>  500, 'gp' =>  4000, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Trident of Submission',    'xp' => 1500, 'gp' => 12500, 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Trident of Warning',       'xp' => 1000, 'gp' => 10000, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Trident of Yearning',      'xp' =>    0, 'gp' =>  1000, 'link' => '' ),
			# TODO:  Use info in DND_Character_Trait_Weapons to modify base values
#			'note00' => 'If the max damage for a weapon is below 4, reduce the price by 60%, otherwise, if the max damage is below 6, reduce the price by 30%.  If the min damage for a weapon is above 1, increase the price by 25%.  If the max damage for a weapon is above 8, increase the price by 35%.',
			'note00' => 'Use table in DMG 165 to test for unusual weapons. d100: 01-75) no result, 76-00) see table',
			'note01' => ' * d20: 1-2) -1;x0.25, 3-10) +1, 11-14) +2;x2, 15-17) +3;x4, 18-19) +4;x5, 20) +5;x7',
			'note02' => '** d20: 1-2) -1;x0.25, 3-14) +1, 15-19) +2;x3, 20) +3;x5',
		);
	}


}
