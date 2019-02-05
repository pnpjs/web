<?php

// start 普通用户默认不显示管理工具条
function set_user_admin_bar_false_by_default($user_id) {
    update_user_meta( $user_id, 'show_admin_bar_front', 'false' );
    update_user_meta( $user_id, 'show_admin_bar_admin', 'false' );
}
add_action('user_register', 'set_user_admin_bar_false_by_default', 10, 1);
// end 普通用户默认不显示管理工具条
