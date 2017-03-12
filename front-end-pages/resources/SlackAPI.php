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

	$request = new HttpRequest();
	$request->setUrl('https://slack.com/api/users.admin.invite');
	$request->setMethod(HTTP_METH_GET);

	$request->setQueryData(array(
	  'token' => $token,
	  'email' => $email,
	  'first_name' => $firstName,
	  'last_name' => $lastName
	));

	try {
	  $response = $request->send();

	  echo $response->getBody();
	} catch (HttpException $ex) {
	  error_log("Error sending Slack Invite:". $ex);
	}
}