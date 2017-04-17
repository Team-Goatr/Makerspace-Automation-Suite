<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

include_once dirname(__DIR__).'../../../resources/GSuiteAPI.php';

$service = getService();

$optParams = array(
    'domain' => 'decaturmakers.org',
    'projection' => 'custom',
    'customFieldMask' => 'Subscription_Management,roles',
    'orderBy' => 'email',
    #'maxResults' => 10,
);
$results = $service->users->listUsers($optParams);

if (count($results->getUsers()) != 0) {
    # Loop through each user, printing a row in the table
    foreach ($results->getUsers() as $user) {
        # Fields from custom schema
        $sub_mgmt = $user->getCustomSchemas()["Subscription_Management"];
        $rfid_tag = $user->getCustomSchemas()['roles']['rfid-id'];
        $recurring = !empty($sub_mgmt["Subscription_Recurring"]) ? $sub_mgmt["Subscription_Recurring"] : '';
        $expiration = !empty($sub_mgmt["Subscription_Expiration"]) ? $sub_mgmt["Subscription_Expiration"] : '';
        $status = !empty($sub_mgmt["Subscription_Status"]) ? $sub_mgmt["Subscription_Status"] : '';
        $type = !empty($sub_mgmt["Subscription_Type"]) ? $sub_mgmt["Subscription_Type"] : '';
        $stripe_id = !empty($sub_mgmt["Stripe_ID"]) ? $sub_mgmt["Stripe_ID"] : '';

        # Default Google Fields to use
        $name = $user->getName()->getFullName();
        $email = $user->getPrimaryEmail();

        $creation_time = strtotime($user->getCreationTime());
        date_default_timezone_set('EST');
        $creation_string = date("m-d-Y", $creation_time);

        $founding_bool = boolval($user->getCustomSchemas()['roles']['founding-member']);
        
        $founding_member = $founding_bool ? 
            '<i class="fa fa-check" aria-hidden="true"><span style="display: none">1</span></i>' : '<i class="fa fa-times" aria-hidden="true"><span style="display: none">0</span></i>';

        $pass_filter =
            (!isset($_GET["before"]) || $creation_time <= strtotime($_GET["before"])) &&
            (!isset($_GET["since"]) || $creation_time >= strtotime($_GET["since"])) &&

            (!isset($_GET["founding"]) || (strtolower($_GET["founding"]) == ($founding_bool ? "true" : "false"))) &&

            (!isset($_GET["type"]) || $_GET["type"] == $type) &&
            (!isset($_GET["status"]) || $_GET["status"] == $status);

        if ($pass_filter) {
            # Print Table Row
            echo <<<END
                <tr>
                    <td><a href="admin.php?page=mas-plugin&content=5&email=$email" class="edit">&#9998; $name</a></td>
                    <td>$email</td>
                    <td>$rfid_tag</td>
                    <td>$type</td>
                    <td>$status</td>
                    <td>$creation_string</td>
                    <td>$founding_member</td>
                </tr>
END;
        }
    }
}

?>
