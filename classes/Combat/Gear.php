<?php

trait DND_Combat_Gear {


	protected $gear      = array();
	private   $gear_skip = array( 'Ammo', 'Armor', 'Shield' );


	/**  Load/Save functions  **/

	public function load_special_gear( $gear ) {
		$this->load_transient_gear();
		$this->import_gear( $gear );
	}

	protected function load_transient_gear() {
echo "load gear\n";
		$stored = dnd1e()->transient( 'gear' );
		foreach( $stored as $key => $item ) {
			if ( ! array_key_exists( $key, $this->gear ) ) {
				$this->gear[ $key ] = $item;
			}
		}
	}

	public function import_gear( $gear ) {
#unset( $this->gear['SLWO_Trindle']);
		foreach( $gear as $data ) {
			if ( is_array( $data ) ) {
				$base = $data['class'];
				$item = new $base( $data );
				$key  = $item->set_owner( $data['owner'] );
			} else if ( is_object( $data ) ) {
				$key  = $data->key;
				$item = $data;
			}
			if ( ! array_key_exists( $key, $this->gear ) ) {
				$this->gear[ $key ] = $item;
			}
		}
	}

	protected function retrieved_gear( $import, $refer ) {
		$gear = array();
		foreach( $import as $item ) {
			if ( array_key_exists( $item->owner, $refer ) ) {
				$item->set_owner( $refer[ $item->owner ] );
				$gear[] = $item;
			}
		}
		$this->import_gear( $gear );
	}

	protected function store_gear() {
		$this->store_data( 'gear' );
	}

	public function get_gear_item( $key ) {
		if ( array_key_exists( $key, $this->gear ) ) return $this->gear[ $key ];
		return false;
	}

	protected function get_owner_gear( $name ) {
		$gear = array_filter(
			$this->gear,
			function( $a ) use ( $name ) {
				if ( $a->owner === $name ) return true;
				return false;
			}
		);
		return $gear;
	}

	protected function get_available_gear( $object ) {
		$key  = $object->get_key();
		return array_filter(
			$this->gear,
			function( $a ) use ( $key ) {
#				if ( $a->active ) return false;
				if ( in_array( $a->base_class(), $this->gear_skip ) ) return false;
				if ( $a->owner === $key ) return true;
				return false;
			}
		);
	}


	/**  Interaction functions  **/

	public function activate_gear_item( $key ) {
		if ( array_key_exists( $key, $this->gear ) ) $this->gear[ $key ]->activate();
	}

	protected function activate_weapon( $object, $item, $secondary ) {
#		$type = $item->base_class();
		$item->activate();
		if ( $item->base_class() === 'Weapon' ) {
			$this->change_weapon( $object, $item, $secondary );
		}
	}

	protected function search_gear( $obj_key, $weapon ) {
		$maybe = array_filter(
			$this->gear,
			function ( $a ) use ( $obj_key, $weapon ) {
				if ( ( $a->owner === $obj_key ) && ( in_array( $weapon, $a->type ) ) ) return true;
				return false;
			}
		);
		if ( count( $maybe ) === 1 ) {
			$new = array_shift( $maybe );
			$new->typepub = $weapon;
			return $new;
		}
		return $weapon;
	}

	protected function search_gear_for_ammo( $object ) {
		foreach( $this->gear as $key => $gear ) {
			if ( get_class( $gear ) === 'DND_Combat_Treasure_Items_Ammo' ) {
				if ( ( $object->get_key() === $gear->owner ) && ( $gear->quan > 0 ) ) {
					if ( in_array( $object->weapon['current'], $gear->user ) ) {
						$gear->activate();
					} else {
						$gear->turn_off();
					}
				}
			}
		}
	}

	protected function check_for_cursed_gear( $object, $location ) {
		if ( array_key_exists( 'key', $object->{$location} ) ) {
			$key = $object->{$location}['key'];
			if ( $key && array_key_exists( $key, $this->gear ) ) {
				if ( in_array( 'Cursed', $this->gear[ $key ]->type ) ) {
					$this->messages[] = $object->get_key() . " is using a cursed weapon and is unable to change weapons.";
					return true;
				}
			}
		}
		return false;
	}

	protected function check_for_secondary_gear( $object ) {
		if ( $object->weap_dual && ( ! in_array( $object->weapon['current'], $object->weap_dual ) ) ) {
			$curr = ( array_key_exists( 'key', $object->weapon ) ) ? $object->weapon['key'] : false;
			foreach( $this->gear as $key => $item ) {
				if ( $curr && ( $curr === $key ) ) continue;
				if ( ! ( $object->get_key() === $item->owner ) ) continue;
				if ( in_array( $item->base_class(), $this->gear_skip ) ) continue;
				$item->turn_off();
			}
		}
	}

	public function deactivate_weapon( $key, $object ) {
		if ( ( ! array_key_exists( 'key', $object->weapon ) ) || ( ! ( $key === $object->weapon['key'] ) ) ) {
			if ( array_key_exists( $key, $this->gear ) ) {
				$this->gear[ $key ]->turn_off();
			}
		}
	}

	protected function deactivate_gear( $name ) {
		foreach( $this->gear as $key => $item ) {
			if ( $item->owner === $name ) $item->turn_off();
		}
	}

	protected function claim_gear( $key, $owner ) {
		if ( array_key_exists( $key, $this->gear ) ) {
			$item = clone $this->gear[ $key ];
			$new  = $item->set_owner( $owner );
			if ( ! array_key_exists( $new, $this->gear ) ) {
				$this->gear[ $key ]->turn_off();
				unset( $this->gear[ $key ] );
				$this->gear[ $new ] = $item;
			} else {
				$this->messages[] = "Duplicate weapon $new found in gear.  Cannot assign to $owner.";
			}
		} else {
			$this->messages[] = "$key not found in gear.";
		}
	}


	/**  Commandline functions  **/

	protected function build_index_array( $object ) {
		$gear = $this->get_available_gear( $object );
		$indexed = array();
		$idx = 'A';
		foreach( $gear as $item ) {
			if ( $item->active ) continue;
			$cnt = $item->get_type_count();
			for( $i = 0; $i < $cnt; $i++ ) {
				$indexed[ $idx ] = array( $item->type[ $i ], $item );
				$idx = chr( ord( $idx ) + 1 );
			}
		}
		return $indexed;
	}

	protected function show_special_gear( $object ) {
		$gear = $this->build_index_array( $object );
		foreach( $gear as $idx => $each ) {
			list( $type, $item ) = $each;
			$item->show_index_item( $idx, $type );
		}
		echo "\n";
	}

	protected function get_lettered_gear( $object, $letter ) {
		$gear = $this->build_index_array( $object );
		if ( array_key_exists( $letter, $gear ) ) {
			list( $type, $item ) = $gear[ $letter ];
			$item->typepub = $type;
			return $item;
		}
		return false;
	}


}
