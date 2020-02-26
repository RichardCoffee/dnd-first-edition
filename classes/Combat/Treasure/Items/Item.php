<?php

class DND_Combat_Treasure_Items_Item implements JsonSerializable, Serializable {


	protected $active  = false;
	protected $data    = array();
	protected $effect  = '';
	protected $filters = array();
	protected $gp      = 0;
	private   $key     = '';
	protected $link    = '';
	protected $name    = '';
	protected $owner   = '';
	private   $prefix  = '';
	protected $symbol  = '';
	protected $type    = array();
	public    $typepub = '';
	protected $xp      = 0;


	use DND_Trait_Magic;
	use DND_Trait_ParseArgs;
	use DND_Combat_Treasure_Items_Effects;


	public function __construct( array $args = array() ) {
		$this->parse_args( $args );
		$this->randomize_filters();
		if ( count( $this->type ) === 1 ) $this->typepub = $this->type[0];
	}


	/**  Weapon functions  **/

	public function merge_gear_info( $weapon ) {
		if ( in_array( $weapon['current'], $this->type ) ) {
			$this->activate();
			$weapon = array_merge(
				$weapon,
				array(
					'effect' => $this->effect,
					'key'    => $this->key,
					'symbol' => $this->symbol,
				)
			);
		}
		return $weapon;
	}


	/**  Utility functions  **/

	public function activate() {
		if ( ! $this->active ) {
			$this->active = true;
			$this->activate_filters();
		}
	}

	public function turn_off() {
		$this->active = false;
		$this->deactivate_filters();
	}

	public function base_class() {
		$comps = explode( '_', get_class( $this ) );
		return $comps[ array_key_last( $comps ) ];
	}

	public function set_owner( $new ) {
		$this->owner = $new;
		$key_owner   = str_replace( ' ', '_', $new );
		$this->key   = implode( '_', [ $this->prefix, $key_owner ] );
		return $this->key;
	}

	public function use_charge() {
		if ( property_exists( $this, 'charges' ) ) {
			$this->charges--;
		}
	}

	public function get_type_count() {
		$cnt = count( $this->type );
		if ( in_array( 'Cursed', $this->type ) ) $cnt--;
		return $cnt;
	}


	/**  Filter functions  **/

	protected function add_filter( $new ) {
		foreach( $this->filters as $key => $filter ) {
			if ( $new[0] === $filter[0] ) {
				$this->filters[ $key ] = $new;
				return;
			}
		}
		$this->filters[] = $new;
	}

	protected function randomize_filters() {
		foreach( $this->filters as $key => $filter ) {
			list ( $name, $func, $delta, $priority, $argn ) = $filter;
			if ( $priority < 10 ) continue;
			$this->filters[ $key ][3] = mt_rand( 11, 9999 );
		}
	}

	public function activate_filters() {
		foreach( $this->filters as $filter ) {
			list ( $name, $func, $delta, $priority, $argn ) = $filter;
			add_filter( $name, [ $this, 'process_effect' ], $priority, $argn );
		}
	}

	public function locate_filter( $name ) {
		foreach( $this->filters as $filter ) {
			if ( $filter[0] === $name ) return $filter;
		}
	}

	public function deactivate_filters() {
		foreach( $this->filters as $filter ) {
			list ( $name, $func, $delta, $priority, $argn ) = $filter;
			remove_filter( $name, [ $this, 'process_effect' ], $priority, $argn );
		}
	}

	protected function remove_filter( $omit ) {
		foreach( $this->filters as $key => $filter ) {
			if ( $filter[0] === $omit ) {
				unset( $this->filters[ $key ] );
			}
		}
	}

#	 * @link https://www.php.net/manual/en/function.array-unique
	protected function remove_duplicate_filters( $current, $idx = 0 ) {
		$old = array_reverse( $current );
		$new = array();
		$key = array();
		foreach( $old as $filter ) {
			if ( ! in_array( $filter[ $idx ], $key ) ) {
				$key[] = $filter[ $idx ];
				$new[] = $filter;
			}
		}
		return $new;
	}


	/**  Commandline functions  **/

	public function show_index_item( $idx, $type ) {
		$line = "\t$idx) ";
		$line.= $this->generate_index_line( $type );
		echo "$line\n";
	}

	protected function generate_index_line( $type ) {
		return "$type : " . ( ( empty( $this->symbol ) ) ? "(no symbol)" : $this->symbol );
	}


	/**  JsonSerializable and Serializable functions  **/

	public function JsonSerialize() {
		return $this->get_serialization_data();
	}

	public function serialize() {
		return serialize( $this->get_serialization_data() );
	}

	private function get_serialization_data() {
		$data = array();
		$vars = get_class_vars( get_class( $this ) );
		foreach( $vars as $key => $value ) {
			if ( $key === 'magic__call' ) continue;
			$data[ $key ] = $this->$key;
		}
		return $data;
	}

	public function unserialize( $data ) {
		$this->__construct( unserialize( $data ) );
	}


}
