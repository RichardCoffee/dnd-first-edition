<?php

require_once( 'setup.php' );

class Combat {
	private $effects = array();
	private $objects = array();
	public  $segment = 5;
	use DND_Combat_Spells;
	public function __construct( $array ) {
		foreach( $array as $object ) {
			$this->objects[ $object->get_key() ] = $object;
		}
	}
	protected function change_weapon( $object, $weapon, $bool ) { }
	protected function get_object( $name ) {
		if ( array_key_exists( $name, $this->objects ) ) return $this->objects[$name];
		return null;
	}
	protected function remove_holding( $name ) { }

	public function cast( $name, $spell ) { $this->start_casting( $name, $spell ); }
	public function check( $name ) { $this->check_casting( $this->get_object( $name ) ); }
	public function data( $name, $data ) { $this->process_spell_data( $name, $data ); }
}

class Druid {
	protected $level = 4;
	use DND_Character_Trait_Magic;
	use DND_Character_Trait_Spells_Druid {
		get_druid_spell_table as get_spell_table;
		get_druid_description_table as get_description_table;
	}
#	public function __construct() 
	public function get_key() { return 'Druid'; }
	public function spend_manna( $spell ) { }
}

class Target {
	private $key;
	public function __construct( $name ) { $this->key = $name; }
	public function get_key() { return $this->key; }
}

$druid = new Druid;
$t1 = new Target( 'Target 1' );
$t2 = new Target( 'Target 2' );
$t3 = new Target( 'Target 3' );
$t4 = new Target( 'Target 4' );
$args = array( $druid, $t1, $t2, $t3 );
$combat = new Combat( $args );

$spell = $druid->locate_magic_spell( 'Faerie Fire', 'Druid' );
$combat->cast( $druid->get_key(), $spell );
$combat->check( $druid->get_key() );
$combat->segment = 6;
do_action( 'dnd1e_combat_init', $combat );
$combat->segment = 7;
do_action( 'dnd1e_combat_init', $combat );
$combat->segment = 8;
do_action( 'dnd1e_combat_init', $combat );
do_action( 'dnd1e_combat_init', $combat );
$combat->data( $druid->get_key(), 'Target 1;Target 2;Target 3' );
$combat->messages[] = 'adj1:'.apply_filters( 'dnd1e_armor_class_adj', 0, $t1 );
$combat->messages[] = 'adj2:'.apply_filters( 'dnd1e_armor_class_adj', 0, $t2 );
$combat->messages[] = 'adj3:'.apply_filters( 'dnd1e_armor_class_adj', 0, $t3 );
$combat->messages[] = 'adj4:'.apply_filters( 'dnd1e_armor_class_adj', 0, $t4 );
#$combat->segment = 9;
#do_action( 'dnd1e_combat_init', $combat );
#$combat->check( $druid->get_key() );

print_r($combat);
