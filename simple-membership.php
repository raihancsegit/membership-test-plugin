<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://raihan.website
 * @since             1.0.0
 * @package           Simple_Membership
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Membership Test
 * Plugin URI:        https://reformedtech.org/
 * Description:       its simple membership plugin, here login,registration and profile page
 * Version:           1.0.0
 * Author:            Raihan Islam
 * Author URI:        https://raihan.website/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-membership
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
define( 'SIMPLE_MEMBERSHIP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-membership-activator.php
 */
function activate_simple_membership() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-membership-activator.php';
	$activator = new Simple_Membership_Activator;
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-membership-deactivator.php
 */
function deactivate_simple_membership() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-membership-deactivator.php';
	$deactivate = new Simple_Membership_Deactivator();
	$deactivate->deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_membership' );
register_deactivation_hook( __FILE__, 'deactivate_simple_membership' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-membership.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_membership() {

	$plugin = new Simple_Membership();
	$plugin->run();

}
run_simple_membership();

function update_user_status($user_id, $status) {
    update_user_meta($user_id, 'online_status', $status);
}

add_action('wp_login', function($user_login, $user) {
    update_user_status($user->ID, 'online');
}, 10, 2);

add_action('wp_logout', function() {
    update_user_status(get_current_user_id(), 'offline');
});