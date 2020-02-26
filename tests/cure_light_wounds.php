<?php

require_once( 'setup.php' );

$t = new DND_Combat_Testing;
$t->add_opt( 'add', 'Derryl' );
$t->add_opt( 'init', 'Derryl:6' );
$t->add_opt( 'add', 'Gaius' );
$t->add_opt( 'init', 'Gaius:1' );
$t->advance_segment();
$t->add_arg( array( 'Testing', 'Derryl', '2' ) );
$t->advance_segment();
$t->add_arg( array( 'Testing', 'Derryl', '2' ) );
$t->add_arg( array( 'Testing', 'Derryl', '2', 'Gaius' ) );
$t->add_opt( 'hit', 'Gaius:10' );
$t->add_arg( array( 'Testing', 'Derryl', '2', 'Gaius' ) );
$t->advance_segment();
$t->advance_segment();
$t->advance_segment();
$t->advance_segment();
$t->advance_segment();
$t->add_opt( 'spell', 'Derryl:7' );

print_r($t);
