<?php

class DND_Character_RangerThief extends DND_Character_FighterMulti {


	use DND_Character_Trait_Multi_Ranger;
	use DND_Character_Trait_Multi_Thief;


	public function __construct( $args = array() ) {
		$this->classes = array( 'fight' => 'Ranger', 'thief' => 'Thief' );
		parent::__construct( $args );
	}


}
