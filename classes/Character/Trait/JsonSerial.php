<?php

trait DND_Character_Trait_JsonSerial {


	public function JsonSerialize() {
		$table = array(
			'armor'      => $this->armor,
			'experience' => $this->experience,
			'hit_points' => $this->hit_points,
			'initiative' => $this->initiative,
			'movement'   => $this->movement,
			'name'       => $this->name,
			'race'       => $this->race,
			'shield'     => $this->shield,
			'spells'     => $this->spells,
			'stats'      => $this->stats,
			'weapon'     => array( 'current' => $this->weapon['current'] ),
			'weapons'    => $this->weapons,
		);
		if ( method_exists( $this, 'initialize_multi' ) ) {
			foreach( $this->classes as $key => $class ) {
				$name   = str_replace( ' ', '', $class );
				$table[ $name ] = json_encode( $this->$key );
			}
		}
		return $table;
	}


}
