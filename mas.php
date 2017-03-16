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

// Enqueueing the MAS styles on the user profile and registration pages
function mas_enqueue_styles() {
    if (is_page('member') || is_page('register')) {
        // Bootstrap
//        wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');

        // Angular Material
        wp_enqueue_style( 'angular-material', '//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css');
    }
}

// Enqueueing the MAS scripts on the user profile and registration pages
function mas_enqueue_scripts() {
    if (is_page("member") || is_page('register')) {
        // Bootstrap
        wp_enqueue_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'));

        // Angular
        wp_enqueue_script('angular', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js');
        wp_enqueue_script('angular-animate', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js');
        wp_enqueue_script('angular-aria', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js');
        wp_enqueue_script('angular-messages', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js');
        wp_enqueue_script('angular-material', '//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js');
    }
}

add_action('wp_enqueue_scripts', 'mas_enqueue_styles');
add_action('wp_enqueue_scripts', 'mas_enqueue_scripts');

// Enqueueing the MAS styles on the admin pages
function mas_admin_enqueue_styles($hook) {
    // Load only on ?page=mas-plugin
    if($hook != 'toplevel_page_mas-plugin') {
        return;
    }
    
    // Bootstrap
    wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    
    // Angular Material
    wp_enqueue_style( 'angular-material', '//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css');
}

// Enqueuing the MAS scripts on the admin pages
function mas_admin_enqueue_scripts($hook) {
    // Load only on ?page=mas-plugin
    if($hook != 'toplevel_page_mas-plugin') {
        return;
    }

    // Bootstrap
    wp_enqueue_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'));

    // Angular
    wp_enqueue_script('angular', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js');
    wp_enqueue_script('angular-animate', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js');
    wp_enqueue_script('angular-aria', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js');
    wp_enqueue_script('angular-messages', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js');
    wp_enqueue_script('angular-material', '//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js');
}
add_action('admin_enqueue_scripts', 'mas_admin_enqueue_styles');
add_action('admin_enqueue_scripts', 'mas_admin_enqueue_scripts');


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
