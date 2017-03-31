<?php
if (isset($_GET["username"])) {
    $username_to_check = $_GET["username"];

    // INSERT CHECK HERE

    $result = false;

    echo '{ result: ' + $result + '}';
}