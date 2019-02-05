<?php

// start 让自定义内容类型不出现在搜索结
// 另一方法：在 custom_post_type 定义的时候，直接将其参数 exclude_from_search 设为 true
function pnp_search_filter($query) {
    if ( !$query->is_admin && $query->is_search) {
        $query->set('post_type', array('type-work', 'type-team','post') ); // 在这里指定要搜索的内容类型
    }
    return $query;
}
add_filter( 'pre_get_posts', 'pnp_search_filter' );
