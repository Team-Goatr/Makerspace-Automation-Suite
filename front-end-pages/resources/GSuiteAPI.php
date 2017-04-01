<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

require_once __DIR__ . '/vendor/autoload.php';

# Constants used for G Suite connection
define('CREDENTIALS_PATH', '/home/ubuntu/service_account.json');
define('APPLICATION_NAME', 'Makerspace Automation Suite');
define('SCOPES', implode(' ', array(
    Google_Service_Directory::ADMIN_DIRECTORY_USER)
));

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
    $client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CREDENTIALS_PATH);
    $client->setSubject('thomas@decaturmakers.org');
    return $client;
}

/**
 * Returns a Google_Service_Directory Object authorized
 */
function getService() {
    $client = getClient();
    $service = new Google_Service_Directory($client);
    return $service;
}

/**
 * Returns a Google_Service_Directory_User Object corresponding to the email given
 */
function getUser($email) {
    $service = getService();
    $optParams = array(
        'projection' => 'custom',
        'customFieldMask' => 'Subscription_Management,roles',
    );
    return $service->users->get($email, $optParams);
}

/**
 * Adds the user-object given to the Google Service Directory
 */
function createUser($user) {
    $service = getService();
    $service->users->insert($user);
}

/**
 * Returns a Google_Service_Directory_User that can be used to make a new user
 */

function userFactory($username, $email, $firstName, $lastName, $password, $stripeToken, $subcriptionType, $subscriptionStatus, $subscriptionRecurring, $subscriptionExpiration) {
    $userData = array(
        'kind' => 'admin#directory#user',
        'primaryEmail' => $username,
        'password' => $password,
        'name' => array(
            'givenName' => $firstName,
            'familyName' => $lastName
        ),
        'emails'=> array(
            array(
                'address' => $email
            )
        ),
        'customSchemas' =>  array(
            'Subscription_Management' => array(
                'Subscription_Type' => $subcriptionType,
                'Subscription_Status' => $subscriptionStatus,
                'Subscription_Recurring' => $subscriptionRecurring,
                'Subscription_Expiration' => $subscriptionExpiration,
                'Stripe_ID' => $stripeToken
                ) 
            )
    );
    //error_log(var_dump($userData));
    
    $user = new Google_Service_Directory_User($userData);
    return $user;
}

/*
 * @param $username the UID of a user ending in @decaturmakers.org
 * @param $properties The properties that are to be updated
 */

function updateUser($username, $properties) {
    $fields = new Google_Service_Directory_User($$properties);

    $service = getService();
    $service->users->update($username, $properties);
}

function addRole($username, $role) {
    $roles = listRoles($username);
    if (!assertRole($role)) {
        $roles[] = $role;
        //Update user Object
    }
}

function removeRole($username, $role) {
    return FALSE;
}

function listRoles($username) {
    $user = getUser($username);
    $roles = $user->getCustomSchemas()['roles']['permissions'];

    $simpleRoles = array_map("stripRoles", $roles);

    return $simpleRoles;
}

function stripRoles($role) {
    return $role['value'];
}

function assertRole($username, $role) {
    $roles = listRoles($username);
    return in_array($role, $roles);
}

/**
 * Updates the GSuite JSON stored in the credentials path
 */
function updateGSuiteCredentials($newCredentials) {
    file_put_contents(CREDENTIALS_PATH, $newCredentials);
}

/**
 * Returns the GSuite JSON stored in the credentials path
 */
function getGSuiteCredentials() {
    return file_get_contents(CREDENTIALS_PATH);
}
