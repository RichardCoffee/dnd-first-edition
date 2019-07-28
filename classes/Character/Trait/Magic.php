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

	public function get_magic_spell_info( $level, $spell, $type = '' ) {
		return array_merge( [ 'name' => $spell, 'level' => $level ], $this->get_spell_data( $level, $spell ) );
	}

	public function locate_magic_spell( $spell, $type = '' ) {
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		$info = array();
		if ( ( ! $type ) || ( $type === 'Single' ) ) {
			$maybe = explode( '_', get_class( $this ) );
			$type  = str_replace( 'rU', 'r U', $maybe[2] );
		}
		foreach( $this->spell_table as $level => $spells ) {
			foreach( $spells as $name => $data ) {
				if ( $name === $spell ) {
					$info = array_merge( [ 'caster' => $type ], $this->get_magic_spell_info( $level, $spell ) );
				}
			}
		}
		return $info;
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

	protected function import_spell_list( $list, $type = '' ) {
		$last = '';
		foreach( $list as $k => $name ) {
			if ( $this->last_spell ) {
				if ( $this->last_spell === $name ) {
					$this->last_spell = '';
				}
				continue;
			}
			$spell = $this->locate_magic_spell( $name );
			if ( isset( $spell['page'] ) ) {
				$this->spells[ $spell['level'] ][ $name ] = $this->get_spell_data( $spell['level'], $name );
				$last = $name;
			} else {
				$this->last_spell = $last;
				return;
			}
		}
	}

	public function get_spell_description( $level, $name ) {
		$table = $this->get_description_table();
		if ( isset( $table[ $level ][ $name ] ) ) {
			return $table[ $level ][ $name ];
		}
		return '';
	}


}
