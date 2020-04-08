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


		public $vendor_table    = '';
		public $vendordbresults = array();
		public $create_opening_html = '';
		public $create_individual_vendors_html = '';
		public $create_closing_html = '';
		public $final_echoed_html = '';


		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {

			global $wpdb;
			$this->vendor_table    = $wpdb->prefix . 'maxfootedb_vendors';
			$this->vendordbresults = $wpdb->get_results( "SELECT * FROM $this->vendor_table" );

			$this->create_opening_html();

			$this->create_individual_vendors_html();

			$this->create_closing_html();





			



			//var_dump( print_r($this->vendordbresults, true) );





			

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

			$this->stitch_ui_html();
			echo $string1 . $this->final_echoed_html;
		}




		/**
		 * Outputs all HTML elements on the page.
		 */
		public function create_opening_html() {
			global $wpdb;

			$string1 = '<div id="maxfoote-display-options-container">
							<p class="maxfoote-tab-intro-para">This is some intro text for Settings 2</p>
						</div>';


			$this->create_opening_html = $string1;
		}


		/**
		 * Outputs all HTML elements on the page.
		 */
		public function create_individual_vendors_html() {
			global $wpdb;

			$string1 = '';
			foreach ( $this->vendordbresults as $key => $value ) {

				
				$string1 = $string1 . '
					<div class="maxfoote-vendor-top-level-container">
						<div class="maxfoote-vendor-top-level-container-title-clicker">
							' . $value->vendorname . '
						</div>
						<div class="maxfoote-vendor-inner-top-container">

							<div class="maxfoote-vendor-inner-top-container-actualdbfields">

								<!-- Build out the rest of the form, complete with saved values from the database -->


								<div class="maxfoote-form-section-fields-wrapper">
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label">Vendor Name</label>
										<input value="' . $value->vendorname . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-vendorname" data-dbname="vendorname" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label">Vendor Type</label>
										<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-vendortype" data-dbname="vendortype" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label">Vendor Certfications</label>
										<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-vendorcerts" data-dbname="vendorcerts" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label">Vendor License</label>
										<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-vendorlicense" data-dbname="vendorlicense" type="text">
									</div>
								</div>
							</div>


							<div class="maxfoote-vendor-inner-top-container-buttons">

								<div class="maxfoote-vendor-inner-top-container-buttons-actual">
									<!-- build a save edits button and a delete button -->
									<!-- create the ability for changes made to be actually saved in the database. This will require the whole Ajax functionality workflow, with javascript function, associated ajax fucntion in out ajax file, and the none and function defininitons in our main root maxfootedb.php file -->
								</div>

								<div class="maxfoote-vendor-inner-top-container-buttons-response">
									<!-- for a response to the user about whatever button they clicked above -->
								</div>
							</div>



						</div>


					</div>';




			}


			


			$this->create_individual_vendors_html = $string1;
		}










		/**
		 * Outputs all HTML elements on the page.
		 */
		public function create_closing_html() {
			global $wpdb;

			$string1 = '<div id="maxfoote-display-options-closing-container">
							<p class="maxfoote-tab-intro-para">This is closing text message</p>
						</div>';


			$this->create_closing_html = $string1;
		}



		/**
		 * Outputs all HTML elements on the page.
		 */
		public function stitch_ui_html() {
			
			$this->final_echoed_html = $this->create_opening_html . $this->create_individual_vendors_html . $this->create_closing_html;
			

		}



	}
endif;
