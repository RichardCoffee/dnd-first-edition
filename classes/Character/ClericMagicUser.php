<?php

class DND_Character_ClericMagicUser extends DND_Character_Multi {


	protected $magic  = null;


	use DND_Character_Trait_Multi_Cleric;


	public function __construct( $args = array() ) {
		$this->classes = array( 'cleric' => 'Cleric', 'magic' => 'Magic User' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	public function set_current_weapon( $new = '' ) {
		$this->set_cleric_weapon( $new );
		$this->set_cleric_armor();
	}

	public function get_to_hit_number( $target_ac = -11, $target_at = -1, $range = -1 ) {
		return $this->get_cleric_to_hit_number( $target_ac, $target_at, $range );
	}

	public function locate_magic_spell( $name, $type = '' ) {
		$spell  = array();
		$string = "Spell '$name' not found in {$this->name}'s spell book.";
		if ( empty( $type ) || ( $type === 'Cleric' ) ) {
			$spell = $this->locate_cleric_spell( $name );
		}
		if ( ! isset( $spell['page'] ) ) {
			$spell = $this->locate_magic_spell( $name, 'Magic User' );
		}
		return ( isset( $spell['page'] ) ) ? $spell : $string;
	}


}
