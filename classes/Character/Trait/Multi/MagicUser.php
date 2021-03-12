<?php

trait DND_Character_Trait_Multi_MagicUser {


	protected $magic = null;


	use DND_Character_Trait_Spells_Effects_MagicUser;


	protected function locate_magicuser_spell( $name ) {
		return parent::locate_magic_spell( $name, 'Magic User' );
	}

	protected function get_magic_to_hit_number( $target, $range = -1 ) {
		return $this->magic->get_to_hit_number( $target, $range );
	}


}
