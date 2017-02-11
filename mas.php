<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Makerspace Automation Suite
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       A plugin to automate the onboarding process for the Decatur Makerspace.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */


function elegance_referal_init()
{
	if(is_page('register')){	
		$dir = plugin_dir_path( __FILE__ );
		include($dir."front-end-pages/registration-form/registration-form.php");
		die();
	}
}

add_action( 'wp', 'elegance_referal_init' );

require plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name.php';
add_action('admin_menu', 'mas_admin_menu_setup');

function mas_admin_menu_setup() {
    add_menu_page('MAS Administration Page', 'Makerspace Automation Suite', 'manage_options', 'mas-plugin', 'mas_admin_init');
};

function mas_admin_init() {
    echo '<br>';
    $dir = plugin_dir_path( __FILE__ );
    include($dir."front-end-pages/admin-pages/admin-header.php");
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Plugin_Name();
	$plugin->run();

}
run_plugin_name();
