<?php

class DND_Character_FighterMagicUser extends DND_Character_FighterMulti {


	protected $magic = null;

	use DND_Character_Trait_Spells_Effects_MagicUser;


	public function __construct( $args = array() ) {
		$this->classes = array( 'fight' => 'Fighter', 'magic' => 'Magic User' );
		parent::__construct( $args );
	}

	public function locate_magic_spell( $name, $type = 'Magic User' ) {
		return parent::locate_magic_spell( $name, $type );
	}


}
