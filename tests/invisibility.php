<?php

include( 'setup.php' );

class int_test extends DND_Combat_Invisibility {

	public function get_obs_level( $obs ) {
		return $this->determine_observer_level( $obs );
	}

	public function get_intel( $obs ) {
		return $this->determine_observer_intelligence( $obs );
	}

}

$subs = array(
#	new DND_Monster_Animal_Bear_Black,
#	new DND_Monster_Animal_Camel,
	new DND_Monster_Reptile_Basilisk,
	new DND_Monster_Aerial_Griffon,
	new DND_Monster_Water_Hippopotamus,
	new DND_Monster_Lamia_Lamia,
	new DND_Monster_Animal_Elephant_Asiatic,
	new DND_Monster_Lamia_Noble,
	new DND_Monster_Dragon_Gold,
);

$int = new int_test;
foreach( $subs as $obs ) {
	$str = sprintf(
		'hd: %2u  ex: %u  i: %2u  col: %u   row: %u   per: %2u     %s',
		$obs->hit_dice,
		$obs->hp_extra,
		$obs->stats['int'],
		$int->get_intel( $obs ),
		$int->get_obs_level( $obs ),
		$int->get_chance_numeric( $obs ),
		$obs->get_name()
	);
	echo "$str\n";
}
/*
$int = new DND_Enum_Intelligence;
$rge = $int->range( $obs->intelligence );
print_r($rge);
*/
