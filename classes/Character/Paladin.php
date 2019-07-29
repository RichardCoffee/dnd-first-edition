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



	public function __construct( $args = array() ) {
		parent::__construct( $args );
		add_filter( 'monster_to_hit_character', [ $this, 'protection_from_evil_to_hit' ], 10, 3 );
		$filter = $this->get_name() . '_all_saving_throws';
		add_filter( $filter, [ $this, 'protection_from_evil_saving_throw' ], 10, 3 );
	}

	public function initialize_character() {
		if ( empty( $this->cleric ) ) {
			$this->cleric = new DND_Character_Cleric( [ 'level' => $this->level ] );
		}
		parent::initialize_character();
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

	public function special_string_undead( $type, $level = 0 ) {
		return $this->cleric->special_string_undead( $type, $this->level - 2 );
	}

	public function get_undead_caps( $level = 0 ) {
		return $this->cleric->get_undead_caps( $this->level - 2 );
	}

	public function protection_from_evil_to_hit( $number, $monster, $target ) {
		if ( $this->protection_from_evil_judgement( $monster, $target ) ) {
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
		$judgement = false;
		if ( ! ( strpos( $monster->alignment, 'Evil' ) === false ) ) {
			if ( $this->name === $target->name ) {
				$judgement = true;
			}
		}
		return $judgement;
	}


}
