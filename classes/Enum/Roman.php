<?php
/**
 *  Provides a Roman numeral enumeration set.
 *
 * @package FirstEdition
 * @subpackage Enum
 * @since 20200915
 * @author Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright Copyright (c) 2020, Richard Coffee
 * @link https://github.com/RichardCoffee/custom-post-type/blob/master/classes/Enum/Roman.php
 */
defined( 'ABSPATH' ) || exit;


class DND_Enum_Roman extends DND_Enum_Enum {


	/**
	 *  Trait to provide singleton methods.
	 */
	use DND_Trait_Singleton;


	/**
	 *  Constructor method
	 *
	 * @since 20191201
	 * @param array $args Substitution values for the set.
	 */
	protected function __construct( $args = array() ) {
		$this->set = array( '-',
			'I',   'II',   'III',   'IV',  'V',
			'VI',  'VII',  'VIII',  'IX',  'X',
			'XI',  'XII',  'XIII',  'XIV', 'XV',
			'XVI', 'XVII', 'XVIII', 'XIX', 'XX',
		);
		if ( $args && is_array( $args ) ) $this->set = array_replace( $this->set, $args );
	}


}
