<?php

// Adding the keys to the wordpress hooks
add_action('admin_post_update_keys', 'prefix_admin_update_keys');

function prefix_admin_update_keys() {
    echo 'Test!';
}

echo 'Butts';