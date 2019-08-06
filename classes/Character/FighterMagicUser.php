<?php

class DND_Character_FighterMagicUser extends DND_Character_FighterMulti {


	protected $magic = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'fight' => 'Fighter', 'magic' => 'Magic User' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	public function set_current_weapon( $new = '' ) {
		parent::set_current_weapon( $new );
		if ( $new === 'Spell' ) {
			$this->magic->set_current_weapon( $new );
			$this->weapon = $this->magic->weapon;
		}
	}

	public function locate_magic_spell( $spell, $type = 'Magic User' ) {
		return parent::locate_magic_spell( $spell, $type );
	}


}
