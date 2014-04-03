<?php
/**
 * Plugin Name.
 *
 * @package   WP_Responsive_Backgrounds
 * @author    Bryan Purcell <bryan@onedesigncompany.com>
 * @license   GPL-2.0+
 * @link      http://onedesigncompany.com
 * @copyright 2014 One Design Company
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package WP_Responsive_Backgrounds
 * @author  Bryan Purcell <bryan@onedesigncompany.com>
 */
class WP_Responsive_Backgrounds {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * @TODO - Rename "plugin-name" to the name your your plugin
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'plugin-name';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public $breaks;
	public $break_resolutions;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'after_setup_theme', array( $this, 'init_thumbs' ) );
		add_action( 'init', array( $this, 'init_thumbs' ) );
		add_action( 'wp_footer', array( $this,'print_the_responsive_styles' ) );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	public function get_unique_class() {
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$unique_identifier = '';
		for ($i = 0; $i < 16; $i++) {
			$unique_identifier .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $unique_identifier;
	}

	public function print_the_responsive_styles() {
		echo "<style>"; 
		for($i = 0; $i < sizeof($this->breaks); $i++):
			if(isset($bthis->reak_resolutions[$i]) && !empty($this->break_resolutions[$i])):
				if(is_numeric($break_resolutions[$i])):
				echo "@media all and (min-width: " . $this->break_resolutions[$i] . "px) {";
				endif;
					echo $this->breaks[$i];
				if(is_numeric($break_resolutions[$i])):
				echo "}";
				endif;
				$this->breaks[$i] = '';
			endif;
		endfor;
		echo "</style>";
	}

	public function init_thumbs() {
		$rule_set = array (
			array("breakpoint" => "default",
				  "size" => "768",
				 ),
			array("breakpoint" => "769",
				  "size" => "1280",
				 ),
			array("breakpoint" => "1280",
				  "size" => "1920",
				 ),
			);

		for($i = 0; $i < sizeof($rule_set); $i++) {
			add_image_size('respond-' . $i, $rule_set[$i]['size'], 9999,  false);
			$this->break_resolutions[$i] = $rule_set[$i]['breakpoint'];
			$this->breaks[$i] = "";
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}
}
