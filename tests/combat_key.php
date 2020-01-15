<?php

require_once( 'setup.php' );

function get_visibility( ReflectionProperty $obj ) {
	if ( $obj->isPublic() )    return 'Public';
	if ( $obj->isProtected() ) return 'Protected';
	if ( $obj->isPrivate() )   return 'Private';
	return 'Unknown';
}

$test = new DND_Monster_Dragon_Mist;
$prop = new ReflectionProperty( $test, 'combat_key' );
$key  = 'test key';

$test->set_key( $key );

echo "\nTest key is ";
echo $test->get_key();
echo "\nVisibility is ";
echo get_visibility( $prop );
echo "\n\n";
