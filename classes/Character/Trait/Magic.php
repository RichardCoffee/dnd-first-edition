<?php

trait DND_Character_Trait_Magic {


	private $spell_table = array();


	public function get_spell_data( $level, $spell, $type = '' ) {
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		$data = array();
		if ( isset( $this->spell_table[ $level ][ $spell ] ) ) {
			$data = $this->spell_table[ $level ][ $spell ];
		}
		return $data;
	}

	// DEPRECATED - phase this out
	public function get_spell_info( $level, $spell, $type = '' ) {
		return array( 'name' => $spell, 'level' => $level, 'data' => $this->get_spell_data( $level, $spell ) );
	}

	public function get_magic_spell_info( $level, $spell, $type = '' ) {
		$data = $this->get_spell_data( $level, $spell );
		return array_merge( [ 'name' => $spell, 'level' => $level ], $data );
	}

	// DEPRECATED - phase this out
	public function locate_spell( $spell, $type = '' ) {
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		foreach( $this->spell_table as $level => $spells ) {
			foreach( $spells as $name => $data ) {
				if ( $name === $spell ) {
					return $this->get_spell_info( $level, $spell );
				}
			}
		}
	}

	public function locate_magic_spell( $spell, $type = '' ) {
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		foreach( $this->spell_table as $level => $spells ) {
			foreach( $spells as $name => $data ) {
				if ( $name === $spell ) {
					return $this->get_magic_spell_info( $level, $spell );
				}
			}
		}
	}

	protected function add_spell( $data ) {
		if ( ! isset( $this->spells[ $data['level'] ][ $data['name'] ] ) ) {
			$this->spells[ $data['level'] ][ $data['name'] ] = $data['data'];
		}
	}

	protected function reload_spells() {
		$this->spell_table = $this->get_spell_table();
		foreach( $this->spells as $level => $spells ) {
			foreach( $spells as $name => $data ) {
				$this->spells[ $level ][ $name ] = $this->get_spell_data( $level, $name );
			}
		}
	}

	public function generate_random_spell( $level ) {
		$spell = '';
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		if ( isset( $this->spell_table[ $level ] ) ) {
			$limit = count( $this->spell_table[ $level ] );
			$index = mt_rand( 1, $limit );
			$keys  = array_keys( $this->spell_table[ $level ] );
			$spell = $keys[ $index -1 ];
		}
		return $spell;
	}

	protected function set_kregen_weapon_skill( $weapon, $line, $bonus ) {
		if ( $weapon === 'Spell' ) {
			$this->weapons[ $weapon ] = array( 'bonus' => 0, 'skill' => 'PF' );
		} else {
			parent::set_kregen_weapon_skill( $weapon, $line, $bonus );
		}
	}


}
