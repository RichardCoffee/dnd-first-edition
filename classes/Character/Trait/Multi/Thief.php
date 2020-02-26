<?php

trait DND_Character_Trait_Multi_Thief {


	protected $thief = null;


	public function get_thief_skills_list() {
		return $this->thief->get_thief_skills_list();
	}

	public function get_thief_skill( $skill ) {
		return $this->thief->get_thief_skill( $skill );
	}

	public function special_integer_backstab() {
		return $this->thief->special_integer_backstab();
	}

	protected function get_thief_to_hit_number( $target, $range = -1 ) {
		return $this->thief->get_to_hit_number( $target, $range );
	}

	public function set_current_weapon( $new = '' ) {
		$ret = parent::set_current_weapon( $new );
		$this->armor = $this->thief->armor;
		return $ret;
	}


}
