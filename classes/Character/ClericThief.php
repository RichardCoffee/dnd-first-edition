<?php

class DND_Character_ClericThief extends DND_Character_Multi {


	use DND_Character_Trait_Multi_Cleric{ locate_cleric_spell as public locate_magic_spell; }
	use DND_Character_Trait_Multi_Thief;


	public function __construct( $args = array() ) {
		$this->classes = array( 'cleric' => 'Cleric', 'thief' => 'Thief' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
		$this->set_cleric_armor();
	}

	public function get_to_hit_number( $target, $range = -1 ) {
		if ( in_array( $this->weapon['current'], $this->thief->weap_allow ) && ( ! in_array( $this->weapon['current'], $this->cleric->weap_allow ) ) ) {
			return $this->get_thief_to_hit_number( $target, $range );
		} else {
			return $this->get_cleric_to_hit_number( $target, $range );
		}
	}


}
