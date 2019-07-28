<?php

class DND_Character_ClericMagicUser extends DND_Character_Multi {


	protected $cleric = null;
	protected $magic  = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'cleric' => 'Cleric', 'magic' => 'Magic User' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	public function set_current_weapon( $new = '' ) {
		$this->cleric->set_current_weapon( $new );
		$this->armor  = $this->cleric->armor;
		$this->weapon = $this->cleric->weapon;
	}

	public function get_to_hit_number( $target_ac = -11, $target_at = -1, $range = -1 ) {
		$this->cleric->opponent = $this->opponent;
		return $this->cleric->get_to_hit_number( $target_ac, $target_at, $range );
	}


}
