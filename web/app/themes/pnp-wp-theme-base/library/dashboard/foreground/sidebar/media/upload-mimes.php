<?php

// start 让媒体中心支持 svg 上传
function pnp_upload_mimes($mimes = array()) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'pnp_upload_mimes');
