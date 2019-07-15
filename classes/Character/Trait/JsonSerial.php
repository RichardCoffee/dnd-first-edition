<?php

trait DND_Character_Trait_JsonSerial {


	public function JsonSerialize() {
		$table = array(
			'what_am_i'  => get_class( $this ),
			'armor'      => $this->armor,
			'experience' => $this->experience,
			'hit_points' => $this->hit_points,
			'initiative' => $this->initiative,
			'name'       => $this->name,
			'race'       => $this->race,
			'shield'     => $this->shield,
			'stats'      => $this->stats,
			'weapon'     => $this->weapon,
			'weapons'    => $this->weapons,
		);
		if ( method_exists( $this, 'initialize_multi' ) ) {
			foreach( $this->classes as $key => $class ) {
				$name = str_replace( ' ', '', $class );
				$table[ $name ] = json_encode( $this->$key );
			}
		} else {
			if ( (bool) $this->spells ) {
				$list = array();
				foreach( $this->spells as $level => $spells ) {
					$list[ $level ] = array();
					foreach( $spells as $name => $info ) {
						$list[ $level ][] = $name;
					}
				}
				$table['spell_list'] = $list;
			}
		}
		return $table;
	}


}
