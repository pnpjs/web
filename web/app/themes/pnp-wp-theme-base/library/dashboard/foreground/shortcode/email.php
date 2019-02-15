<?php

// Anti Spam Email Links（反对垃圾邮件链接）
function email_encode_function($atts, $content){
    return '<a href="'.antispambot($content).'">'.antispambot($content).'</a>';
}
add_shortcode('email', 'email_encode_function');
// Use shortcode [email]email@me.com[/email]
