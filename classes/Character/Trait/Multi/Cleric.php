<?php

trait DND_Character_Trait_Multi_Cleric {


	protected $cleric = null;


	use DND_Character_Trait_Spells_Cleric;
	use DND_Character_Trait_Spells_Effects_Cleric;
#	use DND_Character_Trait_Undead;


	protected function set_cleric_armor() {
		$this->armor = $this->cleric->armor;
	}

	protected function get_cleric_to_hit_number( $target, $range = -1 ) {
		return $this->cleric->get_to_hit_number( $target, $range );
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
