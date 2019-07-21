<?php

class DND_Character_Illusionist extends DND_Character_Character {

	protected $ac_rows    = array( 0, 1, 1, 1, 2, 2, 3, 3, 3, 4, 4, 5, 5, 5, 6, 6, 7, 7, 7, 8, 8, 9 );
	protected $hit_die    = array( 'limit' => 10, 'size' => 4, 'step' => 1 );
	protected $non_prof   = -5;
	protected $stats      = array( 'str' => 3, 'int' => 15, 'wis' => 3, 'dex' => 16, 'con' => 3, 'chr' => 3 );
	protected $weap_allow = array( 'Caltrop', 'Dagger', 'Dagger,Thrown', 'Dart', 'Knife', 'Knife,Thrown', 'Sling', 'Spell', 'Staff,Quarter' );
	protected $weap_init  = array( 'initial' => 1, 'step' => 6 );
	protected $weapons    = array( 'Spell' => 'PF' );
#	protected $xp_bonus   = array();
	protected $xp_step    = 220000;
	protected $xp_table   = array( 0, 2250, 4500, 9000, 18000, 35000, 60000, 95000, 145000, 220000 );


	use DND_Character_Trait_Magic;


	protected function define_specials() { }

	protected function get_spell_table() {
		return array(
			'First' => array(
			),
			'Second' => array(
				'Fog Cloud' => array( 'page' => 'PH 96', 'type' => 'Alteration', 'cast' => '2 segment',
					'range'    => '10 feet',
					'duration' => sprintf( '%u rounds', $this->level + 4 ),
					'aoe'      => "40' wide, 20' high, 20' deep cloud",
				),
			),
			'Third' => array(
			),
			'Fourth' => array(
			),
		);
	}

}
