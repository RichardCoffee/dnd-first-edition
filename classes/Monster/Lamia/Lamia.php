<?php
/* Name: Lamia
 * Class: DND_Monster_Lamia_Lamia
 * Encounter: {"TW":{"D":"VR"},"TSW":{"D":"VR"}}
 */

class DND_Monster_Lamia_Lamia extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
	protected $alignment    = 'Chaotic Evil';
	protected $appearing    = array( 1, 1, 0 );
	protected $armor_class  = 3;
#	protected $armor_type   = 11;      // DND_Monster_Trait_Combat
	protected $attacks      = array( 'Dagger' => [ 1, 4, 0 ], 'Spell' => [ 0, 0, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Very Rare';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 9;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $immune       = array();
	protected $in_lair      = 60;
#	protected $initiative   = 1;
	protected $intelligence = 'High';
#	protected $magic_user   = null;
#	protected $manna        = 0; // DND_Character_Trait_Magic
#	protected $manna_init   = 0; // DND_Character_Trait_Magic
	protected $movement     = array( 'foot' => 24 );
	protected $name         = 'Lamia';
#	protected $psionic      = 'Nil';
	protected $race         = 'Lamia';
	protected $reference    = 'Monster Manual page 58';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = "Medium";
#	protected $specials     = array();
#	protected $spell_table  = array();   // DND_Character_Trait_Magic
#	protected $spell_zero   = 'Cantrip'; // DND_Character_Trait_Magic
#	protected $spells       = array();   // DND_Character_Trait_Magic
#	protected $to_hit_row   = array();   // DND_Monster_Trait_Combat
	protected $treasure     = 'D';
#	protected $vulnerable   = array();
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );


	use DND_Character_Trait_Magic;
	use DND_Character_Trait_Spells_MagicUser;
	use DND_Character_Trait_Spells_Effects_MagicUser;


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->add_lamia_spells();
	}

	protected function determine_hit_dice() {
#		$this->hit_dice = 1;
		$this->description = 'Lamias prefer to dwell in deserts- in ruined cities, coves, or the like. Their upper torso, arms, and head resemble a human female, while their lower body is that of a beast. Lamias are very fast and powerful. They usually are armed with daggers.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['touch']  = 'Touch permanently drains 1 point of Wisdom';
		$this->specials['spells'] = 'Once per day: Charm Person, Mirror Image, Suggestion, Illusion (as a wand)';
	}

	protected function add_lamia_spells() {
		$list = array(
			'Charm Person',
			'Mirror Image',
			'Suggestion',
		);
		$this->import_spell_list( $list, 'MagicUser' );
	}

/*	protected function is_sequence_attack( $check ) {
		if ( $check === '' ) return false;
		return true;
	} //*/

/*	protected function non_sequence_chance( $segment ) {
		return 50;
	} //*/


}
