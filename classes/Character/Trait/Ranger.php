<?php

trait DND_Character_Trait_Ranger {


	public function locate_magic_spell( $name, $type = '' ) {
		$spell = null;
		if ( empty( $type ) || ( $type === 'Druid' ) ) {
			$this->spell_table = $this->get_druid_spell_table();
			$spell = $this->locate_spell( $name, 'Druid' );
		}
		if ( ! is_object( $spell ) ) {
			$this->spell_table = $this->get_spell_table();
			$spell = $this->locate_spell( $name, 'Magic User' );
		}
		return $spell;
	}


}
