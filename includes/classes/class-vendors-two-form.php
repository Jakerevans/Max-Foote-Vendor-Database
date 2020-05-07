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
		public $create_search_ui_html = '';
		public $create_search_ui_results_html = '';
		public $create_individual_vendors_html = '';
		public $create_pagination_html = '';
		public $create_closing_html = '';
		public $final_echoed_html = '';
		public $final_grabbed_params = '';
		public $total_vendors_count = 0;
		public $pagination_display_limit = 2;


		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct()
		{


			// $this->grab_url_params();

			$this->query_db();

			$this->create_opening_html();

			$this->create_search_ui();

			$this->create_individual_vendors_html();

			$this->create_pagination_html();

			$this->create_closing_html();
		}

		/**
		 * Function to house all logic required to query the database depending on URL params, if any exist.
		 */
		public function query_db()
		{

			function console_log($output)
			{
				$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
					');';
				echo $js_code;
			}

			global $wpdb;
			$this->vendor_table    = $wpdb->prefix . 'maxfootedb_vendors';
			$this->vendordbresults = $wpdb->get_results("SELECT * FROM $this->vendor_table LIMIT $this->pagination_display_limit");

			$count_query = "select count(*) from $this->vendor_table";
    		$this->total_vendors_count = $wpdb->get_var( $count_query );





			// URI
			$uri = $_SERVER['REQUEST_URI'];

			$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

			// Full URL
			$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			// Query String
			$query = $_SERVER['QUERY_STRING'];

			$search_city = $_GET['city'];
			$search_state = $_GET['state'];
			$search_zip = $_GET['zip'];
			$search_trade = $_GET['trade'];
			$search_certs = $_GET['certs'];

			// echo $search_state;

			$this->vendor_search_city_results = $wpdb->get_results("SELECT * FROM $this->vendor_table WHERE vendorcity = '" . $search_city . "'");
			$this->vendor_search_state_results = $wpdb->get_results("SELECT * FROM $this->vendor_table WHERE vendorstate = '" . $search_state . "'");
			$this->vendor_search_zip_results = $wpdb->get_results("SELECT * FROM $this->vendor_table WHERE vendorzip = '" . $search_zip . "'");
			$this->vendor_search_trade_results = $wpdb->get_results("SELECT * FROM $this->vendor_table WHERE vendortrade = '" . $search_trade . "'");
			$this->vendor_search_certs_results = $wpdb->get_results("SELECT * FROM $this->vendor_table WHERE vendorcerts = '" . $search_certs . "'");

			$this->vendor_final_search_results = array();

			// console_log($this->vendor_final_search_results);

			foreach ($this->vendor_search_city_results as $vendor) {
				if (!in_array($vendor, $this->vendor_final_search_results)) {
					array_push($this->vendor_final_search_results, $vendor);
				}
			}

			foreach ($this->vendor_search_state_results as $vendor) {
				if (!in_array($vendor, $this->vendor_final_search_results)) {
					array_push($this->vendor_final_search_results, $vendor);
				}
			}

			foreach ($this->vendor_search_zip_results as $vendor) {
				if (!in_array($vendor, $this->vendor_final_search_results)) {
					array_push($this->vendor_final_search_results, $vendor);
				}
			}

			foreach ($this->vendor_search_trade_results as $vendor) {
				if (!in_array($vendor, $this->vendor_final_search_results)) {
					array_push($this->vendor_final_search_results, $vendor);
				}
			}

			foreach ($this->vendor_search_certs_results as $vendor) {
				if (!in_array($vendor, $this->vendor_final_search_results)) {
					array_push($this->vendor_final_search_results, $vendor);
				}
			}
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
							<p class="maxfoote-tab-intro-para">Here you can Edit, Delete, and Search through the current Vendors in the Database.</p>
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

			$string1 = '';


			$this->create_opening_html = $string1;
		}

		/**
		 * Creates the Search UI.
		 */
		public function create_search_ui()
		{
			global $wpdb;

			$vendor_cities_table = $wpdb->prefix . 'maxfootedb_vendor_cities';

			$vendor_cities_in_db = $wpdb->get_results("SELECT * FROM $vendor_cities_table");

			sort($vendor_cities_in_db);

			$cities_html = '<option value="" default disabled selected>Select A City...</option>';

			foreach ($vendor_cities_in_db as $city) {
				$cities_html = $cities_html . "<option>" . $city->vendorcity . "</option>";
			}

			$vendor_zips_table = $wpdb->prefix . 'maxfootedb_vendor_zips';

			$vendor_zips_in_db = $wpdb->get_results("SELECT * FROM $vendor_zips_table");

			sort($vendor_zips_in_db);

			$zips_html = '<option value="" default disabled selected>Select A Zip...</option>';

			foreach ($vendor_zips_in_db as $zip) {
				$zips_html = $zips_html . "<option>" . $zip->vendorzip . "</option>";
			}

			$vendor_trades_table = $wpdb->prefix . 'maxfootedb_vendor_trades';

			$vendor_trades_in_db = $wpdb->get_results("SELECT * FROM $vendor_trades_table");

			sort($vendor_trades_in_db);

			$trades_html = '<option value="" default disabled selected>Select A Trade...</option>';

			foreach ($vendor_trades_in_db as $trade) {
				$trades_html = $trades_html . "<option>" . $trade->vendortrade . "</option>";
			}

			$vendor_certs_table = $wpdb->prefix . 'maxfootedb_vendor_certs';

			$vendor_certs_in_db = $wpdb->get_results("SELECT * FROM $vendor_certs_table");

			sort($vendor_certs_in_db);

			$certs_html = '<option value="" default disabled selected>Select A Cert...</option>';

			foreach ($vendor_certs_in_db as $cert) {
				$certs_html = $certs_html . "<option>" . $cert->vendorcert . "</option>";
			}

			$string1 = '<div class="maxfoote-display-search-ui-top-container">
							<span class="maxfoote-tab-intro-para">Select your search options below</span>
							<div class="maxfoote-display-search-ui-inner-container">
								<div class="maxfoote-display-search-ui-search-fields-container">
									<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper maxfoote-search-field">
											<label class="maxfoote-form-section-fields-label">City</label>
											<select id="maxfootedb-search-cities">' .	$cities_html	. '</select>
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper maxfoote-search-field">
											<label class="maxfoote-form-section-fields-label">State</label>
											<select id="maxfootedb-search-states" name="search_state">
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
										<div class="maxfoote-form-section-fields-indiv-wrapper maxfoote-search-field">
											<label class="maxfoote-form-section-fields-label">Zip</label>
											<select id="maxfootedb-search-zips">' .	$zips_html	. '</select>
										</div>
									</div>
									<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper maxfoote-search-field">
											<label class="maxfoote-form-section-fields-label">Trade</label>
											<select id="maxfootedb-search-trades">' .	$trades_html	. '</select>
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper maxfoote-search-field">
											<label class="maxfoote-form-section-fields-label">Certifications</label>
											<select id="maxfootedb-search-certs">' .	$certs_html	. '</select>
										</div>
									</div>

								</div>
								<div class="maxfoote-display-search-ui-search-buttons-container">
									<button id="maxfootedb-search-button" class="maxfoote-search-ui-buttons">Search</button>
									<button id="maxfoote-toggle-all-vendors" class="maxfoote-search-ui-buttons">Show/Hide All Vendors</button>
									<button id="maxfoote-reset-search-fields" class="maxfoote-search-ui-buttons">Reset Search Fields</button>
								</div>
							</div>
						</div>
						';

			$search_results_vendors = $this->vendor_final_search_results;

			
			function check_select_option($value_in_db, $option)
			{
				if ($value_in_db === $option) {
					return ('selected="selected"');
				};
			};

			$string2 = '';
			foreach ($search_results_vendors as $key => $value) {
				// console_log($value);

				$string2 = $string2 . '
					<div style="display:none;" class="maxfoote-vendor-udpate-container maxfoote-search-vendors">
					<button class="accordion maxfoote-vendor-update-container-accordion-heading maxfoote-vendor-search-udpate-container-update-heading">
						' . $value->vendorname . '
					</button>
					<div class="maxfoote-vendor-update-info-container" style="display:none;">

						<div class="maxfoote-vendor-update-info-container-data" id="maxfoote-vendor-search-info-' . $value->ID . '">

								<div class="maxfoote-form-section-fields-wrapper">
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Name</label>
										<input value="' . $value->vendorname . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorname" data-dbname="vendorname" id="search_vendorname' . $value->ID . '" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Type</label>
										<select name="type" id="search_vendortype' . $value->ID . '" data-dbname="vendortype">
											<option value="" default disabled selected>Select A Vendor Type</option>
											<option value="Subcontractor" ' . check_select_option($value->vendortype,"Subcontractor") . '>Subcontractor</option>
											<option value="Supplier" ' . check_select_option($value->vendortype,"Supplier") . '>Supplier</option>
											<option value="Other" ' . check_select_option($value->vendortype,"Other") . '>Other</option>
										</select>
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Certfications</label>
										<input value="' . $value->vendorcerts . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorcerts" data-dbname="vendorcerts" id="search_vendorcerts' . $value->ID . '" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor License</label>
										<input value="' . $value->vendorlicense . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorlicense" data-dbname="vendorlicense" id="search_vendorlicense' . $value->ID . '" type="text">
									</div>
									</div>
									<div class="maxfoote-form-section-fields-wrapper">
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Trade</label>
										<input value="' . $value->vendortrade . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendortrade" data-dbname="vendortrade" id="search_vendortrade' . $value->ID . '" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Address</label>
										<input value="' . $value->vendoraddress . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendoraddress" data-dbname="vendoraddress" id="search_vendoraddress' . $value->ID . '" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Address2</label>
										<input value="' . $value->vendoraddress2 . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendoraddress2" data-dbname="vendoraddress2" id="search_vendoraddress2' . $value->ID . '" type="text">
									</div>
									</div>
									<div class="maxfoote-form-section-fields-wrapper">
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor City</label>
										<input value="' . $value->vendorcity . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorcity" data-dbname="vendorcity" id="search_vendorcity' . $value->ID . '" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor State</label>

										<select data-dbname="vendorstate" id="maxfootedb-search-states' . $value->ID . '">
											<option value="" default disabled selected>Select A State...</option>
											<option value="AL" ' . check_select_option($value->vendorstate, "AL") . '>Alabama</option>
											<option value="AK" ' . check_select_option($value->vendorstate, "AK") . '>Alaska</option>
											<option value="AZ" ' . check_select_option($value->vendorstate, "AZ") . '>Arizona</option>
											<option value="AR" ' . check_select_option($value->vendorstate, "AR") . '>Arkansas</option>
											<option value="CA" ' . check_select_option($value->vendorstate, "CA") . '>California</option>
											<option value="CO" ' . check_select_option($value->vendorstate, "CO") . '>Colorado</option>
											<option value="CT" ' . check_select_option($value->vendorstate, "CT") . '>Connecticut</option>
											<option value="DE" ' . check_select_option($value->vendorstate, "DE") . '>Delaware</option>
											<option value="DC" ' . check_select_option($value->vendorstate, "DC") . '>District of Columbia</option>
											<option value="FL" ' . check_select_option($value->vendorstate, "FL") . '>Florida</option>
											<option value="GA" ' . check_select_option($value->vendorstate, "GA") . '>Georgia</option>
											<option value="HI" ' . check_select_option($value->vendorstate, "HI") . '>Hawaii</option>
											<option value="ID" ' . check_select_option($value->vendorstate, "ID") . '>Idaho</option>
											<option value="IL" ' . check_select_option($value->vendorstate, "IL") . '>Illinois</option>
											<option value="IN" ' . check_select_option($value->vendorstate, "IN") . '>Indiana</option>
											<option value="IA" ' . check_select_option($value->vendorstate, "IA") . '>Iowa</option>
											<option value="KS" ' . check_select_option($value->vendorstate, "KS") . '>Kansas</option>
											<option value="KY" ' . check_select_option($value->vendorstate, "KY") . '>Kentucky</option>
											<option value="LA" ' . check_select_option($value->vendorstate, "LA") . '>Louisiana</option>
											<option value="ME" ' . check_select_option($value->vendorstate, "ME") . '>Maine</option>
											<option value="MD" ' . check_select_option($value->vendorstate, "MD") . '>Maryland</option>
											<option value="MA" ' . check_select_option($value->vendorstate, "MA") . '>Massachusetts</option>
											<option value="MI" ' . check_select_option($value->vendorstate, "MI") . '>Michigan</option>
											<option value="MN" ' . check_select_option($value->vendorstate, "MN") . '>Minnesota</option>
											<option value="MS" ' . check_select_option($value->vendorstate, "MS") . '>Mississippi</option>
											<option value="MO" ' . check_select_option($value->vendorstate, "MO") . '>Missouri</option>
											<option value="MT" ' . check_select_option($value->vendorstate, "MT") . '>Montana</option>
											<option value="NE" ' . check_select_option($value->vendorstate, "NE") . '>Nebraska</option>
											<option value="NV" ' . check_select_option($value->vendorstate, "NV") . '>Nevada</option>
											<option value="NH" ' . check_select_option($value->vendorstate, "NH") . '>New Hampshire</option>
											<option value="NJ" ' . check_select_option($value->vendorstate, "NJ") . '>New Jersey</option>
											<option value="NM" ' . check_select_option($value->vendorstate, "NM") . '>New Mexico</option>
											<option value="NY" ' . check_select_option($value->vendorstate, "NY") . '>New York</option>
											<option value="NC" ' . check_select_option($value->vendorstate, "NC") . '>North Carolina</option>
											<option value="ND" ' . check_select_option($value->vendorstate, "ND") . '>North Dakota</option>
											<option value="OH" ' . check_select_option($value->vendorstate, "OH") . '>Ohio</option>
											<option value="OK" ' . check_select_option($value->vendorstate, "OK") . '>Oklahoma</option>
											<option value="OR" ' . check_select_option($value->vendorstate, "OR") . '>Oregon</option>
											<option value="PA" ' . check_select_option($value->vendorstate, "PA") . '>Pennsylvania</option>
											<option value="RI" ' . check_select_option($value->vendorstate, "RI") . '>Rhode Island</option>
											<option value="SC" ' . check_select_option($value->vendorstate, "SC") . '>South Carolina</option>
											<option value="SD" ' . check_select_option($value->vendorstate, "SD") . '>South Dakota</option>
											<option value="TN" ' . check_select_option($value->vendorstate, "TN") . '>Tennessee</option>
											<option value="TX" ' . check_select_option($value->vendorstate, "TX") . '>Texas</option>
											<option value="UT" ' . check_select_option($value->vendorstate, "UT") . '>Utah</option>
											<option value="VT" ' . check_select_option($value->vendorstate, "VT") . '>Vermont</option>
											<option value="VA" ' . check_select_option($value->vendorstate, "VA") . '>Virginia</option>
											<option value="WA" ' . check_select_option($value->vendorstate, "WA") . '>Washington</option>
											<option value="WV" ' . check_select_option($value->vendorstate, "WV") . '>West Virginia</option>
											<option value="WI" ' . check_select_option($value->vendorstate, "WI") . '>Wisconsin</option>
											<option value="WY" ' . check_select_option($value->vendorstate, "WY") . '>Wyoming</option>
										</select>

									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Zip</label>
										<input value="' . $value->vendorzip . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorzip" data-dbname="vendorzip" id="search_vendorzip' . $value->ID . '" type="text">
									</div>
									</div>
									<div class="maxfoote-form-section-fields-wrapper">
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Phone</label>
										<input value="' . $value->vendorphone . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorphone" data-dbname="vendorphone" id="search_vendorphone' . $value->ID . '" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Contact</label>
										<input value="' . $value->vendorcontact . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorcontact" data-dbname="vendorcontact" id="search_vendorcontact' . $value->ID . '" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Email</label>
										<input value="' . $value->vendoremail . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendoremail" data-dbname="vendoremail" id="search_vendoremail' . $value->ID . '" type="text">
									</div>
									</div>
									<div class="maxfoote-form-section-fields-wrapper">
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Enterprise</label>
										<input value="' . $value->vendorenterprise . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorenterprise" data-dbname="vendorenterprise" id="search_vendorenterprise' . $value->ID . '" type="text">
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Vendor Last Updated</label>
										<div class="maxfoote-form-newsite-search-vendorlastupdated" data-dbname="vendorlastupdated" id="search_vendorlastupdated' . $value->ID . '">' . $value->vendorlastupdated . '</div>
									</div>
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Event Location</label>
										<input value="' . $value->eventlocation . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-eventlocation" data-dbname="eventlocation" id="search_eventlocation' . $value->ID . '" type="text">
									</div>
								</div>
								<div class="maxfoote-form-section-fields-wrapper maxfoote-vendor-notes">
									<div class="maxfoote-form-section-fields-indiv-wrapper">
										<label class="maxfoote-form-section-fields-label maxfoote-search-label">Notes</label>
										<textarea value="' . $value->vendornotes . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendornotes" data-dbname="vendornotes" id="search_vendornotes' . $value->ID . '" type="text"></textarea>
									</div>
								</div>
							</div>


							<div class="maxfoote-vendor-update-info-buttons-container">

								<div class="maxfoote-vendor-inner-top-container-buttons-actual">
									<!-- build a save edits button and a delete button -->
									<!-- create the ability for changes made to be actually saved in the database. This will require the whole Ajax functionality workflow, with javascript function, associated ajax fucntion in out ajax file, and the none and function defininitons in our main root maxfootedb.php file -->
									<button class="maxfoote-update-vendor" query-type="search" data-dbid="' . $value->ID . '">UPDATE VENDOR</button>
									<button class="maxfoote-delete-vendor" query-type="search" data-dbid="' . $value->ID . '">DELETE VENDOR</button>
									<div class="maxfoote-spinner"></div>
									<div class="maxfoote-displayentries-response-div-actual-container"></div>
								</div>

								<div class="maxfoote-vendor-inner-top-container-buttons-response">
									<!-- for a response to the user about whatever button they clicked above -->
								</div>
							</div>
						</div>
					</div>									
				';
			}

			$this->create_search_ui_html = $string1 . $string2;
		}


		/**
		 * Outputs all HTML elements on the page.
		 */
		public function create_individual_vendors_html()
		{
			global $wpdb;

			function select_state($state_in_db, $state_option)
			{
				if ($state_in_db === $state_option) {
					return ('selected="selected"');
				};
			};

			$string1 = '';
			foreach ($this->vendordbresults as $key => $value) {

				//html for each vendor's info on Settings 2 tab
				$string1 = $string1 . '
					<div class="maxfoote-vendor-udpate-container maxfoote-all-vendors" >
						
						<button class="accordion maxfoote-vendor-update-container-accordion-heading">
							' . $value->vendorname . '
						</button>
						<div class="maxfoote-vendor-update-info-container" style="display: none;">

							<div class="maxfoote-vendor-update-info-container-data" id="maxfoote-vendor-info-' . $value->ID . '">

									<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Name</label>
											<input value="' . $value->vendorname . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorname" data-dbname="vendorname" id="vendorname' . $value->ID . '" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Type</label>
											<select name="type" id="maxfoote-form-admin-vendortype' . $value->ID . '" data-dbname="vendortype">
												<option value="" default disabled selected>Select A Vendor Type</option>
												<option value="Subcontractor" ' . check_select_option($value->vendortype,"Subcontractor") . '>Subcontractor</option>
												<option value="Supplier" ' . check_select_option($value->vendortype,"Supplier") . '>Supplier</option>
												<option value="Other" ' . check_select_option($value->vendortype,"Other") . '>Other</option>
											</select>
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Certfications</label>
											<input value="' . $value->vendorcerts . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorcerts" data-dbname="vendorcerts" id="maxfoote-form-admin-vendorcerts' . $value->ID . '" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor License</label>
											<input value="' . $value->vendorlicense . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorlicense" data-dbname="vendorlicense" id="maxfoote-form-admin-vendorlicense' . $value->ID . '" type="text">
										</div>
										</div>
										<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Trade</label>
											<input value="' . $value->vendortrade . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendortrade" data-dbname="vendortrade" id="maxfoote-form-admin-vendortrade' . $value->ID . '" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Address</label>
											<input value="' . $value->vendoraddress . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendoraddress" data-dbname="vendoraddress" id="maxfoote-form-admin-vendoraddress' . $value->ID . '" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Address2</label>
											<input value="' . $value->vendoraddress2 . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendoraddress2" data-dbname="vendoraddress2" id="maxfoote-form-admin-vendoraddress2' . $value->ID . '" type="text">
										</div>
										</div>
										<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor City</label>
											<input value="' . $value->vendorcity . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorcity" data-dbname="vendorcity" id="maxfoote-form-admin-vendorcity' . $value->ID . '" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor State</label>

											<select data-dbname="vendorstate" id="maxfoote-form-admin-vendorstate' . $value->ID . '">
												<option value="" default disabled selected>Select A State...</option>
												<option value="AL" ' . select_state($value->vendorstate, "AL") . '>Alabama</option>
												<option value="AK" ' . select_state($value->vendorstate, "AK") . '>Alaska</option>
												<option value="AZ" ' . select_state($value->vendorstate, "AZ") . '>Arizona</option>
												<option value="AR" ' . select_state($value->vendorstate, "AR") . '>Arkansas</option>
												<option value="CA" ' . select_state($value->vendorstate, "CA") . '>California</option>
												<option value="CO" ' . select_state($value->vendorstate, "CO") . '>Colorado</option>
												<option value="CT" ' . select_state($value->vendorstate, "CT") . '>Connecticut</option>
												<option value="DE" ' . select_state($value->vendorstate, "DE") . '>Delaware</option>
												<option value="DC" ' . select_state($value->vendorstate, "DC") . '>District of Columbia</option>
												<option value="FL" ' . select_state($value->vendorstate, "FL") . '>Florida</option>
												<option value="GA" ' . select_state($value->vendorstate, "GA") . '>Georgia</option>
												<option value="HI" ' . select_state($value->vendorstate, "HI") . '>Hawaii</option>
												<option value="ID" ' . select_state($value->vendorstate, "ID") . '>Idaho</option>
												<option value="IL" ' . select_state($value->vendorstate, "IL") . '>Illinois</option>
												<option value="IN" ' . select_state($value->vendorstate, "IN") . '>Indiana</option>
												<option value="IA" ' . select_state($value->vendorstate, "IA") . '>Iowa</option>
												<option value="KS" ' . select_state($value->vendorstate, "KS") . '>Kansas</option>
												<option value="KY" ' . select_state($value->vendorstate, "KY") . '>Kentucky</option>
												<option value="LA" ' . select_state($value->vendorstate, "LA") . '>Louisiana</option>
												<option value="ME" ' . select_state($value->vendorstate, "ME") . '>Maine</option>
												<option value="MD" ' . select_state($value->vendorstate, "MD") . '>Maryland</option>
												<option value="MA" ' . select_state($value->vendorstate, "MA") . '>Massachusetts</option>
												<option value="MI" ' . select_state($value->vendorstate, "MI") . '>Michigan</option>
												<option value="MN" ' . select_state($value->vendorstate, "MN") . '>Minnesota</option>
												<option value="MS" ' . select_state($value->vendorstate, "MS") . '>Mississippi</option>
												<option value="MO" ' . select_state($value->vendorstate, "MO") . '>Missouri</option>
												<option value="MT" ' . select_state($value->vendorstate, "MT") . '>Montana</option>
												<option value="NE" ' . select_state($value->vendorstate, "NE") . '>Nebraska</option>
												<option value="NV" ' . select_state($value->vendorstate, "NV") . '>Nevada</option>
												<option value="NH" ' . select_state($value->vendorstate, "NH") . '>New Hampshire</option>
												<option value="NJ" ' . select_state($value->vendorstate, "NJ") . '>New Jersey</option>
												<option value="NM" ' . select_state($value->vendorstate, "NM") . '>New Mexico</option>
												<option value="NY" ' . select_state($value->vendorstate, "NY") . '>New York</option>
												<option value="NC" ' . select_state($value->vendorstate, "NC") . '>North Carolina</option>
												<option value="ND" ' . select_state($value->vendorstate, "ND") . '>North Dakota</option>
												<option value="OH" ' . select_state($value->vendorstate, "OH") . '>Ohio</option>
												<option value="OK" ' . select_state($value->vendorstate, "OK") . '>Oklahoma</option>
												<option value="OR" ' . select_state($value->vendorstate, "OR") . '>Oregon</option>
												<option value="PA" ' . select_state($value->vendorstate, "PA") . '>Pennsylvania</option>
												<option value="RI" ' . select_state($value->vendorstate, "RI") . '>Rhode Island</option>
												<option value="SC" ' . select_state($value->vendorstate, "SC") . '>South Carolina</option>
												<option value="SD" ' . select_state($value->vendorstate, "SD") . '>South Dakota</option>
												<option value="TN" ' . select_state($value->vendorstate, "TN") . '>Tennessee</option>
												<option value="TX" ' . select_state($value->vendorstate, "TX") . '>Texas</option>
												<option value="UT" ' . select_state($value->vendorstate, "UT") . '>Utah</option>
												<option value="VT" ' . select_state($value->vendorstate, "VT") . '>Vermont</option>
												<option value="VA" ' . select_state($value->vendorstate, "VA") . '>Virginia</option>
												<option value="WA" ' . select_state($value->vendorstate, "WA") . '>Washington</option>
												<option value="WV" ' . select_state($value->vendorstate, "WV") . '>West Virginia</option>
												<option value="WI" ' . select_state($value->vendorstate, "WI") . '>Wisconsin</option>
												<option value="WY" ' . select_state($value->vendorstate, "WY") . '>Wyoming</option>
											</select>

										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Zip</label>
											<input value="' . $value->vendorzip . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorzip" data-dbname="vendorzip" id="maxfoote-form-admin-vendorzip' . $value->ID . '" type="text">
										</div>
										</div>
										<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Phone</label>
											<input value="' . $value->vendorphone . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorphone" data-dbname="vendorphone" id="maxfoote-form-admin-vendorphone' . $value->ID . '" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Contact</label>
											<input value="' . $value->vendorcontact . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorcontact" data-dbname="vendorcontact" id="maxfoote-form-admin-vendorcontact' . $value->ID . '" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Email</label>
											<input value="' . $value->vendoremail . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendoremail" data-dbname="vendoremail" id="maxfoote-form-admin-vendoremail' . $value->ID . '" type="text">
										</div>
										</div>
										<div class="maxfoote-form-section-fields-wrapper">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Enterprise</label>
											<input value="' . $value->vendorenterprise . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendorenterprise" data-dbname="vendorenterprise" id="maxfoote-form-admin-vendorenterprise' . $value->ID . '" type="text">
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Vendor Last Updated</label>
											<div class="maxfoote-form-newsite-vendorlastupdated" data-dbname="vendorlastupdated" id="maxfoote-form-admin-vendorlastupdated' . $value->ID . '">' . $value->vendorlastupdated . '</div>
										</div>
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Event Location</label>
											<input value="' . $value->eventlocation . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-eventlocation" data-dbname="eventlocation" id="maxfoote-form-admin-eventlocation' . $value->ID . '" type="text">
										</div>
									</div>
									<div class="maxfoote-form-section-fields-wrapper maxfoote-vendor-notes">
										<div class="maxfoote-form-section-fields-indiv-wrapper">
											<label class="maxfoote-form-section-fields-label">Notes</label>
											<textarea value="' . $value->vendornotes . '" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-newsite-vendornotes" data-dbname="vendornotes" id="maxfoote-form-admin-vendornotes' . $value->ID . '" type="text"></textarea>
										</div>
									</div>
								</div>


								<div class="maxfoote-vendor-update-info-buttons-container">

									<div class="maxfoote-vendor-inner-top-container-buttons-actual">
										<!-- build a save edits button and a delete button -->
										<!-- create the ability for changes made to be actually saved in the database. This will require the whole Ajax functionality workflow, with javascript function, associated ajax fucntion in out ajax file, and the none and function defininitons in our main root maxfootedb.php file -->
										<button class="maxfoote-update-vendor" query-type="all-vendors" data-dbid="' . $value->ID . '">UPDATE VENDOR</button>
										<button class="maxfoote-delete-vendor" query-type="all-vendors" data-dbid="' . $value->ID . '">DELETE VENDOR</button>
										<div class="maxfoote-spinner"></div>
										<div class="maxfoote-displayentries-response-div-actual-container"></div>
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
		public function create_pagination_html()
		{
			global $wpdb;

			//$this->total_vendors_count

			$pagination_option_html = '';
			echo $loop_control_whole_numbers = floor( $this->total_vendors_count / $this->pagination_display_limit );
			for ($i=0; $i < $loop_control_whole_numbers; $i++) { 
				$pagination_option_html = $pagination_option_html  . '<option>Page ' . ( $i + 1 ) . '</option>';
			}





			$string1 = '
				<div class="maxfoote-pagination-top-container">
					<div class="maxfoote-pagination-inner-container">

						<div>
							<div>Previous</div>
							<div>
								<select>
									' . $pagination_option_html . '
								</select>
							</div>
							<div>Next</div>

						</div>

					</div>


				</div>
			';


			$this->create_pagination_html = $string1;
		}






		/**
		 * Outputs all HTML elements on the page.
		 */
		public function create_closing_html()
		{
			global $wpdb;

			$string1 = '';


			$this->create_closing_html = $string1;
		}



		/**
		 * Outputs all HTML elements on the page.
		 */
		public function stitch_ui_html()
		{

			$this->final_echoed_html = $this->create_opening_html . $this->create_search_ui_html . $this->create_individual_vendors_html . $this->create_pagination_html . $this->create_closing_html;
		}
	}
endif;
