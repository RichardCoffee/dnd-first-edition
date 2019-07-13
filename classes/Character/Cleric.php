<?php

class DND_Character_Cleric extends DND_Character_Character {

	protected $ac_rows    = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
	protected $hit_die    = array( 'limit' => 9, 'size' => 8, 'step' => 2 );
	protected $non_prof   = -3;
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 9, 'dex' => 3, 'con' => 3, 'chr' => 3 );
	protected $undead     = array();
	protected $weap_allow = array( 'Club', 'Flail', 'Hammer', 'Hammer,Lucern', 'Mace', 'Spell', 'Staff' );
	protected $weap_init  = array( 'initial' => 2, 'step' => 4 );
	protected $weapons    = array( 'Spell' => 'PF' );
	protected $xp_bonus   = array( 'wis' => 16 );
	protected $xp_step    = 225000;
	protected $xp_table   = array( 0, 1500, 3000, 6000, 13000, 27500, 55000, 110000, 225000 );


	use DND_Character_Trait_Magic;


	public function initialize_character() {
		parent::initialize_character();
		$this->undead = $this->get_undead_caps();
	}

	protected function define_specials() {
		$this->specials = array(
			'string_undead' => 'Turn Undead',
		);
	}

	public function special_string_undead( $type, $level = 0 ) {
		$response = 'Unknown';
		$type   = ucfirst( $type );
		$level  = ( $level === 0 ) ? $this->level : $level;
		$undead = $this->get_undead_table();
		if ( isset( $undead[ $type ] ) ) {
			$foe = $undead[ $type];
			if ( isset( $foe[ $level] ) ) {
				$response = $foe[ $level ];
			} else {
				$response = array_pop( $foe );
			}
		}
		return $response;
	}

	public function get_undead_caps( $level = 0 ) {
		$caps   = array();
		$level  = ( $level === 0 ) ? $this->level : $level;
		$undead = $this->get_undead_table();
		foreach( $undead as $yuch => $turn ) {
			if ( isset( $turn[ $level ] ) ) {
				$caps[ $yuch ] = $turn[ $level ];
			} else {
				$caps[ $yuch ] = array_pop( $turn );
			}
		}
		return $caps;
	}

	protected function get_undead_table() {
		return array(
			'Skeleton' => array(  13,    10,     7,     4,    'T',   'T',   'D',   'D',  'D*' ),
			'Zombie'   => array(  16,    13,    10,     7,    'T',   'T',   'D',   'D',  'D', 'D*' ),
			'Ghoul'    => array(  19,    16,    13,    10,     4,    'T',   'T',   'D',  'D', 'D', 'D', 'D', 'D', 'D*' ),
			'Shadow'   => array(  20,    19,    16,    13,     7,     4,    'T',   'T',  'D', 'D', 'D', 'D', 'D', 'D', 'D*' ),
			'Wight'    => array( 'N/A',  20,    19,    16,    10,     7,     4,    'T',  'T', 'D' ),
			'Ghast'    => array( 'N/A', 'N/A',  20,    19,    13,    10,     7,     4,   'T', 'T', 'T', 'T', 'T', 'T', 'D' ),
			'Wraith'   => array( 'N/A', 'N/A', 'N/A',  20,    16,    13,    10,     7,    4,  'T', 'T', 'T', 'T', 'T', 'D' ),
			'Mummy'    => array( 'N/A', 'N/A', 'N/A', 'N/A',  19,    16,    13,    10,    7,   4,   4,   4,   4,   4,  'T', 'T', 'T', 'T', 'T', 'D' ),
			'Spectre'  => array( 'N/A', 'N/A', 'N/A', 'N/A',  20,    19,    16,    13,   10,   7,   7,   7,   7,   7,   4,   4,   4,   4,   4,  'T' ),
			'Vampire'  => array( 'N/A', 'N/A', 'N/A', 'N/A', 'N/A',  20,    19,    16,   13,  10,  10,  10,  10,  10,   7,   7,   7,   7,   7,   4 ),
			'Ghost'    => array( 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A',  20,    19,   16,  13,  13,  13,  13,  13,  10,  10,  10,  10,  10,   7 ),
			'Lich'     => array( 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A',  20,   19,  16,  16,  16,  16,  16,  13,  13,  13,  13,  13,  10 ),
			'Special'  => array( 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 20,  19,  19,  19,  19,  19,  16,  16,  16,  16,  16,  13 ),
		);
	}

	protected function get_spell_table() {
		return array(
			'First' => array(
				'Bless' => array( 'page' => 'PH44', 'cast' => '1 round', 'duration' => '6 rounds',
					'special' => 'To hit: +1, morale: +5%',
				),
				'Ceremony' => array( 'page' => 'UA32', 'cast' => '1 hour' ),
				'Combine' => array( 'page' => 'UA32', 'cast' => '1 round' ),
				'Command' => array( 'page' => 'PH44', 'cast' => '1 segment', 'duration' => '1 round' ),
				'Create Water' => array( 'page' => 'PH44', 'cast' => '1 round' ),
				'Cure Light Wounds' => array( 'page' => 'PH44', 'cast' => '5 segments',
					'special' => sprintf( 'Heals 1d8+%u', $this->get_wisdom_saving_throw_bonus( $this->stats['wis'] ) ),
				),
				'Detect Evil' => array( 'page' => 'PH45', 'cast' => '1 round',
					'duration' => sprintf( '%3.1f turns', ( $this->level * 0.5 ) + 1 ),
				),
				'Endure Cold/Heat' => array( 'page' => 'UA33', 'cast' => '1 round',
					'duration' => sprintf( '%u turns', $this->level * 9 ),
				),
				'Invisibility to Undead' => array( 'page' => 'UA33', 'cast' => '4 segments', 'duration' => '6 rounds' ),
				'Light' => array( 'page' => 'PH45', 'cast' => '4 segments',
					'duration' => sprintf( '%u turns', $this->level + 6 ),
				),
				'Magic Stone' => array( 'page' => 'UA33', 'cast' => '1 round', 'duration' => '6 rounds or until used',
					'special' => sprintf( 'can enchant %u stones', ceil( $this->level / 5 ) ),
				),
				'Penetrate Disguise' => array( 'page' => 'UA33', 'cast' => '2 rounds', 'duration' => '1 round' ),
				'Protection from Evil' => array( 'page' => 'PH45', 'cast' => '4 segments',
					'duration' => sprintf( '%u rounds', $this->level * 3 ),
				),
				'Purify Food & Drink' => array( 'page' => 'PH45', 'cast' => '1 round' ),
				'Resist Cold' => array( 'page' => 'PH45', 'cast' => '1 round',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Sanctuary' => array( 'page' => 'PH45', 'cast' => '4 segments',
					'duration' => sprintf( '%u rounds', $this->level + 2 ),
				),
			),
			'Second' => array(
				'Augury' => array( 'page' => 'PH46', 'cast' => '2 rounds' ),
				'Chant' => array( 'page' => 'PH46', 'cast' => '1 turn' ),
				'Detect Charm' => array( 'page' => 'PH46', 'cast' => '1 round', 'duration' => '1 turn' ),
				'Detect Life' => array( 'page' => 'UA34', 'cast' => '1 round', 'duration' => '5 rounds' ),
				'Enthrall' => array( 'page' => 'UA34', 'cast' => '1 round' ),
				'Find Traps' => array( 'page' => 'PH46', 'cast' => '5 segments', 'duration' => '3 turns' ),
				'Holy Symbol' => array( 'page' => 'UA35', 'cast' => '1 turn' ),
				'Know Alignment' => array( 'page' => 'PH46', 'cast' => '1 round', 'duration' => '1 turn' ),
				'Resist Fire' => array( 'page' => 'PH46', 'cast' => '5 segments',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				"Silence 15' Radius" => array( 'page' => 'PH46', 'cast' => '5 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Slow Poison' => array( 'page' => 'PH46', 'cast' => '1 segment',
					'duration' => sprintf( '%u hours', $this->level ),
				),
				'Snake Charm' => array( 'page' => 'PH47', 'cast' => '5 segments' ),
				'Speak w/Animals' => array( 'page' => 'PH47', 'cast' => '5 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Withdraw' => array( 'page' => 'UA35', 'cast' => '2 segments',
					'duration' => sprintf( '%u segments', $this->level + 1 ),
				),
				'Wyvern Watch' => array( 'page' => 'UA35', 'cast' => '5 segments', 'duration' => '8 hours or until strike' ),
			),
			'Third' => array(
				'Animate Dead' => array( 'page' => 'PH47', 'cast' => '1 round' ),
				'Cloudburst' => array( 'page' => 'UA35', 'cast' => '5 segments', 'duration' => '1 round' ),
				'Continual Light' => array( 'page' => 'PH47', 'cast' => '6 segments' ),
				'Cure Blindness' => array( 'page' => 'PH47', 'cast' => '1 round' ),
				'Cure Disease' => array( 'page' => 'PH47', 'cast' => '1 turn' ),
				"Death's  Door" => array( 'page' => 'UA35', 'cast' => '5 segments',
					'duration' => sprintf( '%u hours', $this->level ),
				),
				'Dispel Magic' => array( 'page' => 'PH48', 'cast' => '6 segments' ),
				'Feign Death' => array( 'page' => 'PH48', 'cast' => '2 segments',
					'duration' => sprintf( '%3.1f turns', ( $this->level / 10 ) + 1 ),
				),
				'Flame Walk' => array( 'page' => 'UA36', 'cast' => '5 segments',
					'duration' => sprintf( '%u turns', $this->level + 1 ),
					'special'  => sprintf( 'can effect %u man-sized beings or equivalent.', max( 1, $this->level - 5 ) ),
				),
				'Locate Object' => array( 'page' => 'PH48', 'cast' => '1 turn',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Magical Vestment' => array( 'page' => 'UA36', 'cast' => '1 round',
					'duration' => sprintf( '%u rounds', $this->level * 6 ),
				),
				'Meld into Stone' => array( 'page' => 'UA36', 'cast' => '7 segments' ),
				'Prayer' => array( 'page' => 'PH48', 'cast' => '6 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Remove Curse' => array( 'page' => 'PH48', 'cast' => '6 segments' ),
			),
			'Fourth' => array(
				'Abjure' => array( 'page' => 'UA37', 'cast' => '1 round',
					'special' => sprintf( 'as if chain mail +%u.', min( 4, ceil( $this->level / 4 ) ) ),
				),
				'Cure Serious Wounds' => array( 'page' => 'PH49', 'cast' => '7 segments',
					'special' => sprintf( 'Heals 2d8+%u', $this->get_wisdom_saving_throw_bonus( $this->stats['wis'] ) + 1 ),
				),
				'Exorcise' => array( 'page' => 'PH49', 'cast' => 'Special' ),
				'Imbue with Spell Ability' => array( 'page' => 'UA38', 'cast' => '1 turn' ),
				'Lower Water' => array( 'page' => 'PH49', 'cast' => '1 turn',
					'duration' => sprintf( '%u turns', $this->level ),
					'aoe' => sprintf( '%u square feet', $this->level**2 * 100 ),
				),
				'Spell Immunity' => array( 'page' => 'UA38', 'cast' => '1 round',
					'duration' => sprintf( '%u turns', $this->level ),
				),
			),
			'Fifth' => array(
				'Insect Plague' => array( 'page' => 'PH51', 'cast' => '1 turn',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Rainbow' => array( 'page' => 'UA39', 'cast' => '7 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Raise Dead' => array( 'page' => 'PH51', 'cast' => '1 round' ),
				'Spike Stones' => array( 'page' => 'UA40', 'cast' => '6 segments',
					'duration' => sprintf( '3d4+%u turns', $this->level ),
				),
				'True Seeing' => array( 'page' => 'PH51', 'cast' => '8 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
			),
			'Sixth' => array(
				'Animate Object' => array( 'page' => 'PH52', 'cast' => '9 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Forbiddance' => array( 'page' => 'UA40', 'cast' => '6 rounds' ),
				'Part Water' => array( 'page' => 'PH52', 'cast' => '1 turn',
					'duration' => sprintf( '%u turns', $this->level ),
				),
			),
		);
	}



}
