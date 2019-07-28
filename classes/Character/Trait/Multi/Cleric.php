<?php

trait DND_Character_Trait_Multi_Cleric {


	protected $cleric = null;


	protected function set_cleric_weapon( $new = '' ) {
		if ( $new ) {
			$this->cleric->set_current_weapon( $new );
			$this->weapon = $this->cleric->weapon;
		}
	}

	protected function set_cleric_armor() {
		$this->armor  = $this->cleric->armor;
	}

	protected function get_cleric_to_hit_number( $target_ac = -11, $target_at = -1, $range = -1 ) {
		$this->cleric->opponent = $this->opponent;
		return $this->cleric->get_to_hit_number( $target_ac, $target_at, $range );
	}

	protected function locate_cleric_spell( $spell, $type = 'Cleric' ) {
		return parent::locate_magic_spell( $spell, $type );
	}

	public function special_string_undead( $type, $level = 0 ) {
		return $this->cleric->special_string_undead( $type, $this->level );
	}

	public function get_undead_caps( $level = 0 ) {
		return $this->cleric->get_undead_caps( $this->level );
	}


}
