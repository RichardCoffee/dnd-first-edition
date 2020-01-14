<?php

class DND_Monster_Ranking {


	public    $initiative = array();
	protected $key        = '';
	protected $name       = '';
	public    $stats      = array();


	public function __construct( DND_Monster_Monster $monster, $key, $type ) {
		$this->name = $monster->name . " ($type)";
		$this->key  = $key;
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
		return $this->key;
	}


}
