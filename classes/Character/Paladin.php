<?php

class DND_Character_Paladin extends DND_Character_Fighter {

	protected $hit_die   = array( 'limit' => 9, 'size' => 10, 'step' => 3 );
	protected $non_prof  = -3;
	protected $stats     = array( 'str' => 12, 'int' => 9, 'wis' => 13, 'dex' => 3, 'con' => 9, 'chr' => 17 );
	protected $weap_init = array( 'initial' => 3, 'step' => 3 );
	protected $xp_bonus   = array( 'str' => 16, 'wis' => 16 );
	protected $xp_step   = 350000;
	protected $xp_table  = array( 0, 2750, 5500, 12000, 24000, 45000, 95000, 175000, 350000 );


}
