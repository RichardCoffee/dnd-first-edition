<?php

class DND_Character_Druid extends DND_Character_Cleric {

	protected $ac_rows   = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
	protected $hit_die   = array( 'limit' => 14, 'size' => 8, 'step' => 0 );
	protected $non_prof  = -4;
	protected $stats     = array( 'str' => 3, 'int' => 3, 'wis' => 12, 'dex' => 3, 'con' => 3, 'chr' => 15 );
	protected $xp_step   = 500000;
	protected $xp_table  = array( 0, 2000, 4000, 8000, 12000, 20000, 35000, 60000, 90000, 125000, 200000, 300000, 750000, 1500000, 3000000 );
	protected $weap_init = array( 'initial' => 2, 'step' => 5 );


	use DND_Character_Trait_Magic;


	protected function get_spell_table() {
		return array(
			'First' => array(
				'Detect Magic' => array( 'page' => 'PH55, PH45', 'cast' => '1 segment', 'duration' => '12 rounds' ),
			),
		);
	}


}
