<?php
/* Name: Toad, Giant
 * Class: DND_Monster_Giant_Toad
 * Encounter: {"TC":{"M":"R","H":"R","F":"C","S":"C","P":"C","D":"R"},"TW":{"M":"R","H":"R","F":"C","S":"C","P":"C","D":"R"},"TSC":{"M":"R","H":"R","F":"C","S":"C","D":"R"},"TSW":{"M":"R","H":"R","F":"C","S":"C","P":"C","D":"R"}}
 */

class DND_Monster_Giant_Toad extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 12, 0 );
	protected $armor_class  = 6;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 8, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
	protected $hit_dice     = 2;
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_points   = 0;
	protected $hp_extra     = 4;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 6, 'hop' => 6 );
	protected $name         = 'Giant Toad';
#	protected $psionic      = 'Nil';
	protected $race         = 'Toad';
#	protected $reference    = 'Monster Manual page';
#	protected $resistance   = 'Standard';
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	public function __construct( $args = array() ) {
		add_action( 'monster_determine_specials', [ $this, 'toad_determine_specials' ] );
		parent::__construct( $args );
		$this->description = 'Giant toads are found in most regions. Although their smaller cousins are beneficial insect eaters, the large toads are prone to devour any creature which appears edible. All toads are capable of hopping their movement distance. This hop clears objects up to one-third the linear distance in height, and it requires but a single melee round to accomplish, and they can attack in mid-air or at the end of their leap.';
	}

	protected function determine_hit_dice() { }

	public function toad_determine_specials() {
		$this->specials['hop'] = "one 60' hop per round, in addition to normal movement.";
	}


}
