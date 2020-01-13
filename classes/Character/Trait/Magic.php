<?php

trait DND_Character_Trait_Magic {


	protected $last_spell  = '';
	private   $spell_table = array();
	private   $spell_desc  = array();


	public function get_spell_list() {
		return $this->spells;
	}

	protected function initialize_spell_list( $book ) {
		if ( $book ) {
			foreach( $book as $level => $list ) {
				foreach( $list as $spell ) {
					$this->spells[ $level ][ $spell ] = $this->get_spell_data( $level, $spell );
				}
			}
		}
	}

	public function get_spell_data( $level, $spell, $type = '' ) {
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		$data = array();
		if ( isset( $this->spell_table[ $level ][ $spell ] ) ) {
			$data = $this->spell_table[ $level ][ $spell ];
			$text = $this->get_spell_description( $level, $spell );
			if ( $text ) $data['text'] = $text;
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
			$type  = str_replace( 'rU', 'r U', $maybe[2] );  #  Insert space into 'MagicUser' string
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
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		$name = '';
		if ( is_integer( $level ) ) $level = DND_Enum_Ordinal::instance()->get( $level );
		if ( array_key_exists( $level, $this->spell_table ) ) {
			$limit = count( $this->spell_table[ $level ] );
			$index = mt_rand( 1, $limit );
			$keys  = array_keys( $this->spell_table[ $level ] );
			$name  = $keys[ $index - 1 ];
		}
		return $name;
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
			if ( array_key_exists( 'page', $spell ) ) {
				$this->spells[ $spell['level'] ][ $name ] = $this->get_spell_data( $spell['level'], $name );
				$last = $name;
			} else {
				$this->last_spell = $last;
				return;
			}
		}
	}

	public function get_spell_description( $level, $name ) {
		if ( empty( $this->spell_desc ) ) $this->spell_desc = $this->get_description_table();
		$text = '';
		if ( array_key_exists( $level, $this->spell_desc ) && array_key_exists( $name, $this->spell_desc[ $level ] ) ) {
			$text = $this->spell_desc[ $level ][ $name ];
		}
		return $text;
	}


}
