<?php

class DND_Character_Illusionist extends DND_Character_MagicUser {

#	protected $ac_rows    = array( 0, 1, 1, 1, 2, 2, 3, 3, 3, 4, 4, 5, 5, 5, 6, 6, 7, 7, 7, 8, 8, 9 );
	protected $hit_die    = array( 'limit' => 10, 'size' => 4, 'step' => 1 );
#	protected $non_prof   = -5;
	protected $stats      = array( 'str' => 3, 'int' => 15, 'wis' => 3, 'dex' => 16, 'con' => 3, 'chr' => 3 );
#	protected $weap_allow = array( 'Caltrop', 'Dagger', 'Dagger,Thrown', 'Dart', 'Knife', 'Knife,Thrown', 'Sling', 'Spell', 'Staff,Quarter' );
#	protected $weap_init  = array( 'initial' => 1, 'step' => 6 );
#	protected $weapons    = array( 'Spell' => 'PF' );
	protected $xp_bonus   = array();
	protected $xp_step    = 220000;
	protected $xp_table   = array( 0, 2250, 4500, 9000, 18000, 35000, 60000, 95000, 145000, 220000 );


	use DND_Character_Trait_Magic;


	protected function define_specials() { }

	protected function get_spell_table() {
		return array(
			'First' => array(
				'Chromatic Orb' => array( 'page' => 'UA 66-67', 'type' => 'Alteration - Evocation', 'cast' => '1 segment' ),
				'Color Spray' => array( 'page' => 'PH 95', 'type' => 'Alteration', 'cast' => '1 segment',
					'range' => sprintf( '%u feet', $this->level * 10 ),
				),
				'Dancing Lights' => array( 'page' => 'PH 95, PH 66', 'type' => 'Alteration', 'cast' => '1 segment',
					'range'    => sprintf( '%u feet', ( $this->level * 10 ) + 40 ),
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Hypnotism' => array( 'page' => 'PH 96, PH 76', 'type' => 'Enchantment/Charm', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level + 1 ),
				),
				'Light' => array(
					'page'     => 'PH 96, PH 68, PH 45',
					'type'     => 'Alteration',
					'reversible' => true,
					'range'    => '60 feet',
					'duration' => sprintf( '%u turns', $this->level ),
					'aoe'      => '20 foot radius globe',
					'comps'    => 'V, S',
					'cast'     => '1 segment',
					'saving'   => 'None',
				),
				'Phantom Armor' => array( 'page' => 'UA 67', 'type' => 'Alteration', 'cast' => '1 round',
					'special'   => sprintf( 'absorbs %u points of damage', $this->level ),
					'condition' => 'this_origin_only',
					'filters'   => array(
						array( 'character_armor_type', 3, 10, 2 ),
						array( 'temporary_hit_points', $this->level, 10, 2 ),
						array( 'character_all_saving_throws', 1, 10, 2 ),
					),
				),
				'Read Illusionist Magic' => array( 'page' => 'UA 67, PH 69', 'type' => 'Divination', 'cast' => '1 round', 'reversible' => true,
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Spook' => array( 'page' => 'UA 67', 'type' => 'Illusion/Phantasm', 'cast' => '1 segment' ),
			),
			'Second' => array(
				'Blindness' => array( 'page' => 'PH 67', 'type' => 'Illusion/Phantasm', 'cast' => '2 segments' ),
				'Detect Magic' => array( 'page' => 'PH 96, PH 66, PH 45', 'type' => 'Divination', 'cast' => '2 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Fascinate' => array( 'page' => 'UA 67-68', 'type' => 'Illusion/Phantasm', 'cast' => '2 segments',
					'special' => "Roll of 3d6 vs character's comeliness.  Pluses may apply.",
				),
				'Fog Cloud' => array( 'page' => 'PH 96', 'type' => 'Alteration', 'cast' => '2 segments',
					'range'    => '10 feet',
					'duration' => sprintf( '%u rounds', $this->level + 4 ),
					'aoe'      => "40' wide, 20' high, 20' deep cloud",
				),
				'Improved Phantasmal Force' => array( 'page' => 'PH 96-97, PH 76', 'type' => 'Illusion/Phantasm', 'cast' => '2 segments',
					'range' => sprintf( '%u feet', ( $this->level * 10 ) + 60 ),
					'aoe'   => sprintf( '%u square feet', ( $this->level * 10 ) + 40 ),
				),
			),
			'Third' => array(
				'Fear' => array( 'page' => 'PH 97, PH 77', 'type' => 'Illusion/Phantasm', 'cast' => '3 segments' ),
				'Phantom Steed' => array( 'page' => 'UA 68', 'type' => 'Conjuration/Phantasm', 'cast' => '3 segments',
					'duration' => sprintf( '%u turns', $this->level * 6 ),
					'special'  => sprintf( 'Movement rate: %u"', $this->level * 4 ),
				),
				'Suggestion' => array( 'page' => 'PH 98, PH 76', 'type' => 'Enchantment/Charm', 'cast' => '3 segments',
					'duration' => sprintf( '%u turns', ( $this->level * 4 ) + 4 ),
				),
			),
			'Fourth' => array(
				'Confusion' => array( 'page' => 'PH 98, PH 77, PH 64', 'type' => 'Enchantment/Charm', 'cast' => '4 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Improved lnvisibility' => array( 'page' => 'PH 98', 'type' => 'Illusion/Phantasm', 'cast' => '4 segments',
					'duration' => sprintf( '%u rounds', $this->level + 4 ),
					'special'  => 'Recipient is -4 to hit, and +4 saving throws.',
				),
				'Shadow Monsters' => array( 'page' => 'PH 99', 'type' => 'Illusion/Phantasm', 'cast' => '4 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
			),
			'Fifth' => array(
				'Demi-Shadow Monsters' => array( 'page' => 'PH 99', 'type' => 'Illusion/Phantasm', 'cast' => '4 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
					'special'  => 'Monsters are 40% hp, do 40% damage, and are AC 8.',
				),
				'Shadow Magic' => array( 'page' => 'PH 100', 'type' => 'Illusion/Phantasm', 'cast' => '5 segments',
					'range'   => sprintf( '%u feet', ( $this->level * 10 ) + 50 ),
					'special' => sprintf( 'Successful ST damage is %u hp.', $this->level ),
				),
			),
		);
	}

	protected function get_description_table() {
		static $table = null;
		if ( $table ) return $table;
		$table = array(
			'First' => array(
				'Light' => 'This spell is the same as the first level magic-user light spell (PH 68). (cf. first level cleric light spell.(PH 45))',
			),
		);
		return $table;
	}


/**  Manna functions  **/

	protected function spells_usable_table() {
		return array(
			array(),
			array( 1 ),       // 1
			array( 2 ),       // 2
			array( 2, 1 ),    // 3
			array( 3, 2 ),    // 4
			array( 4, 2, 1 ), // 5
			array( 4, 3, 1 ), // 6
			array( 4, 3, 2 ), // 7
			array( 4, 3, 2, 1 ),    //  8
			array( 5, 3, 3, 2 ),    //  9
			array( 5, 4, 3, 2, 1 ), // 10
			array( 5, 4, 3, 3, 2 ), // 11
			array( 5, 5, 4, 3, 2, 1 ),    // 12
			array( 5, 5, 4, 3, 2, 2 ),    // 13
			array( 5, 5, 4, 3, 2, 2, 1 ), // 14
			array( 5, 5, 4, 4, 2, 2, 2 ), // 15
			array( 5, 5, 5, 4, 3, 2, 2 ), // 16
			array( 5, 5, 5, 5, 3, 2, 2 ), // 17
			array( 5, 5, 5, 5, 3, 3, 2 ), // 18
			array( 5, 5, 5, 5, 4, 3, 2 ), // 19
			array( 5, 5, 5, 5, 4, 3, 2 ), // 20
			array( 5, 5, 5, 5, 5, 4, 3 ), // 21
			array( 5, 5, 5, 5, 5, 5, 4 ), // 22
			array( 5, 5, 5, 5, 5, 5, 5 ), // 23
			array( 6, 6, 6, 6, 5, 5, 5 ), // 24
			array( 6, 6, 6, 6, 6, 6, 6 ), // 25
			array( 7, 7, 7, 7, 6, 6, 6 ), // 26
		);
	}


}
