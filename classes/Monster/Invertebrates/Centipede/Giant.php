<?php
/* Name: Giant Centipede
 * Class: DND_Monster_Invertebrates_Centipede_Giant
 * Encounter: {"CC":{"M":"VR","H":"VR","F":"C","S":"C","P":"C","D":"VR"},"CW":{"M":"VR","H":"VR","F":"C","S":"C","P":"C","D":"VR"},"TC":{"M":"VR","H":"VR","F":"C","S":"C","P":"C","D":"VR"},"TW":{"M":"VR","H":"VR","F":"C","S":"C","P":"C","D":"VR"},"TSC":{"M":"VR","H":"VR","F":"C","S":"C","P":"C","D":"VR"},"TSW":{"M":"VR","H":"VR","F":"C","S":"C","P":"C","D":"VR"}}
 */

class DND_Monster_Invertebrates_Centipede_Giant extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 2, 12, 0 );
	protected $armor_class  = 9;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 0, 0, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 2;
	protected $hit_dice     = 1;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Giant Centipede';
#	protected $psionic      = 'Nil';
	protected $race         = 'Centipede';
	protected $reference    = 'Monster Manual page 13';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Small (1' long)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'These nasty creatures are found nearly everywhere. They are aggressive and rush forth to bite their prey, injecting poison into the wound, but in many cases this poison is weak and not fatal (add +4 to saving throw die roll). Also, as the centipede is small, it is less likely to resist attacks which allow it a saving throw (-1 on die). Centipedes come in many colors - pale gray to black, red to brown.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['poison'] = 'Bite causes no damage, but is poisonous (ST+4)';
		$this->specials['saving'] = 'Giant centipede saves are at -1.';
		add_filter( 'character_Poison_saving_throws', [ $this, 'poison_bite_saving_throw' ], 10, 3 );
		add_filter( 'monster_Poison_saving_throws',   [ $this, 'poison_bite_saving_throw' ], 10, 3 );
		add_filter( 'Giant_Centipede_all_saving_throws', [ $this, 'giant_centipede_saving_throws' ], 10, 2 );
	}

	public function poison_bite_saving_throw( $roll, $target, $origin ) {
		if ( $origin === $this ) {
			$roll -= 4;
		}
		return $roll;
	}

	public function giant_centipede_saving_throws( $roll, $target ) {
		if ( $target === $this ) {
			$roll += 1;
		}
		return $roll;
	}


}
