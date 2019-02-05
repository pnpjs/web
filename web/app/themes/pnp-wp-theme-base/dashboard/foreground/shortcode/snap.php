<?php

// 使用shortcode输出你指定的任何一个网站的快照缩略图。
// Output a snapshot of any website!
function pnp_snap($atts, $content = NULL) {
    extract(shortcode_atts(array(
        "snap" => 'http://s.wordpress.com/mshots/v1/',
        "url" => 'http://wpdaily.co/',
        "alt" => 'WPDaily',
        "w" => '400', // width
        "h" => '300' // height
    ), $atts));

    $img = '<img alt="' . $alt . '" src="' . $snap . '' . urlencode($url) . '?w=' . $w . '&h=' . $h . '" />';
    return $img;
}
add_shortcode("snap", "pnp_snap");
// Use [snap url="http://wpdaily.co/" alt="WPDaily Website" w="400" h="300"]
