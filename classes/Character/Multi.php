<?php

abstract class DND_Character_Multi extends DND_Character_Character {

	protected $classes   = array();
	protected $multi     = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		if ( ( ! empty( $this->classes ) ) && ( count( $this->classes ) > 1 ) ) {
			foreach( $this->classes as $class ) {
				$name   = str_replace( ' ', '', $class );
				$actual = 'DND_Character_' . $name;
				if ( class_exists( $actual ) ) {
					$this->multi[ $name ] = new $actual( $args );
				}
			}
			$this->initialize_multi();
		}
	}

	public function initialize_character() { }

	protected function initialize_multi() {
		$number     = count( $this->multi );
		$hit_points = 0;
		$non_prof   = 0;
		$weap_init  = 0;
		$weap_step  = 0;
		foreach( $this->multi as $class => $object ) {
			$object->initialize_character();
			$hit_points += $object->hit_points['base'];
			$non_prof   += $object->non_prof;
			$weap_init  += $object->weap_init['initial'];
			$weap_step  += $object->weap_init['step'];
			$this->stats = array_merge( $this->stats, $object->stats );
		}
		$this->hit_points['base']   = round( $hit_points / $number );
		$this->non_prof             = round( $non_prof / $number );
		$this->weap_init['initial'] = round( $weap_init / $number );
		$this->weap_init['step']    = round( $weap_step / $number );
	}

	public function import_kregen_csv( $file ) {
		parent::import_kregen_csv( $file );
		$this->initialize_multi();
	}

	public function set_import_task() {
		foreach( $this->multi as $class => $object ) {
			$object->set_import_task();
		}
	}

	public function parse_csv_line( $line ) {
#print_r($line);
		foreach( $this->multi as $class => $object ) {
			$object->parse_csv_line( $line );
		}
	}


}
