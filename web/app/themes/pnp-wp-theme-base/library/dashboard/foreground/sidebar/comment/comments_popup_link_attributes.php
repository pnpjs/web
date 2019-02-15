<?php

// 为评论者添加 nofollow 属性
function add_nofollow_to_comments_popup_link(){
    return 'rel="nofollow" ';
}
add_filter('comments_popup_link_attributes', 'add_nofollow_to_comments_popup_link');
