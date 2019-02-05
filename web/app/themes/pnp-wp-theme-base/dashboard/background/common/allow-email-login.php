<?php

// start 让系统支持邮箱登陆
// 修改 WordPress 用户名过滤机制，通过 Email 获取用户名
function pnp_allow_email_login($username, $raw_username, $strict) {
    if (filter_var($raw_username, FILTER_VALIDATE_EMAIL)) {
        $user_data = get_user_by('email', $raw_username);

        if (empty($user_data)) {
            wp_die(__('<strong>ERROR</strong>: There is no user registered with that email address.'), '用户名不正确');
		} else {
            return $user_data->user_login;
		}
    } else {
        return $username;
    }
}

// 修改登录界面的文字，"用户名"改成"用户名或邮箱"
function pnp_change_text() {
    echo '<script type="text/javascript">
		var user_login_node = document.getElementById("user_login");
		var old_username_text = user_login_node.parentNode.innerHTML;
		user_login_node.parentNode.innerHTML = old_username_text.replace(/用户名/, "用户名或邮箱");
	</script>';
}

if (in_array($GLOBALS['pagenow'], array('wp-login.php')) && strpos($_SERVER['REQUEST_URI'], '?action=register') === FALSE && strpos($_SERVER['REQUEST_URI'], '?action=lostpassword') === FALSE && strpos($_SERVER['REQUEST_URI'], '?action=rp') === FALSE ) {
    add_filter('sanitize_user', 'pnp_allow_email_login', 10, 3);
    add_action('login_footer', 'pnp_change_text');
}
