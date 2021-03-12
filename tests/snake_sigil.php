<?php

require_once( 'setup.php' );

$t = new DND_Combat_Testing;

#$t->add_opt( 'add', 'Dayna' );
$t->add_opt( 'add', 'Tifa' );
$t->add_opt( 'init', 'Tifa:4' );

print_r( $t->party );
