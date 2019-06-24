<?php

class DND_Character_Cleric extends DND_Character_Character {

	protected $current = 'Spell';
	protected $non_proficiency = -3;
	protected $weapons = array( 'Spell' );

	protected function to_hit_ac_row() {
		$base = $this->to_hit_ac_table();
		$rows = array( 0, 1, 1, 2, 3, 3, 4, 5, 5, 6, 7, 7, 8, 9, 9, 10, 11, 11, 11, 12 );
		$row  = $rows[ $this->level ];
		return $base[ $row ];
	}


}
