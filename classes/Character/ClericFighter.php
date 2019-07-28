<?php

class DND_Character_ClericFighter extends DND_Character_FighterMulti {


	protected $cleric = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'cleric' => 'Cleric', 'fight' => 'Fighter' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	/**  Cleric Abilities **/

	public function locate_magic_spell( $spell, $type = 'Cleric' ) {
		return parent::locate_magic_spell( $spell, $type );
	}

	public function special_string_undead( $type, $level = 0 ) {
		return $this->cleric->special_string_undead( $type, $this->level );
	}

	public function get_undead_caps( $level = 0 ) {
		return $this->cleric->get_undead_caps( $this->level );
	}


}
