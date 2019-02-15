<?php

// start 只允许管理员访问系统后台
function redirect_non_admin_users() {
    if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'admin_init', 'redirect_non_admin_users' );
// end 只允许管理员访问系统后台
