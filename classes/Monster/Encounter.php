<?php

class DND_Monster_Encounter {


	use DND_Trait_Singleton;


	private function __construct() {
	}

	public function get_monster_list() { }

	public function get_monster_encounter( $terrain ) { }

	protected function get_monster_table() {
		return array(
			'Cooshee',
			'Dragon/Black',
			'Dragon/Blue',
			'Dragon/Brass',
			'Dragon/Bronze',
			'Dragon/Cloud',
			'Dragon/Copper',
			'Dragon/Faerie',
			'Dragon/Gold',
			'Dragon/Green',
			'Dragon/Mist',
			'Dragon/Red',
			'Dragon/Shadow',
/*|   |   |   |-- Silver.php
|   |   |   `-- White.php
|   |   |-- Giant
|   |   |   |-- Crane.php
|   |   |   |-- Lynx.php
|   |   |   |-- Spider.php
|   |   |   `-- Toad.php
|   |   |-- Humanoid
|   |   |   |-- Humanoid.php
|   |   |   `-- Jermlaine.php
|   |   |-- Hydra.php
|   |   |-- Lycan
|   |   |   |-- Lycan.php
|   |   |   `-- Wolf.php
|   |   |-- Monster.php
|   |   |-- Rat.php
|   |   |-- Sphinx
|   |   |   `-- Manticore.php
|   |   |-- Spider
|   |   |   |-- Giant.php
|   |   |   `-- Spider.php*/
		);
	}

	protected function region_key_table() {
		return array(
			'CW'  => 'Cold Wilderness',
			'CC'  => 'Cold Civilized',
			'TW'  => 'Temperate Wilderness',
			'TC'  => 'Temperate Civilized',
			'TSW' => 'Tropical and Subtropical Wilderness',
			'TSC' => 'Tropical and Subtropical Civilized',
		);
	}

	protected function terrain_key_table() {
		return array(
			'M'  => 'Mountains',
			'HR' => 'Hills/Rough',
			'F'  => 'Forest',
			'SM' => 'Swamp/Marsh',
			'PS' => 'Plains/Scrub',
			'D'  => 'Desert',
		);
	}


}
