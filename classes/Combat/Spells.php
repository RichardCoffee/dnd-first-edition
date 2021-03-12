<?php

trait DND_Combat_Spells {


	protected $casting = array();


	/**  Casting functions  **/

	protected function pre_cast_spell( $name, $spell, $target = false ) {
		if ( $this->segment > 1 ) {
			$this->messages[] = "Cannot pre-cast after segment 1.";
			return false;
		}
		if ( $effect = $this->start_casting( $name, $spell, $target ) ) {
			$effect->set_pre_cast();
			$this->finish_casting( $effect );
			$this->remove_casting( $effect->get_caster() );
			return $effect;
		}
		return false;
	}

	protected function start_casting( $name, $spell, $target = false ) {
		$object = $this->get_object( $name );
		if ( is_object( $object ) ) {
			$name = $object->get_key();
			$sequence = $object->get_attack_sequence( $this->rounds, $object->weapon );
			if ( ( ! dnd1e()->called_by( 'pre_cast_spell' ) ) && ( ! in_array( $this->segment, $sequence ) ) ) {
				$this->messages[] = "$name must wait until his/her attack segment before casting a spell.";
			} else if ( is_object( $spell ) ) {
				$this->remove_holding( $name );
				$this->change_weapon( $object, 'Spell', true );
				if ( ( ( $target === false ) || ( $target === null ) ) && ( $spell->get_target() === 'required' ) ) {
					$this->messages[] = "Spell '" . $spell->get_name() . "' missing required target.";
				} else {
					$target = ( ( $target === false ) || ( $target === null ) ) ? $name : $this->get_object( $target );
					if ( $spell->check( $object, $target, $this ) ) {
						$spell->set_target( $target );
						$spell->set_when( $this->segment );
						$this->casting[]  = $spell;
						$this->messages[] = sprintf( '%s casting %s on %s', $name, $spell->get_name(), $spell->get_target() );
						$this->check_special_casting( $spell );
						return $spell;
					}
				}
			}
		}
		return false;
	}

	protected function is_casting( $caster ) {
		if ( empty( $this->casting ) ) return false;
		return $this->find_casting( $caster );
	}

	protected function find_casting( $caster ) {
		foreach( $this->casting as $spell ) {
			if ( $spell->get_caster() === $caster ) {
				return $spell;
			}
		}
		return false;
	}

	protected function process_spell_data( $caster, $data ) {
		$object = $this->get_object( $caster );
		$spell  = $this->find_casting( $object->get_key() );
		$this->finish_casting( $spell, $data );
	}

	protected function remove_casting( $caster ) {
		$this->casting = array_filter(
			$this->casting,
			function( $a ) use ( $caster ) {
				if ( $a->get_caster() === $caster ) return false;
				return true;
			}
		);
	}

	protected function apply_casting( $caster, $spell, $data = null ) {
		$target = $this->get_object( $spell->get_target(), false, true );
echo ( $data ) ? "$data\n" : "no data\n";
		if ( $ret = $spell->process_apply( $caster, $target, $data ) ) $this->messages[] = $ret;
		if ( count( $spell->get_filters() ) > 0 ) $this->add_effect( $spell );
		if ( $ret = $spell->process_post( $caster, $target, $data ) ) $this->messages[] = $ret;
	}

	protected function finish_casting( $spell, $data = null ) {
		$caster = $this->get_object( $spell->get_caster() );
		$this->apply_casting( $caster, $spell, $data );
		$caster->spend_manna( $spell );
		$this->remove_casting( $caster->get_key() );
	}

	protected function abort_casting( $origin ) {
		$obj = $this->get_object( $origin );
		$key = $obj->get_key();
		if ( $abort = $this->is_casting( $key ) ) {
			$obj->spend_manna( $abort );
			$this->remove_casting( $key );
		}
	}

	protected function check_casting( $object ) {
		$key = $object->get_key();
		if ( $spell = $this->is_casting( $key ) ) {
			if ( $spell->has_prior() ) $spell->activate_prior( $object );
			if ( $this->segment > $spell->get_when() ) {
				$this->finish_casting( $spell );
			}
		}
	}

	private function check_special_casting( $spell ) {
		if ( $spell->get_name() === 'Chant' ) {
			$caster = $this->get_object( $spell->get_caster() );
			$this->apply_casting( $caster, $spell );
		}
	}


	/**  Effect functions  **/

	protected function add_effect( $effect ) {
		$key = $effect->get_key();
		$this->effects[ $key ] = $effect;
		$this->process_effect_filters( $effect );
	}

	protected function process_effect_filters( $effect ) {
		if ( $effect->rewrite ) {
			$origin = $this->get_object( $effect->get_caster() );
			$effect->activate_filters( $origin );
			return;
		}
		if ( $effect->get_when() > $this->segment ) return;
		$filters = $effect->get_filters();
		$replace = apply_filters( 'dnd1e_replacement_filters', array() ); //
		// TODO: take aoe into account
		foreach( $filters as $filter ) {
			list ( $name, $delta, $priority, $argn ) = $filter;
			add_filter( $name, function( $value, $b = null, $c = null, $d = null ) use ( $filter, $effect, $replace ) {
static $cnt = 0;
				list ( $name, $delta, $priority, $argn ) = $filter;
				if ( $effect->has_condition() ) {
					foreach( [ $b, $c, $d, $this ] as $object ) {
						if ( $object === null ) continue;
						if ( $effect->condition_applies( $object ) ) {
/*
echo $object->get_key()."\n";
echo "condition: ".$effect->get_condition()."\n";
echo $effect->get_target()."\n";
echo "  purpose: $name\n";
echo "prior: $value  new: $delta cnt: $cnt\n";
#if ( $cnt > 1 ) trigger_error( 'effect filters', E_ERROR );
$cnt++;
//*/
							if ( in_array( $name, $replace ) ) {
								return $delta;
							} else {
								return $value + $delta;
							}
						} else {
							return $value;
						}
					}
				}
				return $value + $delta;
			}, $priority, $argn );
		}
	}

	protected function remove_effect( $key ) {
		if ( $key && array_key_exists( $key, $this->effects ) ) {
			unset( $this->effects[ $key ] );
		}
	}


}
