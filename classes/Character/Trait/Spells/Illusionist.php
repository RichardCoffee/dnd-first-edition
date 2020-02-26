<?php

trait DND_Character_Trait_Spells_Illusionist {


	protected function get_illusionist_spell_table() {
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
						array( 'dnd1e_armor_type',   3, 10, 2 ),
						array( 'dnd1e_temporary_hp', $this->level, 10, 2 ),
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
				'Detect Magic (I)' => array( 'page' => 'PH 96, PH 66, PH 45', 'type' => 'Divination', 'cast' => '2 segments',
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

	protected function get_illusionist_description_table() {
		static $table = null;
		if ( $table ) return $table;
		$table = array(
			'First' => array(
				'Light' => 'This spell is the same as the first level magic-user light spell (PH 68). (cf. first level cleric light spell.(PH 45))',
			),
		);
		return $table;
	}


}
