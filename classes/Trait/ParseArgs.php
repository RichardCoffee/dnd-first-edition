<?php
/**
 * Class DND_Trait_ParseArgs
 *
 * Add support for parsing incoming arrays
 *
 * @package Fluidity\Classes\Traits
 * @since 2.1.1
 *
 */
trait DND_Trait_ParseArgs {

	protected function parse_args( $args ) {
		if ( ! $args ) return;
		foreach( $args as $prop => $value ) {
			if ( property_exists( $this, $prop ) ) {
				$this->{$prop} = $value;
			}
		}
	}

	protected function parse_all_args( $args ) {
		if ( ! $args ) return;
		foreach( $args as $prop => $value ) {
			$this->{$prop} = $value;
		}
	}

	protected function parse_args_merge( $args ) {
		if ( ! $args ) return;
		foreach( $args as $prop => $value ) {
			if ( property_exists( $this, $prop ) ) {
				if ( is_array( $this->{$prop} ) ) {
					$this->{$prop} = array_merge( $this->{$prop}, $value );
				} else {
					$this->{$prop} = $value;
				}
			}
		}
	}

}
