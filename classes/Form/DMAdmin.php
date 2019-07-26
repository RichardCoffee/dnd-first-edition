<?php

class DND_Form_DMAdmin {


	protected $capability = 'import';
	protected $hook       = null;
	protected $slug       = 'dnd1e';


	public function __construct() {
		add_action( 'admin_enqueue_scripts',       [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'admin_menu',                  [ $this, 'add_menu_option' ] );
#		add_action( 'wp_ajax_wmn_import_nodelist', [ $this, 'import_nodelist' ] );
#		add_action( 'wp_ajax_wmn_reset_nodelist',  [ $this, 'reset_nodelist' ] );
	}

	public function add_menu_option() {
		if ( current_user_can( $this->capability ) ) {
			$page = __( 'DM Setup', 'dnd-first' );
			$menu = __( 'DM_Setup', 'dnd-first' );
			$func = array( $this, 'show_dma_form' );
			$this->hook = add_management_page( $page, $menu, $this->capability, $this->slug, $func );
		}
	}

	public function admin_enqueue_scripts( $hook ) {
#		$paths = wmn_paths();
#		wp_enqueue_media();
#		wp_enqueue_style(  'wmn-form-workbook.css', $paths->get_plugin_file_uri( 'css/form-workbook.css' ),       null, $paths->version );
#		wp_enqueue_script( 'wmn-form-workbook.js',  $paths->get_plugin_file_uri( 'js/form-workbook.js' ), [ 'jquery' ], $paths->version, true );
	}

	public function show_dma_form() { ?>
		<h1 class="text-center">Dungeon Master Admin Form</h1>
	}


}
