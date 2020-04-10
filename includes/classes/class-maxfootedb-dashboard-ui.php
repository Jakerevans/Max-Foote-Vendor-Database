

<?php
/**
 * MaxFootedb_Dashboard_UI_Dashboard_UI Class that dispalys the login form or the user dashboard - class-maxfootedb-dashboard-ui.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('MaxFootedb_Dashboard_UI', false)) :


	// Goal: Create front end functionality to allow a vendor to create a new entry into the db
	// Template: 


	/**
	 * MaxFootedb_Dashboard_UI_Admin_Menu Class.
	 */
	class MaxFootedb_Dashboard_UI
	{

		public $randomvariable                         = false;



		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct()
		{


			$this->display_vendor_submission_form();
		}

		/**
		 * Outputs the HTML for the login/register forms.
		 */
		public function display_vendor_submission_form()
		{
			global $wpdb;



			$this->random_html = '
			<div class="maxfoote-form-section-wrapper">
					<div class="maxfoote-form-section-title-wrapper">
						<p class="maxfoote-form-subtitle">Vendor Information</p>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Name</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorname" data-dbname="vendorname" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Type</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendortype" data-dbname="vendortype" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Certfications</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorcerts" data-dbname="vendorcerts" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor License</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorlicense" data-dbname="vendorlicense" type="text" />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Trade</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendortrade" data-dbname="vendortrade" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Address Line 1</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendoraddress" data-dbname="vendoraddress" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Address Line 2</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendoraddress2" data-dbname="vendoraddress2" type="text" />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor City</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorcity" data-dbname="vendorcity" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor State</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorstate" data-dbname="vendorstate" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Zip</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorzip" data-dbname="vendorzip" type="text" />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Phone</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorphone" data-dbname="vendorphone" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Contact</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorcontact" data-dbname="vendorcontact" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Email</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendoremail" data-dbname="vendoremail" type="text" />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Enterprise</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorenterprise" data-dbname="vendorenterprise" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Vendor Last Updated</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorlastupdated" data-dbname="vendorlastupdated" type="date" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Event Location</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-eventlocation" data-dbname="eventlocation" type="text" />
						</div>
					</div>
				</div>
				<button id="maxfoote-user-add-vendor">SAVE VENDOR</button>
			';

			echo $this->random_html;
		}
	}
endif;
