<?php

abstract class DND_Character_Multi extends DND_Character_Character {


#	protected $base_xp = 0;
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
				$args['last_spell'] = $this->$key->last_spell;
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
#		$experience = 0;
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
			$spells['multi'] = array();
		}
		return $spells;
	}

	public function locate_magic_spell( $spell, $type = '' ) {
		foreach( $this->classes as $key => $class ) {
			$spell = $this->$key->locate_magic_spell( $spell, $type );
			if ( isset( $spell['page'] ) ) {
				return $spell;
			}
		}
		return "Spell '$spell' not found in {$this->name}'s spell book.";
	}


}
