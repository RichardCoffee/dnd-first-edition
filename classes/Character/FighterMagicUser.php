<?php

class DND_Character_FighterMagicUser extends DND_Character_FighterMulti {


	protected $magic = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'fight' => 'Fighter', 'magic' => 'Magic User' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	public function set_current_weapon( $new = '' ) {
		if ( $new === 'Spell' ) {
			$this->magic->set_current_weapon( $new );
			$this->armor  = $this->magic->armor;
			$this->weapon = $this->magic->weapon;
		} else {
			parent::set_current_weapon( $new );
		}
	}

	public function locate_magic_spell( $spell, $type = 'Magic User' ) {
		return parent::locate_magic_spell( $spell, $type );
	}

	public function parse_csv_line( $line ) {
		if ( $line[0] === 'AC' ) {
			$index = array_search( 'XP', $line );
			$this->fight->parse_csv_line( [ 0 => 'AC', 4 => 'XP', 5 => $line[ ++$index ] ] );
			$this->magic->parse_csv_line( [ 0 => 'AC', 4 => 'XP', 5 => $line[ $index + 2 ] ] );
		} else {
			parent::parse_csv_line( $line );
		}
	}


}
