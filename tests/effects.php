<?php

require_once( 'setup.php' );

$data = array(
	'caster' => 'Test User',
);
$effect = new DND_Combat_Effect( $data );

$ser0 = serialize( $effect );
echo "$ser0\n";

$obj1 = new DND_Monster_Invertebrates_Beetle_Bombardier;
$obj2 = new DND_Monster_Animal_Dog_Cooshee;

$ser1 = serialize( $obj1->giant_bombardier_beetle_stun_effect( $obj2, 34 ) );
echo "$ser1\n";
$ser2 = serialize( $obj2->cooshee_knock_effect( $obj1, 23 ) );
echo "$ser2\n";

$revert = unserialize( $ser1 );
print_r( $revert );

