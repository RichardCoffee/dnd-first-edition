<?php
/* Name: Troll
 * Class: DND_Monster_Troll_Troll
 * Encounter: {"CC":{"M":"R","H":"R","F":"U","S":"U","P":"R","D":"R"},"CW":{"M":"R","H":"R","F":"U","S":"U","P":"R","D":"R"},"TC":{"M":"R","H":"R","F":"U","S":"U","P":"R","D":"R"},"TW":{"H":"R","F":"U","S":"U","P":"R","D":"R"},"TSC":{"M":"R","H":"R","F":"U","S":"U","P":"R","D":"R"},"TSW":{"M":"R","H":"R","F":"U","S":"U","P":"R","D":"R"}}
 */

class DND_Monster_Troll_Troll extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
	protected $alignment    = 'Chaotic Evil';
	protected $appearing    = array( 1, 12, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Claw Right' => [ 1, 4, 4 ], 'Claw Left' => [ 1, 4, 4 ], 'Bite' => [ 2, 6, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
	protected $hp_extra     = 6;
	protected $in_lair      = 40;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Troll';
#	protected $psionic      = 'Nil';
	protected $race         = 'Troll';
	protected $reference    = 'Monster Manual page 95';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
	protected $size         = "L (9'+ tall)";
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
	protected $treasure     = 'D';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array( 0, 0, 0, 0 );
	protected $extra        = array( 'regen' => 0 );

	public function __construct( $args = array() ) {
		parent::__construct( $args );
		add_action( 'dnd1e_new_seg_enemy', [ $this, 'troll_regeneration' ], 10, 2 );
	}

	protected function determine_hit_dice() {
		$this->hit_dice = 6;
		$this->description = "Troll hide is a nauseating moss green, mottled green and gray, or putrid gray. The writhing hair-like growth upon a troll's head is greenish black or iron gray. The eyes of a troll are dull black.";
	}

	protected function determine_specials() {
		$this->specials = array(
			'attitude' => 'Knows no fear and attacks unceasingly.',
			'senses'   => "90' Infravision",
			'defense'  => 'Regenerates 3 hp per round, begins 3 rounds after taking damage.',
		);
	}

	public function assign_damage( $damage, $segment, $type = '' ) {
		parent::assign_damage( $damage, $segment, $type );
		if ( $this->extra['regen'] === 0 ) $this->extra['regen'] = $segment;
	}

	public function troll_regeneration( $combat, $target ) {
		if ( $this === $target ) {
			if ( $this->extra['regen'] && ( $this->current_hp < $this->hit_points ) ) {
				$diff = $combat->segment - $this->extra['regen'];
				if ( ( $diff > 29 ) && ( ( $diff % 10 ) === 0 ) ) {
					$delta = min( 3, ( $this->hit_points - $this->current_hp ) );
					$this->current_hp += $delta;
					if ( $this->current_hp === $this->hit_points ) {
						$this->extra['regen'] = 0;
					}
				}
			}
		}
	}


}
