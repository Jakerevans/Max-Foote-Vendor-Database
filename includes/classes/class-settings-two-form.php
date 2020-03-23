<?php
/**
 * Maxfoote Book Display Options Form Tab Class - class-maxfoote-book-display-options-form.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Maxfoote_settings2_Form', false ) ) :

	/**
	 * Maxfoote_Admin_Menu Class.
	 */
	class Maxfoote_settings2_Form {


		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {

			

		}

		/**
		 * Outputs all HTML elements on the page.
		 */
		public function output_settings2_form() {
			global $wpdb;

			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			$string1 = '<div id="maxfoote-display-options-container">
							<p class="maxfoote-tab-intro-para">This is some intro text for Settings 2</p>
						</div>';


			echo $string1;
		}
	}
endif;
