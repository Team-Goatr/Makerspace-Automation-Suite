<?php

include dirname(__DIR__).'GSuiteAPI.php';
include dirname(__DIR__).'StripeAPI.php';

if (isset($_GET["stripe-public"])) {
    updateStripePublic($_GET["stripe-public"]);
}

if (isset($_GET["stripe-private"])) {
    updateStripePrivate($_GET["stripe-private"]);
}

if (isset($_GET["gsuite-json"])) {
    updateGSuiteCredentials($_GET["gsuite-json"]);
}