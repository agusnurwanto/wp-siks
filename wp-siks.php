<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/agusnurwanto
 * @since             1.0.0
 * @package           Wp_Siks
 *
 * @wordpress-plugin
 * Plugin Name:       Sistem Informasi Kesejahteraan Sosial
 * Plugin URI:        https://github.com/agusnurwanto/wp-siks
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Agus Nurwanto
 * Author URI:        https://github.com/agusnurwanto
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-siks
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
define( 'WP_SIKS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-siks-activator.php
 */
function activate_wp_siks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-siks-activator.php';
	Wp_Siks_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-siks-deactivator.php
 */
function deactivate_wp_siks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-siks-deactivator.php';
	Wp_Siks_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_siks' );
register_deactivation_hook( __FILE__, 'deactivate_wp_siks' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-siks.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_siks() {

	$plugin = new Wp_Siks();
	$plugin->run();

}
run_wp_siks();
