<?php

/**
 * Maxfoote Book Display Options Form Tab Class - class-maxfoote-book-display-options-form.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('Maxfoote_settings2_Form', false)) :






	/**
	 * Maxfoote_Admin_Menu Class.
	 */
	class Maxfoote_settings2_Form
	{


		public $vendor_table    = '';
		public $vendordbresults = array();
		public $create_opening_html = '';
		public $create_individual_vendors_html = '';
		public $create_closing_html = '';
		public $final_echoed_html = '';


		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct()
		{

			global $wpdb;
			$this->vendor_table    = $wpdb->prefix . 'maxfootedb_vendors';
			$this->vendordbresults = $wpdb->get_results("SELECT * FROM $this->vendor_table");

			$this->create_opening_html();

			$this->create_individual_vendors_html();

			$this->create_closing_html();









			var_dump( print_r($this->vendordbresults, true) );







		}

		/**
		 * Outputs all HTML elements on the page.
		 */
		public function output_settings2_form()
		{
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
		public function create_opening_html()
		{
			global $wpdb;

			$string1 = '<div id="maxfoote-display-options-container">
							<p class="maxfoote-tab-intro-para">This is some intro text for Settings 2</p>
						</div>';


			$this->create_opening_html = $string1;
		}


		/**
		 * Outputs all HTML elements on the page.
		 */
		public function create_individual_vendors_html()
		{
			global $wpdb;

			$string1 = '';
			foreach ($this->vendordbresults as $key => $value) {

				//html for each vendor's info on Settings 2 tab
				$string1 = $string1 . '
					<div class="maxfoote-vendor-udpate-container">
						
						<div class="accordion maxfoote-vendor-update-container-accordion-heading">
							' . $value->vendorname . '
						</div>
						<div class="maxfoote-vendor-update-info-container" style="display: none;">

							<div class="maxfoote-vendor-update-info-container-data" id="maxfoote-vendor-info-'. $value->ID .'">

									<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Name</label>
											<input value="' . $value->vendorname . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorname" data-dbname="vendorname" id="vendorname'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Type</label>
											<input value="' . $value->vendortype . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendortype" data-dbname="vendortype" id="vendortype'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Certfications</label>
											<input value="' . $value->vendorcerts . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorcerts" data-dbname="vendorcerts" id="vendorcerts'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor License</label>
											<input value="' . $value->vendorlicense . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorlicense" data-dbname="vendorlicense" id="vendorlicense'.$value->ID.'" type="text">
										</div>
										</div>
										<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Trade</label>
											<input value="' . $value->vendortrade . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendortrade" data-dbname="vendortrade" id="vendortrade'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Address</label>
											<input value="' . $value->vendoraddress . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendoraddress" data-dbname="vendoraddress" id="vendoraddress'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Address2</label>
											<input value="' . $value->vendoraddress2 . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendoraddress2" data-dbname="vendoraddress2" id="vendoraddress2'.$value->ID.'" type="text">
										</div>
										</div>
										<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor City</label>
											<input value="' . $value->vendorcity . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorcity" data-dbname="vendorcity" id="vendorcity'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor State</label>
											<input value="' . $value->vendorstate . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" class="maxfoote-form-newsite-vendorstate" data-dbname="vendorstate" id="vendorstate'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Zip</label>
											<input value="' . $value->vendorzip . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorzip" data-dbname="vendorzip" id="vendorzip'.$value->ID.'" type="text">
										</div>
										</div>
										<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Phone</label>
											<input value="' . $value->vendorphone . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorphone" data-dbname="vendorphone" id="vendorphone'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Contact</label>
											<input value="' . $value->vendorcontact . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorcontact" data-dbname="vendorcontact" id="vendorcontact'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Email</label>
											<input value="' . $value->vendoremail . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendoremail" data-dbname="vendoremail" id="vendoremail'.$value->ID.'" type="text">
										</div>
										</div>
										<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Enterprise</label>
											<input value="' . $value->vendorenterprise . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorenterprise" data-dbname="vendorenterprise" id="vendorenterprise'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Last Updated</label>
											<input value="' . $value->vendorlastupdated . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorlastupdated" data-dbname="vendorlastupdated" id="vendorlastupdated'.$value->ID.'" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Event Location</label>
											<input value="' . $value->eventlocation . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorlicense" data-dbname="vendorlicense" id="vendovendorlicensername'.$value->ID.'" type="text">
										</div>
									</div>
								</div>


								<div class="maxfoote-vendor-update-info-buttons-container">

									<div class="maxfoote-vendor-inner-top-container-buttons-actual">
										<!-- build a save edits button and a delete button -->
										<!-- create the ability for changes made to be actually saved in the database. This will require the whole Ajax functionality workflow, with javascript function, associated ajax fucntion in out ajax file, and the none and function defininitons in our main root maxfootedb.php file -->
										<button class="maxfoote-update-vendor" data-dbid="'. $value->ID .'">UPDATE VENDOR</button>
										<button class="maxfoote-delete-vendor" data-dbid="'. $value->ID .'">DELETE VENDOR</button>
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
		public function create_closing_html()
		{
			global $wpdb;

			$string1 = '<div id="maxfoote-display-options-closing-container">
							<p class="maxfoote-tab-intro-para">This is closing text message</p>
						</div>';


			$this->create_closing_html = $string1;
		}



		/**
		 * Outputs all HTML elements on the page.
		 */
		public function stitch_ui_html()
		{

			$this->final_echoed_html = $this->create_opening_html . $this->create_individual_vendors_html . $this->create_closing_html;
		}
	}
endif;
