<?php

class DND_Combat_Effect implements JsonSerializable, Serializable {


	//  Original Spell data
	protected $aoe        = '';  //  Area of Effect
	protected $cast       = '';  //  Casting time
	protected $comps      = '';  //  Components - Verbal, Somatic, Material
	protected $duration   = '';  //  Duration
	protected $kind       = '';  //  Cantrip category
	protected $level      = '';  //  Level
	protected $name       = '';  //  Name
	protected $page       = '';  //  Source
	protected $range      = '';  //  Range
	protected $reversible = false;
	protected $saving     = '';  //  Saving Throw
	protected $text       = '';  //  Description text
	protected $type       = '';  //  Type

	//  Effect data
	protected $apply      = '';  //  Hook for when casting is complete
	protected $book       = '';  //  Caster class
	protected $caster     = '';  //  Caster key
	protected $condition  = '';  //  Function that determines whether a filter is applied to passed value, returns a boolean value.
	public    $effects    = array(); // array containing spell information
	protected $ends       = 0;   //  Ending segment
	protected $filters    = array(); // array of filter arrays
	private   $key        = 'Effect_Key';
	protected $location   = array(); // Map location
	protected $object     = null;    //  Caster object
	protected $replace    = '';  //  Spell replacement filter name
	public    $rewrite    = false;   // flag to use new code base for handling effect filters
	protected $secondary  = array(); // secondary effects for Monster classes
	protected $special    = '';  //  Note on special effects
	protected $target     = '';  //  object key, 'party', 'enemy', 'aoe'
	protected $when       = 1;   //  Spell effects begin/occur segment


	use DND_Trait_ParseArgs;


	public function __construct( array $args = array() ) {
		$this->parse_args( $args );
		if ( empty( $this->caster ) ) {
			$caller  = @next( debug_backtrace() ); // without '@', this line produces "PHP Notice:  Only variables should be passed by reference"
			$message = "no caster set for '{$this->name}', called from {$caller['file']} on line {$caller['line']}";
			trigger_error( $message, E_USER_ERROR );
		}
		if ( ! empty( $this->filters ) ) {
			$this->rewrite = is_string( $this->filters[0][1] );
		}
	}


	/**  Get functions  **/

	public function __call( $func, $args ) {
		list( $get, $prop ) = array_pad( explode( '_', $func ), 2, false );
		if ( ( $get === 'get' ) && $prop ) {
			if ( property_exists( $this, $prop ) ) {
				return $this->{$prop};
			}
		}
		$caller  = @next( debug_backtrace() ); // without '@', this line produces "PHP Notice:  Only variables should be passed by reference"
		$message = "non-callable function '$string' called from {$caller['file']} on line {$caller['line']}";
		trigger_error( $message, E_USER_ERROR );
	}

	public function get_key() {
		return $this->set_key();
	}

	public function casting() {
		return $this->convert_segments( $this->cast );
	}

	public function duration() {
		return $this->convert_segments( $this->duration );
	}

	public function manna_cost() {
		$ord = DND_Enum_Ordinal::instance();
		return $ord->position( $this->level );
	}


	/**  Set functions  **/

	public function set_ends( $segment ) {
		$this->ends = $segment;
	}

	public function set_filter_delta( $index, $value, $replace = false ) {
		if ( $replace ) {
			$this->filters[ $index ][1] = $value;
		} else {
			$this->filters[ $index ][1] -= $value;
		}
		return $this->filters[ $index ][1];
	}

	public function set_key( $new = '' ) {
		if ( $this->key === 'Effect_Key' ) {
			if ( $new ) {
				$this->key = $new;
			} else {
				$this->key = implode( '_', [ $this->name, $this->caster, $this->target ] );
				$this->key = str_replace( [ ' ', "'" ], [ '_' ], $this->key );
			}
		}
		return $this->key;
	}

	public function set_pre_cast() {
		$this->when = 1;
		if ( ( $duration = $this->duration() ) > 0 ) {
			$this->ends = $this->when + $duration;
		}
	}

	public function set_target( $target ) {
		if ( empty( $this->target ) ) {
			$this->target = ( is_object( $target ) ) ? $target->get_key() : $target;
		} else if ( $this->target === 'origin' ) {
			$this->target = $this->caster;
		}
	}

