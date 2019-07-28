<?php

class DND_Form_DMAdmin {


	protected $cap   = 'import';
	protected $chars = array();
	protected $hook  = null;
	protected $slug  = 'dnd1e';


	public function __construct() {
		add_action( 'admin_enqueue_scripts',       [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'admin_menu',                  [ $this, 'add_menu_option' ] );
		add_action( 'wp_ajax_dnd_import_kregen',   [ $this, 'import_kregen_csv' ] );
		add_filter( 'upload_mimes',                [ $this, 'upload_mimes' ] );
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

	/**
	 *  Add .csv to allowable mime types.
	 *
	 *  Wordpress already allows .csv files.
	 *
	 * @since 20190728
	 * @link https://neliosoftware.com/blog/how-to-upload-additional-file-types-in-wordpress/
	 * @link https://www.wpbeginner.com/wp-tutorials/how-to-add-additional-file-types-to-be-uploaded-in-wordpress/
	 * @link https://www.freeformatter.com/mime-types-list.html
	 * @param array $mime_types
	 * @return array
	 */
	public function upload_mimes( $mime_types ) {
		if ( ! isset( $mime_types['csv'] ) ) {
			$mime_types['csv'] = 'text/csv';
		}
		return $mime_types;
	}

	public function show_dma_form() {
		$this->get_available_chars(); ?>
		<h1 class="centered"><?php _e( 'Dungeon Master Admin Form', 'dnd-first' );?></h1>
		<form method='post'>
			<p id="file_status" class="centered">No file selected</p>
			<div id="file_log" class="centered"></div>
			<div>
				<div class="centered">
					<input id="upload_kregen_button" type="button" class="button" value="<?php _e( 'Choose file to import', 'wmn-workbook' ); ?>" />
				</div><?php /*
				<div class="pull-right">
					<input id="reset_nodelist_button" type="button" class="button" value="<?php _e( 'Reset nodelist', 'wmn-workbook' ); ?>" />
				</div> */ ?>
			</div>
		</form>
		<div>
			<pre><?php
				foreach( $this->chars as $key => $char ) {
					echo "$char\n";
				} ?>
			</pre>
		</div><?php
	}

	/**
	 *  Load available characters into an array.
	 *
	 * @since 20190728
	 */
	protected function get_available_chars() {
		$me = get_current_user_id();
		$meta = get_user_meta( $me );
		foreach( $meta as $key => $data ) {
			if ( substr( $key, 0, 20 ) === 'dnd1e_DND_Character_' ) {
				$char = substr( $key, 20 );
				$this->chars[ $char ] = get_user_meta( $me, $key, true );
			}
		}
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
