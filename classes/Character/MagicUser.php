<?php

class DND_Character_MagicUser extends DND_Character_Character {

	protected $ac_rows    = array( 0, 1, 1, 1, 2, 2, 3, 3, 3, 4, 4, 5, 5, 5, 6, 6, 7, 7, 7, 8, 8, 9 );
	protected $hit_die    = array( 'limit' => 11, 'size' => 4, 'step' => 1 );
	protected $non_prof   = -5;
	protected $stats      = array( 'str' => 3, 'int' => 9, 'wis' => 3, 'dex' => 6, 'con' => 3, 'chr' => 3 );
	protected $weap_allow = array( 'Caltrop', 'Dagger', 'Dagger,Thrown', 'Dart', 'Knife', 'Knife,Thrown', 'Sling', 'Spell', 'Staff,Quarter' );
	protected $weap_init  = array( 'initial' => 1, 'step' => 6 );
	protected $weapons    = array( 'Spell' => 'PF' );
	protected $xp_bonus   = array( 'int' => 16 );
	protected $xp_step    = 375000;
	protected $xp_table   = array( 0, 2500, 5000, 10000, 22500, 40000, 60000, 90000, 135000, 250000, 375000 );


	use DND_Character_Trait_Magic;


	protected function define_specials() { }

	protected function get_spell_table() {
		return array(
			'Cantrips' => array(
				'Change'  => array( 'page' => 'UA 48' ),
				'Freshen' => array( 'page' => 'UA 46' ),
				'Giggle'  => array( 'page' => 'UA 49' ),
				'Hide'    => array( 'page' => 'UA 48' ),
				'Mouse'   => array( 'page' => 'UA 50' ),
				'Palm'    => array( 'page' => 'UA 48' ),
				'Rattle'  => array( 'page' => 'UA 51' ),
				'Ravel'   => array( 'page' => 'UA 47' ),
				'Salt'    => array( 'page' => 'UA 46' ),
				'Smokepuff' => array( 'page' => 'UA 50' ),
				'Sneeze'  => array( 'page' => 'UA 48' ),
				'Spill'   => array( 'page' => 'UA 47' ),
				'Tangle'  => array( 'page' => 'UA 48' ),
				'Whistle' => array( 'page' => 'UA 51' ),
				'Wilt'    => array( 'page' => 'UA 48' ),
				'Wink'    => array( 'page' => 'UA 49' ),
				'Wrap'    => array( 'page' => 'UA 47' ),
				'Yawn'    => array( 'page' => 'UA 49' ),
			),
			'First' => array(
				'Affect Normal Fires' => array( 'page' => 'PH 65', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Armor' => array( 'page' => 'UA 51', 'type' => 'Conjuration', 'cast' => '1 round',
					'special'   => sprintf( 'absorbs %u points of damage', $this->level + 8 ),
					'condition' => 'this_character_only',
					'filters'   => array(
						array( 'character_armor_class_adjustments', 1, 10, 2 ),
						array( 'character_temporary_hit_points',   12, 10, 2 ),
					),
				),
				'Burning Hands' => array( 'page' => 'PH 65', 'type' => 'Alteration', 'cast' => '1 segment',
					'special' => sprintf( 'damage: %u hit points', $this->level ),
				),
				'Comprehend Languages' => array( 'page' => 'PH 66', 'type' => 'Alteration', 'cast' => '1 round',
					'duration' => sprintf( '%u rounds', $this->level * 5 ),
				),
				'Dancing Lights' => array( 'page' => 'PH 66', 'type' => 'Alteration', 'cast' => '1 segment',
					'range'    => sprintf( '%u feet', ( $this->level * 10 ) + 40 ),
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Detect Magic' => array( 'page' => 'PH 66, PH 55, PH 45', 'type' => 'Divination', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Feather Fall' => array( 'page' => 'PH 67', 'type' => 'Alteration', 'cast' => '0.1 segments',
					'duration' => sprintf( '%u segments', $this->level ),
				),
				'Find Familiar' => array( 'page' => 'PH 67', 'type' => 'Conjuration/Summoning', 'cast' => '24 hours' ),
				'Hold Portal' => array( 'page' => 'PH 67', 'type' => 'Alteration', 'cast' => '1 segment',
					'range'    => sprintf( '%u feet', $this->level * 20 ),
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Identify' => array( 'page' => 'PH 67', 'type' => 'Divination', 'cast' => '1 turn',
					'duration' => sprintf( '%u segments', $this->level ),
					'special'  => ( 15 + ( $this->level * 5 ) ) . '%',
				),
				'Light' => array( 'page' => 'PH 68, PH 45', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Magic Missile' => array( 'page' => 'PH 68', 'type' => 'Evocation', 'cast' => '1 segment',
					'range'   => sprintf( '%u feet', ( $this->level * 10 ) + 60 ),
					'special' => sprintf( '%1$ud4+%1$u', intval( ( $this->level + 1 ) / 2 ) )
				),
				'Mending' => array( 'page' => 'PH 68', 'type' => 'Alteration', 'cast' => '1 segment' ),
				'Message' => array( 'page' => 'PH 68', 'type' => 'Alteration', 'cast' => '1 segment',
					'range'    => sprintf( '%u feet', ( $this->level * 10 ) + 60 ),
					'duration' => sprintf( '%u segments', $this->level + 5 ),
				),
				'Precipitation' => array( 'page' => 'UA 52, UA 34', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u segments', $this->level ),
				),
				'Protection from Evil' => array( 'page' => 'PH 68, PH 44', 'type' => 'Abjuration', 'cast' => '1 segment', 'reversible' => true,
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Read Magic' => array( 'page' => 'PH 69', 'type' => 'Divination', 'cast' => '1 round' ), 'reversible' => true,
				'Sleep' => array( 'page' => 'PH 69', 'type' => 'Enchantment/Charm', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level * 5 ),
				),
				'Spider Climb' => array( 'page' => 'PH 69', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level + 1 ),
				),
				"Tenser's Floating Disc" => array( 'page' => 'PH 69', 'type' => 'Evocation', 'cast' => '1 segment',
					'duration' => sprintf( '%u turns', $this->level + 3 ),
				),
				'Unseen Servant' => array( 'page' => 'PH 70', 'type' => 'Conjuration/Summoning', 'cast' => '1 segment',
					'duration' => sprintf( '%u turns', $this->level + 6 ),
				),
				'Ventriloquism' => array( 'page' => 'PH 70', 'type' => 'Illusion/Phantasm', 'cast' => '1 segment',
					'range'    => sprintf( '%u feet', max( $this->level * 10, 60 ) ),
					'duration' => sprintf( '%u rounds', $this->level + 2 ),
				),
				'Wizard Mark' => array( 'page' => 'UA 53', 'type' => 'Alteration', 'cast' => '1 segment' ),
				'Write' => array( 'page' => 'PH70', 'type' => 'Evocation', 'cast' => '1 segment',
					'duration' => sprintf( '%u hours', $this->level ),
				),
			),
			'Second' => array(
				'Audible Glamer' => array( 'page' => 'PH 70', 'type' => 'Illusion/Phantasm', 'cast' => '2 segments',
					'range'    => sprintf( '%u feet', ( $this->level * 10 ) + 60 ),
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Continual Light' => array( 'page' => 'PH 70, PH 47', 'type' => 'Alteration', 'cast' => '2 segments' ),
				"Darkness 15' Radius" => array( 'page' => 'PH 70', 'type' => 'Alteration', 'cast' => '2 segments',
					'range'    => sprintf( '%u feet', $this->level * 10 ),
					'duration' => sprintf( '%3.1f turns', ( $this->level / 10 ) + 1 ),
				),
				'Forget' => array( 'page' => 'PH 71', 'type' => 'Enchantment/Charm', 'cast' => '2 segments' ),
				"Leomund's Trap" => array( 'page' => 'PH 71', 'type' => 'Illusion/Phantasm', 'cast' => '3 rounds' ),
				'Levitate' => array( 'page' => 'PH 71', 'type' => 'Alteration', 'cast' => '2 segments',
					'range'    => sprintf( '%u feet', $this->level * 20 ),
					'duration' => sprintf( '%u turns', $this->level ),
					'special'  => sprintf( 'Can levitate up to %u pounds', $this->level * 100 ),
				),
				'Magic Mouth' => array( 'page' => 'PH 72', 'type' => 'Alteration', 'cast' => '2 segments' ),
				'Mirror Image' => array( 'page' => 'PH 72', 'type' => 'Illusion/Phantasm', 'cast' => '2 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
					'special'  => sprintf( '01-%u: 1, %u-%u: 2, %u-%u: 3, %u-00: 4', max( 1, 25 - $this->level ), max( 2, 26 - $this->level ), max( 2, 50 - $this->level ), max( 3, 51 - $this->level ), max( 3, 75 - $this->level ), max( 4, 76 - $this->level ) ),
				),
				'Preserve' => array( 'page' => 'UA 54', 'type' => 'Abjuration', 'cast' => '2 rounds' ),
				'Protection from Cantrips' => array( 'page' => 'UA54', 'type' => 'Abjuration', 'cast' => '2 segments',
					'duration' => sprintf( '%u days', $this->level ),
				),
				'Pyrotechnics' => array( 'page' => 'PH 73', 'type' => 'Alteration', 'cast' => '2 segments' ),
				'Stinking Cloud' => array( 'page' => 'PH 72, PH 59', 'type' => 'Evocation', 'cast' => '2 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Strength' => array( 'page' => 'PH 73', 'type' => 'Alteration', 'cast' => '1 turn',
					'duration' => sprintf( '%u turns', $this->level * 6 ),
					'special'  => 'C:d6, F:d8, MU:d4, T:d6, M:d4',
				),
			),
			'Third' => array(
				'Blink' => array( 'page' => 'PH 73', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level ),
					'special'  => 'segment:2d4, direction: d8 - 1)RF 2)R 3)RB 4)B 5)LB 6)L 7)LF 8)F'
				),
				'Cloudburst' => array( 'page' => 'UA 55', 'type' => 'Alteration', 'cast' => '3 segments',
					'range' => sprintf( '%u feet', $this->level * 10 ),
				),
				'Dispel Magic' => array( 'page' => 'PH 74, PH 48', 'type' => 'Abjuration', 'cast' => '3 segments' ),
				'Feign Death' => array( 'page' => 'PH 74', 'type' => 'Necromantic', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level + 6 ),
				),
				'Fly' => array( 'page' => 'PH 74', 'type' => 'Alteration', 'cast' => '3 segments',
					'duration' => sprintf( '%u turns plus 1d6 turns', $this->level ),
					'special'  => 'DM should roll for the extra turns secretly.',
				),
				'Hold Person' => array( 'page' => 'PH 75', 'type' => 'Enchantment/Charm', 'cast' => '3 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
					'special'  => 'ST: 1 person at -3, 2 people at -1, 3-4 people normal',
				),
				'Item' => array( 'page' => 'UA 55', 'type' => 'Alteration', 'cast' => '3 segments',
					'duration' => sprintf( '%u hours (non-living %u hours)', $this->level, $this->level * 4 ),
					'aoe'      => sprintf( '%u cubic feet', $this->level * 2 ),
				),
				'Lightning Bolt' => array( 'page' => 'PH 75', 'type' => 'Evocation', 'cast' => '3 segments',
					'range'   => sprintf( '%u feet', ( $this->level + 4 ) * 10 ),
					'aoe'     => 'Single Bolt: 5 ft wide, 80 feet long; Forked Bolt: 10 ft wide, 40 feet long',
					'special' => sprintf( 'damage %ud6', $this->level ),
				),
				'Monster Summoning I' => array( 'page' => 'PH 75', 'type' => 'Conjuration/Summoning', 'cast' => '3 segments',
					'duration' => sprintf( '%u rounds', $this->level + 2 ),
				),
				'Phantasmal Force' => array( 'page' => 'PH 76', 'type' => 'Illusion/Phantasm', 'cast' => '3 segments',
					'range' => sprintf( '%u feet', ( $this->level * 10 ) + 80 ),
					'aoe'   => sprintf( '%u square inches', $this->level + 8 ),
				),
				'Protection From Normal Missiles' => array( 'page' => 'PH 76', 'type' => 'Abjuration', 'cast' => '3 segments',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Slow' => array( 'page' => 'PH 76', 'type' => 'Alteration', 'cast' => '3 segments',
					'range'    => sprintf( '%u feet', ( $this->level * 10 ) + 90 ),
					'duration' => sprintf( '%u rounds', $this->level + 3 ),
					'aoe'      => sprintf( '40 x 40 foot area, %u creatures', $this->level ),
				),
				'Suggestion' => array( 'page' => 'PH 76', 'type' => 'Enchantment/Charm', 'cast' => '3 segments',
					'duration' => sprintf( '%u turns', ( $this->level * 6 ) + 6 ),
				),
				'Tongues' => array( 'page' => 'PH 76', 'type' => 'Alteration', 'cast' => '3 segments', 'reversible' => true,
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Water Breathing' => array( 'page' => 'PH 76, PH 59-60', 'type' => 'Alteration', 'cast' => '3 segments', 'reversible' => true,
					'duration' => sprintf( '%u turns', $this->level * 3 ),
				),
			),
			'Fourth' => array(
				'Dispel Illusion' => array( 'page' => 'UA 56, PH 97', 'type' => 'Abjuration', 'cast' => '4 segments',
					'range' => sprintf( '%u feet', $this->level * 5 ),
				),
				"Evard's Black Tentacles" => array( 'page' => 'UA 56', 'type' => 'Conjuration/Summoning', 'cast' => '8 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
					'aoe'      => sprintf( '%u sq ft', $this->level * 30 ),
				),
				'Fire Charm' => array( 'page' => 'PH 77', 'type' => 'Enchantmen/Charm', 'cast' => '4 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Fumble' => array( 'page' => 'PH 78', 'type' => 'Enchantmen/Charm', 'cast' => '4 segments',
					'range'    => sprintf( '%u feet', $this->level * 10 ),
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Hallucinatory Terrain' => array( 'page' => 'PH 78', 'type' => 'Illusion/Phantasm', 'cast' => '1 turn',
					'range' => sprintf( '%u feet', $this->level * 20 ),
					'aoe'   => sprintf( ' %1$u x %1$u square area', $this->level * 10 ),
				),
				"Leomund's Secure Shelter" => array( 'page' => 'UA 57', 'type' => 'Alteration Enchantment', 'cast' => '4 turns',
					'duration' => sprintf( '%u hours', $this->level ),
					'aoe'      => sprintf( '%u square feet', $this->level * 30 ),
				),
				'Plant Growth' => array( 'page' => 'PH 79, PH 58', 'type' => 'Alteration', 'cast' => '4 segments',
					'range' => sprintf( '%u feet', $this->level * 10 ),
					'aoe'   => sprintf( ' %1$u x %1$u square feet area', $this->level * 10 ),
				),
				'Polymorph Other' => array( 'page' => 'PH 79', 'type' => 'Alteration', 'cast' => '4 segments',
					'range' => sprintf( '%u feet', $this->level * 5 ),
				),
				'Polymorph Other' => array( 'page' => 'PH 79', 'type' => 'Alteration', 'cast' => '3 segments',
					'duration' => sprintf( '%u turns', $this->level * 2 ),
				),
				'Shout' => array( 'page' => 'UA 57', 'type' => 'Evocation', 'cast' => '1 segment' ),
				'Wall of Ice' => array( 'page' => 'PH 79', 'type' => 'Evocation', 'cast' => '4 segments',
					'range'    => sprintf( '%u feet', $this->level * 10 ),
					'duration' => sprintf( '%u turns', $this->level ),
					'aoe'      => sprintf( '%u inches thick with %u square feet area', $this->level, $this->level * 10 ),
				),
				'Wizard Eye' => array( 'page' => 'PH 80', 'type' => 'Alteration', 'cast' => '1 turn',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
			),
			'Fifth' => array(
				'Distance Distortion' => array( 'page' => 'PH 81', 'type' => 'Alteration', 'cast' => '6 segments',
					'range'    => sprintf( '%u feet', $this->level * 10 ),
					'duration' => sprintf( '%u turns', $this->level ),
					'aoe'      => sprintf( '%u square feet', $this->level * 1000 ),
				),
				"Mordenkainen's Faithful Hound" => array( 'page' => 'PH 82', 'type' => 'Conjuration/Summoning', 'cast' => '5 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Telekinesis' => array( 'page' => 'PH 83', 'type' => 'Alteration', 'cast' => '5 segments',
					'range'    => sprintf( '%u feet', $this->level * 10 ),
					'duration' => sprintf( '%u rounds', $this->level + 2 ),
					'aoe'      => sprintf( '%u lbs', $this->level * 25 ),
				),
				'Transmute Rock to Mud' => array( 'page' => 'PH 83, PH 62', 'type' => 'Alteration', 'cast' => '5 segments', 'reversible' => true,
					'range' => sprintf( '%u feet', $this->level * 10 ),
					'aoe'   => sprintf( '%u cubic feet', $this->level * 20 ),
				),
				'Wall of Force' => array( 'page' => 'PH 83', 'type' => 'Evocation', 'cast' => '5 segments',
					'duration' => sprintf( '%3.1f turns', ( $this->level / 10 ) + 1 ),
					'aoe'      => sprintf( '%u square feet', $this->level * 20 ),
				),
			),
			'Sixth' => array(
				'Control Weather' => array( 'page' => 'PH 84, PH 53', 'type' => 'Alteration', 'cast' => '1 turn',
					'duration' => '4d6 hours',
					'aoe'      => '4d4 square miles',
				),
				'Legend Lore' => array( 'page' => 'PH 85', 'type' => 'Divination', 'cast' => 'Special' ),
				'Project Image' => array( 'page' => 'PH 85', 'type' => 'Alteration,Illusion/Phantasm', 'cast' => '6 segments',
					'range'    => sprintf( '%u feet', $this->level * 10 ),
					'duration' => sprintf( '%u rounds', $this->level ),
				),
			),
			'Seventh' => array(
				'Limited Wish' => array( 'page' => 'PH 89', 'type' => 'Conjuration/Summoning', 'cast' => 'Special' ),
				'Simulacrum' => array( 'page' => 'PH 89', 'type' => 'Illusion/Phantasm', 'cast' => 'Special',
					'special' => "50%+1d10% of the original's hit points.",
				),
			),
			'Eighth' => array(
				"Otto's Irresistible Dance" => array( 'page' => 'PH 91', 'type' => 'Enchantment/Charm', 'cast' => '5 segments',
					'duraction' => '1d4+1 rounds',
					'aoe'       => 'Creature touched',
					'special'   => 'Target AC is -4, no STs allowed, no shield',
				),
			),
		);
	}

}
