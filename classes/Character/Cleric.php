<?php

class DND_Character_Cleric extends DND_Character_Character {

	protected $ac_rows   = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
	protected $hit_die   = array( 'limit' => 9, 'size' => 8, 'step' => 2 );
	protected $non_prof  = -3;
	protected $stats     = array( 'str' => 3, 'int' => 3, 'wis' => 9, 'dex' => 3, 'con' => 3, 'chr' => 3 );
	protected $weap_init = array( 'initial' => 2, 'step' => 4 );
	protected $weapons   = array( 'Spell' => 'PF' );
	protected $xp_bonus  = array( 'wis' => 16 );
	protected $xp_step   = 225000;
	protected $xp_table  = array( 0, 1500, 3000, 6000, 13000, 27500, 55000, 110000, 225000, 450000 );


	use DND_Character_Trait_Magic;


	protected function get_spell_table() {
		return array(
		);
	}



}
