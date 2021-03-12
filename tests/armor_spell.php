<?php

require_once( 'setup.php' );

$t = new DND_Combat_Testing;

$t->add_opt( 'add', 'Dayna' );
$t->add_opt( 'add', 'Saerwen' );
echo "lvl: {$t->party['Saerwen']->level}\n";
echo " AT: {$t->party['Saerwen']->armor['type']}\n";
echo " mi: {$t->party['Saerwen']->manna_init}\n";
$t->add_opt( 'pre', 'Da:Armor:Sa' );
echo " AT: {$t->party['Saerwen']->armor['type']}\n";

$t->add_opt( 'monster', 'Wolf_Wolf' );
