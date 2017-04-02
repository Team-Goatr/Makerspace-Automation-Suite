<?php
defined( 'ABSPATH' ) or die();
require_once __DIR__ . '/stripehook.php';
require_once __DIR__ . '/rfidhook.php';

function webhook_listener() {
    if(isset($_GET['webhook-listener'])) {
        if ($_GET['webhook-listener'] == 'stripe') {
            stripe_webhook_listener();
        } elseif ($_GET['webhook-listener'] == 'rfid') {
            rfid_webhook_listener();
        }
    }
}
add_action('init', 'webhook_listener');
?>
