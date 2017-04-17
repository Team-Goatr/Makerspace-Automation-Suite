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

        $pass_filter =
            !isset($GLOBALS["member-before"]) || $creation_time <= strtotime($GLOBALS["member-before"]) &&
            !isset($GLOBALS["member-after"]) || $creation_time >= strtotime($GLOBALS["member-after"]) &&

            // TODO Add founding member check
            !isset($GLOBALS["founding-member"]) || true &&

            !isset($GLOBALS["subscription-type"]) || $GLOBALS["subscription-type"] == $type &&
            !isset($GLOBALS["subscription-status"]) || $GLOBALS["subscription-status"] == $status;

        if ($pass_filter) {
            # Print Table Row
            echo <<<END
                <tr>
                    <td><a href="admin.php?page=mas-plugin&content=5&email=$email" class="edit">&#9998; $name</a></td>
                    <td>$email</td>
                    <td>$rfid_tag</td>
                    <td>$type</td>
                    <td>$status</td>
                </tr>
END;
        }
    }
}

?>
