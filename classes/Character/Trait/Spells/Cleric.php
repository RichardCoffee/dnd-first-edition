<?php
/*

'Anti-Vermin Barrier' - protects against vermin, of any size
'Assess Health' - A combination of divination and necromantic magic, the advanced magic revealed a combination of detections about the body, such as whether one was diseased, carried parasites, the age of the person, their overall fitness, endurance, revealing any impairments due to past injury, and in Mindal's case, her capacity to become pregnant.
'Bed of Rest' - improves bedding. lasts 12 hours or until released via command word
'Blanket of Comfort' - warms blankets and sheets
'Break Camp' - packs the camping gear up
'Calm Chaos' - used to calm a distraught individual
'Circle of Judgment' - While inside the circle, the castor cannot cast offensive magic, but on the other hand, no one mortal and even lesser planar beings cannot cross the barrier. It will even block a lot of magical energies as well.
'Circle of Privacy' - reduces noise, prevents eavesdropping
'Command Oration' - when the caster speaks, everybody hears it!
"Crimley's Repair Leather" - repair a leather item
'Cure Moderate Wounds' - more han CLW, less than CSW
'Detect Pregnancy' - is she pregnant?
'Disinfect' - cleanse an area
'Divine Age'
'Dream Path' - guides a person's dreams to help them make decisions
'Ease Pain'(O) - use for headaches and other mild pains
'Easy March' - allows person to march longer between breaks
'Fertility' - need to ask?
'Gathering The Sheaves' - will gather together all the particulate parts of a dead body.
'Heavenly Chains of Binding' - used to contain a spirit
'Holy Scribe' - will record whatever the caster hears and sees. The enchanted scribe can record feelings and images with the observations.
'Know Injury' - tells the caster what wounds a person has
'Lay of the Land' - reveals the nature of the land,for good or ill
'Lighten Load' - reduce weight
'Make Camp' - it won't light the fire for you, nor gather wood
'Oration' - a lesser version of Command Oration
'Prevent Pregnancy' - no babies here
'Prime the Bull' (Necromantic) - what do -you- think it does?
'Repair Phenomic Form' - this is a serious spell and should be used with care
'Rest Eternal' - as RIP, and prevents return as undead
'Rest in Peace' - reduces body to dust
'Restful Sleep' - puts a person to sleep for 8 hours
'Reveal the Past' - replay past events

*/

trait DND_Character_Trait_Spells_Cleric {


