<?php
defined( 'ABSPATH' ) or die();

function rfid_webhook_listener() {
    error_log("RFID webhook event received");
}