	public function set_when( $segment ) {
		$this->when = $segment + $this->casting();
		if ( ( $this->ends === 0 ) && ( ( $duration = $this->duration() ) > 0 ) ) {
			$this->ends = $this->when + $duration;
		}
	}


	/**  Boolean functions  **/

	public function has_condition() {
		if ( ! empty( $this->condition ) ) return true;
		return false;
	}

	public function has_ended( $segment ) {
		if ( ( $this->ends > 0 ) && ( $segment > $this->ends ) ) return true;
		return false;
	}

	public function has_filter( $search ) {
		foreach( $this->filters as $filter ) {
			if ( $filter[0] === $search ) return true;
		}
		return false;
	}

	public function has_secondary() {
		return ! empty( $this->secondary );
	}

	public function has_special() {
		return ! empty( $this->special );
	}

	public function condition_applies( $object ) {
		if ( is_object( $object ) && method_exists( $object, $this->condition ) ) {
			return $object->{$this->condition}( $this );
		}
		return false;
	}


	/**  Filter functions  **/

	public function process_apply( $origin, $data ) {
		if ( ! empty( $this->apply ) ) {
			if ( method_exists( $origin, $this->apply ) ) {
				$origin->{$this->apply}( $this, $data );
			}
			$this->apply = '';
		}
	}

	public function process_effect() {
		global $wp_current_filter;
		$args   = func_get_args();
		$args[] = $this;
		$filter = $this->locate_filter( $wp_current_filter[0] );
		list ( $name, $delta, $priority, $argn ) = $filter;
		return call_user_func_array( [ $this->object, $delta ], $args );
	}

	public function add_filter( $new ) {
		if ( is_array( $new ) && ( count( $new ) === 4 ) && is_string( $new[0] ) && is_numeric( $new[1] ) && is_numeric( $new[2] ) && is_numeric( $new[3] ) ) {
			$this->filters[] = $new;
		}
	}

	public function activate_filters( $object ) {
		$this->object = $object;
		foreach( $this->filters as $filter ) {
			list ( $name, $delta, $priority, $argn ) = $filter;
			add_filter( $name, [ $this, 'process_effect' ], $priority, $argn );
		}
	}

	protected function locate_filter( $name ) {
		foreach( $this->filters as $filter ) {
			if ( $filter[0] === $name ) return $filter;
		}
		return null;
	}

	public function remove_filter( $name ) {
		$this->filters = array_filter(
			$this->filters,
			function( $a ) {
				if ( $a[0] === $name ) return false;
				return true;
			}
		);
	}


	/**  Commandline functions  **/

	public function get_listing_line() {
		$line = sprintf( '%-18s', $this->page);
		if ( ! empty( $this->cast ) )     $line .= "\tC: {$this->cast}";
		if ( ! empty( $this->range ) )    $line .= "\tR: {$this->range}";
		if ( ! empty( $this->duration ) ) $line .= "\tD: {$this->duration}";
		if ( ! empty( $this->special ) )  $line .= "\tS: {$this->special}";
		return $line;
	}

	public function show_casting() {
		echo " casting {$this->name} {$this->page}";
		if ( $this->reversible ) echo " Reversible";
		if ( ! empty( $this->range ) )    echo "\n\t\t         Range: {$this->range}";
		if ( ! empty( $this->duration ) ) echo "\n\t\t      Duration: {$this->duration}";
		if ( ! empty( $this->aoe ) )      echo "\n\t\tArea of Effect: {$this->aoe}";
		if ( ! empty( $this->saving ) )   echo "\n\t\t  Saving Throw: {$this->saving}";
		if ( ! empty( $this->special ) )  echo "\n\t\t       Special: {$this->special}";
	}


	/**  Helper functions  **/

	protected function convert_segments( $time_string ) {
		$length = ( strpos( $time_string, 'segment' ) ) ? intval( $time_string ) : intval( $time_string ) * 10;
		$length = ( strpos( $time_string, 'turn'    ) ) ? intval( $time_string ) * 100  : $length;
		$length = ( strpos( $time_string, 'hour'    ) ) ? intval( $time_string ) * 1000 : $length;
		return $length;
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
			if ( $key === 'object' ) continue;
			$data[ $key ] = $this->$key;
		}
		return $data;
	}

	public function unserialize( $data ) {
		$this->__construct( unserialize( $data ) );
	}


}
