<?php

require_once dirname(__DIR__).'/resources/GSuiteAPI.php';

if (isset($_GET["username"])) {
    $username_to_check = $_GET["username"];

    $email = $username_to_check . "@decaturmakers.org";
    error_log("Username to check: ". $email);

    try {
    	getUser($email); //Will fail if username is not in use
    	$result = "false"; //Username is taken
    	error_log("end of Try");
    } catch(Exception $e) {
    	$result = "true"; //username is available
    }

    error_log("Result: " . $result);

    echo '{ result: ' . $result . '}';
}