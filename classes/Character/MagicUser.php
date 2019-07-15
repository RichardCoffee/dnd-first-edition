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
				'Change'  => array( 'page' => 'UA48' ),
				'Freshen' => array( 'page' => 'UA46' ),
				'Giggle'  => array( 'page' => 'UA49' ),
				'Hide'    => array( 'page' => 'UA48' ),
				'Mouse'   => array( 'page' => 'UA50' ),
				'Palm'    => array( 'page' => 'UA48' ),
				'Rattle'  => array( 'page' => 'UA51' ),
				'Ravel'   => array( 'page' => 'UA47' ),
				'Salt'    => array( 'page' => 'UA46' ),
				'Smokepuff' => array( 'page' => 'UA50' ),
				'Sneeze'  => array( 'page' => 'UA48' ),
				'Spill'   => array( 'page' => 'UA47' ),
				'Tangle'  => array( 'page' => 'UA48' ),
				'Whistle' => array( 'page' => 'UA51' ),
				'Wilt'    => array( 'page' => 'UA48' ),
				'Wink'    => array( 'page' => 'UA49' ),
				'Wrap'    => array( 'page' => 'UA47' ),
				'Yawn'    => array( 'page' => 'UA49' ),
			),
			'First' => array(
				'Affect Normal Fires' => array( 'page' => 'PH65', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Armor' => array( 'page' => 'UA51', 'type' => 'Conjuration', 'cast' => '1 round',
					'special' => sprintf( 'absorbs %u points of damage', $this->level + 8 ),
				),
				'Burning Hands' => array( 'page' => 'PH65', 'type' => 'Alteration', 'cast' => '1 segment',
					'special' => sprintf( 'damage: %u hit points', $this->level ),
				),
				'Comprehend Languages' => array( 'page' => 'PH66', 'type' => 'Alteration', 'cast' => '1 round',
					'duration' => sprintf( '%u rounds', $this->level * 5 ),
				),
				'Dancing Lights' => array( 'page' => 'PH66', 'type' => 'Alteration', 'cast' => '1 segment',
					'range'    => sprintf( '%u feet', ( $this->level * 10 ) + 40 ),
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Detect Magic' => array( 'page' => 'PH66,PH55,PH45', 'type' => 'Divination', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Feather Fall' => array( 'page' => 'PH67', 'type' => 'Alteration', 'cast' => '0.1 segments',
					'duration' => sprintf( '%u segments', $this->level ),
				),
				'Find Familiar' => array( 'page' => 'PH67', 'type' => 'Conjuration/Summoning', 'cast' => '24 hours' ),
				'Hold Portal' => array( 'page' => 'PH67', 'type' => 'Alteration', 'cast' => '1 segment',
					'range'    => sprintf( '%u feet', $this->level * 20 ),
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Identify' => array( 'page' => 'PH67', 'type' => 'Divination', 'cast' => '1 turn',
					'duration' => sprintf( '%u segments', $this->level ),
					'special'  => ( 15 + ( $this->level * 5 ) ) . '%',
				),
				'Light' => array( 'page' => 'PH68,PH45', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Magic Missile' => array( 'page' => 'PH68', 'type' => 'Evocation', 'cast' => '1 segment',
					'range'   => sprintf( '%u feet', ( $this->level * 10 ) + 60 ),
					'special' => sprintf( '%1$ud4+%1$u', intval( ( $this->level + 1 ) / 2 ) )
				),
				'Mending' => array( 'page' => 'PH68', 'type' => 'Alteration', 'cast' => '1 segment' ),
				'Precipitation' => array( 'page' => 'UA52,UA34', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u segments', $this->level ),
				),
				'Protection from Evil' => array( 'page' => 'PH68,PH44', 'type' => 'Abjuration', 'cast' => '1 segment', 'reversible' => true,
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Read Magic' => array( 'page' => 'PH69', 'type' => 'Divination', 'cast' => '1 round' ), 'reversible' => true,
				'Sleep' => array( 'page' => 'PH69', 'type' => 'Enchantment/Charm', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level * 5 ),
				),
				'Spider Climb' => array( 'page' => 'PH69', 'type' => 'Alteration', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level + 1 ),
				),
				"Tenser's Floating Disc" => array( 'page' => 'PH69', 'type' => 'Evocation', 'cast' => '1 segment',
					'duration' => sprintf( '%u turns', $this->level + 3 ),
				),
				'Unseen Servant' => array( 'page' => 'PH70', 'type' => 'Conjuration/Summoning', 'cast' => '1 segment',
					'duration' => sprintf( '%u turns', $this->level + 6 ),
				),
				'Ventriloquism' => array( 'page' => 'PH70', 'type' => 'Illusion/Phantasm', 'cast' => '1 segment',
					'range'    => sprintf( '%u feet', max( $this->level * 10, 60 ) ),
					'duration' => sprintf( '%u rounds', $this->level + 2 ),
				),
				'Wizard Mark' => array( 'page' => 'UA53', 'type' => 'Alteration', 'cast' => '1 segment' ),
				'Write' => array( 'page' => 'PH70', 'type' => 'Evocation', 'cast' => '1 segment',
					'duration' => sprintf( '%u hours', $this->level ),
				),
			),
			'Second' => array(
				'Continual Light' => array( 'page' => 'PH70,PH47', 'type' => 'Alteration', 'cast' => '2 segments' ),
				"Darkness 15' Radius" => array( 'page' => 'PH70', 'type' => 'Alteration', 'cast' => '2 segments',
					'range'    => sprintf( '%u feet', $this->level * 10 ),
					'duration' => sprintf( '%3.1f turns', ( $this->level / 10 ) + 1 ),
				),
				'Forget' => array( 'page' => 'PH71', 'type' => 'Enchantment/Charm', 'cast' => '2 segments' ),
				"Leomund's Trap" => array( 'page' => 'PH71', 'type' => 'Illusion/Phantasm', 'cast' => '3 rounds' ),
				'Magic Mouth' => array( 'page' => 'PH72', 'type' => 'Alteration', 'cast' => '2 segments' ),
				'Mirror Image' => array( 'page' => 'PH72', 'type' => 'Illusion/Phantasm', 'cast' => '2 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
					'special'  => sprintf( '01-%u: 1, %u-%u: 2, %u-%u: 3, %u-00: 4', 25 - $this->level, 26 - $this->level, 50 - $this->level, 51 - $this->level, 75 - $this->level, 76 - $this->level ),
				),
				'Preserve' => array( 'page' => 'UA54', 'type' => 'Abjuration', 'cast' => '2 rounds' ),
				'Protection from Cantrips' => array( 'page' => 'UA54', 'type' => 'Abjuration', 'cast' => '2 segments',
					'duration' => sprintf( '%u days', $this->level ),
				),
				'Pyrotechnics' => array( 'page' => 'PH73', 'type' => 'Alteration', 'cast' => '2 segments' ),
				'Stinking Cloud' => array( 'page' => 'PH72,PH59', 'type' => 'Evocation', 'cast' => '2 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Strength' => array( 'page' => 'PH73', 'type' => 'Alteration', 'cast' => '1 turn',
					'duration' => sprintf( '%u turns', $this->level * 6 ),
					'special'  => 'C:d6, F:d8, MU:d4, T:d6, M:d4',
				),
			),
			'Third' => array(
				'Blink' => array( 'page' => 'PH73', 'type' => 'Alteration', 'cast' => '1 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
					'special'  => 'segment:2d4, direction: d8 - 1)RF 2)R 3)RB 4)B 5)LB 6)L 7)LF 8)F'
				),
				'Cloudburst' => array( 'page' => 'UA55', 'type' => 'Alteration', 'cast' => '3 segments',
					'range' => sprintf( '%u feet', $this->level * 10 ),
				),
				'Dispel Magic' => array( 'page' => 'PH74,PH48', 'type' => 'Abjuration', 'cast' => '3 segments' ),
				'Feign Death' => array( 'page' => 'PH74', 'type' => 'Necromantic', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level + 6 ),
				),
				'Hold Person' => array( 'page' => 'PH75', 'type' => 'Enchantment/Charm', 'cast' => '3 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
					'special'  => 'ST: 1 person at -3, 2 people at -1, 3-4 people normal',
				),
				'Item' => array( 'page' => 'UA55', 'type' => 'Alteration', 'cast' => '3 segments',
					'duration' => sprintf( '%u hours (non-living %u hours)', $this->level, $this->level * 4 ),
					'aoe'      => sprintf( '%u cubic feet', $this->level * 2 ),
				),
				'Lightning Bolt' => array( 'page' => 'PH75', 'type' => 'Evocation', 'cast' => '3 segments',
					'range'   => sprintf( '%u feet', ( $this->level + 4 ) * 10 ),
					'aoe'     => 'Single Bolt: 5 ft wide, 80 feet long; Forked Bolt: 10 ft wide, 40 feet long',
					'special' => sprintf( 'damage %ud6', $this->level ),
				),
				'Monster Summoning I' => array( 'page' => 'PH75', 'type' => 'Conjuration/Summoning', 'cast' => '3 segments',
					'duration' => sprintf( '%u rounds', $this->level + 2 ),
				),
				'Protection From Normal Missiles' => array( 'page' => 'PH76', 'type' => 'Abjuration', 'cast' => '3 segments',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Suggestion' => array( 'page' => 'PH76', 'type' => 'Enchantment/Charm', 'cast' => '3 segments',
					'duration' => sprintf( '%u turns', ( $this->level * 6 ) + 6 ),
				),
				'Tongues' => array( 'page' => 'PH76', 'type' => 'Alteration', 'cast' => '3 segments', 'reversible' => true,
					'duration' => sprintf( '%u rounds', $this->level ),
				),
			),
			'Fourth' => array(
				'Dispel Illusion' => array( 'page' => 'UA56,PH97', 'type' => 'Abjuration', 'cast' => '4 segments',
					'range' => sprintf( '%u feet', $this->level * 5 ),
				),
				"Evard's Black Tentacles" => array( 'page' => 'UA56', 'type' => 'Conjuration/Summoning', 'cast' => '8 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
					'aoe'      => sprintf( '%u sq ft', $this->level * 30 ),
				),
				'Hallucinatory Terrain' => array( 'page' => 'PH78', 'type' => 'Illusion/Phantasm', 'cast' => '1 turn',
					'range' => sprintf( '%u feet', $this->level * 20 ),
					'aoe'   => sprintf( ' %1$u x %1$u square area', $this->level * 10 ),
				),
				"Leomund's Secure Shelter" => array( 'page' => 'UA57', 'type' => 'Alteration Enchantment', 'cast' => '4 turns',
					'duration' => sprintf( '%u hours', $this->level ),
					'aoe'      => sprintf( '%u square feet', $this->level * 30 ),
				),
				'Plant Growth' => array( 'page' => 'PH79,PH58', 'type' => 'Alteration', 'cast' => '4 segments',
					'range' => sprintf( '%u feet', $this->level * 10 ),
					'aoe'   => sprintf( ' %1$u x %1$u square feet area', $this->level * 10 ),
				),
				'Polymorph Other' => array( 'page' => 'PH79', 'type' => 'Alteration', 'cast' => '4 segments',
					'range' => sprintf( '%u feet', $this->level * 5 ),
				),
				'Shout' => array( 'page' => 'UA57', 'type' => 'Evocation', 'cast' => '1 segment' ),
				'Wall of Ice' => array( 'page' => 'PH79', 'type' => 'Evocation', 'cast' => '4 segments',
					'range'    => sprintf( '%u feet', $this->level * 10 ),
					'duration' => sprintf( '%u turns', $this->level ),
					'aoe'      => sprintf( '%u inches thick with %u square feet area', $this->level, $this->level * 10 ),
				),
				'Wizard Eye' => array( 'page' => 'PH80', 'type' => 'Alteration', 'cast' => '1 turn',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
			),
		);
	}

}
