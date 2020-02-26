<?php

class DND_Character_Cleric extends DND_Character_Character {

	protected $ac_rows    = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
	protected $hit_die    = array( 'limit' => 9, 'size' => 8, 'step' => 2 );
	protected $non_prof   = -3;
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 9, 'dex' => 3, 'con' => 3, 'chr' => 3 );
	protected $weap_allow = array( 'Club', 'Flail', 'Hammer', 'Hammer,Lucern', 'Mace', 'Spell', 'Staff,Quarter', 'Turn Undead' );
	protected $weap_init  = array( 'initial' => 2, 'step' => 4 );
	protected $weapons    = array( 'Spell' => array( 'bonus' => 0, 'skill' => 'PF' ) );
	protected $xp_bonus   = array( 'wis' => 16 );
	protected $xp_step    = 225000;
	protected $xp_table   = array( 0, 1500, 3000, 6000, 13000, 27500, 55000, 110000, 225000 );


	use DND_Character_Trait_Magic;
	use DND_Character_Trait_Spells_Cleric {
		get_cleric_spell_table as get_spell_table;
		get_cleric_description_table as get_description_table;
	}
	use DND_Character_Trait_Spells_Effects_Cleric;
	use DND_Character_Trait_Undead;


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		if ( array_key_exists( 'spell_import', $args ) ) {
			$this->import_spell_list( $args['spell_import'] );
		}
		$this->spell_zero = 'Orison';
	}

	protected function initialize_character() {
		parent::initialize_character();
		$this->calculate_manna_points( 'cleric' );
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
