<?php

/**
 * Pollfish for Wordpress
 *
 * The plugin enables you to add PollFish Surveys to your wordpress website.
 *
 * @link              https://www.upwork.com/fl/hncvj
 * @since             1.2.0
 * @package           Pollfish_For_Wordpress
 *
 * @wordpress-plugin
 * Plugin Name:       Pollfish for Wordpress
 * Plugin URI:        https://spanrig.com
 * Description:       The plugin enables you to add PollFish Surveys to your wordpress website.
 * Version:           1.2.0
 * Author:            Spanrig Technologies
 * Author URI:        https://www.upwork.com/fl/hncvj
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pollfish-for-wordpress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0
 */
define( 'Pollfish_For_Wordpress_VERSION', '1.2.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pollfish-for-wordpress-activator.php
 */
function activate_Pollfish_For_Wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pollfish-for-wordpress-activator.php';
	Pollfish_For_Wordpress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pollfish-for-wordpress-deactivator.php
 */
function deactivate_Pollfish_For_Wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pollfish-for-wordpress-deactivator.php';
	Pollfish_For_Wordpress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Pollfish_For_Wordpress' );
register_deactivation_hook( __FILE__, 'deactivate_Pollfish_For_Wordpress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pollfish-for-wordpress.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Pollfish_For_Wordpress() {

	$plugin = new Pollfish_For_Wordpress();
	$plugin->run();

}
run_Pollfish_For_Wordpress();
