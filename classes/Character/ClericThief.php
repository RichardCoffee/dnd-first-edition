<?php

class DND_Character_ClericThief extends DND_Character_Multi {


	protected $cleric = null;
	protected $thief  = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'cleric' => 'Cleric', 'thief' => 'Thief' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	/**  Cleric Abilities **/

	public function get_spell_info( $spell, $type = 'Cleric' ) {
		return parent::get_spell_info( $spell, $type );
	}

	public function special_string_undead( $type, $level = 0 ) {
		return $this->cleric->special_string_undead( $type, $this->level );
	}

	public function get_undead_caps( $level = 0 ) {
		return $this->cleric->get_undead_caps( $this->level );
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
#echo "weapon: $new\n";
		$this->cleric->set_current_weapon( $new );
		$this->thief->set_current_weapon( $new );
		$this->armor  = $this->cleric->armor;
		$this->weapon = $this->cleric->weapon;
#print_r($this->weapon);
	}

	public function get_to_hit_number( $target_ac = -11, $target_at = -1, $range = -1 ) {
		$this->cleric->opponent = $this->opponent;
		return $this->cleric->get_to_hit_number( $target_ac, $target_at, $range );
	}

	public function import_kregen_csv( $file ) {
		parent::import_kregen_csv( $file );
		$this->set_current_weapon( $this->weapon['current'] );
	}

	public function parse_csv_line( $line ) {
		if ( $line[0] === 'AC' ) {
			$index = array_search( 'XP', $line );
			$this->cleric->parse_csv_line( [ 0 => 'AC', 4 => 'XP', 5 => $line[ ++$index ] ] );
			$this->thief->parse_csv_line(  [ 0 => 'AC', 4 => 'XP', 5 => $line[ $index + 2 ] ] );
		} else {
			if ( ( $this->import_task === 'spells' ) ) {
				$this->cleric->parse_csv_line( $line );
			} else {
				parent::parse_csv_line( $line );
			}
		}
	}


}
