<?php

require_once( 'setup.php' );

$t = new DND_Combat_Testing;

$t->add_opt( 'add', 'Gaius' );
$t->add_opt( 'monster', 'Sphinx' );
$t->add_arg( [ 'Gaius', 'Heat Metal', 1 ] );

for( $i = 1; $i < 20; $i++ ) {
	$t->advance_segment( $i );
#	$druid->druid_heat_metal_effect( $combat, $target, $spell );
#	if ( ! empty( $combat->messages ) ) echo "{$combat->messages[0]}\n";
}
