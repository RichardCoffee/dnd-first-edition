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
		add_action( 'wp_ajax_dnd_character_list',  [ $this, 'js_character_list' ] );
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
		wp_enqueue_style(  'dnd-form-admin.css',     $paths->get_plugin_file_uri( 'css/form-dmadmin.css' ),       null, $paths->version );
		wp_enqueue_style(  'dnd-bootstrap-core.css', $paths->get_plugin_file_uri( 'css/bootstrap-core.min.css' ), null, $paths->version );
		wp_enqueue_style(  'dnd-bootstrap-grid.css', $paths->get_plugin_file_uri( 'css/bootstrap-grid.min.css' ), null, $paths->version );
		wp_enqueue_script( 'dnd-library.js',         $paths->get_plugin_file_uri( 'js/library.js' ),      [ 'jquery' ], $paths->version, true );
		wp_enqueue_script( 'dnd-file-upload.js',     $paths->get_plugin_file_uri( 'js/file-upload.js' ),  [ 'jquery' ], $paths->version, true );
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
			<p id="file_status" class="centered"></p>
			<div id="file_log" class="centered"></div>
			<div class="row">
				<?php $this->show_file_upload_button(); ?>
			</div>
		</form>
		<div class="container-fluid">
			<div class="row">
				<div id="dnd1e_character_listing" class="col-lg-6">
					<?php $this->show_character_listing(); ?>
				</div>
				<div class="col-lg-6">
					<div class="row">
						<h4 class="centered"><?php _e( 'New Combat', 'dnd-first-edition' ); ?></h4>
					</div>
					<div class="row">
						<h4 class="centered"><?php _e( 'Saved Combats', 'dnd-first-edition' ); ?></h4>
					</div>
				</div>
			</div>
		</div><?php
	}

	/**
	 *  Load available characters into an array.
	 *
	 * @since 20190728
	 */
	protected function get_available_chars( $reload = false ) {
		if ( empty( $this->chars ) || $reload ) {
			$me = get_current_user_id();
			$meta = get_user_meta( $me );
			foreach( $meta as $key => $data ) {
				if ( substr( $key, 0, 20 ) === 'dnd1e_DND_Character_' ) {
					$char = substr( $key, 20 );
					$this->chars[ $char ] = unserialize( get_user_meta( $me, $key, true ) );
				}
			}
		}
	}

	/**
	 *  Show the file upload button
	 *
	 * @since 20190728
	 */
	protected function show_file_upload_button() {
		$attrs = array(
			'id'    => 'dnd1e_upload_kregen_button',
			'type'  => 'button',
			'class' => 'button pull-right',
			'value' => __( 'Choose file to import', 'dnd-first-edition' ),
		);
		dnd1e()->tag( 'input', $attrs );
	}

	/**
	 *  Show character list.
	 *
	 * @since 20190728
	 */
	protected function show_character_listing() { ?>
		<table class="form-table">
			<thead>
				<th class="centered">
					<?php _e( 'Name', 'dnd-first-edition' ); ?>
				</th>
				<th class="centered">
					<?php _e( 'Class', 'dnd-first-edition' ); ?>
				</th>
			</thead>
			<tbody><?php
				foreach( $this->chars as $name => $char ) { ?>
					<tr>
						<td>
							<?php echo $char->get_name(); ?>
						</td>
						<td>
							<?php echo substr( get_class( $char ), 14 ); ?>
						</td>
					</tr><?php
				} ?>
			</tbody>
		</table><?php
	}

	/**
	 *  Reload character list via ajax.
	 *
	 * @since 20190728
	 */
	public function js_character_list() {
		$this->show_character_listing();
		wp_die();
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
