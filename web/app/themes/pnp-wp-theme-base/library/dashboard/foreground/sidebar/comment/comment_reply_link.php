<?php

// 为评论回复链接加 nofollow 属性
function add_nofollow_to_replay_link( $link ){
    return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}
add_filter('comment_reply_link', 'add_nofollow_to_replay_link');
