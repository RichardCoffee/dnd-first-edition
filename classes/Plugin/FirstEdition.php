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
			new DND_Form_DMAdmin;
		} else {
			$form = new DND_Form_DMScreen;
			add_shortcode( 'dm_screen', [ $form, 'show_screen' ] );
		}
	}

	public function add_actions() {
		parent::add_actions();
	}

	public function add_filters() {
		parent::add_filters();
	}

}
