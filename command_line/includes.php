<?php

require_once( DND_FIRST_EDITION_DIR . '/command_line/treasure.php' );

if ( ! defined( 'ABS_PATH' ) ) { // WordPress is not loaded
	require_once( DND_FIRST_EDITION_DIR . '/command_line/functions.php' );
	require_once( DND_FIRST_EDITION_DIR . '/command_line/transients.php' );
	require_once( DND_FIRST_EDITION_DIR . '/command_line/wordpress/plugin.php' );
}

