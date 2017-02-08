<?php
require_once __DIR__ . '/vendor/autoload.php';

define('STRIPE_SECRET_KEY_PATH', '/home/ubuntu/stripe_secret.txt');
define('STRIPE_PUB_KEY_PATH', '/home/ubuntu/stripe_public.txt');

function getStripeCheckout() {
    #$stripe_secret_key = file_get_contents(STRIPE_SECRET_KEY_PATH);
    $stripe_pub_key = trim(file_get_contents(STRIPE_PUB_KEY_PATH));
    echo <<<END

    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="$stripe_pub_key"
        data-amount="2000"
        data-name="Demo Site"
        data-description="2 widgets"
        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-locale="auto"
        data-zip-code="true">
    </script>

END;
}
