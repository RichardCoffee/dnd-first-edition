<?php

trait DND_Character_Trait_Multi_Ranger {


	public function special_integer_giant() {
		return $this->fight->special_integer_giant();
	}

	public function special_array_giant() {
		return $this->fight->special_array_giant();
	}

	public function special_attack_giant( $race, $type = 'bool' ) {
		return $this->fight->special_attack_giant( $race, $type );
	}

/*	public function get_weapon_damage_bonus( $target = null, $range = -1 ) {
		return $this->fight->get_weapon_damage_bonus( $target, $range );
	} //*/

	public function special_integer_track() {
		return $this->fight->special_integer_track();
	}

	public function special_string_surprise() {
		return $this->fight->special_string_surprise();
	}

	public function locate_magic_spell( $name, $type = '' ) {
		return $this->fight->locate_magic_spell( $name, $type );
	}


}
