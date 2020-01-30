<?php

class DND_Monster_Ranking {


	public    $initiative = array();
	protected $combat_key = '';
	protected $name       = '';
	public    $stats      = array();
	protected $weapon     = '';


	public function __construct( DND_Monster_Monster $monster ) {
		$this->combat_key = $monster->get_key();
		$this->name   = $monster->name;
		$this->weapon = $monster->weapon['current'];
		if ( property_exists( $monster, 'stats' ) && array_key_exists( 'dex', $monster->stats ) ) {
			$this->stats = $monster->stats;
		} else {
			$dex = round( ( ( 10 - $monster->armor_class ) * 1.5 ) + 3 );
			$this->stats = array( 'dex' => $dex );
		}
		$this->initiative = [ 'actual' => 11 - $monster->initiative, 'segment' => $monster->initiative ];
	}

	public function get_key() {
		return $this->combat_key;
	}

	public function get_name( $type = '' ) {
		if ( $type === 'w' ) return $this->combat_key . ' (' . $this->weapon . ')';
		return $this->name;
	}


}
