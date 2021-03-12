<?php

abstract class DND_Character_Import_CSV {


	public    $character      = null;
	protected $data           = array();
	public    $import_message = 'Could not import file.';
	public    $import_status  = 'failed';
	protected $name           = '';


#	 * @param string $data First line of the import file.
abstract protected function parse_class( $line );
#	 * @param array $data File line as a filtered array.
abstract protected function parse_line( $data );


	public function __construct( $file, $extra = array() ) {
		$contents = file ( $file, FILE_IGNORE_NEW_LINES );
		$class    = $this->parse_class( $contents[0] );
		if ( class_exists( $class ) ) {
			foreach( $contents as $line ) {
				$parsed = array_values( array_filter( explode( ',', $line ) ) );
				if ( $parsed && ( count( $parsed ) > 1 ) ) {
					$this->parse_line( $parsed );
				}
			}
			$this->save_character( $class, $extra );
			$this->import_status = 'success';
			$this->import_message = "{$this->name} imported as $class.";
		} else {
			$this->import_status = 'fail';
			$this->import_message = "The template for $class does not exist.  Either pick one that does exist or talk to the programmer.";
		}
		echo "{$this->import_message}\n";
	}

	protected function save_character( $class, $extra ) {
		$info = array_merge( $this->data, $extra );
		$this->character = new $class( $info );
		$this->determine_experience();
		if ( function_exists( 'get_current_user_id' ) ) {
			if ( $user = get_current_user_id() ) {
				$key = 'dnd1e_' . $class . '_' . $this->character->get_key(1);
				update_user_meta( $user, $key, $this->character );
			}
		}
	}

	protected function detemine_experience() { }



}
