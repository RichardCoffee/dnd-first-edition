<?php

require_once( 'setup.php' );

class Attack_Type extends DND_Combat_CommandLine {

	use DND_Trait_Singleton;

	public function __toString() {
		return 'Attack Type';
	}

	public function test_one() {
		foreach( $this->enemy as $key => $object ) {
			echo "$key";
			$sequence = $this->get_attack_sequence( $object );
			echo "\t{$object->segment}";
			echo "\t".$this->get_mapped_attack_sequence($sequence);
			echo "\t".$object->weapon['current'];
			echo "\n";
		}
		$enemy = $this->get_enemy_attackers();
		foreach( $enemy as $object ) {
			echo $object->get_name()."\n";
		}
	}


}

$data = array( 'segment' => 11 );
$obj = Attack_Type::get_instance( $data );
$monster = new DND_Monster_Sphinx_Manticore;
$obj->initialize_enemy( $monster );

#echo $obj;
#echo get_class( $obj );

$obj->test_one();

echo "\n";
