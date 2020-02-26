<?php

class DND_Character_FighterMulti extends DND_Character_Multi {


	protected $fight = null;


	use DND_Character_Trait_Dual;


	public function set_current_weapon( $new = '' ) {
		parent::set_current_weapon( $new );
		$ret = $this->fight->set_current_weapon( $new );
		$this->armor  = $this->fight->armor;
		$this->weapon = $this->fight->weapon;
		return $ret;
	}

	public function get_to_hit_number( $target, $range = -1 ) {
		$this->fight->set_dual_flag( $this->get_dual_flag() );
		return $this->fight->get_to_hit_number( $target, $range );
	}


}
