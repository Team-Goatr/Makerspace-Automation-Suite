<?php
include '../GSuiteAPI.php';

$service = getService();

$optParams = array(
    'domain' => 'decaturmakers.org',
    'projection' => 'custom',
    'customFieldMask' => 'Subscription_Management',
    'orderBy' => 'email',
    #'maxResults' => 10,
);
$results = $service->users->listUsers($optParams);

#echo "<html><body>\n";

if (count($results->getUsers()) != 0) {
    # Create html table
    echo '<table cellpadding="0" cellspacing="5" class="member-table">';
    echo "\n";
    # Print header row
    echo '<tr><th></th><th>Name</th><th>Email</th><th>Member Since</th><th>Membership Plan</th><th>Subscription Status</th></tr>';
    echo "\n";
    # Loop through each user, printing a row in the table
    foreach ($results->getUsers() as $user) {
        # Fields from custom schema
        $sub_mgmt = $user->getCustomSchemas()["Subscription_Management"];
        $recurring = $sub_mgmt["Subscription_Recurring"];
        $expiration = $sub_mgmt["Subscription_Expiration"];
        $status = $sub_mgmt["Subscription_Status"];
        $type = $sub_mgmt["Subscription_Type"];
        $stripe_id = $sub_mgmt["Stripe_ID"];

        # Default Google Fields to use
        $creation_time = $user->getCreationTime();
        $name = $user->getName()->getFullName();
        $email = $user->getPrimaryEmail();

        # Print Table Row
        echo '<tr>';
        echo '<td><a href="admin.php?page=mas-plugin&member=1&email=',$email,'" class="edit">&#9998</a></td>';
        echo '<td>',$name,'</td>';
        echo '<td>',$email,'</td>';
        echo '<td>',$creation_time,'</td>';
        echo '<td>',$type,'</td>';
        echo '<td>',$status,'</td>';
        echo "</tr>\n";
    }
    # End the table
    echo "</table>\n";
}

#echo "</body></html>\n";
