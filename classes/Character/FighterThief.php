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
