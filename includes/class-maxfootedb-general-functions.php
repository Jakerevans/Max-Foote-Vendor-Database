<?php
/**
 * Class MaxFootedb_General_Functions - class-toplevel-general-functions.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes
 * @version  6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MaxFootedb_General_Functions', false ) ) :
	/**
	 * MaxFootedb_General_Functions class. Here we'll do things like enqueue scripts/css, set up menus, etc.
	 */
	class MaxFootedb_General_Functions {


		/**
		 *  Code for adding ajax
		 */
		public function maxfootedb_jre_prem_add_ajax_library() {

			$html = '<script type="text/javascript">';

			// Checking $protocol in HTTP or HTTPS.
			if ( isset( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] ) {
				// This is HTTPS.
				$protocol = 'https';
			} else {
				// This is HTTP.
				$protocol = 'http';
			}
			$temp_ajax_path = admin_url( 'admin-ajax.php' );
			$good_ajax_url  = $protocol . strchr( $temp_ajax_path, ':' );

			$html .= 'var ajaxurl = "' . $good_ajax_url . '"';
			$html .= '</script>';
			echo $html;
		}


		

		/**
		 *  Functions that loads up all menu pages/contents, etc.
		 */
		public function maxfootedb_jre_admin_page_function() {
			global $wpdb;
			require_once MAXFOOTEDB_ROOT_INCLUDES_UI_ADMIN_DIR . 'class-admin-master-ui.php';
		}

		/** Functions that loads up the menu page entry for this Extension.
		 *
		 *  @param array $submenu_array - The array that contains submenu entries to add to.
		 */
		public function maxfootedb_jre_my_admin_menu() {
			add_menu_page( 'Bell  MaxFootedb', 'MaxFootedb', 'manage_options', 'MaxFootedb-Options', array( $this, 'maxfootedb_jre_admin_page_function' ), MAXFOOTEDB_ROOT_IMG_URL . 'belllogonocanvas.png', 6 );

			$submenu_array = array(
				'Vendors',
				'Submenu Page1',
				'Submenu Page2',
			);

			// Filter to allow the addition of a new subpage.
			if ( has_filter( 'toplevel_add_sub_menu' ) ) {
				$submenu_array = apply_filters( 'toplevel_add_sub_menu', $submenu_array );
			}

			foreach ( $submenu_array as $key => $submenu ) {
				$menu_slug = strtolower( str_replace( ' ', '-', $submenu ) );
				add_submenu_page( 'MaxFootedb-Options', 'MaxFootedb', $submenu, 'manage_options', 'MaxFootedb-Options-' . $menu_slug, array( $this, 'maxfootedb_jre_admin_page_function' ) );
			}

			remove_submenu_page( 'MaxFootedb-Options', 'MaxFootedb-Options' );
		}

		/**
		 *  Here we take the Constant defined in maxfoote.php that holds the values that all our nonces will be created from, we create the actual nonces using wp_create_nonce, and the we define our new, final nonces Constant, called WPPLUGIN_FINAL_NONCES_ARRAY.
		 */
		public function maxfootedb_create_nonces() {

			$temp_array = array();
			foreach ( json_decode( MAXFOOTEDB_NONCES_ARRAY ) as $key => $noncetext ) {
				$nonce              = wp_create_nonce( $noncetext );
				$temp_array[ $key ] = $nonce;
			}

			// Defining our final nonce array.
			define( 'TOPLEVEL_FINAL_NONCES_ARRAY', wp_json_encode( $temp_array ) );

		}

		/**
		 *  Function to run the compatability code in the Compat class for upgrades/updates, if stored version number doesn't match the defined global in maxfootedb.php
		 */
		public function maxfootedb_update_upgrade_function() {

			// Get current version #.
			global $wpdb;
			$existing_string = $wpdb->get_row( 'SELECT * from ' . $wpdb->prefix . 'maxfootedb_jre_user_options' );

			// Check to see if Extension is already registered and matches this version.
			if ( false !== strpos( $existing_string->extensionversions, 'maxfootedb' ) ) {
				$split_string = explode( 'maxfootedb', $existing_string->extensionversions );
				$version      = substr( $split_string[1], 0, 5 );

				// If version number does not match the current version number found in maxfoote.php, call the Compat class and run upgrade functions.
				if ( MAXFOOTEDB_VERSION_NUM !== $version ) {
					require_once TOPLEVEL_CLASS_COMPAT_DIR . 'class-toplevel-compat-functions.php';
					$compat_class = new MaxFootedb_Compat_Functions();
				}
			}
		}

		/**
		 *  Here we take the Constant defined in wpbooklist.php that holds the values that all our nonces will be created from, we create the actual nonces using wp_create_nonce, and the we define our new, final nonces Constant, called WPBOOKLIST_FINAL_NONCES_ARRAY.
		 */
		public function maxfootedb_jre_create_nonces() {

			$temp_array = array();
			foreach ( json_decode( MAXFOOTEDB_NONCES_ARRAY ) as $key => $noncetext ) {
				$nonce              = wp_create_nonce( $noncetext );
				$temp_array[ $key ] = $nonce;
			}

			// Defining our final nonce array.
			define( 'MAXFOOTEDB_FINAL_NONCES_ARRAY', wp_json_encode( $temp_array ) );

		}

		/**
		 * Adding the admin js file
		 */
		public function maxfootedb_admin_js() {

			wp_register_script( 'maxfootedb_adminjs', MAXFOOTEDB_JS_URL . 'maxfootedb_admin.min.js', array( 'jquery' ), MAXFOOTEDB_VERSION_NUM, true );

			$final_array_of_php_values = array();

			// Adding some other individual values we may need.
			$final_array_of_php_values['MAXFOOTEDB_ROOT_IMG_ICONS_URL']   = MAXFOOTEDB_ROOT_IMG_ICONS_URL;
			$final_array_of_php_values['MAXFOOTEDB_ROOT_IMG_URL']   = MAXFOOTEDB_ROOT_IMG_URL;
			$final_array_of_php_values['FOR_TAB_HIGHLIGHT']    = admin_url() . 'admin.php';
			$final_array_of_php_values['SAVED_ATTACHEMENT_ID'] = get_option( 'media_selector_attachment_id', 0 );
			$final_array_of_php_values['SETTINGS_PAGE_URL'] = menu_page_url( 'WPBookList-Options-settings', false );
			$final_array_of_php_values['DB_PREFIX'] = $wpdb->prefix;

			// Now grab all of our Nonces to pass to the JavaScript for the Ajax functions and merge with the Translations array.
			$final_array_of_php_values = array_merge( $final_array_of_php_values, json_decode( MAXFOOTEDB_FINAL_NONCES_ARRAY, true ) );


			// Now registering/localizing our JavaScript file, passing all the PHP variables we'll need in our $final_array_of_php_values array, to be accessed from 'wpbooklist_php_variables' object (like wpbooklist_php_variables.nameofkey, like any other JavaScript object).
			wp_localize_script( 'maxfootedb_adminjs', 'maxfooteDbPhpVariables', $final_array_of_php_values );

			wp_enqueue_script( 'maxfootedb_adminjs' );

		}

		/**
		 * Adding the frontend js file
		 */
		public function maxfootedb_frontend_js() {

			wp_register_script( 'maxfootedb_frontendjs', MAXFOOTEDB_JS_URL . 'maxfootedb_frontend.min.js', array( 'jquery' ), MAXFOOTEDB_VERSION_NUM, true );			

			$final_array_of_php_values = array();

			// Adding some other individual values we may need.
			$final_array_of_php_values['MAXFOOTEDB_ROOT_IMG_ICONS_URL']   = MAXFOOTEDB_ROOT_IMG_ICONS_URL;
			$final_array_of_php_values['MAXFOOTEDB_ROOT_IMG_URL']   = MAXFOOTEDB_ROOT_IMG_URL;			
			$final_array_of_php_values['DB_PREFIX'] = $wpdb->prefix;

			// Now grab all of our Nonces to pass to the JavaScript for the Ajax functions and merge with the Translations array.
			$final_array_of_php_values = array_merge( $final_array_of_php_values, json_decode( MAXFOOTEDB_FINAL_NONCES_ARRAY, true ) );

			wp_localize_script( 'maxfootedb_frontendjs', 'maxfooteDbPhpVariables', $final_array_of_php_values );

			wp_enqueue_script( 'maxfootedb_frontendjs' );

		}

		/**
		 * Adding the admin css file
		 */
		public function maxfootedb_admin_style() {

			wp_register_style( 'maxfootedb_adminui', MAXFOOTEDB_CSS_URL . 'maxfootedb-main-admin.css', null, MAXFOOTEDB_VERSION_NUM );
			wp_enqueue_style( 'maxfootedb_adminui' );

		}

		/**
		 * Adding the frontend css file
		 */
		public function maxfootedb_frontend_style() {

			wp_register_style( 'maxfootedb_frontendui', MAXFOOTEDB_CSS_URL . 'maxfootedb-main-frontend.css', null, MAXFOOTEDB_VERSION_NUM );
			wp_enqueue_style( 'maxfootedb_frontendui' );

		}

		/**
		 *  Function to add table names to the global $wpdb.
		 */
		public function maxfootedb_register_table_name() {
			global $wpdb;
			$wpdb->maxfootedb_settings = "{$wpdb->prefix}maxfootedb_settings";
			$wpdb->maxfootedb_vendors = "{$wpdb->prefix}maxfootedb_vendors";
			$wpdb->maxfootedb_vendor_cities = "{$wpdb->prefix}maxfootedb_vendor_cities";
			$wpdb->maxfootedb_vendor_zips = "{$wpdb->prefix}maxfootedb_vendor_zips";
			$wpdb->maxfootedb_vendor_trades = "{$wpdb->prefix}maxfootedb_vendor_trades";
			$wpdb->maxfootedb_vendor_certs = "{$wpdb->prefix}maxfootedb_vendor_certs";
		}

		/**
		 *  Function that calls the Style and Scripts needed for displaying of admin pointer messages.
		 */
		public function maxfootedb_admin_pointers_javascript() {
			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_script( 'utils' );
		}

		/**
		 *  Runs once upon plugin activation and creates the table that holds info on Maxfoote Pages & Posts.
		 */
		public function maxfootedb_create_tables() {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			global $wpdb;
			global $charset_collate;

			// Call this manually as we may have missed the init hook.
			$this->maxfootedb_register_table_name();

			$sql_create_table1 = "CREATE TABLE {$wpdb->maxfootedb_settings}
			(
				ID bigint(190) auto_increment,
				repw varchar(255),
				PRIMARY KEY  (ID),
				KEY repw (repw)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'maxfootedb_settings';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table1 );
				$table_name = $wpdb->prefix . 'maxfootedb_settings';
				$wpdb->insert( $table_name, array( 'ID' => 1, ) );
			}

			$sql_create_table2 = "CREATE TABLE {$wpdb->maxfootedb_vendors}
			(
				ID bigint(190) auto_increment,
				vendorname varchar(255),
				vendortype varchar(255),
				vendorcerts varchar(255),
				vendorlicense varchar(255),
				vendortrade varchar(255),
				vendoraddress varchar(255),
				vendoraddress2 varchar(255),
				vendorcity varchar(255),
				vendorstate varchar(255),
				vendorzip varchar(255),
				vendorphone varchar(255),
				vendorcontact varchar(255),
				vendoremail varchar(255),
				vendorenterprise varchar(255),
				vendorlastupdated varchar(255),
				eventlocation MEDIUMTEXT,
				PRIMARY KEY  (ID),
				KEY vendorname (vendorname)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'maxfootedb_vendors';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table2 );
			}

			$sql_create_table3 = "CREATE TABLE {$wpdb->maxfootedb_vendor_cities}
			(
				ID bigint(190) auto_increment,
				vendorcity varchar(255),
				PRIMARY KEY  (ID),
				KEY vendorcity (vendorcity)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'maxfootedb_vendor_cities';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table3 );
			}

			$sql_create_table4 = "CREATE TABLE {$wpdb->maxfootedb_vendor_zips}
			(
				ID bigint(190) auto_increment,
				vendorzip varchar(255),
				PRIMARY KEY  (ID),
				KEY vendorzip (vendorzip)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'maxfootedb_vendor_zips';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table4 );
			}

			$sql_create_table5 = "CREATE TABLE {$wpdb->maxfootedb_vendor_trades}
			(
				ID bigint(190) auto_increment,
				vendortrade varchar(255),
				PRIMARY KEY  (ID),
				KEY vendortrade (vendortrade)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'maxfootedb_vendor_trades';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table5 );
			}

			$sql_create_table6 = "CREATE TABLE {$wpdb->maxfootedb_vendor_certs}
			(
				ID bigint(190) auto_increment,
				vendorcert varchar(255),
				PRIMARY KEY  (ID),
				KEY vendorcert (vendorcert)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'maxfootedb_vendor_certs';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table6 );
			}

		}

		/**
		 *  The shortcode for displaying the login form / register forms / dashboard.
		 */
		public function maxfootedb_vendor_frontend_submission_shortcode_function() {
			echo 'test';
			ob_start();
			include_once MAXFOOTEDB_CLASS_DIR . 'class-maxfootedb-dashboard-ui.php';
			$front_end_ui = new MaxFootedb_Dashboard_UI();
			return ob_get_clean();

		}

	}
endif;
