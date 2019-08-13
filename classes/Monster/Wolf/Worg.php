<?php
/* Name: Worg
 * Class: DND_Monster_Wolf_Worg
 * Encounter: {"CW":{"M":"R","H":"R","F":"R","S":"R","P":"VR","D":"VR"},"TW":{"M":"R","H":"R","F":"R","S":"R","P":"VR","D":"VR"},"TSW":{"M":"R","H":"R","F":"R","S":"R","P":"VR","D":"VR"}}
 */

class DND_Monster_Wolf_Worg extends DND_Monster_Wolf_Dire {

	protected $alignment    = 'Neutral Evil';
#	protected $appearing    = array( 3, 4, 0 );
#	protected $armor_class  = 6;
#	protected $armor_type   = 11;
#	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Rare';
	protected $hit_dice     = 4;
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_points   = 0;
	protected $hp_extra     = 4;
#	protected $in_lair      = 10;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 18 );
#	protected $name         = 'Worg';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Wolf';
#	protected $reference    = 'Monster Manual page 99';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );

	protected function determine_hit_dice() {
		$this->description = 'Evil natured, neo-dire wolves are known as worgs. These creatures have a language and are often found in co-operation with goblins in order to gain prey or to simply enjoy killing. They are as large as ponies and can be ridden. They otherwise conform to the characteristics of wolves.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['boolean_wolfwere'] = '53% chance of being accompanied by a wolfwere.';
	}

	public function specials_boolean_wolfwere() {
		return $this->check_chance( 52.5 );
	}

}
