<?php
/**
 * The official Blaze Meal Planner plugin.
 *
 * Plugin Name:       Blaze Meal Planner
 * Plugin URI:        https://blazebodyonline.com
 * Description:       A custom meal planner application.
 * Version:           1.5.1
 * Author:            Alok Saini
 * Author URI:        https://blazebodyonline.com
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The main class for the plugin. Initializes any hooks
 * and loads any dependencies.
 *
 * @since 1.0
 */
final class Blaze_Meal_Planner {

	/**
	 * Stores the current instance of the plugin.
	 * @var object
	 */
	private static $instance;

	/**
	 * Stores the plugin slug.
	 * @var string
	 */
	public $plugin_slug = 'blaze-meal-planner';

	/**
	 * Since this is a singleton pattern, use etp_meal_planner() instead.
	 *
	 * @access private
	 */
	private function __construct() {
		// Do nothing here.
	}

	/**
	 * Prevent direct __clones by making the method private.
	 *
	 * @access private
	 */
	private function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'blaze-meal-planner' ), '1.0' );
	}

	/**
	 * Prevent direct unserialization by making the method private.
	 *
	 * @access private
	 */
	private function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'blaze-meal-planner' ), '1.0' );
	}

	/**
	 * Defines any constants used throughout the plugin.
	 *
	 * @access private
	 */
	private function define_constants() {

		// The main plugin file.
		if ( ! defined( 'Blaze_MEAL_PLANNER_FILE' ) ) {
			define( 'Blaze_MEAL_PLANNER_FILE', __FILE__ );
		}

		// The path used for PHP includes.
		if ( ! defined( 'Blaze_MEAL_PLANNER_PATH' ) ) {
			define( 'Blaze_MEAL_PLANNER_PATH', plugin_dir_path( Blaze_MEAL_PLANNER_FILE ) );
		}

		// The base URL used for assets.
		if ( ! defined( 'Blaze_MEAL_PLANNER_URL' ) ) {
			define( 'Blaze_MEAL_PLANNER_URL', plugin_dir_url( Blaze_MEAL_PLANNER_FILE ) );
		}

		// The current version of the plugin.
		if ( ! defined( 'Blaze_MEAL_PLANNER_VERSION' ) ) {
			define( 'Blaze_MEAL_PLANNER_VERSION', '1.5.1' );
		}

	}

	/**
	 * Retrieves the current instance of the plugin,
	 * creating a new one if it doesn't already exist.
	 *
	 * @since 	1.0
	 * @return 	object
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {

			// Create a new instance.
			self::$instance = new self;

			// Define any constants used by the plugin.
			self::$instance->define_constants();

			/**
			 * Loads the rest of the plugin after
			 * everything else has had a chance to load.
			 */
			add_action( 'after_setup_theme', array( __CLASS__, 'load_instance' ) );

		}

		// Always return an instance.
		return self::$instance;

	}

	/**
	 * Loads dependencies and initiates action hooks.
	 *
	 * @since 	1.0
	 */
	public static function load_instance() {

		// Loads any dependencies used by the plugin.
		self::$instance->load_dependencies();

		// Fires after the plugin has fully loaded.
		do_action( 'blaze_meal_planner_loaded' );

	}

	/**
	 * Loads any dependencies used by the plugin.
	 *
	 * @access 	private
	 * @since 	1.0
	 */
	public function load_dependencies() {
		include_once Blaze_MEAL_PLANNER_PATH . 'includes/functions.php';
		include_once Blaze_MEAL_PLANNER_PATH . 'includes/post-types.php';
		include_once Blaze_MEAL_PLANNER_PATH . 'includes/post-meta.php';
		include_once Blaze_MEAL_PLANNER_PATH . 'includes/shortcodes.php';
		include_once Blaze_MEAL_PLANNER_PATH . 'includes/ajax.php';
	}

	/**
	 * Installs the database table.
	 * @access public
	 */
	public static function install() {
		$table_name = Blaze_Meal_Planner::table_name();
		$sql = "CREATE TABLE {$table_name} (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			title TEXT,
			meals longtext NOT NULL,
			user_id bigint(20) NOT NULL,
			time datetime NOT NULL,
			UNIQUE KEY id (id)
			);";

	  	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	   	dbDelta( $sql );

		update_option( 'blaze_mp_db_version', '1.1' );
	}

	/**
	 * Returns the table name used by the plugin.
	 * @access public
	 * @return string
	 */
	public static function table_name() {
		global $wpdb;
		return $wpdb->prefix . 'meal_planner';
	}

}

/**
 * Returns a single instance of the plugin.
 *
 * @since 	1.0
 * @return 	object
 */
function blaze_meal_planner() {
	return Blaze_Meal_Planner::get_instance();
}

// Let's go!
blaze_meal_planner();

// Register the activation hook.
register_activation_hook( __FILE__, array( 'Blaze_Meal_Planner', 'install' ) );
