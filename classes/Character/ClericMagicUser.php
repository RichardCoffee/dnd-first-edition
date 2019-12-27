<?php

class DND_Character_ClericMagicUser extends DND_Character_Multi {


	use DND_Character_Trait_Multi_Cleric;
	use DND_Character_Trait_Multi_MagicUser { locate_magic_spell as locate_magic_user_spell; }


	public function __construct( $args = array() ) {
		$this->classes = array( 'cleric' => 'Cleric', 'magic' => 'Magic User' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	public function set_current_weapon( $new = '' ) {
		$ret = parent::set_current_weapon( $new );
		$this->set_cleric_armor();
		return $ret;
	}

	public function get_to_hit_number( $target, $range = -1 ) {
		return $this->get_cleric_to_hit_number( $target, $range );
	}

	public function locate_magic_spell( $name, $type = '' ) {
		$spell  = array();
		$string = "Spell '$name' not found in {$this->name}'s spell book.";
		if ( empty( $type ) || ( $type === 'Cleric' ) ) {
			$spell = $this->locate_cleric_spell( $name );
		}
		if ( ! array_key_exists( 'page', $spell ) ) {
			$spell = locate_magic_user_spell( $name );
		}
		return ( array_key_exists( 'page', $spell ) ) ? $spell : $string;
	}


}
