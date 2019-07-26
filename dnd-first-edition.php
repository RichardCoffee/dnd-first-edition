<?php
/**
 *  DnD First Edition Combat Helper
 *
 * @package   Combat_Helper
 * @author    Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright 2019 Richard Coffee
 * @license   GPLv2  <need uri here>
 * @link      link
 *
 * @wordpress-plugin
 * Plugin Name:       DnD First Edition Combat Helper
 * Plugin URI:        pluginhome.com
 * Description:       Something I wrote to help with my DnD campaigns.
 * Version:           0.1.0
 * Requires at least: 4.7.0
 * Requires WP:       4.7.0
 * Tested up to:      4.7.4
 * Requires PHP:      5.3.6
 * Author:            Richard Coffee
 * Author URI:        rtcenterprises.net
 * GitHub Plugin URI: github uri only needed if using plugin-update-checker
 * License:           GPLv2
 * Text Domain:       dnd-first
 * Domain Path:       /languages
 * Tags:              what, where, when, who, how, why
 */

defined( 'ABSPATH' ) || exit;
/*
# https://github.com/helgatheviking/Nav-Menu-Roles/blob/master/nav-menu-roles.php
if ( ! defined('ABSPATH') || ! function_exists( 'is_admin' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
} //*/

define( 'DND_FIRST_EDITION_DIR' , plugin_dir_path( __FILE__ ) );

require_once( 'functions.php' );

$plugin = DND_Plugin_FirstEdition::get_instance( array( 'file' => __FILE__ ) );

register_activation_hook( __FILE__, array( 'DND_Register_Register', 'activate' ) );
