<?php

class DND_Plugin_Primary extends DND_Plugin_Library {


	private $combat   = null;
	private $treasure = null;


	public function __construct() {
		parent::__construct();
		$this->treasure = new DND_Treasure;
	}

	public function __get( $name ) {
		if ( $name === 'combat' ) {
			return $this->initialize_combat();
		}
		return parent::__get( $name );
	}

	public function initialize_combat() {
		if ( empty( $this->combat ) ) {
			$this->combat = dnd1e_transient( 'combat' );
			if ( empty( $this->combat ) ) {
				if ( defined( 'CSV_PATH' ) ) {
					$this->combat = DND_CommandLine::instance();
				} else {
					$this->combat = DND_Combat::instance();
				}
			} else {
				if ( defined( 'CSV_PATH' ) ) {
					echo "\nusing transient data\n";
				}
			}
		}
		return $this->combat;
	}

	public function reset_combat() {
		if ( ! empty( $this->combat ) ) {
			$this->combat = null;
		}
		delete_transient( 'combat' );
	}


}
