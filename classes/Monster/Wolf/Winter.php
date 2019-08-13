<?php
/* Name: Winter Wolf
 * Class: DND_Monster_Wolf_Winter
 * Encounter: {"CW":{"M":"VR","H":"VR","F":"VR","S":"VR"}}
 */

class DND_Monster_Wolf_Winter extends DND_Monster_Wolf_Dire {

	protected $alignment    = 'Neutral Evil';
	protected $appearing    = array( 2, 4, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
#	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Very Rare';
	protected $hit_dice     = 6;
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_points   = 0;
	protected $hp_extra     = 0;
#	protected $in_lair      = 10;
#	protected $initiative   = 1;
	protected $intelligence = 'Average';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 18 );
	protected $name         = 'Winter Wolf';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Wolf';
#	protected $reference    = 'Monster Manual page 99';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Large';
#	protected $specials     = array();
	protected $treasure     = 'I';
#	protected $xp_value     = array( 0, 0, 0, 0 );

	protected function determine_hit_dice() {
		$this->description = 'The winter wolf is a horrid carnivore which inhabits only chill regions. It is of great size and foul disposition. Winter wolves can use their savage jaws or howl forth a blast of frost which will coat any creature within 10 feet of their muzzle. This frost causes 6d4 hit points damage - half that amount if a saving throw versus dragon breath is successful. The winter wolf is able to use the howling frost but once per 10 melee rounds.  Cold-based attacks do not harm them, but fire-based attacks cause +1 per die of damage normally caused. They have their own language and can also converse with worgs. The coat of the winter wolf is glistening white or silvery, and its eyes are very pale blue or silvery. The pelt of the creature is valued at 5,000 gold pieces.';
	}

}
