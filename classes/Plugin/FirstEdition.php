<?php
/**
 * classes/Plugin/FirstEdition.php
 *
 * @package FirstEdition
 * @subpackage Plugin_Core
 */
/**
 * Main plugin class
 *
 */
class DND_Plugin_FirstEdition extends DND_Plugin_Plugin {

	use DND_Trait_Singleton;

	public function initialize() {
		if ( ( ! DND_Register_Register::php_version_check() ) || ( ! DND_Register_Register::wp_version_check() ) ) {
			return;
		}
		register_deactivation_hook( $this->paths->file, [ 'DND_Register_Register', 'deactivate' ] );
		register_uninstall_hook(    $this->paths->file, [ 'DND_Register_Register', 'uninstall'  ] );
		$this->add_actions();
		$this->add_filters();
		if ( is_admin() ) {
			new DND_Form_Setup;
		} else {
			$form = new DND_Form_Combat;
			add_shortcode( 'dnd1e_combat', [ $form, 'show_screen' ] );
		}
	}

	public function add_actions() {
		parent::add_actions();
	}

	public function add_filters() {
		parent::add_filters();
		add_filter( 'plugin_action_links', [ $this, 'setup_link' ], 10, 4 );
		add_filter( 'network_admin_plugin_action_links', [ $this, 'setup_link' ], 10, 4 );
	}

	public function setup_link( $links, $file, $data, $context ) {
		if ( strpos( $file, $this->plugin ) !== false ) {
			if ( is_plugin_active( $file ) ) {
				$args = array(
					'href'   => admin_url( 'tools.php?page=dnd1e' ),
					'title'  => __( 'DM Setup Screen', 'dnd-first-edition' ),
					'target' => 'dm_setup_screen',
				);
				$links['setup'] = dnd1e()->get_element( 'a', $args, __( 'Setup', 'dnd-first-edition' ) );
			}
		}
		return $links;
	}


}
