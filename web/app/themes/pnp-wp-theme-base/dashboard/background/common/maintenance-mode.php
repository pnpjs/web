<?php

/**
 * Temp Maintenance - with http response 503 (Service Temporarily Unavailable)
 */
function wp_maintenance_mode() {
	if (!current_user_can('edit_themes') || !is_user_logged_in()) {
		wp_die('Maintenance, please come back soon.', 'Maintenance - please come back soon.', array('response' => '503'));
	}
}
// add_action('get_header', 'wp_maintenance_mode');
