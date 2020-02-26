<?php

class DND_Character_Illusionist extends DND_Character_MagicUser {

#	protected $ac_rows    = array( 0, 1, 1, 1, 2, 2, 3, 3, 3, 4, 4, 5, 5, 5, 6, 6, 7, 7, 7, 8, 8, 9 );
	protected $hit_die    = array( 'limit' => 10, 'size' => 4, 'step' => 1 );
#	protected $non_prof   = -5;
	protected $stats      = array( 'str' => 3, 'int' => 15, 'wis' => 3, 'dex' => 16, 'con' => 3, 'chr' => 3 );
#	protected $weap_allow = array( 'Caltrop', 'Dagger', 'Dagger,Thrown', 'Dart', 'Knife', 'Knife,Thrown', 'Sling', 'Spell', 'Staff,Quarter' );
#	protected $weap_init  = array( 'initial' => 1, 'step' => 6 );
#	protected $weapons    = array( 'Spell' => 'PF' );
	protected $xp_bonus   = array();
	protected $xp_step    = 220000;
	protected $xp_table   = array( 0, 2250, 4500, 9000, 18000, 35000, 60000, 95000, 145000, 220000 );


	use DND_Character_Trait_Spells_Illusionist {
		get_illusionist_spell_table as get_spell_table;
		get_illusionist_description_table as get_description_table;
	}


	public function __construct( $args = array() ) {
		parent::__construct( $args );
	}

	protected function initialize_character() {
		parent::initialize_character();
		$this->add_replacement_filter( 'dnd1e_armor_type' ); // First level Phantom Armor spell
	}

	protected function define_specials() { }


/**  Manna functions  **/

	protected function spells_usable_table() {
		return array(
			array(),
			array( 1 ),       // 1
			array( 2 ),       // 2
			array( 2, 1 ),    // 3
			array( 3, 2 ),    // 4
			array( 4, 2, 1 ), // 5
			array( 4, 3, 1 ), // 6
			array( 4, 3, 2 ), // 7
			array( 4, 3, 2, 1 ),    //  8
			array( 5, 3, 3, 2 ),    //  9
			array( 5, 4, 3, 2, 1 ), // 10
			array( 5, 4, 3, 3, 2 ), // 11
			array( 5, 5, 4, 3, 2, 1 ),    // 12
			array( 5, 5, 4, 3, 2, 2 ),    // 13
			array( 5, 5, 4, 3, 2, 2, 1 ), // 14
			array( 5, 5, 4, 4, 2, 2, 2 ), // 15
			array( 5, 5, 5, 4, 3, 2, 2 ), // 16
			array( 5, 5, 5, 5, 3, 2, 2 ), // 17
			array( 5, 5, 5, 5, 3, 3, 2 ), // 18
			array( 5, 5, 5, 5, 4, 3, 2 ), // 19
			array( 5, 5, 5, 5, 4, 3, 2 ), // 20
			array( 5, 5, 5, 5, 5, 4, 3 ), // 21
			array( 5, 5, 5, 5, 5, 5, 4 ), // 22
			array( 5, 5, 5, 5, 5, 5, 5 ), // 23
			array( 6, 6, 6, 6, 5, 5, 5 ), // 24
			array( 6, 6, 6, 6, 6, 6, 6 ), // 25
			array( 7, 7, 7, 7, 6, 6, 6 ), // 26
		);
	}


}
