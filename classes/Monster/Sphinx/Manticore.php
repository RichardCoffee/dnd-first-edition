<?php
/* Name: Manticore
 * Class: DND_Monster_Sphinx_Manticore
 * Encounter: {"CW":{"M":"U","H":"VR","F":"U","S":"VR","P":"VR","D":"VR"},"TW":{"M":"U","H":"VR","F":"U","S":"VR","D":"VR"},"TSW":{"M":"U","H":"VR","F":"U","S":"VR","P":"VR","D":"VR"},"CF":{"S":"VR"},"CS":{"S":"VR"},"TF":{"S":"VR"},"TS":{"S":"VR"},"TSF":{"S":"VR"},"TSS":{"S":"VR"}}
 */

class DND_Monster_Sphinx_Manticore extends DND_Monster_Monster {


	protected $alignment    = 'Lawful Evil';
	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 3, 0 ], 'Claw Left' => [ 1, 3, 0 ], 'Bite' => [ 1, 8, 0 ], 'Special' => [ 1, 6, 0 ] );
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
	protected $hp_extra     = 3;
	protected $in_lair      = 20;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
	protected $movement     = array( 'foot' => 12, 'air' => 18 );
	protected $name         = 'Manticore';
#	protected $psionic      = 'Nil';
	protected $race         = 'Sphinx';
	protected $reference    = 'Monster Manual page 65';
#	protected $resistance   = 'Standard';
	protected $size         = 'Large';
#	protected $specials     = array();
	protected $treasure     = 'E';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->hit_dice = 6;
		$this->description = 'The coloration of the manticore is that of its various parts - lion-colored body, bat-brown wings, human flesh head.';
	}

	protected function determine_specials() {
		$this->specials = array(
			'attack' => 'Tail spines: Can fire four volleys of six bolts each.',
		);
	}

	protected function determine_attack_types() {
		parent::determine_attack_types();
		$this->att_types['Special']['attacks'] = [ 6, 1 ];
	}

	protected function get_modified_weapon_type( $type ) {
		$type = parent::get_modified_weapon_type( $type );
		return ( $type === 'Special' ) ? 'Crossbow,Light' : $type;
	}


}
