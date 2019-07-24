<?php

/*
 *  https://secure.php.net/manual/en/language.oop5.magic.php
 *  http://php.net/manual/en/language.oop5.overloading.php
 *  http://www.garfieldtech.com/blog/magical-php-call
 *  https://lornajane.net/posts/2012/9-magic-methods-in-php
 */

trait DND_Trait_Magic {


	protected $set__callable = false;
	protected $magic__call   = array();


	# do not use is_callable() within this function
	public function __call( $string, $args ) {
		$return = "non-callable function '$string'";
		if ( $this->magic__call && isset( $this->magic__call[ $string ] ) ) {
			$return = call_user_func_array( [ $this, $this->magic__call[ $string ] ], $args );
		}
		return $return;
	}

	public function __get( $name ) {
		if ( property_exists( $this, $name ) ) {
			return $this->$name;  #  Allow read access to private/protected variables
		}
		return null;
	}

	public function __isset( $name ) {
		return isset( $this->$name ); #  Allow read access to private/protected variables
	} //*/

	public function register__call( $method, $alias = false ) {
		if ( is_callable( [ $this, $method ] ) ) {
			$alias = ( $alias ) ? $alias : $method;
			$this->magic__call[ $alias ] = $method;
			return true;
		}
		return false;
	} //*/

	public function set( $property, $value ) {
		if ( $this->set__callable ) {
			if ( ( ! empty( $property ) ) && ( ! empty( $value ) ) ) {
				if ( is_array( $this->set__callable ) ) {
					if ( ! in_array( $property, $this->set_callable ) ) {
						return;
					}
				}
				if ( property_exists( $this, $property ) ) {
					$this->{$property} = $value;
				}
			}
		}
	}


}
