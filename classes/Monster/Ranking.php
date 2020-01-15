<?php

class DND_Monster_Ranking {


	public    $initiative = array();
	protected $combat_key = '';
	protected $name       = '';
	public    $stats      = array();


	public function __construct( DND_Monster_Monster $monster, $type ) {
		$this->combat_key = $monster->get_key();
		$this->name = $this->combat_key . " ({$monster->weapon['current']})";
		if ( property_exists( $monster, 'stats' ) && array_key_exists( 'dex', $monster->stats ) ) {
			$this->stats = $monster->stats;
		} else {
			$dex = round( ( ( 10 - $monster->armor_class ) * 1.5 ) + 3 );
			$this->stats = array( 'dex' => $dex );
		}
		$this->initiative = [ 'actual' => 11 - $monster->initiative, 'segment' => $monster->initiative ];
	}

	public function get_name() {
		return $this->name;
	}

	public function get_key() {
		return $this->combat_key;
	}


}
