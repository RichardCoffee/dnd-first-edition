<?php

class DND_Combat_Treasure_Items_Scroll extends DND_Combat_Treasure_Items_Item {


#	protected $active  = false;   // DND_Combat_Treasure_Items_Item
	protected $class   = '';
#	protected $data    = array(); // DND_Combat_Treasure_Items_Item
#	protected $effect  = '';      // DND_Combat_Treasure_Items_Item
#	protected $filters = array(); // DND_Combat_Treasure_Items_Item
#	protected $gp      = 0;       // DND_Combat_Treasure_Items_Item
#	private   $key     = '';      // DND_Combat_Treasure_Items_Item
#	protected $link    = '';      // DND_Combat_Treasure_Items_Item
#	protected $name    = '';      // DND_Combat_Treasure_Items_Item
#	protected $owner   = '';      // DND_Combat_Treasure_Items_Item
#	private   $prefix  = '';      // DND_Combat_Treasure_Items_Item
#	protected $symbol  = '';      // DND_Combat_Treasure_Items_Item
	protected $type    = array( 'Scroll' );
#	public    $typepub = '';      // DND_Combat_Treasure_Items_Item
#	protected $xp      = 0;       // DND_Combat_Treasure_Items_Item
	protected $zero    = 'Cantrip';


	public function __construct( array $args = array() ) {
		parent::__construct( $args );
	}

	public function get_spell( $key ) {
		if ( array_key_exists( $key, $this->data ) ) {
			$ord  = DND_Enum_Ordinal::instance( [ $this->zero ] );
			$base = $this->class;
			$lvl  = max( 12, $ord->pos( $this->data[ $key ]['rank'] ) * 2 );
			$user = new $base( [ 'level' => $lvl ] );
			return $user->locate_magic_spell( $this->data[ $key ]['spell'] );
		}
		return false;
	}


	/**  Commandline functions  **/

	protected function generate_index_line( $type ) {
		if ( empty( $this->data ) ) {
			$line = 'Scroll of ' . implode( ' vs ', explode( ' - ', $this->name ) );
		} else {
			$main = array_reverse( explode( '_', $this->class ) );
			$line = "{$main[0]}: ";
			$ord  = DND_Enum_Ordinal::instance( [ $this->zero ] );
			foreach( $this->data as $key => $spell ) {
				$line .= $ord->pos( $spell['rank'] ) . ") {$spell['spell']}/$key  ";
			}
		}
		return $line;
	}


}
