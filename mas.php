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
 * @package           Makerspace_Automation_Suite
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
 * Text Domain:       makerspace-automation-suite
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
function activate_makerspace_automation_suite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-makerspace-automation-suite-activator.php';
	Makerspace_Automation_Suite_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_makerspace_automation_suite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-makerspace-automation-suite-deactivator.php';
	Makerspace_Automation_Suite_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_makerspace_automation_suite' );
register_deactivation_hook( __FILE__, 'deactivate_makerspace_automation_suite' );

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
    
    if(is_page('member')){	
		$dir = plugin_dir_path( __FILE__ );
		include($dir."front-end-pages/member-page/member-page.php");
		die();
	}
    
}

add_action( 'wp', 'elegance_referal_init' );


require plugin_dir_path( __FILE__ ) . 'includes/class-makerspace-automation-suite.php';


add_action('admin_menu', 'mas_admin_menu_setup');

function mas_admin_menu_setup() {
    add_menu_page('MAS Administration Page', 'Makerspace Automation Suite', 'manage_options', 'mas-plugin', 'mas_admin_init');
};

function mas_admin_init() {
    echo '<br>';
    $dir = plugin_dir_path( __FILE__ );
    include($dir."front-end-pages/admin-pages/admin-header.php");
}

// Registering postable actions and hooks via the init file
require plugin_dir_path( __FILE__ ) . 'postable/init.php';




/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_makerspace_automation_suite() {

	$plugin = new Makerspace_Automation_Suite();
	$plugin->run();

}

run_makerspace_automation_suite();