<?php

# TODO:  move all kregen import functions into this class.  Info should then be passed to the character class when creating it.

class DND_Character_Import_Kregen {

	public    $character      = null;
	protected $class          = '';
	public    $import_status  = 'failed';
	public    $import_message = 'Could not import file.';
	protected $name           = '';

#	use DND_Character_Trait_Kregen;

	public function __construct( $file, $extra = array() ) {
		$contents = file ( $file, FILE_IGNORE_NEW_LINES );
		$class = $this->parse_class( $contents[0] );
		if ( class_exists( $class ) ) {
			$this->character = new $class( $extra );
			$this->character->import_kregen_csv( $file );
			$this->import_status = 'success';
			$this->import_message = "{$this->name} imported as $class.";
		}
	}

	protected function parse_class( $data ) {
		$line = array_values( array_filter( explode( ',', $data ) ) );
#print_r( $line );
		$this->name = $line[0];
		$class = 'DND_Character_' . $this->check_class_name( $line[1] );
		$check = $this->check_class_name( $line[3] );
		if ( $check ) {
			$class .= $check;
			$check = $this->check_class_name( $line[5] );
			if ( $check ) {
				$class .= $check;
			}
		}
		return $class;
	}

	protected function check_class_name( $string ) {
		switch( $string ) {
			case 'Climb': // shows up on Barbarian spreadsheet
			case 'Dr':    // shows up on Ranger / RangerThief spreadsheets
			case 'MP':
			case 'Race':
				$secondary = '';
				break;
			case 'MU':
				$secondary = 'MagicUser';
				break;
			default:
				$secondary = $string;
		}
		return $secondary;
	}


}
