<?php

require_once dirname(__DIR__).'/resources/GSuiteAPI.php';

if (isset($_GET["username"])) {
    $username_to_check = $_GET["username"];


    try {
    	getUser($username_to_check); //Will fail if username is not in use
    	$result = false; //Username is taken
    } catch(Exception $e) {
    	$result = true; //username is available
    }

    echo '{ result: ' + $result + '}';
}