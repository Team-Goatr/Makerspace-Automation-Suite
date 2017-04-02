<?php

defined( 'ABSPATH' ) or die();

require_once dirname(__DIR__).'/front-end-pages/resources/GSuiteAPI.php';

// Adding the action to the wordpress hooks
add_action('admin_post_update_self', 'prefix_user_update_self');


function prefix_user_update_self() {
    
    $username = wp_get_current_user()->user_email;

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $personalEmail = $_POST['personalEmail'];


    $properties = array(
    	'name' => array(
    		'givenName' => $firstName,
            'familyName' => $lastName
    	),
        'emails' => array(
            array(
                'address' => $personalEmail
            )
        )
    );

    var_dump($properties);

    updateUser($username, $properties);

    //wp_redirect('member');
    exit("User updated succesfully");
}
