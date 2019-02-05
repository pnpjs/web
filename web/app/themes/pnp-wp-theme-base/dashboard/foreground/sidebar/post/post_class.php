<?php

// 给每页最后一篇文章加一个 last 类名
// Add a class to the last post in a loop
function last_post_class($classes){
    global $wp_query;
    if(($wp_query->current_post+1) == $wp_query->post_count) $classes[] = 'last';
    return $classes;
}
add_filter('post_class', 'last_post_class');
