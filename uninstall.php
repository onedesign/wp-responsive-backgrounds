<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   WP_Responsive_Backgrounds
 * @author    Bryan Purcell <bryan@onedesigncompany.com>
 * @license   GPL-2.0+
 * @link      http://onedesigncompany.com
 * @copyright 2014 One Design Company
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
if (is_multisite()) {
	global $wpdb;
	$blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);
		delete_option('wp_responsive_backgrounds');
	if ($blogs) {
		foreach($blogs as $blog) {
			switch_to_blog($blog['blog_id']);
			//delete_option('wp_responsive_backgrounds');
			restore_current_blog();
		}
	}
}
else
{
	delete_option('wp_responsive_backgrounds');
}