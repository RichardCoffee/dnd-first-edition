<?php

class DND_Character_Druid extends DND_Character_Cleric {

	protected $ac_rows    = array( 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 12, 12, 13 );
	protected $alignment  = 'Neutral';
	protected $armr_allow = array( 'Leather', 'Padded' );
	protected $hit_die    = array( 'limit' => 15, 'size' => 8, 'step' => 1 );
	protected $non_prof   = -4;
	protected $shld_allow = array( 'Wooden' );
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 12, 'dex' => 3, 'con' => 3, 'chr' => 15 );
	protected $weap_allow = array( 'Aklys', 'Club', 'Dagger', 'Dagger,Thrown', 'Dart', 'Garrot', 'Hammer', 'Hammer,Thrown', 'Hammer,Lucern', 'Lasso', 'Sap', 'Scimitar', 'Sling', 'Spear', 'Spear,Thrown', 'Spell', 'Staff,Quarter', 'Staff Sling', 'Sword,Khopesh', 'Whip' );
	protected $weap_init  = array( 'initial' => 2, 'step' => 5 );
#	protected $weapons    = array( 'Spell' => array( 'bonus' => 0, 'Skill' => 'PF' ) );
	protected $xp_bonus   = array( 'wis' => 16, 'chr' => 16 );
	protected $xp_step    = 500000;
	protected $xp_table   = array( 0, 2000, 4000, 8000, 12000, 20000, 35000, 60000, 90000, 125000, 200000, 300000, 750000, 1500000, 3000000 );


	use DND_Character_Trait_Spells_Druid {
		get_druid_spell_table as get_spell_table;
		get_druid_description_table as get_description_table;
	}


	protected function define_specials() {
		$this->specials = array(
			'defense_fire-lightning' => '+2 ST vs fire and lightning',
		);
		add_filter( $this->get_key(1) . '_all_saving_throws', [ $this, 'special_defense_saving_throws' ], 10, 4 );
	}

	public function special_defense_saving_throws( $roll, $object, $origin, $cause ) {
		if ( in_array( $cause, [ 'electric', 'fire' ] ) ) {
			$roll -= 2;
		}
		return $roll;
	}


	/**  Manna functions  **/

	protected function spells_usable_table() {
		return array(
			array(),
			array( 2 ),          // 1
			array( 2, 1 ),       // 2
			array( 3, 2, 1 ),    // 3
			array( 4, 2, 2 ),    // 4
			array( 4, 3, 2 ),    // 5
			array( 4, 3, 2, 1 ), // 6
			array( 4, 4, 3, 1 ), // 7
			array( 4, 4, 3, 2 ), // 8
			array( 5, 4, 3, 2, 1 ),       //  9
			array( 5, 4, 3, 3, 2 ),       // 10
			array( 5, 5, 3, 3, 2, 1 ),    // 11
			array( 5, 5, 4, 4, 3, 2, 1 ), // 12
			array( 6, 5, 5, 5, 4, 3, 2 ), // 13
			array( 6, 6, 6, 6, 5, 4, 3 ), // 14
			array( 6, 6, 6, 6, 6, 6, 6 ), // 15
		);
	}


}
