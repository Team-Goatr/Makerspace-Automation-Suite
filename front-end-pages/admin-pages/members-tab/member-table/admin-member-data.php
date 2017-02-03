<?php
include dirname(__DIR__).'../../resources/GSuiteAPI.php';

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
        $recurring = $sub_mgmt["Subscription_Recurring"];
        $expiration = $sub_mgmt["Subscription_Expiration"];
        $status = $sub_mgmt["Subscription_Status"];
        $type = $sub_mgmt["Subscription_Type"];
        $stripe_id = $sub_mgmt["Stripe_ID"];

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
