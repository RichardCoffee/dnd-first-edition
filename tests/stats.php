<?php

require_once( 'setup.php' );

class Test_Attributes {

	use DND_Character_Trait_Attributes;

	public function get_strength_percentage( $str ) {
		echo "$str %:" . $this->parse_strength_percentage( $str ) . "\n";
	}

}

$test = new Test_Attributes;

$test->get_strength_percentage( 17 );
$test->get_strength_percentage( 18.17 );
$test->get_strength_percentage( '18.17' );
$test->get_strength_percentage( '18/17' );
$test->get_strength_percentage( '18.00' );
$test->get_strength_percentage( '18/100' );
$test->get_strength_percentage( 19 );




