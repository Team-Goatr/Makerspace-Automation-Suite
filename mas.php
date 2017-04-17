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
    if (is_page('register')) {
        // Bootstrap
        wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');

        // Angular Material
        wp_enqueue_style( 'angular-material', '//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css');
    }
    if (is_page('member')) {
        // Bootstrap
        wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    }
}

// Enqueueing the MAS scripts on the user profile and registration pages
function mas_enqueue_scripts() {
    if (is_page('register')) {
        // Bootstrap
        wp_enqueue_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'));

        // Angular
        wp_enqueue_script('angular', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js');
        wp_enqueue_script('angular-animate', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js');
        wp_enqueue_script('angular-aria', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js');
        wp_enqueue_script('angular-messages', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js');
        wp_enqueue_script('angular-material', '//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js');
    }
    if (is_page('member')) {
        // Bootstrap
        wp_enqueue_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'));
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

// Registering the MAS's settings in Wordpress
add_action('admin_init', 'register_mas_settings');
function register_mas_settings() {

    // Registering Stripe Settings
    register_setting('mas_options-group', 'stripe-secret');
    register_setting('mas_options-group', 'stripe-public');

    // Registering GSuite Settings
    register_setting('mas_options-group', 'gsuite-json');

    // Registering Slack Settings
    register_setting('mas_options-group', 'slack-secret');

    // Registering Admin Email Settings
    register_setting('mas_options-group', 'admin-email-addresses');
}

// Creates the page for MAS options in the settings menu
function mas_settings_page() {
    if (!current_user_can('manage_options')) {
        die('You do not have the permissions to edit MAS options.');
    }

    echo <<<END
        <div>
            <h2>Makerspace Automation Suite Options</h2>
                <form method="post" action="options.php">
END;
    settings_fields('mas_options-group');
    do_settings_sections('mas_options-group');
    $stripe_public = get_option('stripe-public');
    $stripe_secret = get_option('stripe-secret');
    $gsuite_json = get_option('gsuite-json');
    $slack_secret = get_option('slack-secret');
    $admin_email_addresses = get_option('admin-email-addresses');
    echo <<<END
                    <table class="form-table">
                        <tr valign="top">
                        <th scope="row">Stripe Public Key</th>
                        <td><input type="text" name="stripe-public" value="$stripe_public" /></td>
                        </tr>
                         
                        <tr valign="top">
                        <th scope="row">Stripe Secret Key</th>
                        <td><input type="text" name="stripe-secret" value="$stripe_secret" /></td>
                        </tr>
                        
                        <tr valign="top">
                        <th scope="row">GSuite Access JSON</th>
                        <td><textarea name="gsuite-json" rows="10" cols="60">$gsuite_json</textarea></td>
                        </tr>
                        
                        <tr valign="top">
                        <th scope="row">Slack Secret Key</th>
                        <td><input type="text" name="slack-secret" value="$slack_secret" /></td>
                        </tr>
                        
                        <tr valign="top">
                        <th scope="row">Admin Email Addresses (Comma Separated)</th>
                        <td><textarea name="admin-email-addresses" rows="10" cols="60">$admin_email_addresses</textarea></td>
                        </tr>
                    </table>
END;
                    submit_button();
    echo <<<END
                </form>
            </div>
END;
}

// Registering the MAS Options in the WP Admin settings menu
add_action('admin_menu', 'mas_settings_menu');
function mas_settings_menu() {
    add_options_page('Makerspace Automation Suite Options', 'MAS Options',
        'manage_options', 'mas_options_identifier', 'mas_settings_page');
}

// Setting up the root page for the MAS
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

// Register the webhook listeners with wordpress
require plugin_dir_path( __FILE__ ) . 'resources/webhooks.php';

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
