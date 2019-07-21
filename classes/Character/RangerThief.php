<?php

class DND_Character_RangerThief extends DND_Character_FighterMulti {


	protected $skills = array();
	protected $thief  = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'fight' => 'Ranger', 'thief' => 'Thief' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
		$this->skills = $this->thief->skills;
	}

	/**  Ranger Abilities **/

	public function special_integer_giant() {
		return $this->fight->special_integer_giant();
	}

	public function special_array_giant() {
		return $this->fight->special_array_giant();
	}

	public function special_attack_giant( $race, $type = 'bool' ) {
		return $this->fight->special_attack_giant( $race, $type );
	}

	public function get_weapon_damage_bonus( $range = -1 ) {
		return $this->fight->get_weapon_damage_bonus( $range );
	}

	public function special_integer_track() {
		return $this->fight->special_integer_track();
	}

	public function special_string_surprise() {
		return $this->fight->special_string_surprise();
	}

	public function locate_spell( $spell ) {
		return $this->fight->locate_spell( $spell );
	}

	public function locate_magic_spell( $spell ) {
		return $this->fight->locate_magic_spell( $spell );
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
		$this->fight->set_current_weapon( $new );
		$this->thief->set_current_weapon( $new );
		$this->armor  = $this->thief->armor;
		$this->weapon = $this->fight->weapon;
	}

	/**  Import Functions  **/

	public function parse_csv_line( $line ) {
		if ( $line[0] === 'AC' ) {
			$index = array_search( 'XP', $line );
			$this->fight->parse_csv_line( [ 0 => 'AC', 4 => 'XP', 5 => $line[ ++$index ] ] );
			$this->thief->parse_csv_line( [ 0 => 'AC', 4 => 'XP', 5 => $line[ $index + 2 ] ] );
		} else {
			parent::parse_csv_line( $line );
		}
	}


}
