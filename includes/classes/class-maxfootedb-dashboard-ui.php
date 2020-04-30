

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
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Name</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorname" data-dbname="vendorname" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Type</label>
							<select name="type" id="maxfoote-form-newsite-vendortype" data-dbname="vendortype">
								<option value="" default disabled selected>Select A Vendor Type</option>
								<option value="Subcontractor">Subcontractor</option>
								<option value="Subcontractor">Supplier</option>
								<option value="Subcontractor">Other</option>
							</select>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">List All Active Certifications</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorcerts" data-dbname="vendorcerts" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor License</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorlicense" data-dbname="vendorlicense" type="text" />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Trade</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendortrade" data-dbname="vendortrade" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Address Line 1</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendoraddress" data-dbname="vendoraddress" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Address Line 2</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendoraddress2" data-dbname="vendoraddress2" type="text" />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor City</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorcity" data-dbname="vendorcity" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor State</label>
							<select name="state" id="maxfoote-form-newsite-vendorstate" data-dbname="vendorstate">
								<option value="" default disabled selected>Select A State...</option>
								<option value="AL">Alabama</option>
								<option value="AK">Alaska</option>
								<option value="AZ">Arizona</option>
								<option value="AR">Arkansas</option>
								<option value="CA">California</option>
								<option value="CO">Colorado</option>
								<option value="CT">Connecticut</option>
								<option value="DE">Delaware</option>
								<option value="DC">District of Columbia</option>
								<option value="FL">Florida</option>
								<option value="GA">Georgia</option>
								<option value="HI">Hawaii</option>
								<option value="ID">Idaho</option>
								<option value="IL">Illinois</option>
								<option value="IN">Indiana</option>
								<option value="IA">Iowa</option>
								<option value="KS">Kansas</option>
								<option value="KY">Kentucky</option>
								<option value="LA">Louisiana</option>
								<option value="ME">Maine</option>
								<option value="MD">Maryland</option>
								<option value="MA">Massachusetts</option>
								<option value="MI">Michigan</option>
								<option value="MN">Minnesota</option>
								<option value="MS">Mississippi</option>
								<option value="MO">Missouri</option>
								<option value="MT">Montana</option>
								<option value="NE">Nebraska</option>
								<option value="NV">Nevada</option>
								<option value="NH">New Hampshire</option>
								<option value="NJ">New Jersey</option>
								<option value="NM">New Mexico</option>
								<option value="NY">New York</option>
								<option value="NC">North Carolina</option>
								<option value="ND">North Dakota</option>
								<option value="OH">Ohio</option>
								<option value="OK">Oklahoma</option>
								<option value="OR">Oregon</option>
								<option value="PA">Pennsylvania</option>
								<option value="RI">Rhode Island</option>
								<option value="SC">South Carolina</option>
								<option value="SD">South Dakota</option>
								<option value="TN">Tennessee</option>
								<option value="TX">Texas</option>
								<option value="UT">Utah</option>
								<option value="VT">Vermont</option>
								<option value="VA">Virginia</option>
								<option value="WA">Washington</option>
								<option value="WV">West Virginia</option>
								<option value="WI">Wisconsin</option>
								<option value="WY">Wyoming</option>
							</select>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Zip</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorzip" data-dbname="vendorzip" type="text" />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Phone</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorphone" data-dbname="vendorphone" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Contact</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorcontact" data-dbname="vendorcontact" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Email</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendoremail" data-dbname="vendoremail" type="text" />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Enterprise</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorenterprise" data-dbname="vendorenterprise" type="text" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Last Updated</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-vendorlastupdated" data-dbname="vendorlastupdated" type="date" />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label-frontend">Vendor Notes</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text"
								id="maxfoote-form-newsite-eventlocation" data-dbname="eventlocation" type="text" />
						</div>
					</div>
				</div>
				<button id="maxfoote-user-add-vendor">SAVE VENDOR</button>
				<div class="maxfoote-spinner"></div>
				<div class="maxfoote-displayentries-response-div-actual-container"></div>				
				';

			echo $this->random_html;
		}
	}
endif;
