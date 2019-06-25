<?php

trait DND_Character_Trait_Armor {

	protected function get_armor_class_value( $armor ) {
		$table = array(
			'banded'       => 4,
			'bracers ac7'  => 7,
			'bracers ac6'  => 6,
			'bracers ac5'  => 5,
			'bracers ac4'  => 4,
			'bracers ac3'  => 3,
			'bracers ac2'  => 2,
			'bronze plate' => 4,
			'chain'        => 5,
			'elfin chain'  => 5,
			'field plate'  => 2,
			'full plate'   => 1,
			'leather'      => 8,
			'padded'       => 8,
			'plate mail'   => 3,
			'ring'         => 7,
			'scale'        => 6,
			'splint'       => 4,
			'studded'      => 7
		);
		$ac = 10;
		$armor = strtolower $armor );
		if ( isset( $table[ $armor ] ) ) {
			$ac = $table[ $armor ];
		}
		return $ac;
	}


}
