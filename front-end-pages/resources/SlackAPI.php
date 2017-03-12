<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

require_once __DIR__ . '/vendor/autoload.php';
define('SLACK_TOKEN_PATH', '/home/ubuntu/slack.txt');


function getSlackToken() {
	return file_get_contents(SLACK_TOKEN_PATH);
}


function sendSlackInvite($email, $firstName, $lastName) {

	$token = getSlackToken();

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://slack.com/api/users.admin.invite?token=$token&email=$email&first_name=$firstName&last_name=$lastName",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  error_log("Error sending Slack Invite - cURL Error #:" . $err);
	} else {
	  error_log("Slack response: ". $response);
	}
}