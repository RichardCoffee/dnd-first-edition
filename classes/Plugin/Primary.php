<?php

class DND_Plugin_Primary extends DND_Plugin_Library {


	private $combat   = null;
#	private $treasure = null;


	public function __construct() {
		parent::__construct();
#		$this->treasure = new DND_Combat_Treasure_Treasure;
	}

	public function __get( $name ) {
		if ( $name === 'combat' ) {
			return $this->combat();
		}
		return parent::__get( $name );
	}

	public function combat( $slug = 'combat' ) {
		if ( empty( $this->combat ) ) {
			$this->combat = $this->transient( $slug );
			if ( empty( $this->combat ) ) {
				if ( defined( 'CSV_PATH' ) ) {
					$this->combat = DND_Combat_CommandLine::instance();
				} else {
					$this->combat = DND_Combat_Plugin::instance();
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

	public function transient( $name, $data = null, $expire = YEAR_IN_SECONDS ) {
		$entry = "dnd1e_$name";
		if ( $data ) {
			set_transient( $entry, $data, $expire );
		} else {
#			return $this->unserialize( get_transient( $entry ), [ 'DND_Combat', 'DND_Monster_Monster', 'DND_Character_Character' ] );
			return $this->unserialize( get_transient( $entry ) );
		}
	}


}
