<?php

defined( 'ABSPATH' ) or die();

include_once dirname(__DIR__).'../../../resources/GSuiteAPI.php';
define( 'WP_DEBUG', true );
// Adding the keys to the wordpress hooks
add_action('admin_post_update_member', 'prefix_admin_update_member');

function prefix_admin_update_member() {
    $username = $_POST['username'];

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    $properties = array(
    	'name' => array(
    		'givenName' => $firstName,
            'familyName' => $lastName
    	)
    );

    //updateUser($username, $properties);

    wp_redirect(admin_url('admin.php?page=mas-plugin'));
    exit();
}