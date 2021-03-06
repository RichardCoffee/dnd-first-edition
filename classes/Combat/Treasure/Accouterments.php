<?php

trait DND_Combat_Treasure_Accouterments {


	public function acc_get_accouterments( $obj, $chance = 0 ) {
		$acc   = array();
		$level = 0;
		$types = array();
		if ( $obj instanceof DND_Monster_Monster ) {
			$level = $obj->get_saving_throw_level();
			if ( $obj->hd_extra ) $level++;
		} else if ( $obj instanceof DND_Character_Character ) {
			$level = $obj->level;
		}
		if ( $level ) {
			$chance   = ( $chance ) ? $chance : $level * 5;
			$types    = $this->acc_types( $obj );
			$restrict = array_shift( $types );
			$acc = $this->acc_get_accouterment_list( $types, $chance, $restrict );
		}
		return $acc;
	}

	protected function acc_types( $obj ) {
		$types = array();
		if ( $obj instanceof DND_Monster_Monster ) {
			$types = $this->acc_types_fighter();
			if ( $obj instanceOf DND_Monster_Humanoid_Humanoid ) {
				if ( ! ( strpos( $obj->size, 'Large' ) === false ) ) {
					$types = array_diff( $types, [ 'armor' ] );
				}
			}
		} else if ( $obj instanceof DND_Character_Character ) {
			if ( $obj instanceof DND_Character_Cleric ) {
				$types = $this->acc_types_cleric();
			} else if ( $obj instanceof DND_Character_Fighter ) {
				$types = $this->acc_types_fighter();
			} else if ( $obj instanceof DND_Character_MagicUser ) {
				$types = $this->acc_types_magicuser();
			} else if ( $obj instanceof DND_Character_Thief ) {
				$types = $this->acc_types_thief();
			}
		}
		return $types;
	}

	protected function acc_types_cleric() {
		return array( 'C', 'armor_shields', 'weapons', 'potions', 'scrolls', 'rods/staves/wands', 'books_tomes/jewels_jewelry/cloaks_robes/boots_gloves/girdles_helms/bags_bottles/dusts_stones/items_tools/instruments/weird_stuff' );
	}

	protected function acc_types_fighter() {
		return array( 'F', 'armor', 'shields', 'swords', 'weapons', 'potions', 'scrolls/rings/rods/staves/wands' );
	}

	protected function acc_types_magicuser() {
		return array( 'M', 'scrolls', 'rings', 'rods/staves/wands', 'books_tomes/jewels_jewelry/cloaks_robes/boots_gloves/girdles_helms/bags_bottles/dusts_stones/items_tools/instruments/weird_stuff' );
	}

	protected function acc_types_thief() {
		return array( 'T', 'shields', 'swords', 'weapons', 'potions', 'rings', 'scrolls/wands/books_tomes/jewels_jewelry/cloaks_robes/boots_gloves/girdles_helms/bags_bottles/dusts_stones/items_tools/instruments/weird_stuff' );
	}

	public function acc_get_accouterment_list( $types, $chance, $restrict ) {
		$acc = array();
		foreach( $types as $type ) {
			$accouter = '';
			$possible = mt_rand( 1, 100 );
			if ( $possible <= $chance ) {
				$accouter = $this->acc_determine_accouterment( $type, $restrict );
				if ( $accouter ) {
					$acc[] = $accouter;
				}
			}
		}
		return $acc;
	}

	protected function acc_determine_accouterment( $type, $restrict ) {
		$acc = array();
		if ( strpos( $type, '/' ) ) {
			$acc = $this->acc_get_multi_table_accouterment( $type, $restrict );
		} else {
			$acc = $this->acc_get_table_accouterment( $type, $restrict );
		}
		if ( array_key_exists( 'restrict', $acc ) && ( strpos( $restrict, $acc['restrict'] ) === false ) ) {
			$acc = $this->acc_determine_accouterment( $type, $restrict );
		}
		return $acc;
	}

	protected function acc_get_multi_table_accouterment( $type ) {
		$types = explode( '/', $type );
		$count = count( $types );
		$roll  = mt_rand( 0, $count - 1 );
		return $this->acc_get_table_accouterment( $types[ $roll ] );
	}

	public function acc_get_table_accouterment( $type, $roll = false ) {
		$item = array( 'sub' => 'none' );
		$func = $this->get_sub_table_string( $type );
		if ( method_exists( $this, $func ) ) {
			$table = $this->$func();
			$item  = $this->generate_random_result( $table, $roll );
			$item['sub'] = $type;
		} else { echo "table '$func' not found\n"; }
		return $this->convert_item_to_object( $item );
	}


}
