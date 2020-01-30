<?php

class DND_Character_Cleric extends DND_Character_Character {

	protected $ac_rows    = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
	protected $hit_die    = array( 'limit' => 9, 'size' => 8, 'step' => 2 );
	protected $non_prof   = -3;
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 9, 'dex' => 3, 'con' => 3, 'chr' => 3 );
	protected $undead     = array();
	protected $weap_allow = array( 'Club', 'Flail', 'Hammer', 'Hammer,Lucern', 'Mace', 'Spell', 'Staff,Quarter' );
	protected $weap_init  = array( 'initial' => 2, 'step' => 4 );
	protected $weapons    = array( 'Spell' => array( 'bonus' => 0, 'skill' => 'PF' ) );
	protected $xp_bonus   = array( 'wis' => 16 );
	protected $xp_step    = 225000;
	protected $xp_table   = array( 0, 1500, 3000, 6000, 13000, 27500, 55000, 110000, 225000 );


	use DND_Character_Trait_Magic;


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		if ( array_key_exists( 'spell_import', $args ) ) {
			$this->import_spell_list( $args['spell_import'] );
		}
		$this->calculate_manna_points();
	}

	protected function initialize_character() {
		parent::initialize_character();
		$this->undead = $this->get_undead_caps();
	}

	public function set_level( $level ) {
		parent::set_level( $level );
	}

	protected function define_specials() {
		$this->specials = array(
			'string_undead' => 'Turn Undead',
		);
	}

	public function special_string_undead( $type, $level = 0 ) {
		$response = 'Unknown';
		$type   = ucfirst( $type );
		$level  = ( ( $level === 0 ) ? $this->level : $level ) + apply_filters( 'object_level_bonus', 0 );
		$undead = $this->get_undead_table();
		if ( array_key_exists( $type, $undead ) ) {
			$foe = $undead[ $type];
			if ( array_key_exists( $level, $foe ) ) {
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
			if ( array_key_exists( $level, $turn ) ) {
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

	private function reroll_healing_string() {
		$string = '';
		if ( $this->level > 15 ) {
			$string = ', re-roll 1s, 2s and 3s';
		} else if ( $this->level > 10 ) {
			$string = ', re-roll 1s and 2s';
		} else if ( $this->level > 5 ) {
			$string = ', re-roll 1s';
		}
		return $string;
	}

	protected function get_saving_throw_table() {
		return $this->get_cleric_saving_throw_table();
	}

	protected function get_spell_table() {
		return array(
			'First' => array(
				'Bless' => array( 'page' => 'PH 44',
					'type'       => 'Conjuration/Summoning',
					'reversible' => true,
					'range'      => '60 feet',
					'duration'   => '6 rounds',
					'aoe'        => '50 feet X 50 feet',
					'comps'      => 'V,S,M',
					'cast'       => '1 round',
					'saving'     => 'None',
					'special'    => 'To hit: +1, morale: +5%',
					'condition'  => 'this_group_only',
					'filters'    => array(
						array( 'object_to_hit_opponent', 1, 10, 3 ),
						array( 'object_morale_check',    5, 10, 3 ),
					),
					'target' => 'party',
				),
				'Ceremony' => array( 'page' => 'UA 32', 'cast' => '1 hour' ),
				'Combine' => array( 'page' => 'UA 32',
					'duration'  => '3 turns',
					'cast'      => '1 round',
					'condition' => 'this_group_only',
					'filters'   => array(
						array( 'opponent_to_hit_group', -4, 10, 2 ),
#						array( 'group_ac_dex_bonus',     0, 10, 2 ), # replacement filter
#						array( 'object_level_bonus', max( 4, count( $group ) ), 10, 2 ),
					),
					'target'    => 'origin'
				),
				'Command' => array( 'page' => 'PH 44', 'cast' => '1 segment', 'duration' => '1 round' ),
				'Create Water' => array( 'page' => 'PH 44', 'type' => 'Alteration', 'cast' => '1 round', 'reversible' => true,
					'aoe' => sprintf( '%u gallons', $this->level * 4 ),
				),
				'Cure Light Wounds' => array( 'page' => 'PH 44', 'cast' => '5 segments',
					'special' => sprintf( 'Heals 1d8+%u', $this->get_wisdom_saving_throw_bonus( $this->stats['wis'] ) ) . $this->reroll_healing_string(),
				),
				'Detect Evil' => array( 'page' => 'PH 45', 'cast' => '1 round',
					'duration' => sprintf( '%3.1f turns', ( $this->level * 0.5 ) + 1 ),
				),
				'Endure Cold/Heat' => array( 'page' => 'UA 33', 'cast' => '1 round',
					'duration' => sprintf( '%u turns', $this->level * 9 ),
				),
				'Invisibility to Undead' => array( 'page' => 'UA 33', 'cast' => '4 segments', 'duration' => '6 rounds' ),
				'Light' => array( 'page' => 'PH45', 'type' => 'Alteration', 'cast' => '4 segments',
					'duration' => sprintf( '%u turns', $this->level + 6 ),
				),
				'Magic Stone' => array( 'page' => 'UA 33', 'cast' => '1 round', 'duration' => '6 rounds or until used',
					'special' => sprintf( 'can enchant %u stones', ceil( $this->level / 5 ) ),
				),
				'Penetrate Disguise' => array( 'page' => 'UA 33', 'cast' => '2 rounds', 'duration' => '1 round' ),
				'Protection from Evil' => array( 'page' => 'PH 45', 'cast' => '4 segments',
					'duration'  => sprintf( '%u rounds', $this->level * 3 ),
					'condition' => 'this_origin_only',
					'filters' => array(
						array( 'object_to_hit_opponent',      2, 10, 3 ),
						array( 'character_all_saving_throws', 2, 10, 2 ),
						array( 'opponent_to_hit_object',      2, 10, 3 ),
					),
				),
				'Purify Food & Drink' => array( 'page' => 'PH 45', 'type' => 'Alteration', 'cast' => '1 round' ),
				'Resist Cold' => array( 'page' => 'PH 45', 'type' => 'Alteration', 'cast' => '1 round',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Sanctuary' => array( 'page' => 'PH 45', 'cast' => '4 segments',
					'duration' => sprintf( '%u rounds', $this->level + 2 ),
				),
			),
			'Second' => array(
				'Augury' => array( 'page' => 'PH 46', 'cast' => '2 rounds' ),
				'Chant' => array( 'page' => 'PH 46', 'cast' => '1 turn',
					'aoe'     => "30' radius",
					'special' => '+1 to hit, +1 damage, +1 saving throw, -1 to hit for opponents',
					'condition' => 'this_group_only',
					'filters' => array(
						array( 'object_to_hit_opponent',      1, 10, 3 ),
						array( 'weapon_damage_bonus',         1, 10, 2 ),
						array( 'character_all_saving_throws', 1, 10, 2 ),
						array( 'opponent_to_hit_object',      1, 10, 3 ),
					),
					'target' => 'party',
				),
				'Detect Charm' => array( 'page' => 'PH 46', 'cast' => '1 round', 'reversible' => true, 'duration' => '1 turn' ),
				'Detect Life' => array( 'page' => 'UA 34', 'cast' => '1 round', 'duration' => '5 rounds' ),
				'Enthrall' => array( 'page' => 'UA 34', 'cast' => '1 round' ),
				'Find Traps' => array( 'page' => 'PH 46', 'cast' => '5 segments', 'duration' => '3 turns' ),
				'Holy Symbol' => array( 'page' => 'UA 35', 'cast' => '1 turn' ),
				'Know Alignment' => array( 'page' => 'PH 46', 'cast' => '1 round', 'duration' => '1 turn' ),
				'Resist Fire' => array( 'page' => 'PH 46', 'type' => 'Alteration', 'cast' => '5 segments',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				"Silence 15' Radius" => array( 'page' => 'PH 46', 'type' => 'Alteration', 'cast' => '5 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Slow Poison' => array( 'page' => 'PH 46', 'cast' => '1 segment',
					'duration' => sprintf( '%u hours', $this->level ),
				),
				'Snake Charm' => array( 'page' => 'PH 47', 'cast' => '5 segments' ),
				'Speak w/Animals' => array( 'page' => 'PH 47', 'type' => 'Alteration', 'cast' => '5 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Withdraw' => array( 'page' => 'UA 35', 'cast' => '2 segments',
					'duration' => sprintf( '%u segments', $this->level + 1 ),
				),
				'Wyvern Watch' => array( 'page' => 'UA 35', 'cast' => '5 segments', 'duration' => '8 hours or until strike' ),
			),
			'Third' => array(
				'Animate Dead' => array( 'page' => 'PH 47', 'cast' => '1 round' ),
				'Cloudburst' => array( 'page' => 'UA 35', 'cast' => '5 segments', 'duration' => '1 round' ),
				'Continual Light' => array( 'page' => 'PH 47', 'type' => 'Alteration', 'cast' => '6 segments', 'reversible' => true ),
				'Cure Blindness' => array( 'page' => 'PH 47', 'cast' => '1 round', 'reversible' => true ),
				'Cure Disease' => array( 'page' => 'PH 47-48', 'cast' => '1 turn' ),
				"Death's Door" => array( 'page' => 'UA 35', 'cast' => '5 segments',
					'duration' => sprintf( '%u hours', $this->level ),
				),
				'Dispel Magic' => array( 'page' => 'PH 48', 'cast' => '6 segments' ),
				'Feign Death' => array( 'page' => 'PH 48', 'cast' => '2 segments',
					'duration' => sprintf( '%3.1f turns', ( $this->level / 10 ) + 1 ),
				),
				'Flame Walk' => array( 'page' => 'UA 36', 'cast' => '5 segments',
					'duration' => sprintf( '%u turns', $this->level + 1 ),
					'special'  => sprintf( 'can effect %u man-sized beings or equivalent.', max( 1, $this->level - 5 ) ),
				),
				'Locate Object' => array( 'page' => 'PH 48', 'cast' => '1 turn', 'reversible' => true,
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Magical Vestment' => array( 'page' => 'UA 36', 'cast' => '1 round',
					'duration' => sprintf( '%u rounds', $this->level * 6 ),
				),
				'Meld into Stone' => array( 'page' => 'UA 36', 'cast' => '7 segments' ),
				'Prayer' => array( 'page' => 'PH 48', 'cast' => '6 segments',
					'duration'  => sprintf( '%u rounds', $this->level ),
					'aoe'       => "60' radius",
					'special'   => '+1 to hit, +1 damage, +1 saving throw, -1 to hit for opponents',
					'condition' => 'this_group_only',
					'filters'   => array(
						array( 'object_to_hit_opponent',      1, 10, 3 ),
						array( 'weapon_damage_bonus',         1, 10, 2 ),
						array( 'character_all_saving_throws', 1, 10, 2 ),
						array( 'opponent_to_hit_object',      1, 10, 3 ),
					),
					'target' => 'party',
				),
				'Remove Curse' => array( 'page' => 'PH4 8', 'cast' => '6 segments', 'reversible' => true ),
			),
			'Fourth' => array(
				'Abjure' => array( 'page' => 'UA 37', 'cast' => '1 round',
					'special' => sprintf( 'as if chain mail +%u.', min( 4, ceil( $this->level / 4 ) ) ),
				),
				'Cure Serious Wounds' => array( 'page' => 'PH 49', 'cast' => '7 segments', 'reversible' => true,
					'special' => sprintf( 'Heals 2d8+%u', $this->get_wisdom_saving_throw_bonus( $this->stats['wis'] ) + 1 ),
				),
				'Exorcise' => array( 'page' => 'PH 49', 'cast' => 'Special' ),
				'Imbue with Spell Ability' => array( 'page' => 'UA 38', 'cast' => '1 turn' ),
				'Lower Water' => array( 'page' => 'PH 49', 'type' => 'Alteration', 'cast' => '1 turn', 'reversible' => true,
					'duration' => sprintf( '%u turns', $this->level ),
					'aoe' => sprintf( '%u square feet', $this->level**2 * 100 ),
				),
				'Spell Immunity' => array( 'page' => 'UA 38', 'cast' => '1 round',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Tongues' => array( 'page' => 'PH 50', 'type' => 'Alteration', 'cast' => '7 segments', 'reversible' => true ),
			),
			'Fifth' => array(
				'Insect Plague' => array( 'page' => 'PH 51', 'cast' => '1 turn',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Rainbow' => array( 'page' => 'UA 39', 'cast' => '7 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Raise Dead' => array( 'page' => 'PH 51', 'cast' => '1 round' ), 'reversible' => true,
				'Spike Stones' => array( 'page' => 'UA 40', 'cast' => '6 segments',
					'duration' => sprintf( '3d4+%u turns', $this->level ),
				),
				'True Seeing' => array( 'page' => 'PH 51', 'cast' => '8 segments', 'reversible' => true,
					'duration' => sprintf( '%u rounds', $this->level ),
				),
			),
			'Sixth' => array(
				'Animate Object' => array( 'page' => 'PH 52', 'type' => 'Alteration', 'cast' => '9 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
				),
				'Forbiddance' => array( 'page' => 'UA 40', 'cast' => '6 rounds' ),
				'Part Water' => array( 'page' => 'PH 52', 'type' => 'Alteration', 'cast' => '1 turn',
					'duration' => sprintf( '%u turns', $this->level ),
				),
			),
			'Seventh' => array(
				'Astral Spell' => array( 'page' => 'PH 53', 'type' => 'Alteration', 'cast' => '3 turns' ),
				'Control Weather' => array( 'page' => 'PH 53', 'type' => 'Alteration', 'cast' => '1 turn',
					'duration' => '4d12 hours',
					'aoe'      => '4d4 square miles',
				),
			),
		);
	}

	protected function get_description_table() {
		static $table = null;
		if ( $table ) return $table;
		$table = array(
			'First' => array(
				'Bless' => 'Upon uttering the bless spell, the caster raises the Furthermore, it raises their "to hit" morale of friendly creatures by +1.  Furthermore, i t raises their "to hit" dice rolls by +1.  A blessing, however, will affect only those not already engaged in melee combat. This spell can be reversed by the cleric to a curse upon enemies which lowers morale and "to hit" by -1. The caster determines at what range (up to 6") he or she will cast the spell, and it then affects all creatures in an area 5" square centered on the point the spell was cast upon. In addition to the verbal and somatic gesture components, the bless requires holy water, while the curse requires the sprinkling of specially polluted water.',
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
			array( 3, 3, 1 ), // 5
			array( 3, 3, 2 ), // 6
			array( 3, 3, 2, 1 ),    //  7
			array( 3, 3, 3, 1 ),    //  8
			array( 4, 4, 3, 2, 1 ), //  9
			array( 4, 4, 3, 3, 2 ), // 10
			array( 5, 4, 4, 3, 2, 1 ),    // 11
			array( 6, 5, 5, 3, 2, 2 ),    // 12
			array( 6, 6, 6, 4, 2, 2 ),    // 13
			array( 6, 6, 6, 5, 3, 2 ),    // 14
			array( 7, 7, 7, 5, 4, 2 ),    // 15
			array( 7, 7, 7, 6, 5, 3, 1 ), // 16
			array( 8, 8, 8, 6, 5, 3, 1 ), // 17
			array( 8, 8, 8, 7, 6, 4, 1 ), // 18
			array( 9, 9, 9, 7, 6, 4, 2 ), // 19
			array( 9, 9, 9, 8, 7, 5, 2 ), // 20
			array( 9, 9, 9, 9, 8, 6, 2 ), // 21
			array( 9, 9, 9, 9, 9, 6, 3 ), // 22
			array( 9, 9, 9, 9, 9, 7, 3 ), // 23
			array( 9, 9, 9, 9, 9, 8, 3 ), // 24
			array( 9, 9, 9, 9, 9, 8, 4 ), // 25
			array( 9, 9, 9, 9, 9, 9, 4 ), // 26
			array( 9, 9, 9, 9, 9, 9, 5 ), // 27
			array( 9, 9, 9, 9, 9, 9, 6 ), // 28
			array( 9, 9, 9, 9, 9, 9, 7 ), // 29
		);
	}


}
