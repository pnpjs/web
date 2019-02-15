<?php

// Hide WordPress Update
function pnp_hide_update() {
    remove_action('admin_notices', 'update_nag', 3);
}
add_action('admin_menu','pnp_hide_update');
