<?php
/* Name: Wolf
 * Class: DND_Monster_Animal_Wolf_Wolf
 * Encounter: {"CC":{"M":"C","H":"C","F":"C","S":"U","P":"C","D":"U"},"CW":{"M":"U","H":"C","F":"C","S":"U","P":"C","D":"U"},"TC":{"M":"U","H":"C","F":"U","S":"U","P":"C","D":"U"},"TW":{"M":"U","H":"C","F":"C","S":"U","P":"C","D":"U"},"TSC":{"M":"U","H":"C","F":"C","S":"U","P":"C","D":"U"},"TSW":{"M":"U","H":"C","F":"C","S":"U","P":"C","D":"U"}}
 */

class DND_Monster_Animal_Wolf_Wolf extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 2, 10, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 4, 1 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
	protected $hit_dice     = 2;
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_points   = 0;
	protected $hp_extra     = 2;
	protected $in_lair      = 10;
#	protected $initiative   = 1;
	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 18 );
	protected $name         = 'Wolf';
#	protected $psionic      = 'Nil';
	protected $race         = 'Wolf';
	protected $reference    = 'Monster Manual page 99';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'These carnivores are found in wild forests from the arctic to the temperate zones. They always hunt in packs and if hungry (75%) they will not hesitate to follow and attack prey, always seeking to strike at an unguarded moment. Their howling is 50% likely to panic herbivores which are not being held by humans and calmed. They love horsemeat. If encountered in their lair there is a 30% chance that there will be 1-4 cubs per pair of adult wolves. Cubs do not fight and can be trained as war dogs or hunting beasts.';
	}


}
