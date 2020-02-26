<?php

trait DND_Character_Trait_Magic {


	protected $manna       = 0;
	protected $manna_init  = 0;
	protected $spell_table = array();
	protected $spell_zero  = 'Cantrip';


	/**  Setup functions  **/

	protected function initialize_spell_list( $book ) {
		if ( $book ) {
			foreach( $book as $level => $list ) {
				foreach( $list as $name ) {
					$this->spells[ $level ][ $name ] = $this->locate_magic_spell( $name );
				}
			}
		}
	}

	protected function reload_spells() {
		foreach( $this->spells as $level => $spells ) {
			foreach( $spells as $name => $data ) {
				$this->spells[ $level ][ $name ] = $this->locate_magic_spell( $name );
			}
		}
	}


	/**  Spell List functions  **/

	public function get_spell_list() {
		return $this->spells;
	}

	public function get_listed_spell( $name ) {
		foreach( $this->spells as $level => $spells ) {
			if ( array_key_exists( $name, $spells ) ) {
				return $spells[ $name ];
			}
		}
		return false;
	}

	public function is_listed_spell( $spell ) {
		$level = $spell->get_level();
		return ( array_key_exists( $level, $this->spells ) && array_key_exists( $spell->get_name(), $this->spells[ $level ] ) );
	}

	public function locate_magic_spell( $name, $type = '' ) {
		if ( empty( $this->spell_table ) ) $this->spell_table = $this->get_spell_table();
		if ( ( ! $type ) || ( $type === 'Single' ) ) {
			$maybe = explode( '_', get_class( $this ) );
			$type  = str_replace( 'rU', 'r U', $maybe[2] );  #  Insert space into 'MagicUser' string
		}
		foreach( $this->spell_table as $level => $spells ) {
			foreach( $spells as $key => $data ) {
				if ( $key === $name ) {
					$info = array_merge(
						$data,
						array(
							'book'   => $type,
							'caster' => $this->get_key(),
							'level'  => $level,
							'name'   => $name,
							'text'   => $this->get_spell_description( $level, $name ),
						)
					);
					return new DND_Combat_Effect( $info );
				}
			}
		}
		return false;
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
		foreach( $list as $k => $name ) {
			$spell = $this->locate_magic_spell( $name, $type );
			if ( is_object( $spell ) ) {
				$level = $spell->get_level();
				if ( ! array_key_exists( $level, $this->spells ) )          $this->spells[ $level ] = array();
				if ( ! array_key_exists( $name, $this->spells[ $level ] ) ) $this->spells[ $level ][ $name ] = $spell;
			}
		}
		$this->sort_spell_list();
	}

	protected function sort_spell_list() {
		$ord = DND_Enum_Ordinal::get_instance( array( $this->spell_zero ) );
		uksort(
			$this->spells,
			function( $a, $b ) use ( $ord ) {
				return $ord->compare( $a, $b );
			}
		);
		foreach( $this->spells as $level => $spells ) {
			uksort(
				$this->spells[ $level ],
				function( $a, $b ) {
					return strcasecmp( $a, $b );
				}
			);
		}
	}

	public function get_spell_description( $level, $name ) {
		$desc = $this->get_description_table();
		$text = '';
		if ( array_key_exists( $level, $desc ) && array_key_exists( $name, $desc[ $level ] ) ) {
			$text = $desc[ $level ][ $name ];
		}
		return $text;
	}


	/**  Manna functions  **/

	public function calculate_manna_points( $type = '' ) {
		if ( $this->level === 0 ) return; # temp fix
		if ( $this->manna_init === 0 ) {
			$table = $this->spells_usable_table();
			$level = $table[ $this->level ];
			foreach( $level as $key => $value ) {
				$this->manna_init += $value * ( $key + 1 );
			}
			if ( $type === 'cleric' ) {
				$this->manna_init += $this->get_wisdom_manna( $this->stats['wis'], $this->level );
			}
			if ( $this->manna === 0 ) $this->manna = $this->manna_init;
		}
	}

	public function spend_manna( $spell ) {
		$cost = $spell->manna_cost();
		if ( $cost > 0 ) {
			$this->manna -= $cost;
		}
	}


}
