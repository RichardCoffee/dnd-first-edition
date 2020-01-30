<?php

trait DND_Combat_Treasure_Generate {


	protected function generate_random_result( $table, $roll = 0 ) {
		$total = $this->get_table_total( $table );
		if ( $roll === 0 ) $roll = mt_rand( 1, $total );
		return $this->get_table_result( $table, $roll );
	}

	protected function generate_fake_potions() {
		$table = $this->get_potions_table();
		return $this->generate_random_result( $table );
	}

	protected function generate_random_scrolls( $scroll, $type ) {
		$scr = array();
		if ( array_key_exists( 'cdi', $scroll ) ) {
			$types = $this->get_scrolls_type_table();
			$list  = array_column( $types, 'class', 'type' );
			$base  = $list[ $type ];
			list( $number, $start, $end ) = ( array_key_exists( 'm', $scroll ) && ( $type === 'M' ) ) ? $scroll['m'] : $scroll['cdi'];
			$obj = new $base;
			$ord = DND_Enum_Ordinal::instance();
			for( $i = 1; $i <= $number; $i++ ) {
				$level = mt_rand( $start, $end );
				$rank  = $ord->get( $level );
				$spell = $obj->generate_random_spell( $level );
				$scr[] = array( 'rank' => $rank, 'spell' => $spell );
			}
			usort(
				$scr,
				function( $a, $b ) use ( $ord ) {
					$cmp = $ord->compare( $a['rank'], $b['rank'] );
					if ( $cmp === 0 ) $cmp = strcmp( $a['spell'], $b['spell'] );
					return $cmp;
				}
			);
		}
		return $scr;
	}

	protected function generate_random_charge( $base, $delta ) {
		return $base - ( mt_rand( 1, $delta ) - 1 );
	}

	protected function generate_armor_size( $item, $roll = 0 ) {
		$table = $this->get_armor_size_table();
		$size  = $this->generate_random_result( $table, $roll );
		$item['size'] = $size['size'];
		return $item;
	}

	protected function generate_shield_size( $item, $roll = 0 ) {
		$table = $this->get_shields_size_table();
		$size  = $this->generate_random_result( $table, $roll );
		$item['text'] = "{$size['size']} {$item['text']}";
		return $item;
	}

	protected function generate_swords_type( $item, $roll = 0 ) {
#		if ( ! in_array( $item['text'], [ 'Sword, Short, Quickness (+2)' ] ) ) {
		if ( ( stripos( $item['text'], 'Sun Blade'    ) === false )
		  && ( stripos( $item['text'], 'Sword, Short' ) === false ) ) {
			$table = $this->get_swords_type_table();
			$type  = $this->generate_random_result( $table, $roll );
			$item['text'] = "{$type['text']} {$item['text']}";
		}
		return $item;
	}

	protected function generate_special_swords( $item, $roll = 0 ) {
		if ( $roll === 0 ) $roll = mt_rand( 1, 100 );
		$powers = 'none';
		if ( $roll > 75 ) {
			$powers = array(
				'align'   => $this->generate_swords_alignment( $item ),
				'int'     => 12,
				'primary' => array(),
				'extra'   => array(),
				'comm'    => 'semi-empathy',
			);
			$powers = $this->generate_swords_primary_ability( $powers );
		}
		if ( $roll > 83 ) {
			$powers['int']  = 13;
			$powers['comm'] = 'empathy';
			$powers = $this->generate_swords_primary_ability( $powers );
		}
		if ( $roll > 89 ) {
			$powers['int']  = 14;
			$powers['comm'] = 'speech';
		}
		if ( $roll > 94 ) {
			$powers['int'] = 15;
			$powers = $this->generate_swords_primary_ability( $powers );
		}
		if ( $roll > 97 ) {
			$powers['int'] = 16;
		}
		if ( $roll > 99 ) {
			$powers = $this->generate_swords_extra_power( $powers );
		}
		$item['powers'] = $powers;
		return $item;
	}

	protected function generate_swords_alignment( $item, $roll = 0 ) {
		$restrict = ( array_key_exists( 'restrict', $item ) ) ? substr( $item['restrict'], 1 ) : 'any';
		$table = $this->get_swords_alignment_table();
		$align = $this->generate_random_result( $table, $roll );
		if ( $restrict === 'any' ) return $align['align'];
		if ( strpos( $align['align'], $restrict ) === false ) {
			return $this->generate_swords_alignment( $item );
		}
		return $align['align'];
	}

	protected function generate_swords_primary_ability( $powers, $roll = 0 ) {
		if ( $roll === 0 ) $roll = mt_rand( 1, 100 );
		$table   = $this->get_swords_primary_ability_table();
		$ability = $this->generate_random_result( $table );
		$powers['primary'][] = $ability['ability'];
		if ( $roll > 92 ) {
			$ability = $this->generate_random_result( $table );
			$powers['primary'][] = $ability['ability'];
			if ( $roll === 100 ) $powers = $this->generate_swords_extra_power( $powers );
		}
		return $powers;
	}

	protected function generate_swords_extra_power( $powers, $roll = 0 ) {
		if ( $roll === 0 ) $roll = mt_rand( 1, 100 );
		$table = $this->get_swords_extra_ability_table();
		$powers['extra'][] = $this->generate_random_result( $table );
		if ( $roll > 94 ) {
			$powers['extra'][] = $this->generate_random_result( $table );
			if ( $roll === 100 ) $powers['purpose'] = 'Roll for special purpose - DMG 167';
		}
		return $powers;
	}

	protected function generate_random_missile_pluses( $item, $roll = 0 ) {
		$table = $this->get_missile_adjustment_table();
		return $this->generate_random_pluses( $table, $item, $roll, '**' );
	}

	protected function generate_random_weapons_pluses( $item, $roll = 0 ) {
		$table = $this->get_weapons_adjustment_table();
		return $this->generate_random_pluses( $table, $item, $roll, '*' );
	}

	protected function generate_random_pluses( $table, $item, $roll, $search ) {
		$plus  = $this->generate_random_result( $table, $roll );
		$item['xp'] = intval( $item['xp'] * $plus['gp'] );
		$item['gp'] = intval( $item['gp'] * $plus['gp'] );
		$string  = ( $plus['plus'] > 0 ) ? ' +%d' : ' %d, Cursed';
		$replace = sprintf( $string, $plus['plus'] );
		$item['text'] = str_replace( $search, $replace, $item['text'] );
		return $item;
	}


}
