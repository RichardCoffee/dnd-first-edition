<?php

class DND_Character_FighterThief extends DND_Character_FighterMulti {


	protected $skills = array();


	use DND_Character_Trait_Multi_Thief;


	public function __construct( $args = array() ) {
		$this->classes = array( 'fight' => 'Fighter', 'thief' => 'Thief' );
		parent::__construct( $args );
		$this->skills = $this->thief->skills;
#$this->segment = 5;
#$this->weapon['symbol'] = 'wide V';
	}


}
