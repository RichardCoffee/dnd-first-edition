<?php

abstract class DND_Monster_Lycan_Lycan extends DND_Monster_Monster {


	use DND_Monster_Trait_Defense_Weapons;


	public function __construct( $args = array() ) {
		$this->mtdw_limit  = 1;
		$this->mtdw_silver = true;
		$this->mtdw_setup();
		parent::__construct( $args );
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->mtdw_add_weapon_defense_special();
	}

	public function command_line_display() {
		$line = parent::command_line_display();
		$line.= $this->mtdw_command_line_display_string();
		return $line;
	}


}
