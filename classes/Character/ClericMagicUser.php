<?php

class DND_Character_ClericMagicUser extends DND_Character_Multi {


	protected $cleric = null;
	protected $magic  = null;


	public function __construct( $args = array() ) {
		$this->classes = array( 'cleric' => 'Cleric', 'magic' => 'Magic User' );
		parent::__construct( $args );
	}

	protected function initialize_multi() {
		parent::initialize_multi();
	}

	public function set_current_weapon( $new = '' ) {
		$this->cleric->set_current_weapon( $new );
		$this->armor  = $this->cleric->armor;
		$this->weapon = $this->cleric->weapon;
	}

	public function get_to_hit_number( $target_ac = -11, $target_at = -1, $range = -1 ) {
		$this->cleric->opponent = $this->opponent;
		return $this->cleric->get_to_hit_number( $target_ac, $target_at, $range );
	}

	/**  Import Functions  **/

	public function import_kregen_csv( $file ) {
		parent::import_kregen_csv( $file );
		$this->set_current_weapon( $this->weapon['current'] );
	}

	public function parse_csv_line( $line ) {
		if ( $line[0] === "Non-Proficiency" ) $this->set_import_task( 'cleric' );
		if ( $line[0] === '"MU: Cantrips"' )  $this->set_import_task( 'magic' );
		if ( $line[0] === 'AC' ) {
			$index = array_search( 'XP', $line );
			$this->cleric->parse_csv_line( [ 0 => 'AC', 4 => 'XP', 5 => $line[ ++$index ] ] );
			$this->magic->parse_csv_line( [ 0 => 'AC', 4 => 'XP', 5 => $line[ $index + 2 ] ] );
		} else {
#echo "index 0: {$line[0]} task:{$this->import_task}\n";
			if ( $this->import_task === 'magic' ) {
				$this->magic->parse_csv_line( $line );
			} else if ( ( $this->import_task === 'cleric' ) ) {
				$this->cleric->parse_csv_line( $line );
			} else {
				parent::parse_csv_line( $line );
			}
		}
	}


}
