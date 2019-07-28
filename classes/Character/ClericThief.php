<?php

class DND_Character_ClericThief extends DND_Character_Multi {


	protected $thief  = null;


	use DND_Character_Trait_Multi_Cleric;


	public function __construct( $args = array() ) {
		$this->classes = array( 'cleric' => 'Cleric', 'thief' => 'Thief' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	/**  Cleric Abilities  **/

	public function locate_magic_spell( $spell, $type = '' ) {
		return $this->locate_cleric_spell( $spell );
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
		$this->set_cleric_weapon( $new );
		$this->set_cleric_armor();
	}

	public function get_to_hit_number( $target_ac = -11, $target_at = -1, $range = -1 ) {
		return $this->get_cleric_to_hit_number( $target_ac, $target_at, $range );
	}


}
