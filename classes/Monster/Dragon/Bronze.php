<?php

class DND_Monster_Dragon_Bronze extends DND_Monster_Dragon_Dragon {


	protected $alignment    = 'Lawful Good';
	protected $appearing    = array( 1, 4, 0 );
	protected $armor_class  = 0;
	protected $armor_type   = 0;
	protected $attacks      = array( 'Claw Right' => [ 1, 6, 0 ], 'Claw Left' => [ 1, 6, 0 ], 'Bite' => [ 4, 8, 0 ] );
	protected $co_speaking  = 60;
	protected $co_magic_use = 60;
	protected $co_sleeping  = 25;
	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 0;
	protected $hd_range     = array( 8, 9, 10 );
#	protected $initiative   = 1;
	protected $intelligence = 'Exceptional';
#	protected $magic_use    = false;
	protected $movement     = array( 'foot' => 9, 'air' => 24 );
	protected $name         = 'Bronze Dragon';
#	protected $psionic      = 'Nil';
	protected $race         = 'Dragon';
	protected $reference    = 'Monster Manual page 29-30,32';
#	protected $resistance   = 'Standard';
#	protected $size         = 'Large';
#	protected $sleeping     = false;
#	protected $speaking     = false;
	protected $treasure     = 'H,S,T';
#	protected $xp_value     = array();


}
