<?php

require_once( 'setup.php' );

class Combat {
	public  $messages = array();
	public  $segment  = 0;
	private $target   = null;
	public function __construct( $target ) { $this->target = $target; }
	public function advance_segment( $i ) {
		$this->segment  = $i;
		$this->messages = array();
	}
	public function get_object( $param )   { return $this->target; }
	public function object_damage_with_origin( $p1, $p2, $p3, $p4 ) { }
}

class Target {
	public function get_key() { return 'Target'; }
}

class Spell {
	public $when = 16;
	public $data = array( 1 );
}

class Druid {
	use DND_Character_Trait_Spells_Effects_Druid;
	public function get_key() { return 'Druid'; }
}

$target = new Target;
$combat = new Combat( $target );
$spell  = new Spell;
$druid  = new Druid;

for( $i = 1; $i < 100; $i++ ) {
	echo '.';
	$combat->advance_segment( $i );
	$druid->druid_heat_metal_effect( $combat, $target, $spell );
	if ( ! empty( $combat->messages ) ) echo "{$combat->messages[0]}\n";
}
echo "\n";
