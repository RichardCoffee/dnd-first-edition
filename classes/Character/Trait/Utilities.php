<?php

trait DND_Character_Trait_Utilities {


	protected static $utilities_replace = array();


	/** Effect functions **/

	public function this_origin_only( $effect ) {
		if ( $this->get_key() === $effect->get_caster() ) {
			return true;
		}
		return false;
	}

	public function this_target_only( $effect ) {
		if ( $this->get_key() === $effect->get_target() ) {
			return true;
		}
		return false;
		}

	public function this_group_only( $effect ) {
		$combat = dnd1e()->combat;
		$target = $effect->get_target();
		if ( $target === 'party' ) {
			if ( array_key_exists( $this->get_key(), $combat->party ) ) return true;
		}
		if ( $target === 'enemy' ) {
			if ( array_key_exists( $this->get_key(), $combat->enemy ) ) return true;
		}
		return false;
	} //*/


	/**  Filter functions  **/

	private function is_condition( $condition ) {
		if ( apply_filters( $condition, 0, $this ) ) return true;
		return false;
	}

	public function is_down() {
		if ( $this->is_immobilized() || $this->is_prone() || $this->is_stunned() ) return true;
		return false;
	}

	public function is_deaf() {
		return $this->is_condition( 'target_deaf' );
	}

	public function is_immobilized() {
		return $this->is_condition( 'target_immoblized' );
	}

	public function is_invisible() {
		return $this->is_condition( 'object_invisible' );
	}

	public function is_prone() {
		return $this->is_condition( 'target_prone' );
	}

	public function is_stunned() {
		return $this->is_condition( 'target_stunned' );
	}


	/**  Replacement functions  **/

	public function get_replacements( $unused ) {
		return static::$utilities_replace;
	}

	protected function add_replacement_filter( $filter ) {
		if ( is_string( $filter ) ) {
			if ( empty( static::$utilities_replace ) ) {
				add_filter( 'dnd1e_replacement_filters', [ $this, 'get_replacements' ] );
			}
			if ( ! in_array( $filter, static::$utilities_replace ) ) {
				static::$utilities_replace[] = $filter;
			}
		}
	}


}
