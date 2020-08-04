<?php

trait DND_Character_Trait_Undead {


	protected $undead = array();


	public function special_string_undead( $type, $level = 0 ) {
		$response = 'Unknown';
		$type  = ucfirst( $type );
		$level = $this->calc_level_vs_undead( $level );
		if ( $level > 0 ) {
			$undead = $this->get_undead_table();
			if ( array_key_exists( $type, $undead ) ) {
				$foe = $undead[ $type ];
				if ( array_key_exists( $level, $foe ) ) {
					$response = $foe[ $level ];
				} else {
					$response = array_pop( $foe );
				}
			}
		}
		return $response;
	}

	public function get_undead_caps( $level = 0 ) {
		$caps  = array();
		$level = $this->calc_level_vs_undead( $level );
		if ( $level > 0 ) {
			$undead = $this->get_undead_table();
			foreach( $undead as $yuch => $turn ) {
				if ( array_key_exists( $level, $turn ) ) {
					$caps[ $yuch ] = $turn[ $level ];
				} else {
					$caps[ $yuch ] = array_pop( $turn );
				}
			}
		}
		return $caps;
	}

	protected function calc_level_vs_undead( $level ) {
		return ( ( $level === 0 ) ? $this->level : $level ) + apply_filters( 'dnd1e_cleric_level_bonus', 0, $this );
	}

	protected function get_undead_table() {
		return array(
			'Skeleton' => array(  13,    10,     7,     4,    'T',   'T',   'D',   'D',  'D*' ),
			'Zombie'   => array(  16,    13,    10,     7,    'T',   'T',   'D',   'D',  'D', 'D*' ),
			'Ghoul'    => array(  19,    16,    13,    10,     4,    'T',   'T',   'D',  'D', 'D', 'D', 'D', 'D', 'D*' ),
			'Shadow'   => array(  20,    19,    16,    13,     7,     4,    'T',   'T',  'D', 'D', 'D', 'D', 'D', 'D', 'D*' ),
			'Wight'    => array( 'N/A',  20,    19,    16,    10,     7,     4,    'T',  'T', 'D' ),
			'Ghast'    => array( 'N/A', 'N/A',  20,    19,    13,    10,     7,     4,   'T', 'T', 'T', 'T', 'T', 'T', 'D' ),
			'Wraith'   => array( 'N/A', 'N/A', 'N/A',  20,    16,    13,    10,     7,    4,  'T', 'T', 'T', 'T', 'T', 'D' ),
			'Mummy'    => array( 'N/A', 'N/A', 'N/A', 'N/A',  19,    16,    13,    10,    7,   4,   4,   4,   4,   4,  'T', 'T', 'T', 'T', 'T', 'D' ),
			'Spectre'  => array( 'N/A', 'N/A', 'N/A', 'N/A',  20,    19,    16,    13,   10,   7,   7,   7,   7,   7,   4,   4,   4,   4,   4,  'T' ),
			'Vampire'  => array( 'N/A', 'N/A', 'N/A', 'N/A', 'N/A',  20,    19,    16,   13,  10,  10,  10,  10,  10,   7,   7,   7,   7,   7,   4 ),
			'Ghost'    => array( 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A',  20,    19,   16,  13,  13,  13,  13,  13,  10,  10,  10,  10,  10,   7 ),
			'Lich'     => array( 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A',  20,   19,  16,  16,  16,  16,  16,  13,  13,  13,  13,  13,  10 ),
			'Special'  => array( 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 20,  19,  19,  19,  19,  19,  16,  16,  16,  16,  16,  13 ),
		);
	}


}
