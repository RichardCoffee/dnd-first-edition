<?php

class DND_Character_Druid extends DND_Character_Cleric {

	protected $ac_rows    = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
	protected $alignment  = 'Neutral';
	protected $armr_allow = array( 'Leather', 'Padded' );
	protected $hit_die    = array( 'limit' => 15, 'size' => 8, 'step' => 1 );
	protected $non_prof   = -4;
	protected $shld_allow = array( 'Wooden' );
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 12, 'dex' => 3, 'con' => 3, 'chr' => 15 );
	protected $weap_allow = array( 'Aklys', 'Club', 'Dagger', 'Dart', 'Garrot', 'Hammer', 'Hammer,Lucern', 'Lasso', 'Sap', 'Scimitar', 'Sling', 'Spear', 'Spear,Thrown', 'Spell', 'Staff,Quarter', 'Staff Sling', 'Sword,Khopesh', 'Whip' );
	protected $weap_init  = array( 'initial' => 2, 'step' => 5 );
#	protected $weapons    = array( 'Spell' => array( 'bonus' => 0, 'Skill' => 'PF' ) );
	protected $xp_bonus   = array();
	protected $xp_step    = 500000;
	protected $xp_table   = array( 0, 2000, 4000, 8000, 12000, 20000, 35000, 60000, 90000, 125000, 200000, 300000, 750000, 1500000, 3000000 );


	use DND_Character_Trait_Magic;


	protected function define_specials() {
		$this->specials = array(
			'defense_fire-lightning' => '+2 ST vs fire and lightning',
		);
	}

	protected function get_spell_table() {
		return array(
			'First' => array(
				'Animal Friendship' => array( 'page' => 'PH 55', 'type' => 'Enchantment/Charm', 'cast' => '6 turns' ),
				'Detect Magic' => array( 'page' => 'PH 55,45', 'type' => 'Divination', 'cast' => '1 segment', 'duration' => '12 rounds' ),
				'Entangle' => array( 'page' => 'PH 55', 'type' => 'Alteration', 'range' => '80 feet', 'cast' => '3 segments', 'duration' => '1 turn' ),
				'Faerie Fire' => array( 'page' => 'PH 55', 'type' => 'Alteration', 'cast' => '3 segments',
					'duration' => sprintf( '%u rounds', $this->level * 4 ),
				),
				'Invisibility to Animals' => array( 'page' => 'PH 55', 'type' => 'Alteration', 'cast' => '4 segments',
					'duration' => sprintf( '%3.1u turns', ( $this->level * 0.1 ) + 10 ),
				),
				'Locate Animals' => array( 'page' => 'PH 56', 'type' => 'Divination', 'cast' => '1 round',
					'duration' => sprintf( '%u rounds', $this->level ),
					'aoe' => sprintf( '20 foot path, %u feet long', $this->level * 20 ),
				),
				'Magic Fang' => array( 'page' => 'spec',
					'type'      => 'Alteration',
					'range'     => 'touch',
					'duration'  => sprintf( '%u rounds', $this->level ),
					'aoe'       => 'Creature touched',
					'comps'     => 'V,S,M',
					'cast'      => '3 segments',
					'saving'    => 'None',
					'special'   => '+1 to hit, +1 damage',
/*					'condition' => 'this_monster_only',             NEEDS TESTING!
					'filters'   => array(
						array( 'monster_to_hit_number', 1, 10, 3 ),
						array( 'monster_damage_bonus',  1, 10, 2 ),
					), */
				),
				'Predict Weather' => array( 'page' => 'PH 56', 'type' => 'Divination', 'cast' => '1 round',
					'duration' => sprintf( '%u hours', $this->level * 2 ),
				),
				'Pass Without Trace' => array( 'page' => 'PH 56', 'type' => 'Enchantment/Charm', 'cast' => '1 round',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Speak With Animals' => array( 'page' => 'PH 56, PH 47', 'type' => 'Alteration', 'cast' => '3 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
			),
			'Second' => array(
				'Charm Person or Mammal' => array( 'page' => 'PH 56', 'type' => 'Enchantment/Charm', 'cast' => '4 segments' ),
				'Create Water' => array( 'page' => 'PH 57', 'type' => 'Alteration', 'cast' => '1 turn',
					'aoe' => sprintf( '%u cubic feet', $this->level ),
				),
				'Obscurement' => array( 'page' => 'PH 58', 'type' => 'Alteration', 'cast' => '4 segments',
					'duration' => sprintf( '%u rounds', $this->level * 4 ),
					'aoe'      => sprintf( '%u cubic feet', $this->level * 10 ),
					'special'  => 'Reduces visibility of any sort down to 2d4 feet',
				),
				'Trip' => array( 'page' => 'PH 58', 'type' => 'Enchantment/Charm', 'cast' => '4 segments',
					'duration' => sprintf( '%u turns', $this->level ),
					'special'  => 'Creatures running take 1d6 damage, plus stunned 1d4+1 rounds / 1d4+1 segments',
				),
				'Warp Wood' => array( 'page' => 'PH 58', 'type' => 'Alteration', 'cast' => '4 segments',
					'range' => sprintf( '%u feet', $this->level * 10 ),
					'aoe'   => sprintf( '%u inch diameter', $this->level ),
				),
			),
			'Third' => array(
				'Call Lightning' => array( 'page' => 'PH 58', 'type' => 'Alteration', 'cast' => '1 turn',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Cloudburst' => array( 'page' => 'UA 43', 'type' => 'Alteration', 'cast' => '5 segments',
					'range' => sprintf( '%u feet', $this->level * 10 ),
				),
				'Magic Fang II' => array( 'page' => 'spec',
					'type'      => 'Alteration',
					'range'     => sprintf( '%u feet', ( $this->level *2.5 ) + 25 ),
					'duration'  => sprintf( '%3.1f turns', $this->level * 0.5 ),
					'aoe'       => 'One targeted creature',
					'comps'     => 'V,S,M',
					'cast'      => '5 segments',
					'saving'    => 'None',
					'special'   => sprintf( '+%1$u to hit, +%1$u damage', min( 5, floor( $this->level / 4 ) ) ),
/*					'condition' => 'this_monster_only',             NEEDS TESTING!
					'filters'   => array(
						array( 'monster_to_hit_number', min( 5, floor( $this->level / 4 ) ), 10, 3 ),
						array( 'monster_damage_bonus',  min( 5, floor( $this->level / 4 ) ), 10, 2 ),
					), */
				),
				'Plant Growth' => array( 'page' => 'PH 58-59', 'type' => 'Alteration', 'cast' => '1 round',
					'aoe' => sprintf( '%1$u x %1$u square area', $this->level * 20 ),
				),
				'Pyrotechnics' => array( 'page' => 'PH 59', 'type' => 'Alteration', 'cast' => '5 segments',
					'aoe' => sprintf( 'Fireworks: lasts %1$u segments, or Smoke: last %1$u rounds', $this->level ),
				),
				'Stone Shape' => array( 'page' => 'PH 59, PH 82', 'type' => 'Alteration', 'cast' => '1 round',
					'aoe' => sprintf( '%u cubic feet', $this->level + 3 ),
				),
				'Water Breathing' => array( 'page' => 'PH 59-60', 'type' => 'Alteration', 'cast' => '3 segments', 'reversible' => true,
					'duration' => sprintf( '%u turns', $this->level * 6 ),
				),
			),
			'Fourth' => array(
				'Animal Summoning I' => array( 'page' => 'PH 60', 'type' => 'Conjuration/Summoning', 'cast' => '6 segments',
					'range' => sprintf( '%u feet', $this->level * 40 ),
					'aoe'   => 'Druid may attempt to summon up to three times (different animal type each time).',
				),
				'Call Woodland Beings' => array( 'page' => 'PH 60', 'type' => 'Conjuration/Summoning', 'cast' => '2 turns max.',
					'special' => 'Summoned creature gets a ST versus magic at -4',
				),
				"Control Temperature, 10' radius" => array( 'page' => 'PH 60', 'type' => 'Alteration', 'cast' => '6 segments',
					'duration' => sprintf( '%u turns', $this->level + 4 ),
				),
				'Magic Fang III' => array( 'page' => 'spec',
					'type'     => 'Alteration',
					'range'    => sprintf( '%u feet', ( $this->level *2.5 ) + 25 ),
					'duration' => sprintf( '%u turns', $this->level ),
					'aoe'      => 'One targeted creature',
					'comps'    => 'V,S,M',
					'cast'     => '6 segments',
					'saving'   => 'None',
					'special'  => sprintf( '+%1$u to hit, +%1$u damage', min( 5, floor( $this->level / 5 ) ) ),
/*					'condition' => 'this_monster_only',             NEEDS TESTING!
					'filters'   => array(
						array( 'monster_to_hit_number', min( 5, floor( $this->level / 4 ) ), 10, 3 ),
						array( 'monster_damage_bonus',  min( 5, floor( $this->level / 4 ) ), 10, 2 ),
						//  May need mtdw filter as well
					), */
				),
				'Speak With Plants' => array( 'page' => 'PH 61, PH 50', 'type' => 'Alteration', 'cast' => '1 turn',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
			),
			'Fifth' => array(
				'Animal Growth' => array( 'page' => 'PH 61', 'type' => 'Alteration', 'cast' => '7 segments', 'reversible' => true,
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Control Winds' => array( 'page' => 'PH 61', 'type' => 'Alteration', 'cast' => '7 segments',
					'duration' => sprintf( '%u turns', $this->level ),
					'aoe'      => sprintf( '%u foot radius hemisphere', $this->level * 40 ),
					'special'  => sprintf( 'Increase/Decrease winds by %u miles/hour', $this->level * 3 ),
				),
				'Tranmute Rock To Mud' => array( 'page' => 'PH 62', 'type' => 'Alteration', 'cast' => '7 segments', 'reversible' => true,
					'aoe' => sprintf( '%u cubic feet', $this->level * 30 ),
				),
			),
			'Sixth' => array(
				'Transport Via Plants' => array( 'page' => 'PH 63', 'type' => 'Alteration', 'cast' => '3 segments',
					'special' => sprintf( '%u%% chance of ending up 1d100 miles from desired location', max( 0, 20 - $this->level ) ),
				),
				'Weather Summoning' => array( 'page' => 'PH 64, PH 53', 'type' => 'Conjuration/Summoning', 'cast' => '1 turn' ),
			),
			'Seventh' => array(
				'Animate Rock' => array( 'page' => 'PH 64', 'type' => 'Alteration', 'cast' => '9 segments',
					'duration' => sprintf( '%u rounds', $this->level ),
					'aoe'      => sprintf( '%u cubic feet', $this->level * 2 ),
				),
			),
		);
	}

	protected function get_description_table() {
		static $table = null;
		if ( $table ) return $table;
		$table = array(
			'First' => array(
				'Magic Fang' => 'By means of this spell, the druid is able to affect an animal that the druid has befriended.  The animal recieves a bonus of +1 to hit and +1 damage. Material component is a fang from a woodland animal.',
			),
			'Third' => array(
				'Magic Fang II' => 'This spell works identically to the first level druid spell Magic Fang, except the bonus is +1/+1 per every 4 levels of the druid, maximum of +5/+5.',
			),
			'Fourth' => array(
				'Magic Fang III' => "This spell is a more potent version of the third level druid spell Magic Fang II.  The creature's attack now counts as a magical weapon for monsters that can only be hit by magical weapons, although the bonus is +1/+1 per every five levels of the druid.",
			),
		);
		return $table;
	}

	public function special_defense_fire() {
	}

	public function special_defense_lightning() {
	}


}
