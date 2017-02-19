<?php
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
        'customFieldMask' => 'Subscription_Management',
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

function userFactory($email, $firstName, $lastName, $password) {
    $userData = array(
        'kind' => 'admin#directory#user',
        'primaryEmail' => $email,
        'password' => $password,
        'name' => array(
            'givenName' => $firstName,
            'familyName' => $lastName
        )
    );
    $user = new Google_Service_Directory_User($userData);
    return $user;
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
