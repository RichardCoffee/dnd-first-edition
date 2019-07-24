<?php

class DND_Character_Illusionist extends DND_Character_Character {

	protected $ac_rows    = array( 0, 1, 1, 1, 2, 2, 3, 3, 3, 4, 4, 5, 5, 5, 6, 6, 7, 7, 7, 8, 8, 9 );
	protected $hit_die    = array( 'limit' => 10, 'size' => 4, 'step' => 1 );
	protected $non_prof   = -5;
	protected $stats      = array( 'str' => 3, 'int' => 15, 'wis' => 3, 'dex' => 16, 'con' => 3, 'chr' => 3 );
	protected $weap_allow = array( 'Caltrop', 'Dagger', 'Dagger,Thrown', 'Dart', 'Knife', 'Knife,Thrown', 'Sling', 'Spell', 'Staff,Quarter' );
	protected $weap_init  = array( 'initial' => 1, 'step' => 6 );
	protected $weapons    = array( 'Spell' => 'PF' );
#	protected $xp_bonus   = array();
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
				'Light' => array( 'page' => 'PH 96, PH 45', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Phantom Armor' => array( 'page' => 'UA 67', 'type' => 'Alteration', 'cast' => '1 round',
					'special'   => sprintf( 'absorbs %u points of damage', $this->level ),
					'condition' => 'this_character_only',
					'filters'   => array(
						array( 'character_armor_type', 3, 10, 2 ),
						array( 'character_temporary_hit_points', $this->level, 10, 2 ),
						array( 'character_all_saving_throws', 1, 10, 2 ),
					),
				),
				'Read Illusionist Magic' => array( 'page' => 'UA 67, PH 69', 'type' => 'Divination', 'cast' => '1 round', 'reversible' => true,
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Spook' => array( 'page' => 'UA 67', 'type' => 'Illusion/Phantasm', 'cast' => '1 segment' ),
			),
			'Second' => array(
				'Fog Cloud' => array( 'page' => 'PH 96', 'type' => 'Alteration', 'cast' => '2 segment',
					'range'    => '10 feet',
					'duration' => sprintf( '%u rounds', $this->level + 4 ),
					'aoe'      => "40' wide, 20' high, 20' deep cloud",
				),
			),
			'Third' => array(
			),
			'Fourth' => array(
			),
		);
	}

}
