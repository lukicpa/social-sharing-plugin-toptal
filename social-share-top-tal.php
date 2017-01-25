<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.pressmates.net
 * @since             1.0.0
 * @package           Social_Share_Top_Tal
 *
 * @wordpress-plugin
 * Plugin Name:       Social Share TopTal
 * Plugin URI:        http://www.pressmates.net
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Darko Lukic
 * Author URI:        http://www.pressmates.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       social-share-top-tal
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-social-share-top-tal-activator.php
 */
function activate_social_share_top_tal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-social-share-top-tal-activator.php';
	Social_Share_Top_Tal_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-social-share-top-tal-deactivator.php
 */
function deactivate_social_share_top_tal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-social-share-top-tal-deactivator.php';
	Social_Share_Top_Tal_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_social_share_top_tal' );
register_deactivation_hook( __FILE__, 'deactivate_social_share_top_tal' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-social-share-top-tal.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_social_share_top_tal() {

	$plugin = new Social_Share_Top_Tal();
	$plugin->run();

}
run_social_share_top_tal();
