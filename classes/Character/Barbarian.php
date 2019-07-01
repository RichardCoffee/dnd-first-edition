<?php

class DND_Character_Barbarian extends DND_Character_Fighter {

	protected $ac_rows   = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21 );
	protected $hit_die   = array( 'limit' => 8, 'size' => 12, 'step' => 4 );
	protected $non_prof  = -1;
	protected $stats     = array( 'str' => 15, 'int' => 3, 'wis' => 3, 'dex' => 14, 'con' => 15, 'chr' => 3 );
	protected $weap_init = array( 'initial' => 6, 'step' => 2 );
	protected $weap_reqs = array( 'Axe,Hand', 'Knife', 'Spear' );
	protected $xp_step   = 500000;
	protected $xp_table  = array( 0, 6000, 12000, 24000, 48000, 80000, 150000, 275000, 500000 );


	protected function get_armor_class_dexterity_adjustment( $dex ) {
		$bonus = parent::get_armor_class_dexterity_adjustment( $dex );
		if ( $this->stats['dex'] > 14 ) {
			$bulk  = $this->get_armor_bulk( $this->armor['armor'] );
			$step  = ( in_array( $bulk, [ 'bulky', 'fairly' ] ) ) ? -1 : -2;
			$bonus = ( $this->stats['dex'] - 14 ) * $step;
		}
		return $bonus;
	}


}
