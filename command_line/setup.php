<?php

define( 'DND_FIRST_EDITION_DIR', '/home/oem/work/php/first' );
define( 'CSV_PATH', '/home/oem/DnD/csv/' );
define( 'ABSPATH', true );
define( 'WP_DEBUG', true );

require_once( DND_FIRST_EDITION_DIR . '/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/functions.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/wordpress/get_file_data.php' );
require_once( DND_FIRST_EDITION_DIR . '/command_line/wordpress/plugin.php' );
