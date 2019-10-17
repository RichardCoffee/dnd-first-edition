<?php

abstract class DND_Character_Multi extends DND_Character_Character {


	protected $classes = array();


	public function __construct( $args = array() ) {
		foreach( $this->classes as $key => $class ) {
			if ( array_key_exists( $key, $args ) ) {
				$this->$key = unserialize( $args[ $key ] );
				unset( $args[ $key ] );
			} else {
				$name   = str_replace( ' ', '', $class );
				$actual = 'DND_Character_' . $name;
				if ( class_exists( $actual ) ) {
					$this->$key = new $actual( $args );
				}
				$args['last_spell'] = $this->$key->last_spell;
			}
		}
		parent::__construct( $args );
		$this->initialize_multi();
	}

	public function initialize_character() { }

	public function get_class() {
		return implode( '/', $this->classes );
	}

	public function get_level() {
		$arr = array();
		foreach( $this->classes as $key => $class ) {
			$arr[] = $this->$key->get_level();
		}
		return implode( '/', $arr );
	}

	protected function define_specials() { }

	protected function initialize_multi() {
		$number     = count( $this->classes );
		$initial    = '';
#		$experience = 0;
		$hit_points = 0;
		$level      = 0;
		$non_prof   = 0;
		$weap_init  = 0;
		$weap_step  = 0;
		foreach( $this->classes as $key => $class ) {
			if ( empty( $initial ) ) $initial = $key;
#			$this->$key->weap_dual = $this->weap_dual;
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

	public function set_dual_weapons( $one, $two ) {
		foreach( $this->classes as $key => $class ) {
			if ( method_exists( $this->$key, 'set_dual_weapons' ) ) {
				$this->$key->set_dual_weapons( $one, $two );
			}
		}
		$this->weap_dual = [ $one, $two ];
	}

	public function set_current_weapon( $new = '' ) {
		parent::set_current_weapon( $new );
		foreach( $this->classes as $key => $class ) {
			$this->$key->set_current_weapon( $new );
		}
	}

	public function add_experience( $xp ) {
		$this->experience += $xp;
		$new = $xp / count( $this->classes );
		foreach( $this->classes as $key => $class ) {
			$this->$key->add_experience( $new );
		}
		$this->initialize_multi();
		$this->current_hp = $this->hit_points;
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
			if ( method_exists( $this->$key, 'get_spell_list' ) ) {
				$list = $this->$key->get_spell_list();
				if ( ! empty( $list ) ) {
					if ( $this->$key instanceOf DND_Character_Ranger ) {
						$spells = array_merge( $spells, $list ); // Only tested for Ranger/Thief combination
					} else {
						$spells[ $class ] = $list;
					}
				}
			}
		}
		$spells['multi'] = array();
		return $spells;
	}

	public function get_magic_spell_info( $level, $spell, $type = "" ) {
		if ( $type ) {
			$which = array_keys( $this->classes, $type );
			if ( $which ) {
				$key = $which[0];
				return $this->$key->get_magic_spell_info( $level, $spell, $type );
			}
		}
		foreach( $this->classes as $key => $class ) {
			if ( method_exists( $this->$key, 'get_magic_spell_info' ) ) {
				$info = $this->$key->get_magic_spell_info( $spell, $type );
				if ( array_key_exists( 'page', $info ) ) {
					return $info;
				}
			}
		}
		return "Spell '$spell' not found in {$this->name}'s spell book.";
	}

	public function locate_magic_spell( $spell, $type = '' ) {
		foreach( $this->classes as $key => $class ) {
			if ( method_exists( $this->$key, 'locate_magic_spell' ) ) {
				$data = $this->$key->locate_magic_spell( $spell, $type );
				if ( array_key_exists( 'page', $data ) ) {
					return $data;
				}
			}
		}
		return "Spell '$spell' not found in {$this->name}'s spell book.";
	}

	public function get_character_saving_throws( $source = null, $extra = null ) {
		$base = array();
		foreach( $this->classes as $key => $class ) {
			$base[ $key ] = $this->$key->get_raw_saving_throws( $this->$key->level, $source, $extra );
		}
		$mixed = array();
		foreach( $base as $key => $rolls ) {
			foreach( $rolls as $index => $roll ) {
				if ( array_key_exists( $index, $mixed ) ) {
					$mixed[ $index ]['roll'] = min( $roll['roll'], $mixed[ $index ]['roll'] );
				} else {
					$mixed[ $index ] = $roll;
				}
			}
		}
		return $this->get_keyed_saving_throws( $mixed );
	}


}
