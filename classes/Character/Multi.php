<?php

abstract class DND_Character_Multi extends DND_Character_Character {

	protected $classes = array();


	public function __construct( $args = array() ) {
		foreach( $this->classes as $key => $class ) {
			if ( isset( $args[ $key ] ) ) {
				$this->$key = unserialize( $args[ $key ] );
				unset( $args[ $key ] );
			} else {
				$name   = str_replace( ' ', '', $class );
				$actual = 'DND_Character_' . $name;
				if ( class_exists( $actual ) ) {
					$this->$key = new $actual( $args );
				}
			}
		}
		parent::__construct( $args );
		$this->initialize_multi();
	}

	public function initialize_character() { }

	protected function define_specials() { }

	protected function initialize_multi() {
		$number     = count( $this->classes );
		$initial    = '';
		$hit_points = 0;
		$level      = 0;
		$non_prof   = 0;
		$weap_init  = 0;
		$weap_step  = 0;
		foreach( $this->classes as $key => $class ) {
			if ( empty( $initial ) ) $initial = $key;
			$this->$key->weap_dual = $this->weap_dual;
			$this->$key->initialize_character();
			$hit_points += $this->$key->hit_points;
			$level      += $this->$key->level;
			$non_prof   += $this->$key->non_prof;
			$weap_init  += $this->$key->weap_init['initial'];
			$weap_step  += $this->$key->weap_init['step'];
			$this->specials = array_merge( $this->specials, $this->$key->specials );
		}
		$this->hit_points = round( $hit_points / $number );
		if ( in_array( $this->current_hp, [ 0, -100 ] ) ) {
			$this->current_hp = $this->hit_points;
		}
		$this->level                = $level     / $number;
		$this->non_prof             = $non_prof  / $number;
		$this->weap_init['initial'] = $weap_init / $number;
		$this->weap_init['step']    = $weap_step / $number;
		$props = array( 'armor', 'movement', 'name', 'race', 'stats', 'weapon', 'weapons' );
		foreach( $props as $prop ) {
			$this->$prop = $this->$initial->$prop;
		}
		$this->determine_initiative();
	}

	public function set_level( $level ) {
		$this->level = 0;
		foreach( $this->classes as $key => $class ) {
			$this->level += $this->$key->level;
		}
		$this->level = $this->level / count( $this->classes );
	}

	public function add_experience( $xp ) {
		$cnt = count( $this->classes );
		$new = $xp / $cnt;
		foreach( $this->classes as $key => $class ) {
			$this->$key->add_experience( $new );
		}
		$this->initialize_multi();
	}

	protected function initialize_spell_list( $spells ) {
		if ( $spells ) {
			foreach( $spells as $key => $list ) {
				$this->$key->initialize_spell_list( $list );
			}
		}
	}

	public function get_spell_list() {
		$spells = array();
		foreach( $this->classes as $key => $class ) {
			$list = $this->$key->get_spell_list();
			if ( ! empty( $list ) ) {
				$spells[ $class ] = $list;
			}
		}
		if ( ! empty( $spells ) ) {
			$spells['multi'] = true;
		}
		return $spells;
	}
/*
	public function get_spell_data( $spell, $type ) {
		foreach( $this->classes as $key => $class ) {
			if ( $type === $class ) {
				$data = $this->$key->locate_spell( $spell );
				if ( $data ) return $data;
			}
		}
		return "Unable to locate a $type spell book for {$this->name}.";
	} //*/

	public function locate_spell( $spell, $type ) {
		foreach( $this->classes as $key => $class ) {
			if ( $type === $class ) {
				$data = $this->$key->locate_spell( $spell );
				if ( $data ) {
					$info = array( 'type' => $type );
					return array_merge( $info, $data );
				}
			}
		}
		return "Spell '$spell' not found in {$this->name}'s spell book.";
	}

	public function locate_magic_spell( $spell, $type ) {
		foreach( $this->classes as $key => $class ) {
			if ( $type === $class ) {
				$info = $this->$key->locate_magic_spell( $spell );
				if ( isset( $info['page'] ) ) {
					$info['caster'] = $type;
					return $info;
				}
			}
		}
		return "Spell '$spell' not found in {$this->name}'s spell book.";
	}

	public function import_kregen_csv( $file ) {
		parent::import_kregen_csv( $file );
		$this->initialize_multi();
	}

	public function set_import_task( $task = 'import' ) {
		foreach( $this->classes as $key => $class ) {
			$this->$key->set_import_task( $task );
		}
	}

	public function parse_csv_line( $line ) {
		foreach( $this->classes as $key => $class ) {
			$this->$key->parse_csv_line( $line );
		}
	}


}
