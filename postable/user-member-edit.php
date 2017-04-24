<?php

defined( 'ABSPATH' ) or die();

// Adding the actions to the Wordpress hooks
add_action('admin_post_update_self', 'prefix_user_update_self');
add_action('admin_post_update_self_password', 'user_update_password');


function prefix_user_update_self() {
    require_once dirname(__DIR__).'/resources/GSuiteAPI.php';

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

    updateUser($username, $properties);

    wp_redirect('member');
    exit("User updated successfully");
}

function user_update_password() {
    require_once dirname(__DIR__).'/resources/GSuiteAPI.php';

    try {
        $username = wp_get_current_user()->user_email;

        $password = $_POST['newPassword'];

        $properties = array(
            'password' => $password
        );

        updateUser($username, $properties);

        wp_redirect('member');
        exit("User updated successfully");
    } catch (Google_Service_Exception $e) {
        echo $e->getErrors()[0]["message"];
        exit();
    }
}
