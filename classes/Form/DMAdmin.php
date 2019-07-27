<?php

class DND_Form_DMAdmin {


	protected $cap  = 'import';
	protected $hook = null;
	protected $slug = 'dnd1e';


	public function __construct() {
		add_action( 'admin_enqueue_scripts',       [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'admin_menu',                  [ $this, 'add_menu_option' ] );
		add_action( 'wp_ajax_dnd_import_kregen',   [ $this, 'import_kregen_csv' ] );
#		add_action( 'wp_ajax_wmn_reset_nodelist',  [ $this, 'reset_nodelist' ] );
	}

	public function add_menu_option() {
		if ( current_user_can( $this->cap ) ) {
			$page = __( 'DM Setup', 'dnd-first' );
			$menu = __( 'DM Setup', 'dnd-first' );
			$func = array( $this, 'show_dma_form' );
			$this->hook = add_management_page( $page, $menu, $this->cap, $this->slug, $func );
		}
	}

	public function admin_enqueue_scripts( $hook ) {
		$paths = DND_Plugin_Paths::instance();
		wp_enqueue_media();
		wp_enqueue_style(  'dnd-form-admin.css', $paths->get_plugin_file_uri( 'css/form-dmadmin.css' ),       null, $paths->version );
		wp_enqueue_script( 'dnd-form-admin.js',  $paths->get_plugin_file_uri( 'js/form-dmadmin.js' ), [ 'jquery' ], $paths->version, true );
	}

	public function show_dma_form() { ?>
		<h1 class="centered"><?php _e( 'Dungeon Master Admin Form', 'dnd-first' );?></h1>
		<form method='post'>
			<p id="file_status" class="centered">No file selected</p>
			<div id="file_log" class="centered"></div>
			<div>
				<div class="centered">
					<input id="upload_kregen_button" type="button" class="button" value="<?php _e( 'Choose file to import', 'wmn-workbook' ); ?>" />
				</div><?php/*
				<div class="pull-right">
					<input id="reset_nodelist_button" type="button" class="button" value="<?php _e( 'Reset nodelist', 'wmn-workbook' ); ?>" />
				</div>*/?>
			</div>
		</form><?php
	}

	public function import_kregen_csv() {
		$csv      = get_attached_file( $_POST['attachment_id'] );
		$import   = new DND_Character_Import_Kregen( $csv );
		$response = array(
			'status'  => $import->import_status,
			'type'    => 'complete',
			'message' => $import->import_message,
		);
		echo json_encode( $response );
		wp_die();
	}


}
