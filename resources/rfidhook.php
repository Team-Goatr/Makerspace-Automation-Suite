<?php
defined( 'ABSPATH' ) or die();

function rfid_webhook_listener() {
    error_log("RFID webhook event received");
    require_once __DIR__ . '/../front-end-pages/resources/GSuiteAPI.php';

    # Send header specifying JSON type
    header('Content-type:application/json;charset=utf-8');

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

    # Build an array of the data we want to return
    $data = array();
    foreach ($users as $user) {
        # Get data from G Suite
        $name = $user['name']['fullName'];
        $status = $user->getCustomSchemas()['Subscription_Management']['Subscription_Status'];
        $type = $user->getCustomSchemas()['Subscription_Management']['Subscription_Type'];
        $rfid_tag = $user->getCustomSchemas()['roles']['rfid-id'];

        # Don't include data for members who don't have active subscription or RFID tag
        if ($status != 'Active' or empty($rfid_tag)) {
            continue;
        }

        # Add data to the array
        $data[] = array(
            'rfid_tag' => $rfid_tag,
            'type' => $type
        );
    }

    # Echo the array to the requestor in JSON
    echo json_encode($data);
    http_response_code(200);
    die();
}
