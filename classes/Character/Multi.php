<?php

abstract class DND_Character_Multi extends DND_Character_Character {

	protected $classes = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		if ( ( ! empty( $this->classes ) ) && ( count( $this->classes ) > 1 ) ) {
			foreach( $this->classes as $key => $class ) {
				$name   = str_replace( ' ', '', $class );
				$actual = 'DND_Character_' . $name;
				if ( class_exists( $actual ) ) {
					$data = ( isset( $args[ $name ] ) ) ? $args[ $name ] : array();
					$this->$key = new $actual( $data );
				}
			}
			$this->initialize_multi();
		}
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
			$hit_points += $this->$key->hit_points['base'];
			$level      += $this->$key->level;
			$non_prof   += $this->$key->non_prof;
			$weap_init  += $this->$key->weap_init['initial'];
			$weap_step  += $this->$key->weap_init['step'];
			$this->specials = array_merge( $this->specials, $this->$key->specials );
		}
		$this->hit_points['base']   = round( $hit_points / $number );
		if ( in_array( $this->hit_points['current'], [ 0, -100 ] ) ) {
			$this->hit_points['current'] = $this->hit_points['base'];
		}
		$this->level                = $level     / $number;
		$this->non_prof             = $non_prof  / $number;
		$this->weap_init['initial'] = $weap_init / $number;
		$this->weap_init['step']    = $weap_step / $number;
#		$this->set_level(0);
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
