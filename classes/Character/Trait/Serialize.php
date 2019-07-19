<?php

trait DND_Character_Trait_Serialize {


	public function JsonSerialize() {
		$table = $this->get_serialization_data();
		$table['what_am_i'] = get_class( $this );
		return $table;
	}

	public function serialize() {
		return serialize( $this->get_serialization_data() );
	}

	private function get_serialization_data() {
		$table = array(
			'armor'      => $this->armor,
			'current_hp' => $this->current_hp,
			'experience' => $this->experience,
			'hit_points' => $this->hit_points,
			'initiative' => $this->initiative,
			'name'       => $this->name,
			'race'       => $this->race,
			'segment'    => $this->segment,
			'shield'     => $this->shield,
			'stats'      => $this->stats,
			'weapon'     => $this->weapon,
			'weapons'    => $this->weapons,
		);
		if ( $this instanceOf DND_Character_Multi ) {
#			foreach( $this->classes as $key => $class ) {
#				$name = str_replace( ' ', '', $class );
#				$table[ $name ] = json_encode( $this->$key );
#			}
		}
		if ( $this->spells ) {
			$list = array();
			foreach( $this->spells as $level => $spells ) {
				$list[ $level ] = array();
				foreach( $spells as $name => $info ) {
					$list[ $level ][] = $name;
				}
			}
			$table['spell_list'] = $list;
		}
		return $table;
	}

	public function unserialize( $data ) {
		$args = unserialize( $data );
		$this->__construct( $args );
	}


}
