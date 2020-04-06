<?php
/**
 * WordPress Book List MaxFootedb Extension
 *
 * @package     WordPress Book List MaxFootedb Extension
 * @author      Jake Evans
 * @copyright   2018 Jake Evans
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Max Foote Vendor Database Plugin
 * Plugin URI: https://www.jakerevans.com
 * Description: A plugin that allows Max Foote to Maintanin and Manage a Databse of Vendors
 * Version: 1.0.0
 * Author: Jake Evans
 * Text Domain: maxfootedb
 * Author URI: https://www.jakerevans.com
 */

/*
 * SETUP NOTES:
 *
 * Rename root plugin folder to an all-lowercase version of maxfootedb
 *
 * Change all filename instances from maxfootedb to desired plugin name
 *
 * Modify Plugin Name
 *
 * Modify Description
 *
 * Modify Version Number in Block comment and in Constant
 *
 * Find & Replace these 3 strings:
 * maxfootedb
 * maxfooteDb
 * Maxfootedb
 * MaxFootedb
 * MAXFOOTEDB
 * Maxfoote
 * maxfoote
 * $maxfoote
 * TOPLEVEL
 * repw with something also random - db column that holds license.
 *
 * Rename and/or delete the Node_Modules folder to prevent that Sass error message when running Gulp
 *
 * Change the EDD_SL_ITEM_ID_MAXFOOTEDB contant below.
 *
 * Install Gulp & all Plugins listed in gulpfile.js
 *
 *
 *
 *
 */




// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb;

/* REQUIRE STATEMENTS */
	require_once 'includes/class-maxfootedb-general-functions.php';
	require_once 'includes/class-maxfootedb-ajax-functions.php';
	require_once 'includes/classes/update/class-maxfootedb-update.php';
/* END REQUIRE STATEMENTS */

/* CONSTANT DEFINITIONS */

	if ( ! defined('MAXFOOTEDB_VERSION_NUM' ) ) {
		define( 'MAXFOOTEDB_VERSION_NUM', '1.0.0' );
	}

	// This is the URL our updater / license checker pings. This should be the URL of the site with EDD installed.
	define( 'EDD_SL_STORE_URL_MAXFOOTEDB', 'https://maxfoote.com' );

	// The id of your product in EDD.
	define( 'EDD_SL_ITEM_ID_MAXFOOTEDB', 46 );

	// This Extension's Version Number.
	define( 'MAXFOOTEDB_VERSION_NUM', '1.0.0' );

	// Root plugin folder directory.
	define( 'MAXFOOTEDB_ROOT_DIR', plugin_dir_path( __FILE__ ) );

	// Root WordPress Plugin Directory. The If is for taking into account the update process - a temp folder gets created when updating, which temporarily replaces the 'maxfoote-bulkbookupload' folder.
	if ( false !== stripos( plugin_dir_path( __FILE__ ) , '/maxfootedb' ) ) { 
		define( 'MAXFOOTEDB_ROOT_WP_PLUGINS_DIR', str_replace( '/maxfootedb', '', plugin_dir_path( __FILE__ ) ) );
	} else {
		$temp = explode( 'plugins/', plugin_dir_path( __FILE__ ) );
		define( 'MAXFOOTEDB_ROOT_WP_PLUGINS_DIR', $temp[0] . 'plugins/' );
	}

	// Root plugin folder URL .
	define( 'MAXFOOTEDB_ROOT_URL', plugins_url() . '/maxfootedb/' );

	// Root Classes Directory.
	define( 'MAXFOOTEDB_CLASS_DIR', MAXFOOTEDB_ROOT_DIR . 'includes/classes/' );

	// Root Update Directory.
	define( 'MAXFOOTEDB_UPDATE_DIR', MAXFOOTEDB_CLASS_DIR . 'update/' );

	// Root REST Classes Directory.
	define( 'MAXFOOTEDB_CLASS_REST_DIR', MAXFOOTEDB_ROOT_DIR . 'includes/classes/rest/' );

	// Root Compatability Classes Directory.
	define( 'MAXFOOTEDB_CLASS_COMPAT_DIR', MAXFOOTEDB_ROOT_DIR . 'includes/classes/compat/' );

	// Root Transients Directory.
	define( 'MAXFOOTEDB_CLASS_TRANSIENTS_DIR', MAXFOOTEDB_ROOT_DIR . 'includes/classes/transients/' );

	// Root Image URL.
	define( 'MAXFOOTEDB_ROOT_IMG_URL', MAXFOOTEDB_ROOT_URL . 'assets/img/' );

	// Root Image Icons URL.
	define( 'MAXFOOTEDB_ROOT_IMG_ICONS_URL', MAXFOOTEDB_ROOT_URL . 'assets/img/icons/' );

	// Root CSS URL.
	define( 'MAXFOOTEDB_CSS_URL', MAXFOOTEDB_ROOT_URL . 'assets/css/' );

	// Root JS URL.
	define( 'MAXFOOTEDB_JS_URL', MAXFOOTEDB_ROOT_URL . 'assets/js/' );

	// Root UI directory.
	define( 'MAXFOOTEDB_ROOT_INCLUDES_UI', MAXFOOTEDB_ROOT_DIR . 'includes/ui/' );

	// Root UI Admin directory.
	define( 'MAXFOOTEDB_ROOT_INCLUDES_UI_ADMIN_DIR', MAXFOOTEDB_ROOT_DIR . 'includes/ui/' );

	// Define the Uploads base directory.
	$uploads     = wp_upload_dir();
	$upload_path = $uploads['basedir'];
	define( 'MAXFOOTEDB_UPLOADS_BASE_DIR', $upload_path . '/' );

	// Define the Uploads base URL.
	$upload_url = $uploads['baseurl'];
	define( 'MAXFOOTEDB_UPLOADS_BASE_URL', $upload_url . '/' );

	// Nonces array.
	define( 'MAXFOOTEDB_NONCES_ARRAY',
		wp_json_encode(array(
			'adminnonce1' => 'maxfootedb_save_license_key_action_callback',
			'adminnonce2' => 'maxfootedb_admin_save_todb_action_callback',
		))
	);



