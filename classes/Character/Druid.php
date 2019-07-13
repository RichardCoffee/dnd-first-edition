<?php

class DND_Character_Druid extends DND_Character_Cleric {

	protected $ac_rows    = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
	protected $armr_allow = array( 'Leather', 'Padded' );
	protected $hit_die    = array( 'limit' => 15, 'size' => 8, 'step' => 1 );
	protected $non_prof   = -4;
	protected $shld_allow = array( 'Wooden' );
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 12, 'dex' => 3, 'con' => 3, 'chr' => 15 );
	protected $weap_allow = array( 'Aklys', 'Club', 'Dagger', 'Dart', 'Garrot', 'Hammer', 'Hammer,Lucern', 'Lasso', 'Sap', 'Scimitar', 'Sling', 'Spear', 'Spear,Thrown', 'Spell', 'Staff,Quarter', 'Staff Sling', 'Sword,Khopesh', 'Whip' );
	protected $weap_init  = array( 'initial' => 2, 'step' => 5 );
	protected $weapons    = array( 'Spell' => 'PF' );
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
				'Animal Friendship' => array( 'page' => 'PH 55', 'cast' => '6 turns' ),
				'Detect Magic' => array( 'page' => 'PH 55,45', 'cast' => '1 segment', 'duration' => '12 rounds' ),
				'Entangle' => array( 'page' => 'PH 55', 'cast' => '3 segments', 'duration' => '1 turn' ),
				'Faerie Fire' => array( 'page' => 'PH 55', 'cast' => '3 segments',
					'duration' => sprintf( '%u rounds', $this->level * 4 ),
				),
				'Locate Animals' => array( 'page' => 'PH 56', 'cast' => '1 round',
					'duration' => sprintf( '%u rounds', $this->level ),
					'aoe' => sprintf( '20 foot path, %u feet long', $this->level * 20 ),
				),
				'Magic Fang' => array( 'page' => 'spec',
					'range'    => 'touch',
					'duration' => sprintf( '%u rounds', $this->level ),
					'aoe'      => 'Creature touched',
					'comps'    => 'V,S,M',
					'cast'     => '3 segments',
					'saving'   => 'None',
					'special'  => '+1 to hit, +1 damage',
					'desc'     => 'By means of this spell, the druid is able to affect an animal that the druid has befriended.  The animal recieves a bonus of +1 to hit and +1 damage. Material component is a fang from a woodland animal.',
				),
			),
			'Third' => array(
				'Magic Fang II' => array( 'page' => 'spec',
					'range'    => sprintf( '%u feet', ( $this->level *2.5 ) + 25 ),
					'duration' => sprintf( '%3.1f turns', $this->level * 0.5 ),
					'aoe'      => 'One targeted creature',
					'comps'    => 'V,S,M',
					'cast'     => '5 segments',
					'saving'   => 'None',
					'special'  => sprintf( '+%1$u to hit, +%1$u damage', min( 5, floor( $this->level / 4 ) ) ),
					'desc'     => 'This spell works identically to the first level druid spell Magic Fang, except the bonus is +1/+1 per every 4 levels of the druid, maximum of +5/+5.',
				),
			),
			'Fourth' => array(
				'Magic Fang III' => array( 'page' => 'spec',
					'range'    => sprintf( '%u feet', ( $this->level *2.5 ) + 25 ),
					'duration' => sprintf( '%u turns', $this->level ),
					'aoe'      => 'One targeted creature',
					'comps'    => 'V,S,M',
					'cast'     => '6 segments',
					'saving'   => 'None',
					'special'  => sprintf( '+%1$u to hit, +%1$u damage', min( 5, floor( $this->level / 5 ) ) ),
					'desc'     => "This spell is a more potent version of the third level druid spell Magic Fang II.  The creature's attack now counts as a magical weapon for monsters that can only be hit by magical weapons, although the bonus is +1/+1 per every five levels of the druid.",
				),
			),
		);
	}

	public function special_defense_fire() {
	}

	public function special_defense_lightning() {
	}


}
