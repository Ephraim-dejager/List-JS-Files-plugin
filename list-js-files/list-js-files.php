<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewpgreat.com
 * @since             1.0.0
 * @package           List_Js_Files
 *
 * @wordpress-plugin
 * Plugin Name:       List JS Files
 * Plugin URI:        https://makewpgreat.com
 * Description:       Lists all JavaScript files loaded at the bottom of each page with sequential numbering and detailed information on source, plugin/theme name, and file size.
 * Version:           1.0.0
 * Author:            Make WP Great
 * Author URI:        https://makewpgreat.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       list-js-files
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LIST_JS_FILES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-list-js-files-activator.php
 */
function activate_list_js_files() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-list-js-files-activator.php';
	List_Js_Files_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-list-js-files-deactivator.php
 */
function deactivate_list_js_files() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-list-js-files-deactivator.php';
	List_Js_Files_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_list_js_files' );
register_deactivation_hook( __FILE__, 'deactivate_list_js_files' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-list-js-files.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_list_js_files() {

	$plugin = new List_Js_Files();
	$plugin->run();

}
run_list_js_files();
