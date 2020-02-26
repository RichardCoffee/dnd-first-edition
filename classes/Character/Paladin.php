<?php

class DND_Character_Paladin extends DND_Character_Fighter {

	protected $alignment  = 'Lawful Good';
	protected $armr_allow = array( 'Banded', 'Bronze Plate', 'Chain', 'Elfin Chain', 'Field Plate', 'Full Plate', 'Plate Mail', 'Ring', 'Scale', 'Splint' );
	private   $cleric     = null;
	protected $has_horse  = false;
	protected $hit_die    = array( 'limit' => 9, 'size' => 10, 'step' => 3 );
	protected $non_prof   = -3;
	protected $stats      = array( 'str' => 12, 'int' => 9, 'wis' => 13, 'dex' => 3, 'con' => 9, 'chr' => 17 );
	protected $weap_init  = array( 'initial' => 3, 'step' => 3 );
	protected $xp_bonus   = array( 'str' => 16, 'wis' => 16 );
	protected $xp_step    = 350000;
	protected $xp_table   = array( 0, 2750, 5500, 12000, 24000, 45000, 95000, 175000, 350000 );


	use DND_Character_Trait_Undead;


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		add_filter( 'dnd1e_to_hit_object', [ $this, 'protection_from_evil_to_hit' ], 10, 3 );
		$filter = $this->get_key(1) . '_all_saving_throws';
		add_filter( $filter, [ $this, 'protection_from_evil_saving_throw' ], 10, 3 );
		add_filter( $filter, [ $this, 'undead_level_adjustment' ], 10, 2 );
	}

	protected function initialize_character() {
		if ( empty( $this->cleric ) ) {
			$this->cleric = new DND_Character_Cleric( [ 'level' => $this->level ] );
		}
		parent::initialize_character();
		$this->undead = $this->get_undead_caps();
	}

	protected function calculate_level( $xp ) {
		$level = parent::calculate_level( $xp );
		$this->cleric->set_level( $level );
		return $level;
	}

	protected function define_specials() {
		$this->specials = array(
			'string_detect'  => $this->special_string_detect(),
			'string_immune'  => $this->special_string_immune(),
			'integer_heal'   => sprintf( 'Lay on hands: %u hp, once daily.', $this->special_integer_heal() ),
			'integer_cure'   => sprintf( 'Cure disease: %u per week.', $this->special_integer_cure() ),
			'string_protect' => $this->special_string_protect(),
		);
		if ( ( $this->level > 3 ) && ( ! $this->has_horse ) ) {
			$this->specials['boolean_warhorse'] = 'Summon Warhorse';
		}
		if ( $this->level > 2 ) {
			$this->specials = array_merge( $this->specials, $this->cleric->specials );
		}
	}

	private function special_string_detect() {
		return 'Detect evil up to 60 feet away.';
	}

	private function special_string_immune() {
		return 'Immune to disease.';
	}

	public function special_integer_heal() {
		return $this->level * 2;
	}

	public function special_integer_cure() {
		return intval( ceil( $this->level / 5 ) );
	}

	private function special_string_protect() {
		return "Protection from evil 10' radius";
	}

	public function special_boolean_warhorse() {
		return $this->has_horse;
	}

	public function undead_level_adjustment( $adj, $object ) {
		if ( $object === $this ) {
			$adj -= 2;
		}
		return $adj;
	}

	public function protection_from_evil_to_hit( $number, $origin, $target ) {
		if ( $this->protection_from_evil_judgement( $origin, $target ) ) {
			$number += 2;
		}
		return $number;
	}

	public function protection_from_evil_saving_throw( $number, $target, $monster ) {
		if ( $this->protection_from_evil_judgement( $monster, $target ) ) {
			$number -= 2;
		}
		return $number;
	}

	private function protection_from_evil_judgement( $monster, $target ) {
		if ( $this === $target ) {
			if ( ! ( strpos( $monster->alignment, 'Evil' ) === false ) ) {
				return true;
			}
		}
		return false;
	}


/**  Manna functions  **/

	protected function spells_usable_table() {
		return array(
			array( 1 ),    //  9
			array( 2 ),    // 10
			array( 2, 1 ), // 11
			array( 2, 2 ), // 12
			array( 2, 2, 1 ),    // 13
			array( 3, 2, 1 ),    // 14
			array( 3, 2, 1, 1 ), // 15
			array( 3, 3, 1, 1 ), // 16
			array( 3, 3, 2, 1 ), // 17
			array( 3, 3, 3, 1 ), // 18
			array( 3, 3, 3, 2 ), // 19
			array( 3, 3, 3, 3 ), // 20
		);
	}


}
