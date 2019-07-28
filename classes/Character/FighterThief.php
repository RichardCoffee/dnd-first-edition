<?php

class DND_Character_FighterThief extends DND_Character_FighterMulti {


	protected $skills = array();
	protected $thief  = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'fight' => 'Fighter', 'thief' => 'Thief' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
		$this->skills = $this->thief->skills;
	}

	public function set_current_weapon( $new = '' ) {
		$this->fight->set_current_weapon( $new );
		$this->thief->set_current_weapon( $new );
		$this->armor  = $this->thief->armor;
		$this->weapon = $this->fight->weapon;
	}


}
