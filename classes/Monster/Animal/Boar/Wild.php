<?php
/* Name: Wild Boar
 * Class: DND_Monster_Animal_Boar_Wild
 * Encounter: {"CC":{"H":"R","F":"C","S":"R","P":"C","D":"R"},"CW":{"H":"R","F":"C","S":"R","P":"C","D":"R"},"TC":{"H":"R","F":"C","S":"R","P":"C","D":"R"},"TW":{"H":"R","F":"C","S":"R","P":"C","D":"R"},"TSC":{"H":"R","F":"C","S":"R","P":"C","D":"R"},"TSW":{"H":"R","F":"C","S":"R","P":"C","D":"R"}}
 */

class DND_Monster_Animal_Boar_Wild extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 12, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 3, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 3;
#	protected $hit_points   = 0;
	protected $hp_extra     = 3;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Wild Boar';
#	protected $psionic      = 'Nil';
	protected $race         = 'Boar';
	protected $reference    = 'Monster Manual page 10';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Medium (3' at shoulder)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'If more than 1 is encountered the others will be sows (3 hit dice, 2-8 hit points damage/attack), on a 1 :4, sows: sounders, ratio. Thus if 12 are encountered there will be 1 boar, 3 sows, and 8 young. The boar will fight for 2-5 melee rounds after reaching 0 to -6 hit points but dies immediately at -7 or greater damage.';
	}

	public function get_number_appearing() {
		$num  = parent::get_number_appearing();
		if ( $num > 1 ) {
			$num--;
			$sows = ceil( $num / 5 );
			$enemy = array();
			for( $i = 1; $i <= $sows; $i++ ) {
				$enemy[] = new DND_Monster_Animal_Boar_Sow;
			}
			$num -= $sows;
			for( $i = 1; $i <= $num ; $i++ ) {
				$enemy[] = new DND_Monster_Animal_Boar_Sounder;
			}
			return $enemy;
		}
		return $num;
	}


}
