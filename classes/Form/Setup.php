<?php

class DND_Form_Setup {


	protected $cap   = 'import';
	protected $chars = array();
	protected $hook  = null;
	protected $slug  = 'dnd1e';


	public function __construct() {
		add_action( 'admin_enqueue_scripts',         [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'admin_menu',                    [ $this, 'add_menu_option' ] );
		add_action( 'wp_ajax_dnd1e_import_kregen',   [ $this, 'import_kregen_csv' ] );
		add_action( 'wp_ajax_dnd1e_character_list',  [ $this, 'js_character_list' ] );
		add_action( 'wp_ajax_dnd1e_combat_party',    [ $this, 'js_combat_party' ] );
		add_filter( 'upload_mimes',                  [ $this, 'upload_mimes' ] );
	}

	public function add_menu_option() {
		if ( current_user_can( $this->cap ) ) {
			$page = __( 'D&D1e Setup', 'dnd-first' );
			$menu = __( 'D&D1e Setup', 'dnd-first' );
			$func = array( $this, 'show_dma_form' );
			$this->hook = add_management_page( $page, $menu, $this->cap, $this->slug, $func );
		}
	}

	public function admin_enqueue_scripts( $hook ) {
		$screen = get_current_screen();
		if ( $screen->id === 'tools_page_dnd1e' ) {
			$paths = DND_Plugin_Paths::instance();
			wp_enqueue_media();
			wp_enqueue_style(  'dnd1e-form-setup.css',     $paths->get_plugin_file_uri( 'css/form-setup.css' ),          null, $paths->version );
			wp_enqueue_style(  'dnd1e-bootstrap-core.css', $paths->get_plugin_file_uri( 'css/bootstrap-core.min.css' ),  null, $paths->version );
			wp_enqueue_style(  'dnd1e-bootstrap-grid.css', $paths->get_plugin_file_uri( 'css/bootstrap-grid.min.css' ),  null, $paths->version );
			wp_enqueue_script( 'dnd1e-library.js',         $paths->get_plugin_file_uri( 'js/library.js', true ), [ 'jquery' ], $paths->version, true );
			wp_enqueue_script( 'dnd1e-file-upload.js',     $paths->get_plugin_file_uri( 'js/file-upload.js' ),   [ 'dnd1e-library.js' ], $paths->version, true );
			wp_enqueue_script( 'dnd1e-setup.js',           $paths->get_plugin_file_uri( 'js/setup.js' ),         [ 'dnd1e-library.js' ], $paths->version, true );
		}
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
		if ( ! array_key_exists( 'csv', $mime_types ) ) {
			$mime_types['csv'] = 'text/csv';
		}
		return $mime_types;
	}

	public function show_dma_form() {
		$this->get_available_characters(); ?>
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
				<div id="character_listing" class="col-lg-5">
					<?php $this->show_character_listing(); ?>
				</div>
				<div class="col-lg-6">
					<div class="row">
						<h3 class="centered"><?php _e( 'New Combat', 'dnd-first-edition' ); ?></h3>
						<div id="assignment_buttons"><?php
							$this->show_assign_button();
							$this->show_clear_button(); ?>
						</div>
						<div id="combat_party"></div>
						<div id="combat_enemy"></div>
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
	protected function get_available_characters( $reload = false ) {
		if ( empty( $this->chars ) || $reload ) {
			$me = get_current_user_id();
			$meta = get_user_meta( $me );
			foreach( $meta as $key => $data ) {
				if ( substr( $key, 0, 20 ) === 'dnd1e_DND_Character_' ) {
					$arr  = explode( '_', $key );
					$char = array_pop( $arr );
					$this->chars[ $char ] = unserialize( get_user_meta( $me, $key, true ) );
				}
			}
			ksort( $this->chars );
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
			'class' => 'button pull-left',
			'value' => __( 'Import character file', 'dnd-first-edition' ),
		);
		dnd1e()->tag( 'input', $attrs );
	}

	/**
	 *  Show character list.
	 *
	 * @since 20190728
	 */
	protected function show_character_listing( $list = array() ) {
		$display = ( $list ) ? false : true;
		if ( $display ) { ?>
			<h3 class="centered"><?php _e( 'Characters', 'dnd-first-edition' ); ?></h3><?php
		} ?>
		<table class="form-table">
			<thead>
				<td>
				</td>
				<th>
					<?php _e( 'Name', 'dnd-first-edition' ); ?>
				</th>
				<th>
					<?php _e( 'Class', 'dnd-first-edition' ); ?>
				</th>
				<th class="centered">
					<?php _e( 'Level', 'dnd-first-edition' ); ?>
				</th>
				<th class="centered">
					<?php _e( 'Hit Points', 'dnd-first-edition' ); ?>
				</th>
				<th>
					<?php _e( 'Location', 'dnd-first-edition' ); ?>
				</th>
			</thead>
			<tbody><?php
				foreach( $this->chars as $name => $char ) {
					if ( $list && ( ! in_array( $name, $list ) ) ) {
						continue;
					} ?>
					<tr>
						<th class="check-column">
							<?php $this->show_assignment_checkbox( $name, $display ); ?>
						</th>
						<td>
							<?php echo $name; ?>
						</td>
						<td>
							<?php echo $char->get_class(); ?>
						</td>
						<td class="centered">
							<?php echo $char->get_level(); ?>
						</td>
						<td class="centered">
							<?php echo $char->hit_points; ?>
						</td>
						<td>
							<?php echo $char->assigned; ?>
						</td>
					</tr><?php
				} ?>
			</tbody>
		</table><?php
	}

	/**
	 *  Show assignment checkbox for character.
	 *
	 * @since 20190806
	 * @param string $name Character name
	 */
	protected function show_assignment_checkbox( $name = '', $display = true ) {
		if ( $name && $display ) {
			$attrs = array(
				'id'    => 'dnd1e_assign_' . $name,
				'type'  => 'checkbox',
				'name'  => 'assign_chars[]',
				'class' => 'assignment',
				'value' => $name,
			);
			dnd1e()->tag( 'input', $attrs );
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
		// this next line just errors out in the js - just so much crappy documentation.
		wp_send_json_success( $response );
	}

	/**
	 *  Show character assignment button.
	 *
	 * @since 20190806
	 */
	protected function show_assign_button() {
		$attrs = array(
			'id'    => 'dnd1e_character_assignment_button',
			'type'  => 'button',
			'class' => 'button pull-left',
			'value' => __( 'Assign Marked Characters', 'dnd-first-edition' ),
			'disabled' => true,
		);
		dnd1e()->tag( 'input', $attrs );
	}

	/**
	 *  Show clear assignment button.
	 *
	 * @since 20190807
	 */
	protected function show_clear_button() {
		$attrs = array(
			'id'    => 'dnd1e_character_clear_button',
			'type'  => 'button',
			'class' => 'button pull-right',
			'value' => __( 'Clear Assigned Characters', 'dnd-first-edition' ),
			'disabled' => true,
		);
		dnd1e()->tag( 'input', $attrs );
	}

	/**
	 *  Reload character list via ajax.
	 *
	 * @since 20190728
	 */
	public function js_character_list() {
dnd1e(true)->log($_POST);
		$this->get_available_characters();
		$this->show_character_listing();
		wp_die();
	}

	/**
	 *  Load party characters.
	 *
	 * @since 20190806
	 */
	public function js_combat_party() {
		$decode = str_replace( '\"', '"', $_POST['info'] );
		$assign = json_decode( $decode );
		$this->get_available_characters();
		$this->show_character_listing( $assign );
		wp_die();
	}


}
