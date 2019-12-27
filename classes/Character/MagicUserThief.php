<?php

class DND_Character_MagicUserThief extends DND_Character_Multi {


	use DND_Character_Trait_Multi_MagicUser;
	use DND_Character_Trait_Multi_Thief;


	public function __construct( $args = array() ) {
		$this->classes = array( 'magic' => 'Magic User', 'thief' => 'Thief' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	public function get_to_hit_number( $target, $range = -1 ) {
		if ( in_array( $this->weapon['current'], $this->thief->weap_allow ) ) {
			return $this->get_thief_to_hit_number( $target, $range );
		} else {
			return $this->get_magic_to_hit_number( $target, $range );
		}
	}


}
