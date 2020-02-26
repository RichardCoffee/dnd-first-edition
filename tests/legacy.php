<?php

require_once( 'setup.php' );

class Owner {
	public $level = 1;
	public function get_key() { return 'Fundin'; }
}

$base = array(
	'align'  => 'Neutral',
	'name'   => 'Axe of Exile',
	'owner'  => 'Fundin',
	'prefix' => 'AXEX',
	'type'   => array( 'Axe,Hand', 'Axe,Throwing' ),
);

$own = new Owner;
$axe = new DND_Combat_Treasure_Items_Legacy( $base );
$axe->activate_filters();
$wtf = apply_filters( 'dnd1e_origin_damage', 0, $own );
$own->level+=4;
$wtf = apply_filters( 'dnd1e_origin_damage', 0, $own );
$own->level++;
$wtf = apply_filters( 'dnd1e_origin_damage', 0, $own );
$own->level++;
$wtf = apply_filters( 'dnd1e_origin_damage', 0, $own );
$own->level++;
$wtf = apply_filters( 'dnd1e_origin_damage', 0, $own );
$own->level++;
$wtf = apply_filters( 'dnd1e_origin_damage', 0, $own );
#$own->level++;
$wtf = apply_filters( 'dnd1e_origin_damage', 0, $own );
#$own->level++;
$wtf = apply_filters( 'dnd1e_origin_damage', 0, $own );
#$own->level++;
$wtf = apply_filters( 'dnd1e_origin_damage', 0, $own );


print_r( $axe );
