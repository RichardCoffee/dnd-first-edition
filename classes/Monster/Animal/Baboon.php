<?php
/* Name: Baboon
 * Class: DND_Monster_Animal_Baboon
 * Encounter: {"TW":{"H":"R","F":"C","S":"R","P":"C","D":"R"}}
 */

class DND_Monster_Animal_Baboon extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 10, 4, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
	protected $hp_extra     = 1;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Baboon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Baboon';
	protected $reference    = 'Monster Manual page 7';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Small (4'+ tall)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Baboons are basically herbivorous, group animals. The tribe will be led by 2-8 large males ( + 1 hit point damage on attacks). Half of the tribe will be young which will not attack. If the home territory of a tribe is invaded the baboons will attempt to drive the invaders off, but it is 90% likely that the tribe will flee if faced by determined resistance.';
	}

	protected function determine_specials() {
		parent::determine_specials();
#		$this->specials['index'] = 'Special Attack';
	}


}
