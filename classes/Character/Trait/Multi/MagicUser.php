<?php

trait DND_Character_Trait_Multi_MagicUser {


	protected $magic = null;


	public function locate_magic_spell( $spell, $type = 'Magic User' ) {
		return parent::locate_magic_spell( $spell, $type );
	}

	protected function get_magic_to_hit_number( $target, $range = -1 ) {
		return $this->magic->get_to_hit_number( $target, $range );
	}


}
