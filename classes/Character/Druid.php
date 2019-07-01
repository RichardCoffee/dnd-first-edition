<?php

class DND_Character_Druid extends DND_Character_Cleric {

	protected $ac_rows   = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
	protected $hit_die   = array( 'limit' => 14, 'size' => 8, 'step' => 0 );
	protected $non_prof  = -4;
	protected $stats     = array( 'str' => 3, 'int' => 3, 'wis' => 12, 'dex' => 3, 'con' => 3, 'chr' => 15 );
	protected $weap_init = array( 'initial' => 2, 'step' => 5 );
	protected $weapons   = array( 'Spell' => 'PF' );
	protected $xp_bonus  = array();
	protected $xp_step   = 500000;
	protected $xp_table  = array( 0, 2000, 4000, 8000, 12000, 20000, 35000, 60000, 90000, 125000, 200000, 300000, 750000, 1500000, 3000000 );


	use DND_Character_Trait_Magic;


	public function __construct( $args = array() ) {
		$this->specials = array(
			'defense_fire-lightning' => '+2 ST vs fire and lightning',
		);
		parent::__construct( $args );
	}

	protected function get_spell_table() {
		return array(
			'First' => array(
				'Animal Friendship' => array( 'page' => 'PH55', 'cast' => '6 turns' ),
				'Detect Magic' => array( 'page' => 'PH55, PH45', 'cast' => '1 segment', 'duration' => '12 rounds' ),
				'Entangle' => array( 'page' => 'PH55', 'cast' => '3 segments', 'duration' => '1 turn' ),
				'Faerie Fire' => array( 'page' => 'PH55', 'cast' => '3 segments',
					'duration' => sprintf( '%u rounds', $this->level * 4 ),
				),
			),
		);
	}

	public function special_defense_fire() {
	}

	public function special_defense_lightning() {
	}


}
