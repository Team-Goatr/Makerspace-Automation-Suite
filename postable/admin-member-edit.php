<?php

defined( 'ABSPATH' ) or die();

require_once dirname(__DIR__).'/front-end-pages/resources/GSuiteAPI.php';

// Adding the action to the wordpress hooks
add_action('admin_post_update_member', 'prefix_admin_update_member');


function prefix_admin_update_member() {
    
    $username = $_POST['username'];

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $rfidNumber = $_POST['rfidNumber'];
    $subscriptionType = $_POST['membershipPlan'];
    $subscriptionExpiry = $_POST['subscriptionExp'];

    $properties = array(
    	'name' => array(
    		'givenName' => $firstName,
            'familyName' => $lastName
    	)
    );

    if (!empty($subscriptionType) && !($subscriptionType === 'none')) {
        $properties['customSchemas']['Subscription_Management']['Subscription_Type'] = $subscriptionType;
    }
    if (!empty($subscriptionExpiry)) {
        $properties['customSchemas']['Subscription_Management']['Subscription_Expiry'] = $subscriptionExpiry;
    }
    if (!empty($rfidNumber)) {
        $properties['customSchemas']['roles']['rfid-id'] = $rfidNumber;
    }

    updateUser($username, $properties);

    wp_redirect(admin_url('admin.php?page=mas-plugin'));
    exit("User updated succesfully");
}