	protected function get_cleric_spell_table() {
		return array(
			'Orison' => array(
				'Ease Pain' => array(
					'kind' => 'Person-Affecting',
				),
			),
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
						array( 'dnd1e_armor_class_adj', -1, 10, 3 ),
#						array( 'object_morale_check',    5, 10, 3 ), # FIXME: adj applies to other group, while check applies to caster's group
					),
					'target' => 'other',
				),
				'Ceremony' => array( 'page' => 'UA 32', 'cast' => '1 hour' ),
				'Combine' => array( 'page' => 'UA 32',
					'duration'  => '3 turns',
					'cast'      => '1 round',
					'condition' => 'this_group_only',
					'filters'   => array(
						array( 'opponent_to_hit_group', -4, 10, 2 ),
#						array( 'group_ac_dex_bonus',     0, 10, 2 ), # replacement filter
#						array( 'dnd1e_cleric_level_bonus', max( 4, count( $group ) ), 10, 2 ),
					),
					'target'    => 'origin'
				),
				'Command' => array(
					'page'     => 'PH 44',
					'type'     => 'Enchantment/Charm',
					'range'    => '10 feet',
					'duration' => '1 round',
					'aoe'      => 'One creature',
					'comps'    => 'V',
					'cast'     => '1 segment',
					'saving'   => 'Int>12 or HD>5',
					'target'   => 'required',
				),
				'Create Water' => array( 'page' => 'PH 44', 'type' => 'Alteration', 'cast' => '1 round', 'reversible' => true,
					'aoe' => sprintf( '%u gallons', $this->level * 4 ),
				),
				'Cure Light Wounds' => array(
					'page'       => 'PH 44',
					'type'       => 'Necromantic',
					'reversible' =>  true,
					'range'      => 'Touch',
					'duration'   => 'Permanent',
					'aoe'        => 'Creature touched',
					'comps'      => 'V,S',
					'cast'       => '5 segments',
					'saving'     => 'None',
					'special'    =>  sprintf( 'Heals 1d8+%u', $this->get_wisdom_saving_throw_bonus( $this->stats['wis'] ) ) . $this->reroll_healing_string(),
					'apply'      => 'cleric_first_cure_light_wounds',
					'check'      => 'cure_wounds_check_target',
					'prior'      =>  array( 'dnd1e_combat_init', 'cure_wounds_notice', 10, 1 ),
					'target'     => 'required',
				),
				'Detect Evil' => array( 'page' => 'PH 45', 'cast' => '1 round',
					'duration' => sprintf( '%3.1f turns', ( $this->level * 0.5 ) + 1 ),
				),
				'Detect Magic (C)' => array(
					'page'     => 'PH 45',
					'type'     => 'Divination',
					'range'    => '30 feet',
					'duration' => '1 turn',
					'aoe'      => '10 foot path, 30 feet long',
					'comps'    => 'V,S,M',
					'cast'     => '1 round',
					'saving'   => 'None',
				),
				'Endure Cold/Heat' => array( 'page' => 'UA 33', 'cast' => '1 round',
					'duration' => sprintf( '%u turns', $this->level * 9 ),
				),
				'Invisibility to Undead' => array(
					'page'      => 'UA 33',
					'type'      => 'Illusion/Phantasm',
					'range'     => 'Touch',
					'duration'  => '6 rounds',
					'aoe'       => 'Creature touched',
					'comps'     => 'V,S,M',
					'cast'      => '4 segments',
					'saving'    => 'Negates',
					'special'   => 'No attacks or spells, or this spell ends.',
#					'apply'     => 'cleric_first_invisibility_to_undead',
#					'condition' => 'this_group_only',
					'effect'    => 'undead',
#					'filters'   => array(
#						array( FIXME: no attacks against this character
#					),
					'target' => 'other',
				),
				'Light' => array( 'page' => 'PH 45', 'type' => 'Alteration', 'cast' => '4 segments',
					'duration' => sprintf( '%u turns', $this->level + 6 ),
				),
				'Magic Stone' => array( 'page' => 'UA 33', 'cast' => '1 round', 'duration' => '6 rounds or until used',
					'special' => sprintf( 'can enchant %u stones', ceil( $this->level / 5 ) ),
				),
				'Penetrate Disguise' => array( 'page' => 'UA 33', 'cast' => '2 rounds', 'duration' => '1 round' ),
				'Protection from Evil' => array(
					'page'       => 'PH 45',
					'type'       => 'Abjuration',
					'reversible' => true,
					'range'      => 'Touch',
					'duration'   => sprintf( '%u rounds', $this->level * 3 ),
					'aoe'        => 'Creature touched',
					'comps'      => 'V,S,M',
					'cast'       => '4 segments',
					'saving'     => 'None',
					'condition'  => 'this_origin_only',
					'filters'    => array(
						array( 'dnd1e_object_to_hit_opponent',    2, 10, 3 ),
						array( 'dnd1e_secondary_to_hit_opponent', 2, 10, 3 ),
						array( 'character_all_saving_throws',     2, 10, 2 ),
						array( 'dnd1e_to_hit_object',             2, 10, 3 ),
					),
				),
				'Purify Food & Drink' => array(
					'page'       => 'PH 45',
					'type'       => 'Alteration',
					'reversible' => true,
					'range'      => '30 feet',
					'duration'   => 'Permanent',
					'aoe'        => sprintf( '%u cubic feet, 10 foot square area', $this->level ),
					'comps'      => 'V,S',
					'cast'       => '1 round',
					'saving'     => 'None',
				),
				'Resist Cold' => array( 'page' => 'PH 45', 'type' => 'Alteration', 'cast' => '1 round',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Sanctuary' => array(
					'page'     => 'PH 45',
					'type'     => 'Abjuration',
					'range'    => 'Touch',
					'duration' => sprintf( '%u rounds', $this->level + 2 ),
					'aoe'      => 'One creature',
					'comps'    => 'V,S,M',
					'cast'     => '4 segments',
					'saving'   => 'None',
				),
			),
			'Second' => array(
				'Augury' => array( 'page' => 'PH 46', 'cast' => '2 rounds' ),
				'Chant' => array( 'page' => 'PH 46', 'cast' => '1 turn',
					'aoe'     => "30' radius",
					'special' => '+1 to hit, +1 damage, +1 saving throw, -1 to hit for opponents',
					'condition' => 'this_group_only',
					'filters' => array(
						array( 'dnd1e_object_to_hit_opponent',    1, 10, 3 ),
						array( 'dnd1e_secondary_to_hit_opponent', 2, 10, 3 ),
						array( 'dnd1e_weapon_damage_bonus',       1, 10, 2 ),
						array( 'dnd1e_secondary_damage_bonus',    1, 10, 2 ),
						array( 'character_all_saving_throws',     1, 10, 2 ),
						array( 'dnd1e_to_hit_object',             1, 10, 3 ),
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
						array( 'dnd1e_object_to_hit_opponent',    1, 10, 3 ),
						array( 'dnd1e_secondary_to_hit_opponent', 2, 10, 3 ),
						array( 'dnd1e_weapon_damage_bonus',       1, 10, 2 ),
						array( 'dnd1e_secondary_damage_bonus',    1, 10, 2 ),
						array( 'character_all_saving_throws',     1, 10, 2 ),
						array( 'dnd1e_to_hit_object',             1, 10, 3 ),
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

	protected function get_cleric_description_table() {
		static $table = null;
		if ( $table ) return $table;
		$table = array(
			'First' => array(
				'Bless' => 'Upon uttering the bless spell, the caster raises the Furthermore, it raises their "to hit" morale of friendly creatures by +1.  Furthermore, i t raises their "to hit" dice rolls by +1.  A blessing, however, will affect only those not already engaged in melee combat. This spell can be reversed by the cleric to a curse upon enemies which lowers morale and "to hit" by -1. The caster determines at what range (up to 6") he or she will cast the spell, and it then affects all creatures in an area 5" square centered on the point the spell was cast upon. In addition to the verbal and somatic gesture components, the bless requires holy water, while the curse requires the sprinkling of specially polluted water.',
			),
		);
		return $table;
	}


}