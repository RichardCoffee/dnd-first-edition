<?php

class DND_Character_ClericFighter extends DND_Character_FighterMulti {


	use DND_Character_Trait_Multi_Cleric;


	public function __construct( $args = array() ) {
		$this->classes = array( 'cleric' => 'Cleric', 'fight' => 'Fighter' );
		parent::__construct( $args );
	}


	/**  Cleric Abilities **/

	public function locate_magic_spell( $name, $type = '' ) {
		return $this->locate_cleric_spell( $name );
	}


}
