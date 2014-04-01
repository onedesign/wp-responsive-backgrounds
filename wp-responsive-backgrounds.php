<?php
/**
 * WP Responsive Backgrounds
 *
 * A Small Plugin to help make your background images responsive.
 *
 * @package   WP Responsive Backgrounds
 * @author    Bryan Purcell <bryan@onedesigncompany.com>
 * @license   GPL-2.0+
 * @link      http://onedesigncompany.com
 * @copyright One Design Company
 *
 * @wordpress-plugin
 * Plugin Name:       WP Responsive Backgrounds
 * Plugin URI:        http://onedesigncompany.com
 * Description:       A Small Plugin to help make your background images responsive.
 * Version:           1.0.0
 * Author:            Bryan Purcell
 * Author URI:        http://onedesigncompany.com
 * Text Domain:       plugin-wp-responsive-images
 * License:           GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-wp-responsive-backgrounds.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/includes/api.php' );



/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'WP_Responsive_Backgrounds', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Responsive_Backgrounds', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'WP_Responsive_Backgrounds', 'get_instance' ) );
