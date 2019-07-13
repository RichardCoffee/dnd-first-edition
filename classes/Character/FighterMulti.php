<?php

class DND_Character_FighterMulti extends DND_Character_Multi {


	protected $fight = null;


	public function set_current_weapon( $new = '' ) {
		$this->fight->set_current_weapon( $new );
		$this->armor  = $this->fight->armor;
		$this->weapon = $this->fight->weapon;
	}

	public function get_to_hit_number( $target_ac = -11, $target_at = -1, $range = -1 ) {
		$this->fight->opponent = $this->opponent;
		return $this->fight->get_to_hit_number( $target_ac, $target_at, $range );
	}

	public function import_kregen_csv( $file ) {
		parent::import_kregen_csv( $file );
		$this->set_current_weapon( $this->weapon['current'] );
	}


}
