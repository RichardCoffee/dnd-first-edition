<?php
/* Name: Slicer Beetle
 * Class: DND_Monster_Invertebrates_Beetle_Slicer
 * Encounter: {"TW":{"H":"VR","F":"R","S":"VR","P":"R"}}
 */

class DND_Monster_Invertebrates_Beetle_Slicer extends DND_Monster_Invertebrates_Beetle_Beetle {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 3, 0 );
#	protected $armor_class  = 3;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 8, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
	protected $in_lair      = 25;
#	protected $initiative   = 1;
#	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 6 );
	protected $name         = 'Giant Slicer Beetle';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Beetle';
	protected $reference    = 'Monster Manual II page 17-18';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $size         = 'Large';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 275, 6, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = "The slicer beetle issimilar to a stag beetle(MM 17) but does not have horns. Its mandibles are razor-sharp. When attacking, a roll of 1 9 or 2 0 indicates that it has nipped off an opponent's arm or leg. If the battle is going against the slicer beetle, it will grab any food conveniently available (i.e., lost limbs) and flee. It's lair usually contains many bones and 1d6 types of normal weaponry. The lair may also contain magical weapons (25% chance) or magical boots (10% chance). However, if a pair of boots or gauntlets is present, the pair is probably not matched (only a 5% chance). Attempts at identifying an unmatched set will give standard (but false) results.

The effects of non-matching boots or gauntlets can be unpredictable. These effects will not commence until the wearer is engaged in an encounter, adventure, or other normal but potentially dangerous activity. Each boot alone will perform as follows:

Dancing:       1 foot taps and shuffles.
Elvenkind:     1 foot tip-toes.
Levitation:    1 side of the body tends to rise.
Speed:         1 foot takes 2 steps to the other's 1.
Striding       1 foot either goose steps or makes hops
and springing:   of 3-4 feet.

Each gauntlet alone will perform as follows:

Dexterity:    1 hand tends to attempt pocket-picking (with
                 base 50% chance of success).
Fumbling:     1 hand tends to drop things (50% chance).
Ogre power:   1 hand sloppily uses more force than intended;
                 if in combat, no strength modifiers will apply.
Swimming
and climbing: 1 hand tends to wave about randomly.

";
	}


}
