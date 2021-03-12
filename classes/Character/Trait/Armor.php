<?php

trait DND_Character_Trait_Armor {


	protected $armor  = array( 'armor' => 'none', 'bonus' => 0, 'type' => 10, 'class' => 10, 'flank' => 10, 'rear' => 10, 'spell' => 10 );
	protected $shield = array( 'type' => 'none', 'bonus' => 0, 'size' => 'none', 'hits' => 0 );


	public function determine_armor_class() {
		$shield_type = apply_filters( 'dnd1e_shield_type', $this->shield['type'], $this );
		$no_shld     = ( $shield_type === 'none' ) || in_array( $this->weapon['attack'], $this->get_weapons_not_allowed_shield() );
		$no_shld     = apply_filters( 'dnd1e_has_no_shield', $no_shld, $this );
		$armor_armor = apply_filters( 'dnd1e_armor_armor', $this->armor['armor'], $this );
		$armor_type  = $this->get_armor_ac_value( $armor_armor );
		$arm_bonus   = apply_filters( 'dnd1e_armor_bonus', $this->armor['bonus'], $this );
		$ac_adj      = apply_filters( 'dnd1e_armor_class_adj', 0, $this );
		$shld_bonus  = apply_filters( 'dnd1e_shield_bonus', $this->shield['bonus'], $this );
		$dex_bonus   = $this->get_ac_dex_bonus();
echo "dac:".$this->get_key().":$armor_armor:T$armor_type:B$arm_bonus:A$ac_adj:S$no_shld:T$shield_type:B$shld_bonus:D$dex_bonus\n";
		$this->armor['type']  = $armor_type - ( ( $no_shld ) ? 0 : 1 );
		$this->armor['class'] = $this->armor['type'] - $arm_bonus - $ac_adj - ( ( $no_shld ) ? 0 : $shld_bonus );
		$this->armor['spell'] = $this->armor['class'];
		$this->armor['class']+= $dex_bonus;
		$this->armor['flank'] = $armor_type - $ac_adj - $arm_bonus + $dex_bonus;
		$this->armor['rear']  = $armor_type - $ac_adj - $arm_bonus;
#print_r($this->armor);
	}

	public function get_armor_type() {
		return $this->armor['type'];
	}

	public function get_armor_class() {
		return $this->armor['class'];
	}

	public function get_armor_flank() {
		return $this->armor['flank'];
	}

	public function get_armor_rear() {
		return $this->armor['rear'];
	}

	public function get_armor_spell() {
		return $this->armor['spell'];
	}

