<?php
include dirname(__DIR__).'../../../resources/GSuiteAPI.php';

$service = getService();

$optParams = array(
    'domain' => 'decaturmakers.org',
    'projection' => 'custom',
    'customFieldMask' => 'Subscription_Management',
    'orderBy' => 'email',
    #'maxResults' => 10,
);
$results = $service->users->listUsers($optParams);

if (count($results->getUsers()) != 0) {
    # Loop through each user, printing a row in the table
    foreach ($results->getUsers() as $user) {
        # Fields from custom schema
        $sub_mgmt = $user->getCustomSchemas()["Subscription_Management"];
        $recurring = !empty($sub_mgmt["Subscription_Recurring"]) ? $sub_mgmt["Subscription_Recurring"] : '';
        $expiration = !empty($sub_mgmt["Subscription_Expiration"]) ? $sub_mgmt["Subscription_Expiration"] : '';
        $status = !empty($sub_mgmt["Subscription_Status"]) ? $sub_mgmt["Subscription_Status"] : '';
        $type = !empty($sub_mgmt["Subscription_Type"]) ? $sub_mgmt["Subscription_Type"] : '';
        $stripe_id = !empty($sub_mgmt["Stripe_ID"]) ? $sub_mgmt["Stripe_ID"] : '';

        # Default Google Fields to use
        $creation_time = $user->getCreationTime();
        $name = $user->getName()->getFullName();
        $email = $user->getPrimaryEmail();

	# Convert creation time to useful string
	date_default_timezone_set('EST');
	$creation_string = date("M d, Y - g:i:s A T", strtotime($creation_time));

        # Print Table Row
        echo <<<END
	<tr>
		<td><a href="admin.php?page=mas-plugin&content=5&email=$email" class="edit">&#9998;</a></td>
		<td>$name</td>
		<td>$email</td>
		<td>$creation_string</td>
		<td>$type</td>
		<td>$status</td>
	</tr>

END;
    }
}

?>
