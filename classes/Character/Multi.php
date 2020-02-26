<?php

abstract class DND_Character_Multi extends DND_Character_Character {


#	protected $ac_rows    = array();
#	protected $alignment  = 'Neutral';
#	protected $armor      = array();
#	protected $armr_allow = array();
#	public    $assigned   = 'Unassigned';
#	protected $base_xp    = 0;
	protected $classes    = array();
#	public    $current_hp = -100;
#	protected $experience = 0;
#	protected $hit_die    = array();
#	protected $hit_points = 0;
#	protected $horse      = '';
#	protected $initiative = array();
#	protected $level      = 0;
	protected $manna      = 0;
	protected $manna_init = 0;
#	protected $move       = array( 'max' => 12, 'foot' => 12, 'segment' => 0 );
#	protected $name       = 'Character Name';
#	protected $non_prof   = -100;
#	protected $race       = 'Human';
#	protected $segment    = 0;  # attack segment
#	protected $shield     = array();
#	protected $shld_allow = array();
#	protected $specials   = array();
#	protected $spells     = array();
#	protected $stats      = array();
#	protected $weap_allow = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual  = false;   // DND_Character_Trait_Weapons
#	protected $weap_init  = array();
#	protected $weap_reqs  = array();
#	protected $weap_twins = array(); // DND_Character_Trait_Dual
#	protected $weapon     = array(); // DND_Character_Trait_Weapons
#	protected $weapons    = array(); // DND_Character_Trait_Weapons
#	protected $xp_bonus   = array();
#	protected $xp_step    = 1000000;
#	protected $xp_table   = array();


	public function __construct( $args = array() ) {
		foreach( $this->classes as $key => $class ) {
			if ( array_key_exists( $key, $args ) ) {
				$this->$key = unserialize( $args[ $key ] );
				unset( $args[ $key ] );
			} else {
				$actual = 'DND_Character_' . str_replace( ' ', '', $class );
				if ( class_exists( $actual ) ) {
					$this->$key = new $actual( $args );
				}
				$args['last_spell'] = $this->$key->last_spell;
			}
		}
		parent::__construct( $args );
	}

	protected function initialize_character() {
		$number     = count( $this->classes );
		$initial    = '';
		$hit_points = 0;
		$level      = 0;
		$non_prof   = 0;
		$weap_init  = 0;
		$weap_step  = 0;
		foreach( $this->classes as $key => $class ) {
			if ( empty( $initial ) ) $initial = $key;
			$hit_points += $this->$key->hit_points;
			$level      += $this->$key->level;
			$non_prof   += $this->$key->non_prof;
			$weap_init  += $this->$key->weap_init['initial'];
			$weap_step  += $this->$key->weap_init['step'];
			$this->specials    = array_merge( $this->specials, $this->$key->specials );
			$this->weap_allow  = array_merge( $this->weap_allow, $this->$key->weap_allow );
			$this->manna_init += $this->$key->manna_init;
			$this->manna      += $this->$key->manna;
		}
		$this->hit_points = round( $hit_points / $number );
		if ( in_array( $this->current_hp, [ 0, -100 ] ) ) {
			$this->current_hp = $this->hit_points;
		}
		$this->level                = $level     / $number;
		$this->non_prof             = $non_prof  / $number;
		$this->weap_init['initial'] = $weap_init / $number;
		$this->weap_init['step']    = $weap_step / $number;
		if ( $this->weapon['current'] === 'none' ) $this->set_current_weapon( array_key_first( $this->weapons ) );
		$props = array( 'armor', 'movement', 'name', 'race', 'stats' );
		foreach( $props as $prop ) {
#			$this->$prop = $this->$initial->$prop;
		}
		$this->determine_initiative();
	}

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

	public function set_level( $level ) {
		$this->level = 0;
		foreach( $this->classes as $key => $class ) {
			$this->level += $this->$key->level;
		}
		$this->level = $this->level / count( $this->classes );
	}

	public function add_experience( $xp ) {
		$this->experience += $xp;
		$new = $xp / count( $this->classes );
		foreach( $this->classes as $key => $class ) {
			$this->$key->add_experience( $new );
		}
		$this->initialize_character();
		$this->current_hp = $this->hit_points;
	}


	/**  Weapon functions  **/

	public function set_current_weapon( $new = '' ) {
		$ret = parent::set_current_weapon( $new );
		if ( $ret ) {
			foreach( $this->classes as $key => $class ) {
				$this->$key->set_current_weapon( $new );
			}
		}
		return $ret;
	}


	/**  Spell functions  **/

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

	public function get_listed_spell( $name ) {
		foreach( $this->classes as $key => $class ) {
			if ( method_exists( $this->$key, 'get_listed_spell' ) ) {
				$spell = $this->$key->get_listed_spell( $name );
				if ( $spell ) return $spell;
			}
		}
		return false;
	}

	public function locate_magic_spell( $name, $type = '' ) {
		if ( $type ) {
			if ( array_key_exists( $type, $this->classes ) ) {
				$spell = $this->$type->locate_magic_spell( $name, $type );
				if ( is_object( $spell ) ) return $spell;
			}
		}
		foreach( $this->classes as $key => $class ) {
			if ( method_exists( $this->$key, 'locate_magic_spell' ) ) {
				$spell = $this->$key->locate_magic_spell( $name, $type );
				if ( is_object( $spell ) ) return $spell;
			}
		}
		return "Spell '$name' not found in {$this->name}'s spell book.";
	} //*/

	public function calculate_manna_points() {
		if ( $this->manna_init === 0 ) {
			foreach( $this->classes as $key => $class ) {
				if ( method_exists( $this->$key, 'calculate_manna_points' ) ) {
					$this->$key->calculate_manna_points();
					$this->manna_init += $this->$key->manna_init;
					$this->manna += $this->$key->manna;
				}
			}
		}
	}

	public function spend_manna( $spell ) {
		$cost = $spell->manna_cost();
		if ( $cost > 0 ) {
			$this->manna -= $cost;
			foreach( $this->classes as $key => $class ) {
				if ( $this->$key->is_listed_spell( $spell ) ) {
					$this->$key->spend_manna( $spell );
					break;
				}
			}
		}
	}


	/**  Saving Throws  **/

	public function get_saving_throws( $source = null, $extra = null ) {
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
