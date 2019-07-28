<?php

class DND_Character_MagicUserThief extends DND_Character_Multi {


	protected $magic = null;
	protected $thief = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'magic' => 'Magic User', 'thief' => 'Thief' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	/**  Magic User Abilities **/

	public function locate_magic_spell( $spell, $type = 'Magic User' ) {
		return parent::locate_magic_spell( $spell, $type );
	}

	/**  Thief Abilities  **/

	public function get_thief_skills_list() {
		return $this->thief->get_thief_skills_list();
	}

	public function get_thief_skill( $skill ) {
		return $this->thief->get_thief_skill( $skill );
	}

	public function special_integer_backstab() {
		return $this->thief->special_integer_backstab();
	}

	/**  Character Functions  **/

	public function set_current_weapon( $new = '' ) {
		$this->magic->set_current_weapon( $new );
		$this->thief->set_current_weapon( $new );
		$this->armor  = $this->thief->armor;
		$this->weapon = $this->thief->weapon;
	}

	public function get_to_hit_number( $target_ac = -11, $target_at = -1, $range = -1 ) {
		$this->thief->opponent = $this->opponent;
		return $this->thief->get_to_hit_number( $target_ac, $target_at, $range );
	}


}
