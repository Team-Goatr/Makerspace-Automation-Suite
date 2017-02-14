<?php

include dirname(__DIR__).'../resources/GSuiteAPI.php';
include dirname(__DIR__).'../resources/StripeAPI.php';

if (isset($_POST["stripe-public"])) {
    updateStripePublic($_GET["stripe-public"]);
}

if (isset($_POST["stripe-private"])) {
    updateStripeSecret($_GET["stripe-private"]);
}

if (isset($_POST["gsuite-json"])) {
    updateGSuiteCredentials($_GET["gsuite-json"]);
}

echo '<script>window.location = "https://goatr.tech/wp-admin/admin.php?page=mas-plugin&content=4"</script>';