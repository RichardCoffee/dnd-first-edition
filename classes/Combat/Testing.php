<?php

class DND_Combat_Testing extends DND_Combat_CommandLine {

	public function __construct( $args = array() ) {
		parent::__construct( $args );
	}

	public function add_opt( $name, $data = '' ) {
		$this->opts[ $name ] = $data;
		$this->process_opts();
		$this->opts = array();
		$this->do_each_action();
	}

	public function add_arg( $args = array() ) {
		$this->process_arguments( $args );
		$this->do_each_action();
	}

	public function advance_segment() {
		$this->segment++;
		add_action( 'dnd1e_combat_init', [ $this, 'new_segment_housekeeping' ], 5 );
		$this->rounds += floor( $this->segment / 10 );
		if ( $this->party )   $this->integrate_party();
		$this->post_parent();
		$this->do_each_action();
		remove_action( 'dnd1e_combat_init', [ $this, 'new_segment_housekeeping' ], 5 );
	}

	private function do_each_action() {
		do_action( 'dnd1e_combat_init', $this );
		$this->show_messages();
	}

	protected function show_error( $error ) {}

	protected function show_messages( $messages = array() ) {
		parent::show_messages( $this->messages );
		$this->messages = array();
	}


}
