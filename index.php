<?php
/**
 * Plugin Name:      Uf Toggle Menu
 * Plugin URI:        https://wordpress.org/plugins/uf-toggle-menu/
 * Description:       Simple elementor addons
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            UnikForce IT
 * Author URI:        https://unikforce.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       uf-toggle-menu
 * Elementor tested up to:     3.5.0
 * Elementor Pro tested up to: 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'UFTOGGLEMENU_PLUG_DIR', dirname(__FILE__).'/' );
define('UFTOGGLEMENU_PLUG_URL', plugin_dir_url(__FILE__));

function uf_toggle_menu() {

    // Load plugin file
    require_once( __DIR__ . '/includes/index.php' );

    // Run the plugin
    menu\includes\UFTOGGLEMENU::instance();

}
add_action( 'plugins_loaded', 'uf_toggle_menu' );