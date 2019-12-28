<?php
/* Name: Warthog
 * Class: DND_Monster_Animal_Boar_Warthog
 * Encounter: {"TW":{"H":"R","F":"C","S":"R","P":"C"},"TSW":{"H":"R","F":"C","S":"R"}}
 */

class DND_Monster_Animal_Boar_Warthog extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 6, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Tusk Right' => [ 2, 4, 0 ], 'Tusk Left' => [ 2, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 3;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Warthog';
#	protected $psionic      = 'Nil';
	protected $race         = 'Boar';
	protected $reference    = 'Monster Manual page 10';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Medium (2 1/2' at shoulder)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'These tropical beasts are aggressive only if their territory is threatened or if cornered or threatened. They make two slashing attacks with their large tusks. Male and female fight equally. If 3-6 are encountered the balance will be young (1-2 hit dice, 1-3/2-5 hit points damage/attack). The warthog will continue to fight for 1-2 melee rounds after reaching 0 to -5 hit points but at -6 or greater damage dies immediately.';
	}

	public function get_number_appearing() {
		$num  = parent::get_number_appearing();
		if ( $num > 1 ) {
			$num--;
			$sows = ceil( $num / 5 );
			$enemy = array();
			for( $i = 1; $i <= $sows; $i++ ) {
				$enemy[] = new DND_Monster_Animal_Boar_Warthog;
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
