<?php

// start 让系统支持中文注册
function pnp_non_strict_login( $username, $raw_username, $strict ) {
    if( !$strict )
        return $username;

    return sanitize_user(stripslashes($raw_username), false);
}
add_filter('sanitize_user', 'pnp_non_strict_login', 10, 3);
