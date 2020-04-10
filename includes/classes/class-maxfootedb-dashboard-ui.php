

<?php
/**
 * MaxFootedb_Dashboard_UI_Dashboard_UI Class that dispalys the login form or the user dashboard - class-maxfootedb-dashboard-ui.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MaxFootedb_Dashboard_UI_Dashboard_UI', false ) ) :

	/**
	 * MaxFootedb_Dashboard_UI_Admin_Menu Class.
	 */
	class MaxFootedb_Dashboard_UI_Dashboard_UI {

		public $randomvariable                         = false;



		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {


			$this->display_vendor_submission_form();

		}

		/**
		 * Outputs the HTML for the login/register forms.
		 */
		public function display_vendor_submission_form() {
			global $wpdb;

			

			$this->random_html = '<div>Junk html</div>';

			echo $this->random_html;

		}




	}
endif;