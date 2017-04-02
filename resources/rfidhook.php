<?php
defined( 'ABSPATH' ) or die();

function rfid_webhook_listener() {
    error_log("RFID webhook event received");
    require_once __DIR__ . '/../front-end-pages/resources/GSuiteAPI.php';

    # Query G Suite for user info
    $service = getService();
    $optParams = array(
        'domain' => 'decaturmakers.org',
        'projection' => 'custom',
        'customFieldMask' => 'Subscription_Management,roles',
        'orderBy' => 'email'
    );
    $results = $service->users->listUsers($optParams);
    $users = $results->getUsers();
    #var_dump($users);

    # Build an array of the data we want to return
    $data = array();
    foreach ($users as $user) {
        # Get data from G Suite
        $name = $user['name']['fullName'];
        $status = $user->getCustomSchemas()['Subscription_Management']['Subscription_Status'];
        $rfid_tag = $user->getCustomSchemas()['roles']['rfid-id'];

        # Don't include data for members who aren't active
        if ($status != 'Active') {
            continue;
        }

        # Add data to the array
        $data[] = array(
            'name' => "$name",
            'status' => "$status",
            'rfid_tag' => "$rfid_tag",
        );
    }
    echo json_encode($data);

    http_response_code(200);
    die();
}
