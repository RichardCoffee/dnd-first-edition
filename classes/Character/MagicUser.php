<?php

class DND_Character_MagicUser extends DND_Character_Character {

	protected $ac_rows   = array( 0, 1, 1, 1, 2, 2, 3, 3, 3, 4, 4, 5, 5, 5, 6, 6, 7, 7, 7, 8, 8, 9 );
	protected $hit_die   = array( 'limit' => 11, 'size' => 4, 'step' => 1 );
	protected $non_prof  = -5;
	protected $stats     = array( 'str' => 3, 'int' => 9, 'wis' => 3, 'dex' => 6, 'con' => 3, 'chr' => 3 );
	protected $weap_init = array( 'initial' => 1, 'step' => 6 );
	protected $weapons   = array( 'Spell' => 'PF' );
	protected $xp_bonus  = array( 'int' => 16 );
	protected $xp_step   = 375000;
	protected $xp_table  = array( 0, 2500, 5000, 10000, 22500, 40000, 60000, 90000, 135000, 250000, 375000 );


	use DND_Character_Trait_Magic;


	protected function get_spell_table() {
		return array(
			'First' => array(
				'Armor' => array( 'page' => 'UA51', 'cast' => '1 round' ),
				'Burning Hands' => array( 'page' => 'PH65', 'cast' => '1 segment',
					'special' => sprintf( 'damage: %u hit points', $this->level ),
				),
				'Detect Magic' => array( 'page' => 'PH66,PH55,PH45', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Hold Portal' => array( 'page' => 'PH67', 'cast' => '1 segment',
					'range' => sprintf( '%u feet', $this->level * 20 ),
					'duration' => sprintf( '%u rounds', $this->level ) ,
				),
				'Identify' => array( 'page' => 'PH67', 'cast' => '1 turn',
					'duration' => sprintf( '%u segments', $this->level ),
					'special' => ( 15 + ( $this->level * 5 ) ) . '%',
				),
				'Light' => array( 'page' => 'PH68,PH45', 'cast' => '1 segment',
					'duration' => sprintf( '%u turns', $this->level ),
				),
				'Magic Missile' => array( 'page' => 'PH68', 'cast' => '1 segment',
					'range' => sprintf( '%u feet', ( $this->level * 10 ) + 60 ),
					'special' => sprintf( '%1$ud4+%1$u', intval( ( $this->level + 1 ) / 2 ) )
				),
				'Protection from Evil' => array( 'page' => 'PH68,PH44', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
				),
				'Read Magic' => array( 'page' => 'PH69', 'cast' => '1 round' ),
				'Spider Climb' => array( 'page' => 'PH69', 'cast' => '1 segment',
					'duration' => sprintf( '%u rounds', $this->level + 1 ),
				),
			),
			'Second' => array(
				'Mirror Image' => array( 'page' => 'PH72', 'cast' => '2 segments',
					'duration' => sprintf( '%u rounds', $this->level * 2 ),
					'special' => sprintf( '01-%u: 1, %u-%u: 2, %u-%u: 3, %u-00: 4', 25 - $this->level, 26 - $this->level, 50 - $this->level, 51 - $this->level, 75 - $this->level, 76 - $this->level ),
				),
				'Preserve' => array( 'page' => 'UA54', 'cast' => '2 rounds' ),
			),
		);
	}

}
