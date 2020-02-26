<?php

class DND_Monster_Ranking {


	public    $initiative = array();
	protected $combat_key = '';
	protected $name       = '';
	public    $race       = '';
	public    $segment    = 0;
	public    $stats      = array();
	public    $weapon     = array();


	public function __construct( DND_Monster_Monster $monster ) {
		$this->combat_key = $monster->get_key();
		$this->name    = $monster->name;
		$this->race    = $monster->race;
		$this->segment = $monster->segment;
		$this->weapon  = $monster->weapon;
		if ( property_exists( $monster, 'stats' ) && array_key_exists( 'dex', $monster->stats ) ) {
			$this->stats = $monster->stats;
		} else {
			$this->stats['dex'] = round( ( ( 10 - $monster->armor_class ) * 1.5 ) + 3 );
		}
		$this->initiative = [ 'actual' => 11 - $monster->initiative, 'segment' => $monster->initiative ];
	}

	public function get_key() {
		return $this->combat_key;
	}

	public function get_name( $type = '' ) {
		if ( $type === 'w' ) return "{$this->combat_key} ({$this->weapon['current']})";
		return $this->name;
	}


}
