<?php

defined( 'ABSPATH' ) or die();

require_once dirname(__DIR__).'/front-end-pages/resources/GSuiteAPI.php';

// Adding the action to the wordpress hooks
add_action('admin_post_update_member', 'prefix_admin_update_member');


function prefix_admin_update_member() {
    error_log("Function Called");
    $username = $_POST['username'];

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $rfidNumber = $_POST['rfidNumber'];
    $subcriptionType = $_POST['membershipPlan'];
    $subcriptionExpiry = $_POST['subscriptionExp'];

    $properties = array(
    	'name' => array(
    		'givenName' => $firstName,
            'familyName' => $lastName
    	),
    	'customSchemas' =>  array(
    		'Subscription_Management' => array(
                'Subscription_Type' => $subcriptionType,
                'Subscription_Expiration' => $subcriptionExpiry
            ),
            'roles' => array(
            	'rfid-id' => $rfidNumber
            )
    	)
    );


    updateUser($username, $properties);

    wp_redirect(admin_url('admin.php?page=mas-plugin'));
    exit("User updated succesfully");
}
