<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

require_once __DIR__ . '/vendor/autoload.php';
define('SLACK_TOKEN_PATH', '/home/ubuntu/slack.txt');


function getSlackToken() {
    return trim(file_get_contents(SLACK_TOKEN_PATH));
}


function sendSlackInvite($email, $firstName, $lastName) {

    $token = getSlackToken();
    $url = "https://slack.com/api/users.admin.invite?token=$token&email=$email&first_name=$firstName&last_name=$lastName";

    $args = array(
        'timeout'     => 30,
        'redirection' => 10,
        'httpversion' => '1.1',
    );

    $response = wp_remote_get($url, $args);

    $code = wp_remote_retrieve_response_code($response);

    if ($code >= 300) {
        error_log("Error sending Slack Invite - HTTP Error:" . $code);
    }
}
