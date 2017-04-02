<?php
defined( 'ABSPATH' ) or die();

function rfid_webhook_listener() {
    error_log("RFID webhook event received");
    require_once __DIR__ . '/../front-end-pages/resources/GSuiteAPI.php';

    $service = getService();
    $optParams = array(
        'domain' => 'decaturmakers.org',
        'projection' => 'custom',
        'customFieldMask' => 'Subscription_Management,roles',
        'orderBy' => 'email'
    );
    $results = $service->users->listUsers($optParams);
    $users = $results->getUsers();
    var_dump($users);

    http_response_code(200);
    die();
}
