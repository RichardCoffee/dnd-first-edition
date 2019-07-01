<?php

class DND_Character_FighterMagicUser extends DND_Character_Multi {


	protected $fight = null;
	protected $magic = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'Fighter', 'Magic User' );
		parent::__construct( $args );
		$this->fight  = $this->multi['Fighter'];
		$this->magic  = $this->multi['MagicUser'];
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	public function import_kregen_csv( $file ) {
		parent::import_kregen_csv( $file );
		$this->armor      = $this->magic->armor;
		$this->name       = $this->fight->name;
		$this->race       = $this->fight->race;
		$this->stats      = $this->fight->stats;
		$this->weapon     = $this->fight->weapon;
		$this->weapons    = $this->magic->weapons;
		$this->weap_profs = $this->magic->weap_profs;
	}

	public function parse_csv_line( $line ) {
		if ( $line[0] === 'AC' ) {
			$this->fight->parse_csv_line( [ 0 => 'AC', 5 => $line[5] ] );
			$this->magic->parse_csv_line( [ 0 => 'AC', 5 => $line[7] ] );
		} else {
			parent::parse_csv_line( $line );
		}
	}


}
