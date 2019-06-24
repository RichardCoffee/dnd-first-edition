<?php

class DND_Character_Cleric extends DND_Character_Character {

	protected $current  = 'Spell';
	protected $hd_limit = 9;
	protected $hit_die  = 8;
	protected $hp_step  = 2;
	protected $non_prof = -3;
	protected $stats    = array( 'str' => 3, 'int' => 3, 'wis' => 9, 'dex' => 3, 'con' => 3, 'chr' => 3 );
	protected $xp_step  = 225000;
	protected $xp_table = array( 0, 1550, 2900, 6000, 13250, 27000, 55000, 110000, 220000, 450000 );
	protected $weapons  = array( 'Spell' => 'PF' );

	protected function to_hit_ac_row() {
		$base = $this->to_hit_ac_table();
		$rows = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
		$row  = $rows[ $this->level ];
		return $base[ $row ];
	}


}
