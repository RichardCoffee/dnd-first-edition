<?php
/*

pendant of peace
Hadrian's Mailbox - Invented a century earlier by the arch-mage Hadrian Falonaë, it was both simple and amazing in its power. One wrote a letter to someone by taking quill and ink to paper or parchment. On the outside, the sender addressed the letter by name, and while visualizing the recipient, pulled back the handle near the top, and dropped the missive into the slot of the blue postal box.
	Once inside the mailbox, the envelope would magically transport to the recipient, appearing in midair and floating to the ground by means of a feather fall spell. That is, the letter would float lightly to the ground as if it were as light as a downy feather. If all you had was the person's name and did not personally know the recipient, the letter could take up to three days to arrive. Generally, if you also had the city where the person resided, it would shave off a day of travel time; though it could take longer if the person was out of town, as the mail would actually try to catch up with the person. If you personally knew the person, however, the letter would appear instantly before the recipient, no matter where they were -- across the room or at the other end of the world, as long as they were on the same plane of existence.
	Hadrian, who was still among the living, was a remarkable man and powerful mage, and a renowned expert in both the manufacture of magical items and the crafting of dimensional magic. It was rumored that sometimes the mailboxes would deliver letters to other planes of existence as well. But as Tia had never seen it happen, those could just be rumors.
	The magical mailbox would only transport correspondence written on paper or parchment. Vellum and leather were outright rejected by the mailbox, the slot refusing to open. Attempting to include anything with the letter would likewise be refused; the letter itself would be accepted, while any enclosed items simply fell to the ground outside the mailbox.
	A remarkable feature of the such mail delivered by the mailbox was the ability to reply. If within ten minutes of receiving a letter the recipient chose to respond, they could write a response on the original letter, even if they themselves didn't have a Hadrian's Mailbox of their own. One simply folded their reply into the shape of a paper airplane and threw it. The envelope would vanish, instantly returning to the sender. This back and forth could go on several times as long as space remained on the original letter.
Essence of Osh Mayan - "If someone dies, a single drop will bring them back to life, guaranteed, instantly healed of all injury, poisons, and disease, even curing any curses. However, if it's consumed by someone still alive, besides the healing, it also gives a slight yet permanent increase to a person's appearance, making them more attractive and persuasive. Hair on your head will grow at least a foot. Within two minutes after you take a dose -- right Tia? Yeah, two minutes later, you are filled with an intense desire to have sex. No, that's not descriptive enough. For two hours, the only thing you want to do is have mad, passionate, animal-sex, and have really intense, frequent orgasms. Even guys can come over and over and not get soft. Or so I'm told. I've not personally seen it work."
	"Two whole hours," Mindal confirmed. "Coming over and over. Then the imbiber falls asleep for another two hours, happy and exhausted. When they wake up, blamo! The woman is pregnant! Even if you are normally sterile, taking this magic drink will guarantee your ability to impregnate if you are male and a successful pregnancy if you are female. And the baby is born healthy and hale."

*/
trait DND_Combat_Treasure_Tables {


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
			array( 'chance' =>  6, 'text' => 'Swords',                     'sub' => 'swords' ),
			array( 'chance' => 19, 'text' => 'Miscellaneous Weapons (d1000)', 'sub' => 'weapons' ),
		);
	}

	protected function get_potions_table() {
		return array(
			'title' => 'Potions: 1d1000',
			array( 'chance' => 20, 'text' => 'Animal Control',            'prefix' => 'POAC', 'xp' => 250, 'gp' =>   400, 'link' => 'DMG 124' ),
			array( 'chance' => 20, 'text' => 'Clairaudience',             'prefix' => 'POCA', 'xp' => 250, 'gp' =>   400, 'link' => 'DMG 124' ),
			array( 'chance' => 20, 'text' => 'Clairvoyance',              'prefix' => 'POCV', 'xp' => 300, 'gp' =>   500, 'link' => 'DMG 124' ),
			array( 'chance' => 30, 'text' => 'Climbing',                  'prefix' => 'PCLB', 'xp' => 300, 'gp' =>   500, 'link' => 'DMG 124' ),
			array( 'chance' => 20, 'text' => 'Cursed/Poison',             'prefix' => 'POCD', 'xp' => '~', 'gp' => '~~~', 'link' => 'DMG 126' ),
			array( 'chance' => 10, 'text' => 'Delusion',                  'prefix' => 'PDLU', 'xp' => '~', 'gp' =>   150, 'link' => 'DMG 124' ),
			array( 'chance' => 20, 'text' => 'Diminution',                'prefix' => 'PDIM', 'xp' => 300, 'gp' =>   500, 'link' => 'DMG 124' ),
			array( 'chance' => 17, 'text' => 'Dragon Control',            'prefix' => 'PDC' , 'xp' => 700, 'gp' =>  5000, 'link' => 'DMG 124' ),
			array( 'chance' =>  2, 'text' => 'Evil Dragon Control',       'prefix' => 'PDCE', 'xp' => 700, 'gp' =>  9000, 'link' => 'DMG 124' ),
			array( 'chance' =>  1, 'text' => 'Good Dragon Control',       'prefix' => 'PDCG', 'xp' => 700, 'gp' =>  9000, 'link' => 'DMG 124' ),
			array( 'chance' => 10, 'text' => 'Elixir of Health',          'prefix' => 'PEOH', 'xp' => 350, 'gp' =>  2000, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Elixir of Madness',         'prefix' => 'PEOM', 'xp' => '~', 'gp' => '~~~', 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Elixir of Youth',           'prefix' => 'PEOY', 'xp' => 500, 'gp' => 10000, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'ESP',                       'prefix' => 'PESP', 'xp' => 500, 'gp' =>   850, 'link' => 'DMG 124' ),
			array( 'chance' => 50, 'text' => 'Extra-Healing',             'prefix' => 'PEXH', 'xp' => 400, 'gp' =>   800, 'link' => 'DMG 125' ),
			array( 'chance' => 10, 'text' => 'Fire Breath',               'prefix' => 'PFIB', 'xp' => 400, 'gp' =>  4000, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Fire Resistance',           'prefix' => 'POFR', 'xp' => 250, 'gp' =>   400, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Flying',                    'prefix' => 'PFLY', 'xp' => 500, 'gp' =>   750, 'link' => 'DMG 125', 'symbol' => 'pair of wings' ),
			array( 'chance' => 20, 'text' => 'Gaseous Form',              'prefix' => 'PGAS', 'xp' => 300, 'gp' =>   400, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Giant Control',             'prefix' => 'PGC' , 'xp' => 600, 'gp' =>  1000, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Giant Strength',            'prefix' => 'PGS' , 'xp' => 550, 'gp' =>   900, 'link' => 'DMG 125' ),
			array( 'chance' => 15, 'text' => 'Growth',                    'prefix' => 'PGRO', 'xp' => 250, 'gp' =>   300, 'link' => 'DMG 125' ),
			array( 'chance' => 40, 'text' => 'Healing',                   'prefix' => 'PHEA', 'xp' => 200, 'gp' =>   400, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Heroism(F)',                'prefix' => 'POHE', 'xp' => 300, 'gp' =>   500, 'restrict' => 'F', 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Human Control: Dwarves',    'prefix' => 'PHC' , 'xp' => 500, 'gp' =>   900, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Invisibility',              'prefix' => 'PINV', 'xp' => 250, 'gp' =>   500, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Invulnerability(F)',        'prefix' => 'PIVN', 'xp' => 350, 'gp' =>   500, 'restrict' => 'F', 'link' => 'DMG 125', 'symbol' => 'red man with white outline' ),
			array( 'chance' => 20, 'text' => 'Levitation',                'prefix' => 'PLEV', 'xp' => 250, 'gp' =>   400, 'link' => 'DMG 125' ),
			array( 'chance' => 20, 'text' => 'Longevity',                 'prefix' => 'PLON', 'xp' => 500, 'gp' =>  1000, 'link' => 'DMG 125' ),
			array( 'chance' => 30, 'text' => 'Neutralize Poison',         'prefix' => 'PNTP', 'xp' => 300, 'gp' =>   500, 'link' => '', 'symbol' => 'drop with alternationg red and green bands' ),
			array( 'chance' => 10, 'text' => 'Oil of Acid Resistance',    'prefix' => 'POAR', 'xp' => 500, 'gp' =>  5000, 'link' => '', 'symbol' => 'horizontal line below three vertical squiggly lines' ),
			array( 'chance' => 10, 'text' => 'Oil of Disenchantment',     'prefix' => 'PODS', 'xp' => 750, 'gp' =>  3500, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Oil of Elemental Invulnerability','prefix'=>'PEI','xp'=>500, 'gp' =>  5000, 'link' => 'http://www.mountnevermind.de/Dokumente/DMG/DD00732.htm' ),
			array( 'chance' => 20, 'text' => 'Oil of Etherealness',       'prefix' => 'PETR', 'xp' => 600, 'gp' =>  1500, 'link' => 'DMG 125' ),
			array( 'chance' => 10, 'text' => 'Oil of Fiery Burning',      'prefix' => 'POFB', 'xp' => 500, 'gp' =>  4000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Oil of Fumbling**',         'prefix' => 'PFUM', 'xp' => '~', 'gp' =>  1000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Oil of Impact',             'prefix' => 'POIM', 'xp' => 750, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Oil of Slipperiness',       'prefix' => 'POSL', 'xp' => 400, 'gp' =>   750, 'link' => 'DMG 126' ),
			array( 'chance' => 10, 'text' => 'Oil of Timelessness',       'prefix' => 'POTM', 'xp' => 500, 'gp' =>  2000, 'link' => '', 'symbol' => 'clock face' ),
			array( 'chance' => 10, 'text' => 'Philter of Glibness',       'prefix' => 'PPGB', 'xp' => 500, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Philter of Love',           'prefix' => 'PPLV', 'xp' => 200, 'gp' =>   300, 'link' => 'DMG 126', 'symbol' => 'heart' ),
			array( 'chance' => 20, 'text' => 'Philter of Persuasiveness', 'prefix' => 'PPPS', 'xp' => 400, 'gp' =>   850, 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Philter of Stammering and Stuttering**','prefix'=>'PPSS','xp'=>'~','gp'=>1500,'link' => '' ),
			array( 'chance' => 20, 'text' => 'Plant Control',             'prefix' => 'POPC', 'xp' => 250, 'gp' =>   300, 'link' => 'DMG 126', 'symbol' => 'three leaves' ),
			array( 'chance' => 20, 'text' => 'Polymorph Self',            'prefix' => 'PPMS', 'xp' => 200, 'gp' =>   350, 'link' => 'DMG 126', 'symbol' => 'green person with white squiggly outline' ),
			array( 'chance' => 10, 'text' => 'Rainbow Hues',              'prefix' => 'PHUE', 'xp' => 200, 'gp' =>   800, 'link' => '', 'symbol' => 'rainbow' ),
			array( 'chance' => 20, 'text' => 'Speed',                     'prefix' => 'PSPD', 'xp' => 200, 'gp' =>   450, 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Super-Heroism (F)',         'prefix' => 'PSHE', 'xp' => 450, 'gp' =>   750, 'restrict' => 'F', 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Sweet Water',               'prefix' => 'POSW', 'xp' => 200, 'gp' =>   250, 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Treasure Finding',          'prefix' => 'POTF', 'xp' => 600, 'gp' =>  2000, 'link' => 'DMG 126' ),
			array( 'chance' => 20, 'text' => 'Undead Control',            'prefix' => 'PUC' , 'xp' => 700, 'gp' =>  2500, 'link' => 'DMG 126' ),
			array( 'chance' => 10, 'text' => 'Ventriloquism',             'prefix' => 'PVEN', 'xp' => 200, 'gp' =>   800, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Vitality',                  'prefix' => 'PVIT', 'xp' => 300, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Water Breathing',           'prefix' => 'POWB', 'xp' => 400, 'gp' =>   900, 'link' => 'DMG 126', 'symbol' => 'three squiggly horizontal lines with small circles between' ),
			array( 'chance' => 35, 'text' => "DM's choice",               'prefix' => 'PDMC', 'xp' => '~', 'gp' => '~~~', 'link' => '' ),
		);
	}

	protected function get_dragon_type_table() {
		return array(
			array( 'chance' => 10, 'text' => 'Black',  'postfix' => 'B' ), // 10
			array( 'chance' => 10, 'text' => 'Blue',   'postfix' => 'U' ), // 20
			array( 'chance' => 10, 'text' => 'Brass',  'postfix' => 'A' ), // 30
			array( 'chance' =>  5, 'text' => 'Bronze', 'postfix' => 'Z' ), // 35
			array( 'chance' =>  5, 'text' => 'Cloud',  'postfix' => 'L' ), // 40
			array( 'chance' => 10, 'text' => 'Copper', 'postfix' => 'C' ), // 50
			array( 'chance' =>  5, 'text' => 'Faerie', 'postfix' => 'F' ),
			array( 'chance' =>  5, 'text' => 'Gold',   'postfix' => 'O' ), // 55
			array( 'chance' => 15, 'text' => 'Green',  'postfix' => 'N' ), // 70
			array( 'chance' =>  5, 'text' => 'Mist',   'postfix' => 'M' ), // 75
			array( 'chance' =>  5, 'text' => 'Red',    'postfix' => 'R' ), // 80
			array( 'chance' =>  5, 'text' => 'Shadow', 'postfix' => 'S' ), // 85
			array( 'chance' =>  5, 'text' => 'Silver', 'postfix' => 'V' ), // 90
			array( 'chance' => 10, 'text' => 'White',  'postfix' => 'W' ), // 100
		);
	}

	protected function get_elemental_type_table() {
		return array(
			array( 'chance' => 25, 'text' => 'Air',   'postfix' => 'A' ),
			array( 'chance' => 25, 'text' => 'Earth', 'postfix' => 'E' ),
			array( 'chance' => 25, 'text' => 'Fire',  'postfix' => 'F' ),
			array( 'chance' => 25, 'text' => 'Water', 'postfix' => 'W' ),
		);
	}

	protected function get_giant_type_table() {
		return array(
			array( 'chance' => 25, 'text' => 'Hill',  'postfix' => 'H' ),
			array( 'chance' => 20, 'text' => 'Stone', 'postfix' => 'N' ),
			array( 'chance' => 20, 'text' => 'Frost', 'postfix' => 'F' ),
			array( 'chance' => 20, 'text' => 'Fire',  'postfix' => 'I' ),
			array( 'chance' => 10, 'text' => 'Cloud', 'postfix' => 'C' ),
			array( 'chance' =>  5, 'text' => 'Storm', 'postfix' => 'M' ),
		);
	}

	protected function get_human_type_table() {
		return array(
			array( 'chance' => 10, 'text' => 'Dwarves',                 'postfix' => 'D' ),
			array( 'chance' => 10, 'text' => 'Elves/Half-Elves',        'postfix' => 'E' ),
			array( 'chance' => 10, 'text' => 'Gnomes',                  'postfix' => 'G' ),
			array( 'chance' => 10, 'text' => 'Halflings',               'postfix' => 'F' ),
			array( 'chance' => 10, 'text' => 'Half-Orcs',               'postfix' => 'O' ),
			array( 'chance' => 30, 'text' => 'Humans',                  'postfix' => 'U' ),
			array( 'chance' => 15, 'text' => 'Humanoids',               'postfix' => 'D' ),
			array( 'chance' =>  5, 'text' => 'Elves/Half-Elves/Humans', 'postfix' => 'H' ),
		);
	}

	protected function get_undead_type_table() {
		return array(
			array( 'chance' => 10, 'text' => 'Ghast',    'postfix' => 'A' ),
			array( 'chance' => 10, 'text' => 'Ghost',    'postfix' => 'O' ),
			array( 'chance' => 10, 'text' => 'Ghoul',    'postfix' => 'U' ),
			array( 'chance' => 10, 'text' => 'Shadow',   'postfix' => 'D' ),
			array( 'chance' => 15, 'text' => 'Skeleton', 'postfix' => 'S' ),
			array( 'chance' => 10, 'text' => 'Spectre',  'postfix' => 'P' ),
			array( 'chance' => 10, 'text' => 'Wight',    'postfix' => 'W' ),
			array( 'chance' => 10, 'text' => 'Wraith',   'postfix' => 'R' ),
			array( 'chance' =>  5, 'text' => 'Vampire',  'postfix' => 'V' ),
			array( 'chance' => 10, 'text' => 'Zombie',   'postfix' => 'Z' ),
		);
	}

	protected function get_scrolls_table() {
		return array(
			'title' => 'Scrolls:  1d100 - M:01-63, I:64-70, C:71-93, D:94-00',
			array( 'chance' => 10, 'text' => '1 spell',  'prefix' => 'S1', 'cdi' => [ 1, 1, 4 ] ),
			array( 'chance' =>  6, 'text' => '1 spell',  'prefix' => 'S1', 'cdi' => [ 1, 1, 6 ] ),
			array( 'chance' =>  3, 'text' => '1 spell',  'prefix' => 'S1', 'cdi' => [ 1, 2, 7 ], 'm' => [ 1, 2, 9 ] ),
			array( 'chance' =>  5, 'text' => '2 spells', 'prefix' => 'S2', 'cdi' => [ 2, 1, 4 ] ),
			array( 'chance' =>  3, 'text' => '2 spells', 'prefix' => 'S2', 'cdi' => [ 2, 1, 6 ], 'm' => [ 2, 0, 8 ] ),
			array( 'chance' =>  5, 'text' => '3 spells', 'prefix' => 'S3', 'cdi' => [ 3, 1, 4 ] ),
			array( 'chance' =>  3, 'text' => '3 spells', 'prefix' => 'S3', 'cdi' => [ 3, 1, 6 ], 'm' => [ 3, 0, 8 ] ),
			array( 'chance' =>  4, 'text' => '4 spells', 'prefix' => 'S4', 'cdi' => [ 4, 1, 6 ] ),
			array( 'chance' =>  3, 'text' => '4 spells', 'prefix' => 'S4', 'cdi' => [ 4, 1, 6 ], 'm' => [ 4, 0, 8 ] ),
			array( 'chance' =>  4, 'text' => '5 spells', 'prefix' => 'S5', 'cdi' => [ 5, 1, 6 ] ),
			array( 'chance' =>  3, 'text' => '5 spells', 'prefix' => 'S5', 'cdi' => [ 5, 1, 6 ], 'm' => [ 5, 0, 8 ] ),
			array( 'chance' =>  3, 'text' => '6 spells', 'prefix' => 'S6', 'cdi' => [ 6, 1, 6 ] ),
			array( 'chance' =>  2, 'text' => '6 spells', 'prefix' => 'S6', 'cdi' => [ 6, 3, 6 ], 'm' => [ 6, 3, 8 ] ),
			array( 'chance' =>  3, 'text' => '7 spells', 'prefix' => 'S7', 'cdi' => [ 7, 1, 6 ], 'm' => [ 7, 0, 8 ] ),
			array( 'chance' =>  2, 'text' => '7 spells', 'prefix' => 'S7', 'cdi' => [ 7, 2, 7 ], 'm' => [ 7, 2, 9 ] ),
			array( 'chance' =>  1, 'text' => '7 spells', 'prefix' => 'S7', 'cdi' => [ 7, 4, 7 ], 'm' => [ 7, 4, 9 ] ),
			array( 'chance' =>  2, 'text' => 'Protection - Acid',          'prefix' => 'SACI', 'xp' => 2500, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Cold',          'prefix' => 'SCOL', 'xp' => 2000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Demons',        'prefix' => 'SDEM', 'xp' => 2500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Devils',        'prefix' => 'SDEV', 'xp' => 2500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Dragon Breath', 'prefix' => 'SDRA', 'xp' => 2000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Electricity',   'prefix' => 'SELE', 'xp' => 1500, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Protection - Elementals',    'prefix' => 'SELM', 'xp' => 1500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Fire',          'prefix' => 'SFIR', 'xp' => 2000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Gas',           'prefix' => 'SGAS', 'xp' => 2000, 'link' => '' ),
			array( 'chance' =>  4, 'text' => 'Protection - Lycanthropes',  'prefix' => 'SLYC', 'xp' => 1000, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Magic',         'prefix' => 'SMAG', 'xp' => 1500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Petrification', 'prefix' => 'SPET', 'xp' => 2000, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Plants',        'prefix' => 'SPLA', 'xp' => 1000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Poison',        'prefix' => 'SPOI', 'xp' => 1000, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Protection - Possession',    'prefix' => 'SPOS', 'xp' => 2000, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Undead',        'prefix' => 'SUND', 'xp' => 1500, 'link' => 'DMG 127' ),
			array( 'chance' =>  2, 'text' => 'Protection - Water',         'prefix' => 'SWAT', 'xp' => 1500, 'link' => '' ),
			array( 'chance' =>  2, 'text' => 'Curse**', 'prefix' => 'SCUR' ),
		);
	}

	protected function get_scrolls_type_table() {
		return array(
			array( 'chance' => 63, 'type' => 'M', 'class' => 'DND_Character_MagicUser' ),
			array( 'chance' =>  7, 'type' => 'I', 'class' => 'DND_Character_Illusionist' ),
			array( 'chance' => 23, 'type' => 'C', 'class' => 'DND_Character_Cleric' ),
			array( 'chance' =>  7, 'type' => 'D', 'class' => 'DND_Character_Druid' ),
		);
	}

	protected function get_scrolls_curse_table() {
		return array(
			array( 'chance' => 25, 'text' => 'Reader polymorphed to monster of equal level which attacks any creatures nearby' ),
			array( 'chance' =>  5, 'text' => 'Reader turned to liquid and drains away' ),
			array( 'chance' =>  5, 'text' => "Reader ond all within 20' radius transported 200 to 1,200 miles in a random direction" ),
			array( 'chance' => 10, 'text' => "Reader and all in 20' radius transported to another planet, plane or continuum" ),
			array( 'chance' => 25, 'text' => 'Disease fatal to reader in 2d4 turns unless cured' ),
			array( 'chance' => 15, 'text' => 'Explosive runes' ),
			array( 'chance' =>  9, 'text' => 'Magic item nearby is "de-magicked"' ),
			array( 'chance' =>  1, 'text' => 'Randomly rolled spell affects reader at 12th level of magic-use' ),
		);
	}

	protected function get_rings_table() {
		return array(
			'title' => 'Rings: 1d1000',
			array( 'chance' => 10, 'text' => 'Animal Friendship', 'prefix' => 'RANI', 'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Blinking',          'prefix' => 'RBLI', 'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Chameleon Power',   'prefix' => 'RCHM', 'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 30, 'text' => 'Charisma',          'prefix' => 'RCHR', 'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 129' ),
			array( 'chance' => 10, 'text' => 'Contrariness: Flying',          'prefix' => 'RCFL', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
			array( 'chance' => 10, 'text' => 'Contrariness: Invisibility',    'prefix' => 'RCIV', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
			array( 'chance' => 10, 'text' => 'Contrariness: Levitation',      'prefix' => 'RCLV', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
			array( 'chance' => 10, 'text' => 'Contrariness: Shocking Grasp',  'prefix' => 'RCSG', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
			array( 'chance' => 10, 'text' => 'Contrariness: Spell Turning',   'prefix' => 'RCST', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
			array( 'chance' => 10, 'text' => 'Contrariness: Strength(18/00)', 'prefix' => 'RCST', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 128' ),
			array( 'chance' => 60, 'text' => 'Delusion',          'prefix' => 'RDUL', 'xp' => '~~', 'gp' =>  2000, 'link' => 'DMG 128' ),
			array( 'chance' =>  2, 'text' => 'Djinni Summoning',  'prefix' => 'RDJS', 'xp' => 3000, 'gp' => 20000, 'link' => 'DMG 128' ),
			array( 'chance' =>  1, 'text' => 'Elemental Command: Air   (Invisibility)',    'prefix' => 'RECA', 'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 128' ),
			array( 'chance' =>  1, 'text' => 'Elemental Command: Earth (Feather Falling)', 'prefix' => 'RECE', 'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 128-129' ),
			array( 'chance' =>  1, 'text' => 'Elemental Command: Fire  (Fire Resistance)', 'prefix' => 'RECF', 'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 128-129' ),
			array( 'chance' =>  1, 'text' => 'Elemental Command: Water (Water Walking)',   'prefix' => 'RECW', 'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 128-129' ),
			array( 'chance' => 60, 'text' => 'Feather Falling',   'prefix' => 'RFEA', 'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
			array( 'chance' => 60, 'text' => 'Fire Resistance',   'prefix' => 'RFIR', 'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
			array( 'chance' => 30, 'text' => 'Free Action',       'prefix' => 'RACT', 'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
			array( 'chance' => 70, 'text' => 'Invisibility',      'prefix' => 'RINV', 'xp' => 1500, 'gp' =>  7500, 'link' => 'DMG 129' ),
			array( 'chance' => 20, 'text' => 'Jumping',           'prefix' => 'RJUM', 'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 30, 'text' => 'Mammal Control',    'prefix' => 'RMAM', 'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
			array( 'chance' => 10, 'text' => 'Mind Shielding',    'prefix' => 'RMIN', 'xp' =>  500, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 70, 'text' => 'Protection +1',     'prefix' => 'RPP1', 'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 129' ),
			array( 'chance' => 12, 'text' => 'Protection +2',     'prefix' => 'RPP2', 'xp' => 2500, 'gp' => 12000, 'link' => 'DMG 129' ),
			array( 'chance' =>  1, 'text' => 'Protection +2, 5-foot radius protection',  'prefix' => 'RP25', 'xp' => 3000, 'gp' => 15000, 'link' => 'DMG 129' ),
			array( 'chance' =>  7, 'text' => 'Protection +3',     'prefix' => 'RPP3', 'xp' => 4000, 'gp' => 20000, 'link' => 'DMG 129' ),
			array( 'chance' =>  1, 'text' => 'Protection +3, 5-foot radius protection',  'prefix' => 'RP35', 'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 129' ),
			array( 'chance' =>  6, 'text' => 'Protection +4 on AC, +2 to saving throws', 'prefix' => 'RP42', 'xp' => 4800, 'gp' => 24000, 'link' => 'DMG 129' ),
			array( 'chance' =>  3, 'text' => 'Protection +6 on AC, +1 to saving throws', 'prefix' => 'RP61', 'xp' => 6000, 'gp' => 30000, 'link' => 'DMG 129' ),
			array( 'chance' => 10, 'text' => 'Ram, Ring of the*',       'prefix' => 'RRAM', 'xp' =>  750, 'gp' =>  7500, 'link' => '' ),
			array( 'chance' =>  9, 'text' => 'Regeneration (1hp/rd)',   'prefix' => 'RREG', 'xp' => 5000, 'gp' => 40000, 'link' => 'DMG 129' ),
			array( 'chance' =>  1, 'text' => 'Regeneration (vampiric)', 'prefix' => 'RVAM', 'xp' => 5000, 'gp' => 40000, 'link' => 'DMG 129' ),
			array( 'chance' => 10, 'text' => 'Shocking Grasp',          'prefix' => 'RGRA', 'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 20, 'text' => 'Shooting Stars',          'prefix' => 'RSTA', 'xp' => 3000, 'gp' => 15000, 'link' => 'DMG 129-130' ),
			array( 'chance' => 20, 'text' => 'Spell Storing',           'prefix' => 'RSS' , 'xp' => 2500, 'gp' => 22500, 'link' => 'DMG 130' ),
			array( 'chance' => 40, 'text' => 'Spell Turning',           'prefix' => 'RSPE', 'xp' => 2000, 'gp' => 17500, 'link' => 'DMG 130' ),
			array( 'chance' => 15, 'text' => 'Sustenance',              'prefix' => 'RSUS', 'xp' =>  500, 'gp' =>  3500, 'link' => '' ),
			array( 'chance' => 60, 'text' => 'Swimming',                'prefix' => 'RSWI', 'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 130' ),
			array( 'chance' =>  5, 'text' => 'Telekinesis: 25 lbs',     'prefix' => 'RT25', 'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
			array( 'chance' =>  5, 'text' => 'Telekinesis: 50 lbs',     'prefix' => 'RT50', 'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
			array( 'chance' =>  4, 'text' => 'Telekinesis: 100 lbs',    'prefix' => 'RT10', 'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
			array( 'chance' =>  2, 'text' => 'Telekinesis: 200 lbs',    'prefix' => 'RT20', 'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
			array( 'chance' =>  1, 'text' => 'Telekinesis: 400 lbs',    'prefix' => 'RT40', 'xp' => 2000, 'gp' => 10000, 'link' => 'DMG 130' ),
			array( 'chance' => 10, 'text' => 'Truth',                   'prefix' => 'RTRU', 'xp' => 1000, 'gp' =>  5000, 'link' => '' ),
			array( 'chance' => 60, 'text' => 'Warmth',                  'prefix' => 'RWAR', 'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 130' ),
			array( 'chance' => 50, 'text' => 'Water Walking',           'prefix' => 'RWAT', 'xp' => 1000, 'gp' =>  5000, 'link' => 'DMG 131' ),
			array( 'chance' => 80, 'text' => 'Weakness',                'prefix' => 'RWEA', 'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 131' ),
			array( 'chance' =>  4, 'text' => 'Wishes, Multiple',        'prefix' => 'RWM' , 'xp' => 5000, 'gp' => 25000, 'link' => 'DMG 129' ),
			array( 'chance' =>  8, 'text' => 'Wishes, Three',           'prefix' => 'RWIS', 'xp' => 3000, 'gp' => 15000, 'link' => 'DMG 130' ),
			array( 'chance' => 10, 'text' => 'Wizardry* (MU)',          'prefix' => 'RWIZ', 'xp' => 4000, 'gp' => 50000, 'restrict' => 'M', 'link' => 'DMG 131' ),
			array( 'chance' => 10, 'text' => 'X-Ray Vision',            'prefix' => 'RXRY', 'xp' => 4000, 'gp' => 35000, 'link' => 'DMG 131' ),
		);
	}

	protected function get_rods_table() {
		return array(
			'title' => 'Rods',
			array( 'chance' => 10, 'text' => 'Absorption (C,MU)',     'xp' =>  7500, 'gp' => 40000, 'restrict' => 'CM', 'link' => 'DMG 131' ),
			array( 'chance' =>  5, 'text' => 'Alertness',             'xp' =>  7000, 'gp' => 50000, 'link' => '' ),
			array( 'chance' =>  3, 'text' => 'Beguiling (C,MU,T)',    'xp' =>  5000, 'gp' => 30000, 'restrict' => 'CMT', 'link' => 'DMG 131-132' ),
			array( 'chance' => 29, 'text' => 'Cancellation',          'xp' => 10000, 'gp' => 15000, 'link' => 'DMG 132' ),
			array( 'chance' =>  3, 'text' => 'Captivation',           'xp' =>  5000, 'gp' => 30000, 'link' => 'OS 321' ),
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
			array( 'chance' => 12, 'text' => "Boccob's Blessed Book (M)",            'xp' => 4500, 'gp' => 35000, 'restrict' => 'M', 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Book of Exalted Deeds (C)',            'xp' => 8000, 'gp' => 40000, 'restrict' => 'C:Good', 'link' => 'DMG 137' ),
			array( 'chance' =>  5, 'text' => 'Book of Infinite Spells',              'xp' => 9000, 'gp' => 50000, 'link' => 'DMG 137-138' ),
			array( 'chance' =>  5, 'text' => 'Book of Neutrality (C)',               'xp' => 8000, 'gp' => 40000, 'restrict' => 'C:Neutral', 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Book of Vile Darkness (C)',            'xp' => 8000, 'gp' => 40000, 'restrict' => 'C:Evil', 'link' => 'DMG 138' ),
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
			array( 'chance' =>  8, 'text' => 'Vacuous Grimoire',                     'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 154' ),
		);
	}

	protected function get_jewels_jewelry_table() {
		return array(
			'title' => 'Jewels, Jewelry, and Phylacteries',
			array( 'chance' =>  2, 'text' => 'Amulet of Inescapable Location',             'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 136' ),
			array( 'chance' =>  1, 'text' => 'Amulet of Health',                           'xp' => 7000, 'gp' => 30000, 'link' => 'https://roll20.net/compendium/dnd5e/Amulet of Health' ),
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
			array( 'chance' =>  3, 'text' => 'Talisman of Pure Good (C)',                  'xp' => 3500, 'gp' => 27500, 'restrict' => 'C:Good', 'link' => 'DMG 154' ),
			array( 'chance' =>  1, 'text' => 'Talisman of the Sphere (M)',                 'xp' =>  100, 'gp' => 10000, 'restrict' => 'M', 'link' => 'DMG 154' ),
			array( 'chance' =>  2, 'text' => 'Talisman of Ultimate Evil (C)',              'xp' => 3500, 'gp' => 32500, 'restrict' => 'C:Evil', 'link' => 'DMG 154' ),
			array( 'chance' =>  5, 'text' => 'Talisman of Zagy',                           'xp' => 1000, 'gp' => 10000, 'link' => 'DMG 154' ),
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
			array( 'chance' =>  3, 'text' => 'Gauntlets of Fumbling',                  'xp' => '~~', 'gp' =>  1000, 'link' => 'DMG 144' ),
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
			array( 'chance' =>  1, 'text' => 'Horn of Goodness (Evil)',   'xp' =>  750, 'gp' =>  3250, 'restrict' => ':Evil', 'link' => '' ),
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
			array( 'chance' =>  1, 'text' => 'Wind Fan: Gust of Wind (12th) PH 75', 'prefix' => 'WFGW', 'xp' =>   500, 'gp' =>  2500, 'link' => '' ),
			array( 'chance' => 10, 'text' => 'Wings of Flying',             'xp' =>   750, 'gp' =>  7500, 'link' => 'DMG 154' ),
			'note01' => ' * roll % for type, xp/gp is per hit die of figurine.',
			'note02' => '** roll 1d20 for type of token.',
		);
	}

	protected function get_armor_shields_table() {
		$combined = array();
		$combined['title'] = 'Armor and Shields: 1d1000';
		$armor = $this->get_armor_table();
		foreach( $armor as $entry ) {
			$combined[] = $entry;
		}
		$shields = $this->get_shields_table();
		foreach( $shields as $entry ) {
			$combined[] = $entry;
		}
		$combined['note00'] = 'Roll for size: 1d100 - 01-65: Human, 66-85: Elven, 86-95: Dwarven, 96-00: Gnome/Halfling';
		return $combined;
	}

	protected function get_armor_table() {
		return array(
			array( 'chance' => 24, 'text' => 'Banded +1',       'bonus' => 1, 'prefix' => 'BDP1', 'key' => 'banded',     'xp' =>  700, 'gp' =>   4000, 'link' => 'DMG' ),
			array( 'chance' => 18, 'text' => 'Banded +2',       'bonus' => 2, 'prefix' => 'BDP2', 'key' => 'banded',     'xp' => 1500, 'gp' =>   8500, 'link' => 'DMG' ),
			array( 'chance' => 12, 'text' => 'Banded +3',       'bonus' => 3, 'prefix' => 'BDP3', 'key' => 'banded',     'xp' => 2250, 'gp' =>  14500, 'link' => 'DMG' ),
			array( 'chance' =>  6, 'text' => 'Banded +4',       'bonus' => 4, 'prefix' => 'BDP4', 'key' => 'banded',     'xp' => 3000, 'gp' =>  19000, 'link' => 'DMG' ),
			array( 'chance' => 30, 'text' => 'Brigandine +1',   'bonus' => 1, 'prefix' => 'BGP1', 'key' => 'brigandine', 'xp' =>  500, 'gp' =>   3000, 'link' => '' ),
			array( 'chance' => 18, 'text' => 'Brigandine +2',   'bonus' => 2, 'prefix' => 'BGP2', 'key' => 'brigandine', 'xp' => 1100, 'gp' =>   6750, 'link' => '' ),
			array( 'chance' =>  6, 'text' => 'Brigandine +3',   'bonus' => 3, 'prefix' => 'BGP3', 'key' => 'brigandine', 'xp' => 1650, 'gp' =>  10500, 'link' => '' ),
			array( 'chance' => 24, 'text' => 'Bronze Plate +1', 'bonus' => 1, 'prefix' => 'BPP1', 'key' => 'bronze',     'xp' =>  700, 'gp' =>   4500, 'link' => 'DMG' ),
			array( 'chance' => 18, 'text' => 'Bronze Plate +2', 'bonus' => 3, 'prefix' => 'BPP2', 'key' => 'bronze',     'xp' => 1500, 'gp' =>   9500, 'link' => 'DMG' ),
			array( 'chance' => 12, 'text' => 'Bronze Plate +3', 'bonus' => 3, 'prefix' => 'BPP3', 'key' => 'bronze',     'xp' => 2250, 'gp' =>  15000, 'link' => 'DMG' ),
			array( 'chance' =>  6, 'text' => 'Bronze Plate +4', 'bonus' => 4, 'prefix' => 'BPP4', 'key' => 'bronze',     'xp' => 3000, 'gp' =>  19500, 'link' => 'DMG' ),
			array( 'chance' =>  3, 'text' => 'Bronze Plate +5', 'bonus' => 5, 'prefix' => 'BPP5', 'key' => 'bronze',     'xp' => 3750, 'gp' =>  25500, 'link' => 'DMG' ),
			array( 'chance' => 30, 'text' => 'Chain Mail +1',   'bonus' => 1, 'prefix' => 'CMP1', 'key' => 'chain',      'xp' =>  600, 'gp' =>   3500, 'link' => 'DMG' ),
			array( 'chance' => 24, 'text' => 'Chain Mail +2',   'bonus' => 2, 'prefix' => 'CMP2', 'key' => 'chain',      'xp' => 1200, 'gp' =>   7500, 'link' => 'DMG' ),
			array( 'chance' => 18, 'text' => 'Chain Mail +3',   'bonus' => 3, 'prefix' => 'CMP3', 'key' => 'chain',      'xp' => 2000, 'gp' =>  12500, 'link' => 'DMG' ),
			array( 'chance' => 12, 'text' => 'Chain Mail +4',   'bonus' => 4, 'prefix' => 'CMP4', 'key' => 'chain',      'xp' => 4000, 'gp' =>  16500, 'link' => 'DMG' ),
			array( 'chance' =>  6, 'text' => 'Chain Mail +5',   'bonus' => 5, 'prefix' => 'CMP5', 'key' => 'chain',      'xp' => 6000, 'gp' =>  20500, 'link' => 'DMG' ),
			array( 'chance' => 12, 'text' => 'Field Plate +1',  'bonus' => 1, 'prefix' => 'FDP1', 'key' => 'field',      'xp' =>  900, 'gp' =>  15000, 'link' => 'UA' ),
			array( 'chance' => 10, 'text' => 'Field Plate +2',  'bonus' => 2, 'prefix' => 'FDP2', 'key' => 'field',      'xp' => 1800, 'gp' =>  30000, 'link' => 'UA' ),
			array( 'chance' =>  8, 'text' => 'Field Plate +3',  'bonus' => 3, 'prefix' => 'FDP3', 'key' => 'field',      'xp' => 2700, 'gp' =>  50000, 'link' => 'UA' ),
			array( 'chance' =>  4, 'text' => 'Field Plate +4',  'bonus' => 4, 'prefix' => 'FDP4', 'key' => 'field',      'xp' => 3600, 'gp' =>  80000, 'link' => 'UA' ),
			array( 'chance' =>  2, 'text' => 'Field Plate +5',  'bonus' => 5, 'prefix' => 'FDP5', 'key' => 'field',      'xp' => 4800, 'gp' => 120000, 'link' => 'UA' ),
			array( 'chance' =>  6, 'text' => 'Full Plate +1',   'bonus' => 1, 'prefix' => 'FPP1', 'key' => 'full',       'xp' => 1000, 'gp' =>  30000, 'link' => 'UA' ),
			array( 'chance' =>  5, 'text' => 'Full Plate +2',   'bonus' => 2, 'prefix' => 'FPP2', 'key' => 'full',       'xp' => 2000, 'gp' =>  50000, 'link' => 'UA' ),
			array( 'chance' =>  4, 'text' => 'Full Plate +3',   'bonus' => 3, 'prefix' => 'FPP3', 'key' => 'full',       'xp' => 3000, 'gp' =>  80000, 'link' => 'UA' ),
			array( 'chance' =>  2, 'text' => 'Full Plate +4',   'bonus' => 4, 'prefix' => 'FPP4', 'key' => 'full',       'xp' => 4000, 'gp' => 120000, 'link' => 'UA' ),
			array( 'chance' =>  1, 'text' => 'Full Plate +5',   'bonus' => 5, 'prefix' => 'FPP5', 'key' => 'full',       'xp' => 5000, 'gp' => 200000, 'link' => 'UA' ),
			array( 'chance' => 48, 'text' => 'Leather +1',      'bonus' => 1, 'prefix' => 'LAP1', 'key' => 'leather',    'xp' =>  300, 'gp' =>   2000, 'link' => 'DMG' ),
			array( 'chance' => 36, 'text' => 'Leather +2',      'bonus' => 2, 'prefix' => 'LAP2', 'key' => 'leather',    'xp' =>  600, 'gp' =>   5000, 'link' => 'DMG' ),
			array( 'chance' => 24, 'text' => 'Leather +3',      'bonus' => 3, 'prefix' => 'LAP3', 'key' => 'leather',    'xp' => 1000, 'gp' =>  10000, 'link' => 'DMG' ),
			array( 'chance' => 18, 'text' => 'Plate Mail +1',   'bonus' => 1, 'prefix' => 'PMP1', 'key' => 'plate',      'xp' =>  800, 'gp' =>   5000, 'link' => 'DMG' ),
			array( 'chance' => 15, 'text' => 'Plate Mail +2',   'bonus' => 2, 'prefix' => 'PMP2', 'key' => 'plate',      'xp' => 1750, 'gp' =>  10500, 'link' => 'DMG' ),
			array( 'chance' => 12, 'text' => 'Plate Mail +3',   'bonus' => 3, 'prefix' => 'PMP3', 'key' => 'plate',      'xp' => 2750, 'gp' =>  15500, 'link' => 'DMG' ),
			array( 'chance' =>  9, 'text' => 'Plate Mail +4',   'bonus' => 4, 'prefix' => 'PMP4', 'key' => 'plate',      'xp' => 3500, 'gp' =>  20500, 'link' => 'DMG' ),
			array( 'chance' =>  3, 'text' => 'Plate Mail +5',   'bonus' => 5, 'prefix' => 'PMP5', 'key' => 'plate',      'xp' => 4500, 'gp' =>  27500, 'link' => 'DMG' ),
			array( 'chance' =>  6, 'text' => 'Plate Mail of Etherealness',  'bonus' =>  1, 'prefix' => 'PMER', 'key' => 'plate', 'xp' => 5000, 'gp' => 30000, 'link' => 'DMG' ),
			array( 'chance' => 30, 'text' => 'Plate Mail of Vulnerability', 'bonus' => -1, 'prefix' => 'PMVL', 'key' => 'plate', 'xp' => '~~', 'gp' =>  1500, 'link' => 'DMG' ),
			array( 'chance' => 42, 'text' => 'Ring Mail +1',       'bonus' => 1, 'prefix' => 'RMP1', 'key' => 'ring',    'xp' =>  400, 'gp' =>  2500, 'link' => 'DMG' ),
			array( 'chance' => 28, 'text' => 'Ring Mail +2',       'bonus' => 2, 'prefix' => 'RMP2', 'key' => 'ring',    'xp' =>  800, 'gp' =>  6000, 'link' => 'DMG' ),
			array( 'chance' => 12, 'text' => 'Ring Mail +3',       'bonus' => 3, 'prefix' => 'RMP3', 'key' => 'ring',    'xp' => 1200, 'gp' =>  9500, 'link' => 'DMG' ),
			array( 'chance' => 36, 'text' => 'Scale Mail +1',      'bonus' => 1, 'prefix' => 'SMP1', 'key' => 'scale',   'xp' =>  500, 'gp' =>  3000, 'link' => 'DMG' ),
			array( 'chance' => 24, 'text' => 'Scale Mail +2',      'bonus' => 2, 'prefix' => 'SMP2', 'key' => 'scale',   'xp' => 1100, 'gp' =>  6750, 'link' => 'DMG' ),
			array( 'chance' => 12, 'text' => 'Scale Mail +3',      'bonus' => 3, 'prefix' => 'SMP3', 'key' => 'scale',   'xp' => 1650, 'gp' => 10500, 'link' => 'DMG' ),
			array( 'chance' => 24, 'text' => 'Splint Mail +1',     'bonus' => 1, 'prefix' => 'SPP1', 'key' => 'splint',  'xp' =>  700, 'gp' =>  4000, 'link' => 'DMG' ),
			array( 'chance' => 18, 'text' => 'Splint Mail +2',     'bonus' => 2, 'prefix' => 'SPP2', 'key' => 'splint',  'xp' => 1500, 'gp' =>  8500, 'link' => 'DMG' ),
			array( 'chance' => 12, 'text' => 'Splint Mail +3',     'bonus' => 3, 'prefix' => 'SPP3', 'key' => 'splint',  'xp' => 2250, 'gp' => 14500, 'link' => 'DMG' ),
			array( 'chance' =>  6, 'text' => 'Splint Mail +4',     'bonus' => 4, 'prefix' => 'SPP4', 'key' => 'splint',  'xp' => 3000, 'gp' => 19000, 'link' => 'DMG' ),
			array( 'chance' => 42, 'text' => 'Studded Leather +1', 'bonus' => 1, 'prefix' => 'STP1', 'key' => 'studded', 'xp' =>  400, 'gp' =>  2500, 'link' => 'DMG' ),
			array( 'chance' => 30, 'text' => 'Studded Leather +2', 'bonus' => 2, 'prefix' => 'STP2', 'key' => 'studded', 'xp' =>  800, 'gp' =>  5000, 'link' => 'DMG' ),
			array( 'chance' => 18, 'text' => 'Studded Leather +3', 'bonus' => 3, 'prefix' => 'STP3', 'key' => 'studded', 'xp' => 1250, 'gp' => 10000, 'link' => 'DMG' ),
			array( 'chance' => 24, 'text' => 'Studded Leather +4', 'bonus' => 4, 'prefix' => 'STP4', 'key' => 'studded', 'xp' => 2000, 'gp' => 15000, 'link' => 'DMG' ),
		);
	}

	protected function get_armor_size_table() {
		return array(
			array( 'chance' => 65, 'size' => 'Human' ),
			array( 'chance' => 20, 'size' => 'Elf' ),
			array( 'chance' => 10, 'size' => 'Dwarf' ),
			array( 'chance' =>  5, 'size' => 'Gnome/Halfling' ),
		);
	}

	protected function get_shields_table() {
		return array(
			array( 'chance' => 54, 'text' => 'Shield +1', 'bonus' => 1, 'prefix' => 'SH', 'xp' =>  250, 'gp' =>  2500, 'link' => 'DMG' ),
			array( 'chance' => 30, 'text' => 'Shield +2', 'bonus' => 2, 'prefix' => 'SH', 'xp' =>  500, 'gp' =>  5000, 'link' => 'DMG' ),
			array( 'chance' => 24, 'text' => 'Shield +3', 'bonus' => 3, 'prefix' => 'SH', 'xp' =>  800, 'gp' =>  8000, 'link' => 'DMG' ),
			array( 'chance' => 12, 'text' => 'Shield +4', 'bonus' => 4, 'prefix' => 'SH', 'xp' => 1200, 'gp' => 12000, 'link' => 'DMG' ),
			array( 'chance' =>  6, 'text' => 'Shield +5', 'bonus' => 5, 'prefix' => 'SH', 'xp' => 1750, 'gp' => 17500, 'link' => 'DMG' ),
			array( 'chance' =>  6, 'text' => 'Shield +1, +4 vs. missiles',   'bonus' => 1, 'prefix' => 'SHVM', 'xp' =>  400, 'gp' => 4000, 'link' => 'DMG' ),
			array( 'chance' => 18, 'text' => 'Shield +1, missile attractor', 'bonus' => 1, 'prefix' => 'SHMA', 'xp' => '~~', 'gp' =>  750, 'link' => 'DMG' ),
		);
	}

	protected function get_shields_size_table() {
		return array(
			array( 'chance' => 25, 'size' => 'Large' ),
			array( 'chance' => 50, 'size' => 'Medium' ),
			array( 'chance' => 15, 'size' => 'Small' ),
			array( 'chance' => 10, 'size' => 'Wooden' ),
		);
	}

/*	protected function get_shields_table() {
		return array(
			array( 'chance' => 126, 'name' => 'Shield', 'link' => 'DMG' ),
			array( 'chance' =>   6, 'name' => 'Missile Defender',  'bonus' => 1, 'xp' =>  400, 'gp' => 4000, 'link' => 'DMG' ),
			array( 'chance' =>  18, 'name' => 'Missile Attractor', 'bonus' => 1, 'xp' => '~~', 'gp' =>  750, 'link' => 'DMG' ),
		);
	}

	protected function get_shield_plus_table() {
		return array(
			array( 'chance' => 54, 'bonus' => 1, 'xp' =>  250, 'gp' =>  2500 ),
			array( 'chance' => 30, 'bonus' => 2, 'xp' =>  500, 'gp' =>  5000 ),
			array( 'chance' => 24, 'bonus' => 3, 'xp' =>  800, 'gp' =>  8000 ),
			array( 'chance' => 12, 'bonus' => 4, 'xp' => 1200, 'gp' => 12000 ),
			array( 'chance' =>  6, 'bonus' => 5, 'xp' => 1750, 'gp' => 17500 ),
		);
	}

	protected function get_shields_size_table() {
		return array(
			array( 'chance' => 25, 'type' => array( 'Large' ) ),
			array( 'chance' => 50, 'type' => array( 'Medium' ) ),
			array( 'chance' => 15, 'type' => array( 'Small' ) ),
			array( 'chance' => 10, 'type' => array( 'Wooden' ) ),
		);
	} //*/

	protected function get_swords_table() {
		return array(
			'title' => 'Swords',
#			array( 'chance' =>  1, 'text' => 'Sword, Sun Blade', 'bonus' => 2, 'ego' => 4, 'xp' => 3000, 'gp' => 20000, 'restrict' => ':Good', 'link' => 'https://www.d20pfsrd.com/magic-items/magic-weapons/specific-magic-weapons/sun-blade/' ),
#			array( 'chance' =>  7, 'text' => 'Sword +1, +2 vs. magic-using & enchanted creatures', 'bonus' => 1, 'ego' => 3, 'xp' => 600, 'gp' => 3000, 'link' => 'DMG 164', 'symbol' => 'circles on pommel' ),
#			array( 'chance' =>  7, 'text' => 'Sword +1, +3 vs. lycanthropes & shape-changers',     'bonus' => 1, 'ego' => 4, 'xp' => 700, 'gp' => 3500, 'link' => 'DMG 164', 'symbol' => 'red man with white outline (outline is squiggly)'  ),
#			array( 'chance' =>  7, 'text' => 'Sword +1, +3 vs. regenerating creatures',            'bonus' => 1, 'ego' => 4, 'xp' => 800, 'gp' => 4000, 'link' => 'DMG 164' ),
#			array( 'chance' =>  7, 'text' => 'Sword +1, +4 vs. reptiles',     'bonus' => 1, 'ego' => 5, 'xp' =>   800, 'gp' =>  4000, 'link' => 'DMG 164' ),
#			array( 'chance' =>  7, 'text' => 'Sword +1, Cursed',              'bonus' => 1, 'ego' => 2, 'xp' =>  '~~', 'gp' =>  1000, 'link' => 'DMG 165' ),
#			array( 'chance' =>  5, 'text' => 'Sword +1, Flame Tongue',        'bonus' => 1, 'ego' => 5, 'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164' ),
#			array( 'chance' =>  1, 'text' => 'Sword +1, Luck Blade',          'bonus' => 1, 'ego' => 2, 'xp' =>  1000, 'gp' =>  5000, 'link' => 'DMG 164' ),
#			array( 'chance' =>  5, 'text' => 'Sword +2, Dragon Slayer',       'bonus' => 2, 'ego' => 6, 'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164', 'symbol' => 'Dragon head on pommel' ),
#			array( 'chance' =>  5, 'text' => 'Sword +2, Giant Slayer',        'bonus' => 2, 'ego' => 5, 'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164' ),
#			array( 'chance' =>  1, 'text' => 'Sword +2, Nine Lives Stealer',  'bonus' => 2, 'ego' => 4, 'xp' =>  1600, 'gp' =>  8000, 'link' => 'DMG 164' ),
#			array( 'chance' =>  4, 'text' => 'Sword +3, Frost Brand',         'bonus' => 3, 'ego' => 9, 'xp' =>  1600, 'gp' =>  8000, 'effect' => 'cold', 'link' => 'DMG 164' ),
#			array( 'chance' =>  2, 'text' => 'Sword +4, Defender',            'bonus' => 4, 'ego' => 8, 'xp' =>  3000, 'gp' => 15000, 'link' => 'DMG 164' ),
#			array( 'chance' =>  1, 'text' => 'Sword +5, Defender',            'bonus' => 5, 'ego' =>10, 'xp' =>  3600, 'gp' => 18000, 'link' => 'DMG 164' ),
#			array( 'chance' =>  1, 'text' => 'Sword +5, Holy Avenger (LG)',   'bonus' => 5, 'ego' =>10, 'xp' =>  4000, 'gp' => 20000, 'restrict' => ':Lawful Good', 'link' => 'DMG 164' ),
#			array( 'chance' =>  8, 'text' => 'Sword -2, Cursed',              'bonus' =>-2, 'ego' => 4, 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
#			array( 'chance' =>  1, 'text' => 'Sword of Dancing',              'bonus' => 1, 'ego' => 5, 'xp' =>  4400, 'gp' => 22000, 'link' => 'DMG 164-165' ),
#			array( 'chance' =>  1, 'text' => 'Sword of Life Stealing',        'bonus' => 2, 'ego' => 4, 'xp' =>  5000, 'gp' => 25000, 'link' => 'DMG 164' ),
#			array( 'chance' =>  2, 'text' => 'Sword of Sharpness (C)',        'bonus' => 1, 'ego' => 4, 'xp' =>  7000, 'gp' => 35000, 'restrict' => ':Chaotic', 'link' => 'DMG 164' ),
#			array( 'chance' => 14, 'text' => 'Sword of the Planes',           'bonus' => 2, 'ego' => 6, 'xp' =>  2000, 'gp' => 30000, 'link' => 'https://www.d20pfsrd.com/magic-items/magic-weapons/specific-magic-weapons/sword-of-the-planes/' ),
#			array( 'chance' =>  1, 'text' => 'Sword of Wounding',             'bonus' => 1, 'ego' => 2, 'xp' =>  4000, 'gp' => 22000, 'link' => 'DMG 165' ),
#			array( 'chance' =>  6, 'text' => 'Sword, Cursed Berserking',      'bonus' => 2, 'ego' => 4, 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
#			array( 'chance' =>  5, 'text' => 'Short Sword of Quickness (+2)', 'bonus' => 2, 'ego' => 4, 'xp' =>  1000, 'gp' => 17500, 'link' => '' ),
#			array( 'chance' =>  1, 'text' => 'Sword, Vorpal Weapon (L)',      'bonus' => 3, 'ego' => 6, 'xp' => 10000, 'gp' => 50000, 'restrict' => ':Lawful', 'link' => 'DMG 165' ),
			array( 'chance' =>  2, 'text' => "Bastard's Sting(CE)",'bonus' => 5, 'ego' =>10, 'post' => 'BS', 'xp' =>  3600, 'gp' => 18000, 'link' => 'https://www.d20pfsrd.com/magic-items/magic-weapons/specific-magic-weapons/bastard-s-sting' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' =>-2, 'ego' => 4, 'post' => 'C2', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  1, 'text' => 'Dancing',            'bonus' => 1, 'ego' => 5, 'post' => 'DC', 'xp' =>  4400, 'gp' => 22000, 'link' => 'DMG 164-165' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' =>-2, 'ego' => 4, 'post' => 'C2', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  3, 'text' => 'Defender',           'bonus' => 4, 'ego' => 8, 'post' => 'D4', 'xp' =>  3000, 'gp' => 15000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' =>-2, 'ego' => 4, 'post' => 'C2', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  2, 'text' => 'Defender',           'bonus' => 5, 'ego' =>10, 'post' => 'D5', 'xp' =>  3600, 'gp' => 18000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' =>-2, 'ego' => 4, 'post' => 'C2', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  4, 'text' => 'Dragon Slayer',      'bonus' => 2, 'ego' => 6, 'post' => 'DS', 'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' =>-2, 'ego' => 4, 'post' => 'C2', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  5, 'text' => 'Flame Tongue',       'bonus' => 1, 'ego' => 5, 'post' => 'FT', 'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' =>-2, 'ego' => 4, 'post' => 'C2', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  5, 'text' => 'Frost Brand',        'bonus' => 3, 'ego' => 9, 'post' => 'FB', 'xp' =>  1600, 'gp' =>  8000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' =>-2, 'ego' => 4, 'post' => 'C2', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  5, 'text' => 'Giant Slayer',       'bonus' => 2, 'ego' => 5, 'post' => 'GS', 'xp' =>   900, 'gp' =>  4500, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' =>-2, 'ego' => 4, 'post' => 'C2', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  1, 'text' => 'Holy Avenger (LG)',  'bonus' => 5, 'ego' =>10, 'post' => 'HA', 'xp' =>  4000, 'gp' => 20000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' => 1, 'ego' => 2, 'post' => 'C1', 'xp' =>  '~~', 'gp' =>  1000, 'link' => 'DMG 165' ),
			array( 'chance' =>  1, 'text' => 'Life Stealing',      'bonus' => 2, 'ego' => 4, 'post' => 'LS', 'xp' =>  5000, 'gp' => 25000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Luck Blade',         'bonus' => 1, 'ego' => 2, 'post' => 'LB', 'xp' =>  1000, 'gp' =>  5000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' => 1, 'ego' => 2, 'post' => 'C1', 'xp' =>  '~~', 'gp' =>  1000, 'link' => 'DMG 165' ),
			array( 'chance' =>  7, 'text' => 'Magic Phobia',       'bonus' => 1, 'ego' => 3, 'post' => 'MP', 'xp' =>   600, 'gp' =>  3000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' => 1, 'ego' => 2, 'post' => 'C1', 'xp' =>  '~~', 'gp' =>  1000, 'link' => 'DMG 165' ),
			array( 'chance' =>  2, 'text' => 'Nine Lives Stealer', 'bonus' => 2, 'ego' => 4, 'post' => 'S9', 'xp' =>  1600, 'gp' =>  8000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' => 1, 'ego' => 2, 'post' => 'C1', 'xp' =>  '~~', 'gp' =>  1000, 'link' => 'DMG 165' ),
			array( 'chance' =>  5, 'text' => 'Quickness',          'bonus' => 2, 'ego' => 4, 'post' => 'QN', 'xp' =>  1000, 'gp' => 17500, 'link' => '' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' => 1, 'ego' => 2, 'post' => 'C1', 'xp' =>  '~~', 'gp' =>  1000, 'link' => 'DMG 165' ),
			array( 'chance' =>  2, 'text' => 'Planes',             'bonus' => 2, 'ego' => 6, 'post' => 'PN', 'xp' =>  2000, 'gp' => 30000, 'link' => 'https://www.d20pfsrd.com/magic-items/magic-weapons/specific-magic-weapons/sword-of-the-planes/' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' => 1, 'ego' => 2, 'post' => 'C1', 'xp' =>  '~~', 'gp' =>  1000, 'link' => 'DMG 165' ),
			array( 'chance' =>  7, 'text' => 'Regen Phobia',       'bonus' => 1, 'ego' => 4, 'post' => 'RG', 'xp' =>   800, 'gp' =>  4000, 'effect' => 'regen',   'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed',             'bonus' => 1, 'ego' => 2, 'post' => 'C1', 'xp' =>  '~~', 'gp' =>  1000, 'link' => 'DMG 165' ),
			array( 'chance' =>  7, 'text' => 'Reptile Phobia',     'bonus' => 1, 'ego' => 5, 'post' => 'RP', 'xp' =>   800, 'gp' =>  4000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed Berserking',  'bonus' => 2, 'ego' => 4, 'post' => 'CB', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  1, 'text' => 'Rising Sun',         'bonus' => 1, 'ego' => 2, 'post' => 'RS', 'xp' =>  1000, 'gp' =>  5000, 'link' => 'https://www.d20pfsrd.com/magic-items/magic-weapons/specific-magic-weapons/blade-of-the-rising-sun' ),
			array( 'chance' =>  2, 'text' => 'Sharpness (C)',      'bonus' => 1, 'ego' => 4, 'post' => 'SN', 'xp' =>  7000, 'gp' => 35000, 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed Berserking',  'bonus' => 2, 'ego' => 4, 'post' => 'CB', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  7, 'text' => 'Shifter Phobia',     'bonus' => 1, 'ego' => 4, 'post' => 'SP', 'xp' =>   700, 'gp' =>  3500, 'effect' => 'shifter', 'symbol' => 'red man with two white squiggly outlines', 'link' => 'DMG 164' ),
			array( 'chance' =>  1, 'text' => 'Cursed Berserking',  'bonus' => 2, 'ego' => 4, 'post' => 'CB', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  3, 'text' => 'Subtlety',           'bonus' => 1, 'ego' => 2, 'post' => 'SU', 'xp' =>  2000, 'gp' => 22310, 'link' => 'https://www.d20pfsrd.com/magic-items/magic-weapons/specific-magic-weapons/sword-of-subtlety' ),
			array( 'chance' =>  1, 'text' => 'Cursed Berserking',  'bonus' => 2, 'ego' => 4, 'post' => 'CB', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  2, 'text' => 'Sun Blade (G)',      'bonus' => 2, 'ego' => 4, 'post' => 'SB', 'xp' =>  3000, 'gp' => 20000, 'link' => 'https://www.d20pfsrd.com/magic-items/magic-weapons/specific-magic-weapons/sun-blade/' ),
			array( 'chance' =>  1, 'text' => 'Cursed Berserking',  'bonus' => 2, 'ego' => 4, 'post' => 'CB', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  1, 'text' => 'Vorpal Weapon (L)',  'bonus' => 3, 'ego' => 6, 'post' => 'VW', 'xp' => 10000, 'gp' => 50000, 'restrict' => ':Lawful', 'link' => 'DMG 165' ),
			array( 'chance' =>  1, 'text' => 'Cursed Berserking',  'bonus' => 2, 'ego' => 4, 'post' => 'CB', 'xp' =>  '~~', 'gp' =>   500, 'link' => 'DMG 165' ),
			array( 'chance' =>  3, 'text' => 'Wounding',           'bonus' => 1, 'ego' => 2, 'post' => 'WO', 'xp' =>  4000, 'gp' => 22000, 'effect' => 'wounding', 'symbol' => 'red pommel', 'link' => 'DMG 165' ),
			'note00' => 'Use table in DMG 165 to test for unusual swords.',
		);
	}

	protected function get_swords_type_table() {
		return array(
			array( 'chance' => 70, 'pre' => 'L', 'text' => 'Long' ),
			array( 'chance' => 20, 'pre' => 'B', 'text' => 'Broad' ),
			array( 'chance' =>  5, 'pre' => 'S', 'text' => 'Short' ),
			array( 'chance' =>  4, 'pre' => 'A', 'text' => 'Bastard' ),
			array( 'chance' =>  1, 'pre' => 'T', 'text' => 'Two-handed' ),
		);
	}

	protected function get_swords_info_table() {
		return array(
			'BS' => array( 'prefix' => 'SA', 'type' => array( 'Sword,Bastard' ), 'restrict' => ':Chaotic Evil' ),
			'DS' => array( 'effect' => 'dragon', 'symbol' => 'Dragon head on pommel' ),
			'FB' => array( 'effect' => 'cold' ),
			'FT' => array( 'effect' => 'fire' ),
			'HA' => array( 'restrict' => ':Lawful Good' ),
			'MP' => array( 'effect' => 'magic', 'symbol' => 'four small interlocking circles' ),
			'PN' => array( 'symbol' => 'circle with four radiating arrows' ),
			'QN' => array( 'prefix' => 'SS', 'type' => array( 'Sword,Short' ) ),
			'RP' => array( 'effect' => 'reptile', 'symbol' => 'T-Rex head on pommel' ),
			'SB' => array( 'restrict' => ':Good', 'symbol' => 'sun burst' ),
			'SN' => array( 'restrict' => ':Chaotic' ),
			'SP' => array( 'effect' => 'shifter', 'symbol' => 'red man with two white squiggly outlines' ),
			'SU' => array( 'prefix' => 'SS', 'type' => array( 'Sword,Short' ) ),
			'VW' => array( 'restrict' => ':Lawful' ),
			'WO' => array( 'effect' => 'wounding', 'symbol' => 'red pommel' ),
		);
	}

	protected function get_swords_alignment_table() {
		return array(
			array( 'chance' =>  5, 'align' => 'Chaotic Good' ),
			array( 'chance' => 10, 'align' => 'Chaotic Neutral' ),
			array( 'chance' =>  5, 'align' => 'Chaotic Evil' ),
			array( 'chance' =>  5, 'align' => 'Neutral Evil' ),
			array( 'chance' =>  5, 'align' => 'Lawful Evil' ),
			array( 'chance' => 25, 'align' => 'Lawful Good' ),
			array( 'chance' =>  5, 'align' => 'Lawful Neutral' ),
			array( 'chance' => 20, 'align' => 'Neutral' ),
			array( 'chance' => 20, 'align' => 'Neutral Good' ),
		);
	}

	protected function get_swords_primary_ability_table() {
		return array(
			array( 'chance' => 11, 'radius' =>  10, 'ability' => 'Detect elevator/shifting rooms/walls' ),
			array( 'chance' => 11, 'radius' =>  10, 'ability' => 'Detect sloping passages' ),
			array( 'chance' => 11, 'radius' =>  10, 'ability' => 'Detect traps of large size' ),
			array( 'chance' => 11, 'radius' =>  10, 'ability' => 'Detect evil/good' ),
			array( 'chance' => 11, 'radius' =>  20, 'ability' => 'Detect precious metals, kind, and amount' ),
			array( 'chance' => 11, 'radius' =>   5, 'ability' => 'Detect gems, kind, and number' ),
			array( 'chance' => 11, 'radius' =>  10, 'ability' => 'Detect magic' ),
			array( 'chance' =>  5, 'radius' =>   5, 'ability' => 'Detect secret doors' ),
			array( 'chance' =>  5, 'radius' =>  10, 'ability' => 'Detect invisible objects' ),
			array( 'chance' =>  5, 'radius' => 120, 'ability' => 'Locate object' ),
		);
	}

	protected function get_swords_extra_ability_table() {
		return array(
			array( 'chance' => 7, 'ability' => 'Charm person on contact - 3 times/day' ),
			array( 'chance' => 8, 'ability' => 'Clairaudience, 30 foot range-3 times/day 1 round per use' ),
			array( 'chance' => 7, 'ability' => 'Clairvoyance, 30 foot range - 3 times/day, 1 round per use' ),
			array( 'chance' => 6, 'ability' => 'Determine directions and depth - 2 times/day' ),
			array( 'chance' => 6, 'ability' => 'ESP, 30 foot ronge - 3 times/day 1 round per use' ),
			array( 'chance' => 7, 'ability' => 'Flying, 120 feet/turn - 1 hour/day' ),
			array( 'chance' => 6, 'ability' => 'Heal - 1 time/day' ),
			array( 'chance' => 7, 'ability' => 'Illusion, 120 foot range - 2 times/day, as the wand' ),
			array( 'chance' => 7, 'ability' => 'Levitation, 1 turn duration - 3 times/day ot 6th level of magic use ability' ),
			array( 'chance' => 6, 'ability' => 'Strength - 1 time/day (upon wielder only)' ),
			array( 'chance' => 8, 'ability' => 'Telekinesis, 2,500 g.p. wt. maximum - 2 times/day, 1 round each use' ),
			array( 'chance' => 6, 'ability' => 'Telepathy, 60 foot range - 2 times/day' ),
			array( 'chance' => 7, 'ability' => 'Teleportation - 1 time/day 6,000 g.p. wt. maximum, 2 segments to activate' ),
			array( 'chance' => 6, 'ability' => 'X-ray vision, 40 foot range - 2 times/day 1 turn per use' ),
		);
	}

	protected function get_swords_special_purpose_table() {
		return array(
			array( 'chance' => 10, 'text' => 'defeat/slay diametrically opposed alignment*' ),
			array( 'chance' => 10, 'text' => 'kill clerics' ),
			array( 'chance' => 10, 'text' => 'kill fighters' ),
			array( 'chance' => 10, 'text' => 'kill magic-users' ),
			array( 'chance' => 10, 'text' => 'kill thieves' ),
			array( 'chance' =>  5, 'text' => 'kill bards/monks' ),
			array( 'chance' => 10, 'text' => 'overthrow law and/or chaos' ),
			array( 'chance' => 10, 'text' => 'slay good and/or evil' ),
			array( 'chance' => 25, 'text' => 'slay non-human monsters' ),
		);
	}

	protected function get_swords_special_powers_table() {
		return array(
			array( 'chance' => 10, 'text' => 'blindness* for 2-12 rounds' ),
			array( 'chance' => 10, 'text' => 'confusion* for 2-12 rounds' ),
			array( 'chance' =>  5, 'text' => 'disintegrate*' ),
			array( 'chance' => 30, 'text' => 'fear* for 1-4 rounds' ),
			array( 'chance' => 10, 'text' => 'insanity* for 1-4 rounds' ),
			array( 'chance' => 15, 'text' => 'paralysis* for 1-4 rounds' ),
			array( 'chance' => 20, 'text' => '+2 on all saving throws, -1 on each die of damage sustained' ),
		);
	}

	protected function get_swords_languages_table() {
		return array(
			array( 'chance' => 40, 'text' => '1' ),
			array( 'chance' => 30, 'text' => '2' ),
			array( 'chance' => 15, 'text' => '3' ),
			array( 'chance' => 10, 'text' => '4' ),
			array( 'chance' =>  4, 'text' => '5' ),
			array( 'chance' =>  1, 'text' => 'max of 6 or two more rolls on this table' ),
		);
	}

	protected function get_weapons_table() {
		return array(
			'title' => 'Miscellaneous Weapons: 1d1000',
			array( 'chance' => 60, 'text' => 'Arrow**',                  'bonus' => 0, 'prefix' =>   'AR', 'xp' =>   20, 'gp' =>   120, 'ex' => 'N:2', 'q' => array( 2, 12, 0 ), 'link' => 'DMG' ),
			array( 'chance' => 30, 'text' => 'Arrow**',                  'bonus' => 0, 'prefix' =>   'AR', 'xp' =>   20, 'gp' =>   120, 'ex' => 'N:2', 'q' => array( 2, 8, 0 ), 'link' => 'DMG' ),
			array( 'chance' => 15, 'text' => 'Arrow**',                  'bonus' => 0, 'prefix' =>   'AR', 'xp' =>   20, 'gp' =>   120, 'ex' => 'N:2', 'q' => array( 2, 6, 0 ), 'link' => 'DMG' ),
			array( 'chance' =>  5, 'text' => 'Arrow of Direction',       'bonus' => 0, 'prefix' =>  'ARD', 'xp' => 2500, 'gp' => 17500, 'ex' => 'N:0', 'link' => '' ),
			array( 'chance' =>  3, 'text' => 'Arrow of Slaying',         'bonus' => 3, 'prefix' => 'ARS3', 'xp' =>  250, 'gp' =>  2500, 'ex' => 'N:0', 'link' => 'DMG 167' ),
			array( 'chance' => 60, 'text' => 'Axe*',                     'bonus' => 0, 'prefix' =>   'AX', 'xp' =>  300, 'gp' =>  1750, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' =>  5, 'text' => 'Axe +2, Throwing',         'bonus' => 2, 'prefix' => 'AXT2', 'xp' =>  750, 'gp' =>  4500, 'ex' => 'Y:0', 'link' => 'DMG 167' ),
			array( 'chance' =>  5, 'text' => 'Axe of Hurling*',          'bonus' => 0, 'prefix' =>  'AXH', 'xp' => 1500, 'gp' => 15000, 'ex' => 'Y:1', 'link' => 'http://www.mountnevermind.de/Dokumente/DMG/DD01088.htm' ),
			array( 'chance' => 25, 'text' => 'Battle Axe*',              'bonus' => 0, 'prefix' =>   'BA', 'xp' =>  400, 'gp' =>  2500, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' => 60, 'text' => 'Bolt**',                   'bonus' => 0, 'prefix' =>   'BT', 'xp' =>   50, 'gp' =>   300, 'ex' => 'N:2', 'q' => array( 2, 10, 0 ), 'link' => 'DMG 167' ),
			array( 'chance' => 30, 'text' => 'Bolt**',                   'bonus' => 0, 'prefix' =>   'BT', 'xp' =>   50, 'gp' =>   300, 'ex' => 'N:2', 'q' => array( 2, 8, 0 ), 'link' => 'DMG 167' ),
			array( 'chance' => 15, 'text' => 'Bolt**',                   'bonus' => 0, 'prefix' =>   'BT', 'xp' =>   50, 'gp' =>   300, 'ex' => 'N:2', 'q' => array( 2, 6, 0 ), 'link' => 'DMG 167' ),
			array( 'chance' => 25, 'text' => 'Bow*',                     'bonus' => 0, 'prefix' =>    'B', 'xp' =>  500, 'gp' =>  3500, 'ex' => 'Y:1', 'link' => 'DMG 167' ),
			array( 'chance' => 30, 'text' => 'Bullet, Sling**',          'bonus' => 0, 'prefix' =>   'BS', 'xp' =>   10, 'gp' =>    10, 'ex' => 'N:2', 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Crossbow*',                'bonus' => 0, 'prefix' =>   'CB', 'xp' => 2000, 'gp' => 12000, 'ex' => 'Y:1', 'link' => 'DMG 167' ) ,
			array( 'chance' =>  5, 'text' => 'Crossbow of Accuracy, +3', 'bonus' => 3, 'prefix' =>   'CA', 'xp' => 2000, 'gp' => 12000, 'ex' => 'Y:1', 'link' => 'DMG 167' ),
			array( 'chance' =>  5, 'text' => 'Crossbow of Distance',     'bonus' => 1, 'prefix' =>   'CD', 'xp' => 1500, 'gp' =>  7500, 'ex' => 'Y:1', 'link' => 'DMG 167' ),
			array( 'chance' =>  5, 'text' => 'Crossbow of Speed',        'bonus' => 1, 'prefix' =>   'CS', 'xp' => 1500, 'gp' =>  7500, 'ex' => 'Y:1', 'link' => 'DMG 167' ),
			array( 'chance' => 15, 'text' => 'Dagger*',                  'bonus' => 1, 'prefix' =>   'DG', 'xp' =>  100, 'gp' =>   750, 'ex' => 'Y:0 ', 'link' => '' ),
			array( 'chance' => 60, 'text' => 'Dagger +1, +2 vs. S',      'bonus' => 1, 'prefix' => 'DGS2', 'xp' =>  100, 'gp' =>   750, 'ex' => 'Y:0', 'link' => '' ),
			array( 'chance' => 30, 'text' => 'Dagger +2, +3 vs. L',      'bonus' => 2, 'prefix' => 'DGL3', 'xp' =>  250, 'gp' =>  2000, 'ex' => 'Y:0', 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Dagger +2, Longtooth',     'bonus' => 2, 'prefix' => 'DGL2', 'xp' =>  300, 'gp' =>  2500, 'ex' => 'Y:0', 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Dagger of Throwing*',      'bonus' => 0, 'prefix' =>  'DGT', 'xp' =>  250, 'gp' =>  2500, 'ex' => 'Y:1', 'link' => '' ),
			array( 'chance' =>  3, 'text' => 'Dagger of Venom',          'bonus' => 1, 'prefix' =>  'DGV', 'xp' =>  350, 'gp' =>  3000, 'ex' => 'Y:0', 'link' => 'DMG 167' ),
			array( 'chance' =>  8, 'text' => 'Dart**',                   'bonus' => 0, 'prefix' =>   'DT', 'xp' =>   50, 'gp' =>   300, 'ex' => 'N:2', 'link' => 'DMG' ),
			array( 'chance' =>  3, 'text' => 'Dart of Homing',           'bonus' => 0, 'prefix' =>   'DH', 'xp' =>  450, 'gp' =>  4500, 'ex' => 'Y:0', 'link' => '' ),
			array( 'chance' => 40, 'text' => 'Flail*',                   'bonus' => 0, 'prefix' =>    'F', 'xp' =>  450, 'gp' =>  4000, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' => 25, 'text' => 'Hammer*',                  'bonus' => 0, 'prefix' =>    'H', 'xp' =>  300, 'gp' =>  2500, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' =>  5, 'text' => 'Hammer, Dwarven Thrower',  'bonus' => 3, 'prefix' => 'HDT3', 'xp' => 1500, 'gp' => 15000, 'ex' => 'Y:0', 'link' => 'DMG 167' ),
			array( 'chance' =>  2, 'text' => 'Hammer of Thunderbolts',   'bonus' => 3, 'prefix' => 'HTB3', 'xp' => 2500, 'gp' => 25000, 'ex' => 'Y:0', 'link' => 'DMG 167-168' ),
			array( 'chance' =>  5, 'text' => 'Hornblade*',               'bonus' => 0, 'prefix' =>   'HB', 'xp' =>  500, 'gp' =>  5000, 'ex' => 'Y:1', 'link' => 'http://www.mountnevermind.de/Dokumente/DMG/DD01099.htm' ),
			array( 'chance' => 25, 'text' => 'Javelin*',                 'bonus' => 0, 'prefix' =>   'JV', 'xp' =>  375, 'gp' =>  2500, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' =>  5, 'text' => 'Javelin of Lightning',     'bonus' => 0, 'prefix' => 'JVLI', 'xp' =>  250, 'gp' =>  3000, 'ex' => 'Y:0', 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Javelin of Piercing',      'bonus' => 6, 'prefix' => 'JVPR', 'xp' =>  250, 'gp' =>  3000, 'ex' => 'Y:0', 'link' => '' ),
			array( 'chance' => 40, 'text' => 'Knife*',                   'bonus' =>  0, 'prefix' =>   'KN', 'xp' =>  100, 'gp' =>   750, 'ex' => 'Y:1', 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Knife, Buckle*',           'bonus' =>  0, 'prefix' =>   'KB', 'xp' =>  100, 'gp' =>  1000, 'ex' => 'Y:1', 'link' => '' ),
			array( 'chance' => 25, 'text' => 'Lance*',                   'bonus' => 0, 'prefix' =>   'LN', 'xp' =>  600, 'gp' =>  5000, 'ex' => 'Y:1', 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Net of Entrapment',        'bonus' => 0, 'prefix' => 'NENT', 'xp' => 1000, 'gp' =>  7500, 'ex' => 'Y:0', 'link' => '' ),
			array( 'chance' =>  5, 'text' => 'Net of Snaring',           'bonus' => 0, 'prefix' => 'NSNR', 'xp' => 1000, 'gp' =>  6000, 'ex' => 'Y:0', 'link' => '' ),
			array( 'chance' => 30, 'text' => 'Mace*',                    'bonus' => 0, 'prefix' =>    'M', 'xp' =>  350, 'gp' =>  3000, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' =>  5, 'text' => 'Mace of Disruption',       'bonus' => 1, 'prefix' =>   'MD', 'xp' => 1750, 'gp' => 17500, 'ex' => 'Y:0', 'link' => 'DMG 168' ),
			array( 'chance' => 25, 'text' => 'Military Pick*',           'bonus' => 0, 'prefix' =>   'MP', 'xp' =>  350, 'gp' =>  2500, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' => 25, 'text' => 'Morning Star*',            'bonus' => 0, 'prefix' =>   'MS', 'xp'=> 400, 'gp' =>  3000, 'ex' => 'Y:1', 'link' => 'DMG' ),
#			array( 'chance' =>  8, 'text' => 'Pole Arm*',                'bonus' =>  0, 'prefix' =>   'PA', 'xp' =>  500, 'gp' =>  4000, 'ex' => 'Y:1', 'ego' => 0, 'link' => 'DMG' ),
			array( 'chance' => 25, 'text' => 'Quarterstaff*',            'bonus' => 0, 'prefix' =>   'QS', 'xp' =>  250, 'gp' =>  1500, 'ex' => 'Y:1', 'link' => 'DMG' ),
#			array( 'chance' => 25, 'text' => 'Scimitar*',                'bonus' =>  0, 'prefix' =>   'SC', 'key' => 'Scimitar',      'xp' =>  375, 'gp' =>  3000, 'ex' => 'Y:1', 'ego' => 0, 'link' => 'DMG 168' ),
#			array( 'chance' =>  5, 'text' => 'Scimitar of Speed*',       'bonus' =>  0, 'prefix' =>  'SCS', 'key' => 'Scimitar',      'xp' => 2500, 'gp' =>  9000, 'ex' => 'Y:1', 'ego' => 0, 'link' => '' ),
#			array( 'chance' =>  5, 'text' => 'Sling of Seeking +2',      'bonus' =>  2, 'prefix' => 'SLS2', 'xp' =>  700, 'gp' =>  7000, 'ex' => 'Y:0', 'ego' => 4, 'link' => 'DMG 168' ),
			array( 'chance' => 50, 'text' => 'Spear*',                   'bonus' => 0, 'prefix' =>   'SP', 'xp' =>  500, 'gp' =>  3000, 'ex' => 'Y:1', 'link' => 'DMG 168' ),
			array( 'chance' => 15, 'text' => 'Spear, Cursed Backbiter',  'bonus' => 1, 'prefix' => 'SPCB', 'xp' =>    0, 'gp' =>  1000, 'ex' => 'N:0', 'link' => 'DMG 168' ),
			array( 'chance' => 34, 'text' => 'Sword,Long*',              'bonus' => 0, 'prefix' =>   'SL', 'xp' =>  500, 'gp' =>  2500, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' => 10, 'text' => 'Sword,Broad*',             'bonus' => 0, 'prefix' =>   'SB', 'xp' =>  350, 'gp' =>  1600, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' =>  3, 'text' => 'Sword,Short*',             'bonus' => 0, 'prefix' =>   'SS', 'xp' =>  250, 'gp' =>  1250, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' =>  2, 'text' => 'Sword,Bastard*',           'bonus' => 0, 'prefix' =>   'SA', 'xp' =>  850, 'gp' =>  4100, 'ex' => 'Y:1', 'link' => 'DMG' ),
			array( 'chance' =>  1, 'text' => 'Sword,Two-Handed*',        'bonus' => 0, 'prefix' =>   'ST', 'xp' => 1000, 'gp' =>  5000, 'ex' => 'Y:1', 'ego' => 0, 'link' => 'DMG' ),
#			array( 'chance' =>  5, 'text' => 'Trident (Military Fork)*', 'bonus' =>  0, 'prefix' =>   'MF', 'key' => 'Trident', 'xp' => 1500, 'gp' => 12500, 'ex' => 'Y:1', 'ego' => 0, 'link' => 'DMG 168' ),
#			array( 'chance' =>  5, 'text' => 'Trident of Fish Command',  'bonus' =>  1, 'prefix' => 'TFC1', 'key' => 'Trident', 'xp' =>  500, 'gp' =>  4000, 'ex' => 'Y:0', 'ego' => 2, 'link' => 'DMG 155' ),
#			array( 'chance' =>  4, 'text' => 'Trident of Submission',    'bonus' =>  1, 'prefix' => 'TSU1', 'key' => 'Trident', 'xp' => 1500, 'gp' => 12500, 'ex' => 'Y:0', 'ego' => 2, 'link' => 'DMG 155' ),
#			array( 'chance' =>  5, 'text' => 'Trident of Warning',       'bonus' =>  2, 'prefix' => 'TWA2', 'key' => 'Trident', 'xp' => 1000, 'gp' => 10000, 'ex' => 'Y:0', 'ego' => 4, 'link' => 'DMG 155' ),
#			array( 'chance' =>  4, 'text' => 'Trident of Yearning',      'bonus' => -2, 'prefix' => 'TYEA', 'key' => 'Trident', 'xp' =>    0, 'gp' =>  1000, 'ex' => 'N:0', 'link' => 'DMG 155' ),
			# TODO:  Use info in DND_Character_Trait_Weapons to modify base values
#			'note00' => 'If the max damage for a weapon is below 4, reduce the price by 60%, otherwise, if the max damage is below 6, reduce the price by 30%.  If the min damage for a weapon is above 1, increase the price by 25%.  If the max damage for a weapon is above 8, increase the price by 35%.',
			'note00' => 'Use table in DMG 165 to test for unusual weapons. d100: 01-75) no result, 76-00) see table',
			'note01' => ' * d20: 1-2) -1;x0.25, 3-10) +1, 11-14) +2;x2, 15-17) +3;x4, 18-19) +4;x5, 20) +5;x7',
			'note02' => '** d20: 1-2) -1;x0.25, 3-14) +1, 15-19) +2;x3, 20) +3;x5',
		);
	}

	protected function get_weapons_info_table() {
		return array(
			'AR'   => array( 'type' => array( 'Arrow' ), 'user' => array( 'Bow,Long', 'Bow,Short' ) ),
			'ARD'  => array( 'type' => array( 'Arrow' ), 'user' => array( 'Bow,Long', 'Bow,Short' ) ),
			'ARS3' => array( 'type' => array( 'Arrow' ), 'user' => array( 'Bow,Long', 'Bow,Short' ) ),
			'AX'   => array( 'ego' => 0, 'type' => array( 'Axe,Hand', 'Axe,Throwing' ) ),
			'AXH'  => array( 'ego' => 0, 'type' => array( 'Axe,Hand', 'Axe,Throwing' ) ),
			'AXT2' => array( 'ego' => 4, 'type' => array( 'Axe,Hand', 'Axe,Throwing' ) ),
			'B'    => array( 'ego' => 0 ),
			'BA'   => array( 'ego' => 0, 'type' => array( 'Axe,Battle' ) ),
			'BS'   => array( 'q' => array( 2, 8, 0 ), 'type' => array( 'Bullet' ), 'user' => array( 'Sling' ) ),
			'BT'   => array( 'type' => array( 'Bolt' ), 'user' => array( 'Crossbow,Light', 'Crossbow,Heavy' ), ),
			'CA'   => array( 'ego' => 6 ),
			'CB'   => array( 'ego' => 0 ),
			'CD'   => array( 'ego' => 2 ),
			'CS'   => array( 'ego' => 2 ),
			'DG'   => array( 'ego' => 0, 'type' => array( 'Dagger', 'Dagger,Thrown', 'Dagger,Off-Hand' ) ),
			'DGL2' => array( 'ego' => 4, 'type' => array( 'Dagger', 'Dagger,Thrown', 'Dagger,Off-Hand' ) ),
			'DGL3' => array( 'ego' => 5, 'type' => array( 'Dagger', 'Dagger,Thrown', 'Dagger,Off-Hand' ) ),
			'DGS2' => array( 'ego' => 3, 'type' => array( 'Dagger', 'Dagger,Thrown', 'Dagger,Off-Hand' ) ),
			'DGT'  => array( 'ego' => 0, 'type' => array( 'Dagger', 'Dagger,Thrown', 'Dagger,Off-Hand' ), 'symbol' => 'wide V' ),
			'DGV'  => array( 'ego' => 2, 'type' => array( 'Dagger', 'Dagger,Thrown', 'Dagger,Off-Hand' ) ),
			'DH'   => array( 'type' => array( 'Dart' ) ),
			'DT'   => array( 'q' => array( 3, 4, 0 ), 'type' => array( 'Dart' ) ),
			'F'    => array( 'ego' => 0, 'type' => array( 'Flail' ) ),
			'H'    => array( 'ego' => 0 ),
			'HB'   => array( 'ego' => 0 ),
			'HDT3' => array( 'ego' => 6 ),
			'HTB3' => array( 'ego' => 6 ),
			'JV'   => array( 'type' => array( 'Javelin' ) ),
			'JVLI' => array( 'effect' => 'electric', 'q' => array( 1, 4, 1 ), 'type' => array( 'Javelin' ) ),
			'JVPR' => array( 'q' => array( 2, 4, 0 ), 'type' => array( 'Javelin' ) ),
			'KB'   => array( 'ego' => 0, 'type' => array( 'Knife' ) ),
			'KN'   => array( 'ego' => 0, 'type' => array( 'Knife', 'Knife,Thrown' ) ),
			'LN'   => array( 'ego' => 0 ),
			'M'    => array( 'ego' => 0, 'type' => array( 'Mace' ) ),
			'MD'   => array( 'ego' => 2, 'type' => array( 'Mace' ) ),
			'MP'   => array( 'ego' => 0, 'type' => array( 'Military Pick' ) ),
			'MS'   => array( 'ego' => 0, 'type' => array( 'Morning Star' ) ),
			'NENT' => array( 'ego' => 0, 'type' => array( 'Net' ) ),
			'NSNR' => array( 'ego' => 0, 'type' => array( 'Net' ) ),
			'QS'   => array( 'ego' => 0, 'type' => array( 'Staff,Quarter' ) ),
			'SA'   => array( 'ego' => 0, 'type' => array( 'Sword,Bastard' ) ),
			'SB'   => array( 'ego' => 0, 'type' => array( 'Sword,Broad' ) ),
			'SL'   => array( 'ego' => 0, 'type' => array( 'Sword,Long' ) ),
			'SP'   => array( 'ego' => 0, 'type' => array( 'Spear', 'Spear,Thrown' ) ),
			'SPCB' => array( 'ego' => 2, 'type' => array( 'Spear', 'Spear,Thrown' ) ),
			'SS'   => array( 'ego' => 0, 'type' => array( 'Sword,Short' ) ),
			'ST'   => array( 'ego' => 0, 'type' => array( 'Sword,Two-Handed' ) ),
		);
	}

	protected function get_weapons_adjustment_table() {
		return array(
			array( 'chance' => 10, 'plus' => -1, 'gp' => 0.25 ),
			array( 'chance' => 40, 'plus' =>  1, 'gp' => 1 ),
			array( 'chance' => 20, 'plus' =>  2, 'gp' => 2 ),
			array( 'chance' => 15, 'plus' =>  3, 'gp' => 4 ),
			array( 'chance' => 10, 'plus' =>  4, 'gp' => 5 ),
			array( 'chance' =>  5, 'plus' =>  5, 'gp' => 7 ),
		);
	}

	protected function get_missile_adjustment_table() {
		return array(
			array( 'chance' => 10, 'plus' => -1, 'gp' => 0.25 ),
			array( 'chance' => 60, 'plus' =>  1, 'gp' => 1 ),
			array( 'chance' => 25, 'plus' =>  2, 'gp' => 3 ),
			array( 'chance' =>  5, 'plus' =>  3, 'gp' => 5 ),
		);
	}

	protected function retrieve_item_filters( $item, $key ) {
		$filters = array(
			'DC' => array(
			),
			'DS' => array(
				array( 'dnd1e_to_hit_object', 'vulnerable_to_hit',     2, 10, 3 ),
				array( 'dnd1e_origin_damage', 'vulnerable_to_damage',  2, 10, 4 ),
				array( 'dnd1e_damage_die',    'damage_die_multiplier', 3, 11, 3 ),
			),
			'MP' => array(
				array( 'dnd1e_to_hit_object', 'vulnerable_to_hit',    3, 10, 3 ),
				array( 'dnd1e_origin_damage', 'vulnerable_to_damage', 3, 10, 4 ),
			),
			'JVLI' => array(
				array( 'dnd1e_weapon_merge',  'javelin_of_lightning_range',  0, 10, 1 ),
				array( 'dnd1e_origin_damage', 'javelin_of_lightning_damage', 0,  9, 3 ),
			),
			'JVPR' => array(
				array( 'dnd1e_weapon_merge', 'javelin_of_piercing_range',  0, 10, 1 ),
			),
			'PN' => array(
				array( 'dnd1e_to_hit_object',  'vulnerable_to_hit',    0, 10, 3 ),
				array( 'dnd1e_origin_damage',  'vulnerable_to_damage', 0, 10, 4 ),
				array( 'dnd1e_vulnerable_hit', 'sword_of_the_planes',  0, 10, 3 ),
				array( 'dnd1e_vulnerable_dam', 'sword_of_the_planes',  0, 10, 3 ),
			),
			'PMVL' => array(
				array( 'dnd1e_critical_hit', 'vulnerability', '', 10, 1 ),
			),
			'RP' => array(
				array( 'dnd1e_to_hit_object', 'vulnerable_to_hit',    3, 10, 3 ),
				array( 'dnd1e_origin_damage', 'vulnerable_to_damage', 3, 10, 4 ),
			),
			'WO' => array(
				array( 'dnd1e_origin_damage', 'sword_of_wounding', 0, 10, 4 ),
				array( 'dnd1e_new_segment',   'sow_new_segment',   0, 10, 1 ),
			),
		);
		if ( array_key_exists( $key, $filters ) ) return $filters[ $key ];
		return array();
	}


}