	private function armor_get_armor_table() {
		$table = array(
			'banded'      => [ 'name' => 'Banded Mail',             'ac' =>  4, 'bulk' => 'bulky',  'weight' => 35, 'move' => 9,  'cost' =>    90 ],
			'bracers ac7' => [ 'name' => 'Bracers of Defense AC 7', 'ac' =>  7, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' =>  9000 ],
			'bracers ac6' => [ 'name' => 'Bracers of Defense AC 6', 'ac' =>  6, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 12000 ],
			'bracers ac5' => [ 'name' => 'Bracers of Defense AC 5', 'ac' =>  5, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 15000 ],
			'bracers ac4' => [ 'name' => 'Bracers of Defense AC 4', 'ac' =>  4, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 18000 ],
			'bracers ac3' => [ 'name' => 'Bracers of Defense AC 3', 'ac' =>  3, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 21000 ],
			'bracers ac2' => [ 'name' => 'Bracers of Defense AC 2', 'ac' =>  2, 'bulk' => 'non-',   'weight' => 5,  'move' => 12, 'cost' => 24000 ],
			'brigandine'  => [ 'name' => 'Brigandine Mail',         'ac' =>  6, 'bulk' => 'fairly', 'weight' => 40, 'move' => 6,  'cost' =>    45 ],
			'bronze'      => [ 'name' => 'Bronze Plate Mail',       'ac' =>  4, 'bulk' => 'bulky',  'weight' => 45, 'move' => 6,  'cost' =>   100 ],
			'chain'       => [ 'name' => 'Chain Mail',              'ac' =>  5, 'bulk' => 'fairly', 'weight' => 30, 'move' => 9,  'cost' =>    75 ],
			'elfin'       => [ 'name' => 'Elfin Chain Mail',        'ac' =>  5, 'bulk' => 'non-',   'weight' => 15, 'move' => 12, 'cost' => 'n/a' ],
			'field'       => [ 'name' => 'Field Plate Armor',       'ac' =>  2, 'bulk' => 'fairly', 'weight' => 55, 'move' => 6,  'cost' =>  2000 ],
			'full'        => [ 'name' => 'Full Plate Armor',        'ac' =>  1, 'bulk' => 'fairly', 'weight' => 65, 'move' => 6,  'cost' =>  4000 ],
			'leather'     => [ 'name' => 'Leather Armor',           'ac' =>  8, 'bulk' => 'non-',   'weight' => 15, 'move' => 12, 'cost' =>     5 ],
			'none'        => [ 'name' => 'no armor',                'ac' => 10, 'bulk' => 'non-',   'weight' =>  0, 'move' => 12, 'cost' => 'n/a' ],
			'padded'      => [ 'name' => 'Padded Armor',            'ac' =>  8, 'bulk' => 'fairly', 'weight' => 10, 'move' => 9,  'cost' =>     4 ],
			'plate'       => [ 'name' => 'Plate Mail',              'ac' =>  3, 'bulk' => 'bulky',  'weight' => 45, 'move' => 6,  'cost' =>   400 ],
			'ring'        => [ 'name' => 'Ring Mail',               'ac' =>  7, 'bulk' => 'fairly', 'weight' => 25, 'move' => 9,  'cost' =>    30 ],
			'scale'       => [ 'name' => 'Scale Mail',              'ac' =>  6, 'bulk' => 'fairly', 'weight' => 40, 'move' => 6,  'cost' =>    45 ],
			'splint'      => [ 'name' => 'Splint Mail',             'ac' =>  4, 'bulk' => 'bulky',  'weight' => 40, 'move' => 6,  'cost' =>    80 ],
			'studded'     => [ 'name' => 'Studded Leather Armor',   'ac' =>  7, 'bulk' => 'fairly', 'weight' => 20, 'move' => 9,  'cost' =>    15 ],
		);
		return $table;
	}

	protected function get_armor_info( $armor ) {
		$armor = strtolower( $armor );
		$info  = false;
		$table = $this->armor_get_armor_table();
		if ( array_key_exists( $armor, $table ) ) {
			$info = $table[ $armor ];
		}
		return $info;
	}

	private function get_armor_trait_value( $armor, $trait ) {
		static $table = null;
		if ( ! $table ) $table = $this->armor_get_armor_table();
		$value = "Armor $armor not found in armor table.";
		$split = ( strpos( $armor, 'Bracers' ) === false ) ? explode( ' ', $armor ) : array( $armor );
		$armor = strtolower( $split[0] );
		if ( array_key_exists( $armor, $table ) ) {
			$value = "$armor trait $trait not found in armor table.";
			$trait = strtolower( $trait );
			if ( array_key_exists( $trait, $table[ $armor ] ) ) {
				$value = $table[ $armor ][ $trait ];
			}
		}
		return $value;
	}

	public function get_armor_proper_name( $armor ) {
		return $this->get_armor_trait_value( $armor, 'name' );
	}

	protected function get_armor_ac_value( $armor, $force = false ) {
		$ac = $this->get_armor_trait_value( $armor, 'ac' );
		if ( ( ! $force ) && $this instanceOf DND_Monster_Humanoid_Humanoid ) {
			$ac = min( $ac, $this->armor_type );
		}
		return apply_filters( 'dnd1e_armor_type', $ac, $this );
	}

	protected function get_armor_bulk( $armor ) {
		return $this->get_armor_trait_value( $armor, 'bulk' );
	}

	private function get_armor_weight( $armor ) {
		return $this->get_armor_trait_value( $armor, 'weight' );
	}

	protected function get_armor_base_movement( $armor ) {
		return $this->get_armor_trait_value( $armor, 'move' );
	}

	private function get_armor_base_cost( $armor ) {
		return $this->get_armor_trait_value( $armor, 'cost' );
	}


}
