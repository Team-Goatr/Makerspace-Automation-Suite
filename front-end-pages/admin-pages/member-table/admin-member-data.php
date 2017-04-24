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

date_default_timezone_set('EST');
$now = time();

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

        # Treat 0 as "empty" value, since deleting the rfid_id from G Suite doesn't work
        if ($rfid_tag == 0) {
            $rfid_tag = "";
        }

        # Default Google Fields to use
        $name = $user->getName()->getFullName();
        $email = $user->getPrimaryEmail();

        # Format user creation time
        $creation_time = strtotime($user->getCreationTime());
        $creation_string = date("Y-m-d", $creation_time);

        # Set user to expired if they aren't already and their expiration date has passed
        $expiration_time = strtotime($expiration);
        if ($status != 'Disabled' && $status != 'Expired' && $now > $expiration_time) {
            # TODO: Send email
            $fields = array(
                "customSchemas" => array (
                    "Subscription_Management" => array(
                        "Subscription_Status" => 'Expired'
                    )
                )
            );
            updateUser($email, $fields);
        }

        $founding_bool = boolval($user->getCustomSchemas()['roles']['founding-member']);
        $founding_member = $founding_bool ?
            '<i class="fa fa-check" aria-hidden="true"><span style="display: none">1</span></i>' : '<i class="fa fa-times" aria-hidden="true"><span style="display: none">0</span></i>';

        # Enable URL filtering based on these tokens
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
                    <td><a href="admin.php?page=mas-plugin&mas-action=edit&email=$email" class="edit">&#9998; $name</a></td>
                    <td>$email</td>
                    <td>$rfid_tag</td>
                    <td>$type</td>
                    <td>$status</td>
                    <td>$expiration</td>
                    <td>$creation_string</td>
                    <td>$founding_member</td>
                </tr>
END;
        }
    }
}

?>
