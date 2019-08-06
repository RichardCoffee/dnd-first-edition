<?php

class DND_Character_FighterThief extends DND_Character_FighterMulti {


	protected $skills = array();


	use DND_Character_Trait_Multi_Thief;


	public function __construct( $args = array() ) {
		$this->classes = array( 'fight' => 'Fighter', 'thief' => 'Thief' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
		$this->skills = $this->thief->skills;
	}

	public function set_current_weapon( $new = '' ) {
		parent::set_current_weapon( $new );
		$this->armor  = $this->thief->armor;
		$this->weapon = $this->fight->weapon;
	}


}
