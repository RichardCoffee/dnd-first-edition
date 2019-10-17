<?php
/* Name: Huge Centipede
 * Class: DND_Monster_Invertebrates_Centipede_Huge
 * Encounter: {
"CC":{"M":"U","H":"U","F":"C","S":"C","P":"C","D":"U"},
"CW":{"M":"U","H":"U","F":"C","S":"C","P":"C","D":"U"},
"TC":{"M":"U","H":"U","F":"C","S":"C","P":"C","D":"U"},
"TW":{"M":"U","H":"U","F":"C","S":"C","P":"C","D":"U"},
"TSC":{"M":"U","H":"U","F":"C","S":"C","P":"C","D":"U"},
"TSW":{"M":"U","H":"U","F":"C","S":"C","P":"C","D":"U"}
}
 */

class DND_Monster_Invertebrates_Centipede_Huge extends DND_Monster_Invertebrates_Centipede_Giant {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 5, 6, 0 );
#	protected $armor_class  = 9;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 0, 0, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 1;
#	protected $hit_dice     = 1;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 21 );
	protected $name         = 'Huge Centipede';
#	protected $psionic      = 'Nil';
	protected $race         = 'Centipede';
	protected $reference    = 'Monster Manual II page 24';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Small (6" long)';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 31, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'Huge centipedes are simply smaller versions of giant centipedes.  They conform in most respects to their larger counterparts, including having a weak poison which allows a +4 on saves vs. its effects. However, due to their smaller size, failure to save vs. poison results in the victim taking 4d4 points of damage rather than death.  Huge centipedes make saving throws at -2.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['poison'] = 'Bite is poisonous (ST+4).  Victim takes 4d4 damage when saving.';
		$this->specials['saving'] = 'Huge centipede saves are at -2.';
		add_filter( 'Huge_Centipede_all_saving_throws', [ $this, 'huge_centipede_saving_throws' ], 10, 2 );
	}

	public function huge_centipede_saving_throws( $roll, $target ) {
		if ( $target === $this ) {
			$roll += 1;
		}
		return $roll;
	}


}
