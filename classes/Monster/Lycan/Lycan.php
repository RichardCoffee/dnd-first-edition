<?php

abstract class DND_Monster_Lycan_Lycan extends DND_Monster_Monster {


	protected $vulnerable = array( 'shifter' );


	use DND_Monster_Trait_Defense_Weapons;


	public function __construct( $args = array() ) {
		$this->mtdw_silver = true;
		$this->mtdw_setup();
		parent::__construct( $args );
	}

	protected function determine_specials() {
		parent::determine_specials();
	}

	public function command_line_display() {
		$line = parent::command_line_display();
		$line.= $this->mtdw_command_line_display_string();
		return $line;
	}


}
