<?php

trait DND_Character_Trait_Magic {


	protected $spell_table = array();


	public function get_spell_data( $level, $spell, $type = '' ) {
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		$data = array();
		if ( isset( $this->spell_table[ $level ][ $spell ] ) ) {
			$data = $this->spell_table[ $level ][ $spell ];
		}
		return $data;
	}

	public function get_spell_info( $spell, $type = '' ) {
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		foreach( $this->spell_table as $level => $spells ) {
			foreach( $spells as $name => $data ) {
				if ( $name === $spell ) {
					return array( 'name' => $name, 'level' => $level, 'data' => $data );
				}
			}
		}
		return false;
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
				$info = $this->get_spell_info( $name );
				if ( $info ) {
					$this->spells[ $level ][ $name ] = $info['data'];
				}
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
