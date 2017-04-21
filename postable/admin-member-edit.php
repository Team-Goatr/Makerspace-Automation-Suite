<?php

defined( 'ABSPATH' ) or die();

require_once dirname(__DIR__).'/resources/GSuiteAPI.php';

// Adding the action to the wordpress hooks
add_action('admin_post_update_member', 'prefix_admin_update_member');


function prefix_admin_update_member() {
    
    $username = $_POST['username'];

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $rfidNumber = $_POST['rfidNumber'];
    $subscriptionType = $_POST['membershipPlan'];
    $subscriptionStatus = $_POST['subscriptionStatus'];
    $subscriptionExpiry = $_POST['subscriptionExp'];
    $founding_member = $_POST['founding'];

    if ($subscriptionType === 'none') {
        $subscriptionType = '';
    }
    if ($subscriptionStatus === 'none') {
        $subscriptionStatus = '';
    }

    $properties = array(
    	'name' => array(
    		'givenName' => $firstName,
            'familyName' => $lastName
    	)
    );

    $properties['customSchemas']['Subscription_Management']['Subscription_Type'] = $subscriptionType;
    $properties['customSchemas']['Subscription_Management']['Subscription_Status'] = $subscriptionStatus;
    $properties['customSchemas']['roles']['rfid-id'] = $rfidNumber;
    $properties['customSchemas']['roles']['founding-member'] = $founding_member == "true";
    if (!empty($subscriptionExpiry)) {
        $properties['customSchemas']['Subscription_Management']['Subscription_Expiration'] = $subscriptionExpiry;
    }

    updateUser($username, $properties);

    wp_redirect(admin_url('admin.php?page=mas-plugin'));
    exit("User updated succesfully");
}
