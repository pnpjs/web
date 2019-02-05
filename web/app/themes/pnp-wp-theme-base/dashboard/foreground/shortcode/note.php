<?php

// Admin Note, Admin Only Notes（只有管理员可以看到的信息）
function adminnote($atts, $content = NULL){
    if (current_user_can('edit_themes') || is_user_logged_in()){
        return '</pre>
			<div style="margin-bottom: 22px; font-size: 12px; overflow-x: auto; width: 99%; word-wrap: break-word; background: #f3f3f7; border: 1px solid #dedee3; padding: 11px; line-height: 1.3em;">
				<b>Admin Notice</b>
			' . $content . '</div>
		<pre>';
    }
}
add_shortcode('note', 'adminnote');
// Use [note]This will appear only to admins[/note]
