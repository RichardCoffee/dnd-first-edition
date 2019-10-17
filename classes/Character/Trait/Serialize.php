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
			'ac_rows'    => $this->ac_rows,  # Humanoid
			'alignment'  => $this->alignment,
			'armor'      => $this->armor,
			'assigned'   => $this->assigned,
			'current_hp' => $this->current_hp,
			'experience' => $this->experience,
			'hit_dice'   => $this->hit_dice, # Humanoid
			'hit_points' => $this->hit_points,
			'initiative' => $this->initiative,
			'level'      => $this->level,
			'max_move'   => $this->max_move, # Humanoid
			'movement'   => $this->movement, # Humanoid
			'name'       => $this->name,
			'race'       => $this->race,
			'segment'    => $this->segment,
			'shield'     => $this->shield,
			'stats'      => $this->stats,
			'weap_dual'  => $this->weap_dual,
			'weapon'     => $this->weapon,
			'weapons'    => $this->weapons,
		);
		if ( $this instanceOf DND_Character_Multi ) {
			foreach( $this->classes as $key => $class ) {
				$table[ $key ] = serialize( $this->$key );
			}
		} else if ( $this instanceOf DND_Character_Ranger ) {
			if ( $this->spells ) {
				$list = array();
				foreach( $this->spells as $class => $spells ) {
					$list[ $class ] = $this->convert_spell_list( $spells );
				}
				$table['spell_list'] = $list;
			}
		} else if ( $this->spells ) {
			$table['spell_list'] = $this->convert_spell_list( $this->spells );
		}
		return $table;
	}

	private function convert_spell_list( $book ) {
		$list = array();
		foreach( $book as $level => $spells ) {
			$list[ $level ] = array();
			foreach( $spells as $name => $info ) {
				$list[ $level ][] = $name;
			}
		}
		return $list;
	}

	public function unserialize( $data ) {
		$args = unserialize( $data );
		$this->__construct( $args );
	}


}