/* END OF CONSTANT DEFINITIONS */

/* MISC. INCLUSIONS & DEFINITIONS */

	// Loading textdomain.
	load_plugin_textdomain( 'maxfootedb', false, MAXFOOTEDB_ROOT_DIR . 'languages' );

/* END MISC. INCLUSIONS & DEFINITIONS */

/* CLASS INSTANTIATIONS */

	// Call the class found in maxfoote-functions.php.
	$maxfoote_general_functions = new MaxFootedb_General_Functions();

	// Call the class found in maxfoote-functions.php.
	$maxfoote_ajax_functions = new MaxFootedb_Ajax_Functions();

	// Include the Update Class.
	$maxfoote_update_functions = new Maxfoote_Toplevel_Update();


/* END CLASS INSTANTIATIONS */


/* FUNCTIONS FOUND IN CLASS-WPPLUGIN-GENERAL-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */

	// For the admin pages.
	add_action( 'admin_menu', array( $maxfoote_general_functions, 'maxfootedb_jre_my_admin_menu' ) );


	// Adding the function that will take our MAXFOOTEDB_NONCES_ARRAY Constant from above and create actual nonces to be passed to Javascript functions.
	add_action( 'init', array( $maxfoote_general_functions, 'maxfootedb_create_nonces' ) );

	// Function to run any code that is needed to modify the plugin between different versions.
	//add_action( 'plugins_loaded', array( $maxfoote_general_functions, 'maxfootedb_update_upgrade_function' ) );

	// Adding the admin js file.
	add_action( 'admin_enqueue_scripts', array( $maxfoote_general_functions, 'maxfootedb_admin_js' ) );

	// Adding the frontend js file.
	add_action( 'wp_enqueue_scripts', array( $maxfoote_general_functions, 'maxfootedb_frontend_js' ) );

	// Adding the admin css file for this extension.
	add_action( 'admin_enqueue_scripts', array( $maxfoote_general_functions, 'maxfootedb_admin_style' ) );

	// Adding the Front-End css file for this extension.
	add_action( 'wp_enqueue_scripts', array( $maxfoote_general_functions, 'maxfootedb_frontend_style' ) );

	// Function to add table names to the global $wpdb.
	add_action( 'admin_footer', array( $maxfoote_general_functions, 'maxfootedb_register_table_name' ) );

	// Function that adds in any possible admin pointers
	add_action( 'admin_footer', array( $maxfoote_general_functions, 'maxfootedb_admin_pointers_javascript' ) );


	// Function that adds in any possible admin pointers
	add_action( 'wp_head', array( $maxfoote_general_functions, 'maxfootedb_jre_prem_add_ajax_library' ) );


	// Adding the function that will take our WPHEALTHTRACKER_NONCES_ARRAY Constant from below and create actual nonces to be passed to Javascript functions.
	add_action( 'init', array( $maxfoote_general_functions, 'maxfootedb_jre_create_nonces' ) );


	// Creates tables upon activation.
	register_activation_hook( __FILE__, array( $maxfoote_general_functions, 'maxfootedb_create_tables' ) );

	// Adding the front-end login / dashboard shortcode.
	add_shortcode( 'maxfootedb_login_shortcode', array( $maxfoote_general_functions, 'maxfootedb_login_shortcode_function' ) );



/* END OF FUNCTIONS FOUND IN CLASS-WPPLUGIN-GENERAL-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */

/* FUNCTIONS FOUND IN CLASS-WPPLUGIN-AJAX-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */

	// For adding a book from the admin dashboard.
	add_action( 'wp_ajax_maxfootedb_admin_save_todb_action', array( $maxfoote_ajax_functions, 'maxfootedb_admin_save_todb_action_callback' ) );




/* END OF FUNCTIONS FOUND IN CLASS-WPPLUGIN-AJAX-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */






















