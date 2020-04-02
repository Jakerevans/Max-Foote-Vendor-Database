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

if (!class_exists('Maxfoote_Settings1_Form', false)) :

	/**
	 * Maxfoote_Admin_Menu Class.
	 */
	class Maxfoote_Settings1_Form
	{


		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct()
		{
		}

		/**
		 * Outputs all HTML elements on the page.
		 */
		public function output_settings1_form()
		{
			global $wpdb;

			/*
				Below is a default contact form using default class names, ids, and custom data attributes, with associated default styling found in the "BEGIN CSS FOR COMMON FORM FILL" section of the maxfootedb-admin-ui.scss file. The custom data attribute "data-dbname" is supposed to hold the exact name of the corresponding database column in the database, prefixed with a description of the kind of "object" we're working with. For example, if I were creating an App that needed to save Student data, I would probably call that database table 'studentdata' and each column in that database would begin with 'student'. So, I would replace all instances below of data-dbname="contact with data-dbname="student. I would also replace each instance of id="maxfoote-form-contact with id="maxfoote-form-student. If I were creating an app that needed to track customer info, and not students, I would replace all instances below of data-dbname="contact with data-dbname="customer. I would also replace each instance of id="maxfoote-form-contact with id="maxfoote-form-customer.
			*/
			$contact_form_html = '
				<div class="maxfoote-form-section-wrapper">
					<div class="maxfoote-form-section-title-wrapper">
							<p class="maxfoote-form-subtitle">General Site Information</p>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">URL</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-url" data-dbname="contactfirstname" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Kickoff Date</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-kickoffdate" data-dbname="contactlastname" type="date"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Completion Date</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-completiondate" data-dbname="contactemail" type="date"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Launch Date</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-launchdate" data-dbname="contactnull" type="date"  />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Is Site Live and Active?</label>
							<select class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-select" id="maxfoote-form-newsite-active" data-dbname="contactstate">
								<option selected default disabled>Choose an Option...</option>
								<option value="yes">Yes</option>
								<option value="no">No</option>
							</select>
						</div>
					</div>
				</div>
				<div class="maxfoote-form-section-wrapper">
					<div class="maxfoote-form-section-title-wrapper">
							<p class="maxfoote-form-subtitle">Client Information</p>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Company Name</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-companyname" data-dbname="contactfirstname" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Main Contact Name</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-maincontactname" data-dbname="contactlastname" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Main Contact Email</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-maincontactemail" data-dbname="contactemail" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Main Contact Phone</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-maincontactnumber" data-dbname="contactnull" type="text"  />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Industry</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-industry" data-dbname="contactphone" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Total Value Price</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-totalvalueprice" data-dbname="contactstreetaddress1" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Do We Host This?</label>
							<select class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-select" id="maxfoote-form-newsite-whohosts" data-dbname="contactstate">
								<option selected default disabled>Choose an Option...</option>
								<option value="yes">Yes</option>
								<option value="no">No</option>
							</select>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Hosting Rate (Monthly)</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-hostingrate" data-dbname="contactcity" type="text"  />
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Support Rate</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-supportrate" data-dbname="contactcity" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Monthly Support Hours</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-monthlysupporthours" data-dbname="contactcity" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">PITA Scale</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-form-newsite-pitascale" data-dbname="contactcity" type="number"  max="10" min="1"/>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Discount Information</label>
							<textarea id="maxfoote-form-newsite-discountinfo" style="width: 250px; height: 75px;" placeholder="If this website\'s price was discounted, provide info as to why here, otherwise leave blank."></textarea>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Upload Contract</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-upload-file-input-contract" data-dbname="contactcity" type="number"  max="10" min="1"/>
							<button class="maxfoote-upload-file-button" id="maxfoote-upload-file-button-contract">Choose File</button>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Upload Scope of Work</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text" id="maxfoote-upload-file-input-sow" data-dbname="contactcity" type="number"  max="10" min="1"/>
							<button class="maxfoote-upload-file-button" id="maxfoote-upload-file-button-sow">Choose File</button>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input id="maxfoote-form-newsite-googlereview" type="checkbox" type="checkbox" />
							<label class="maxfoote-form-section-fields-checkbox-label">Asked for a Google Review?</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input id="maxfoote-form-newsite-mailing" type="checkbox" type="checkbox" />
							<label class="maxfoote-form-section-fields-checkbox-label">Sent Launch Mailing?</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<label class="maxfoote-form-section-fields-label maxfoote-form-subtitle-subtitle">Upsells</label>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" type="checkbox" value="1" />
							<label class="maxfoote-form-section-fields-checkbox-label">Built With Accessibility</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="2" />
							<label class="maxfoote-form-section-fields-checkbox-label">Accessibility Tool</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="3" />
							<label class="maxfoote-form-section-fields-checkbox-label">Worry-Free WordPress</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="4" />
							<label class="maxfoote-form-section-fields-checkbox-label">Photography</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="5" />
							<label class="maxfoote-form-section-fields-checkbox-label">Content Writing</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="6" />
							<label class="maxfoote-form-section-fields-checkbox-label">Videography</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="7" />
							<label class="maxfoote-form-section-fields-checkbox-label">User Journey Analysis</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="8" />
							<label class="maxfoote-form-section-fields-checkbox-label">Shopify Consulting</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="9" />
							<label class="maxfoote-form-section-fields-checkbox-label">Priority Fee</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="10" />
							<label class="maxfoote-form-section-fields-checkbox-label">Additional E-Commerce Products</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="11" />
							<label class="maxfoote-form-section-fields-checkbox-label">Logo Recreation</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="12" />
							<label class="maxfoote-form-section-fields-checkbox-label">Logo Design & Creation</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="13" />
							<label class="maxfoote-form-section-fields-checkbox-label">Brandbook</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="14" />
							<label class="maxfoote-form-section-fields-checkbox-label">Brand-On-A-Page</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-upsells" type="checkbox" value="15" />
							<label class="maxfoote-form-section-fields-checkbox-label">Executive Design Package</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input data-ignore="false" data-grouped="true" data-sep="--p--" data-required="true" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-checkbox" data-dbtype="%s" data-dbname="propertyhunts" type="checkbox" value="Other" id="maxfoote-form-section-fields-input-text-additional-upsells-other"/>
							<label class="maxfoote-form-section-fields-checkbox-label" style="margin-bottom: 10px;">Other</label>
							<div class="maxfoote-form-section-fields-input-text-additional-upsells-hidden">
								<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-section-fields-input-text-additional-upsell" id="maxfoote-form-contactcity" data-dbname="contactcity" type="text"  />
								<div id="maxfoote-form-section-fields-input-text-additional-upsell" class="maxfoote-form-section-fields-new-thing-control"><p>Add Additional Upsell</p><img class="maxfoote-form-section-addnewstuff-icon" src="' . MAXFOOTEDB_ROOT_IMG_URL . 'plus.svg" /></div>
							</div>
						</div>
					</div>
				</div>
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
				<div class="maxfoote-form-section-wrapper">
					<div class="maxfoote-form-section-title-wrapper">
							<p class="maxfoote-form-subtitle">Technical Information</p>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">CMS</label>
							<input id="maxfoote-form-newsite-cms" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Theme Name</label>
							<input id="maxfoote-form-newsite-theme" type="text"  />
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Page Count</label>
							<input id="maxfoote-form-newsite-pagecount" type="number"  min="1"/>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Site Type?</label>
							<select id="maxfoote-form-newsite-sitetype" class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-select">
								<option selected default disabled>Choose an Option...</option>
								<option value="regular">Regular Website</option>
								<option value="spw">Single-Page Website</option>
								<option value="lp">Landing Page</option>
							</select>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">Plugins</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-section-fields-input-text-additional-plugins" id="maxfoote-form-newsite-plugins" type="text"  />
							<div id="maxfoote-form-section-fields-new-plugin-control" class="maxfoote-form-section-fields-new-thing-control"><p>Add Additional Plugin</p><img class="maxfoote-form-section-addnewstuff-icon" src="' . MAXFOOTEDB_ROOT_IMG_URL . 'plus.svg" /></div>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<label class="maxfoote-form-section-fields-label">3rd-Party Integrations</label>
							<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-section-fields-input-text-additional-3rdparty" id="maxfoote-form-newsite-thirdparty" type="text"  />
							<div id="maxfoote-form-section-fields-new-3rdparty-control" class="maxfoote-form-section-fields-new-thing-control"><p>Add Additional 3rd-Party Integrations</p><img class="maxfoote-form-section-addnewstuff-icon" src="' . MAXFOOTEDB_ROOT_IMG_URL . 'plus.svg" /></div>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper">
						<label class="maxfoote-form-section-fields-label maxfoote-form-subtitle-subtitle">Website Features</label>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="1" />
							<label class="maxfoote-form-section-fields-checkbox-label">Ads</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="2" />
							<label class="maxfoote-form-section-fields-checkbox-label">Application Form</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="3" />
							<label class="maxfoote-form-section-fields-checkbox-label">Biographies</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="4" />
							<label class="maxfoote-form-section-fields-checkbox-label">Blog Articles</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="5" />
							<label class="maxfoote-form-section-fields-checkbox-label">Booth Reservations</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="6" />
							<label class="maxfoote-form-section-fields-checkbox-label">Breadcrumbs</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="7" />
							<label class="maxfoote-form-section-fields-checkbox-label">Calculators</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="8" />
							<label class="maxfoote-form-section-fields-checkbox-label">Calendars</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="9" />
							<label class="maxfoote-form-section-fields-checkbox-label">Class Schedules</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="10" />
							<label class="maxfoote-form-section-fields-checkbox-label">Click-To-Call</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="11" />
							<label class="maxfoote-form-section-fields-checkbox-label">Client Portal</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="12" />
							<label class="maxfoote-form-section-fields-checkbox-label">Custom Development Work</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="13" />
							<label class="maxfoote-form-section-fields-checkbox-label">Custom Plugin Creation</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="14" />
							<label class="maxfoote-form-section-fields-checkbox-label">Customer Portal</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="15" />
							<label class="maxfoote-form-section-fields-checkbox-label">Directories</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="16" />
							<label class="maxfoote-form-section-fields-checkbox-label">Divi Builder</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="17" />
							<label class="maxfoote-form-section-fields-checkbox-label">Donations</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="18" />
							<label class="maxfoote-form-section-fields-checkbox-label">E-Commerce</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="19" />
							<label class="maxfoote-form-section-fields-checkbox-label">Elementor</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="20" />
							<label class="maxfoote-form-section-fields-checkbox-label">Audio</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="21" />
							<label class="maxfoote-form-section-fields-checkbox-label">Embedded PDFs</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="22" />
							<label class="maxfoote-form-section-fields-checkbox-label">Events</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="23" />
							<label class="maxfoote-form-section-fields-checkbox-label">FAQs</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="24" />
							<label class="maxfoote-form-section-fields-checkbox-label">Financial Calculators</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="25" />
							<label class="maxfoote-form-section-fields-checkbox-label">Flipbooks</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="26" />
							<label class="maxfoote-form-section-fields-checkbox-label">Floorplans</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="27" />
							<label class="maxfoote-form-section-fields-checkbox-label">Food/Drink Menus</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="28" />
							<label class="maxfoote-form-section-fields-checkbox-label">Forum</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="29" />
							<label class="maxfoote-form-section-fields-checkbox-label">Gated Content</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="30" />
							<label class="maxfoote-form-section-fields-checkbox-label">Hero Slider</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="31" />
							<label class="maxfoote-form-section-fields-checkbox-label">Hero Video</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="32" />
							<label class="maxfoote-form-section-fields-checkbox-label">Image Gallery</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="33" />
							<label class="maxfoote-form-section-fields-checkbox-label">Interactive Map</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="34" />
							<label class="maxfoote-form-section-fields-checkbox-label">Job Application Form</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="35" />
							<label class="maxfoote-form-section-fields-checkbox-label">Live Chat</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="36" />
							<label class="maxfoote-form-section-fields-checkbox-label">Maps</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="37" />
							<label class="maxfoote-form-section-fields-checkbox-label">Membership Portal</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="38" />
							<label class="maxfoote-form-section-fields-checkbox-label">Mobile App Download Links</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="39" />
							<label class="maxfoote-form-section-fields-checkbox-label">News Articles</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="40" />
							<label class="maxfoote-form-section-fields-checkbox-label">Newsletter Integration</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="41" />
							<label class="maxfoote-form-section-fields-checkbox-label">Online Bill Pay</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="42" />
							<label class="maxfoote-form-section-fields-checkbox-label">Online Booking</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="43" />
							<label class="maxfoote-form-section-fields-checkbox-label">Online Ordering</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="44" />
							<label class="maxfoote-form-section-fields-checkbox-label">Online Reservations</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="45" />
							<label class="maxfoote-form-section-fields-checkbox-label">Online Scheduling</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="46" />
							<label class="maxfoote-form-section-fields-checkbox-label">Parallax Scrolling</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="47" />
							<label class="maxfoote-form-section-fields-checkbox-label">Paywalls</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="48" />
							<label class="maxfoote-form-section-fields-checkbox-label">Podcasts</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="49" />
							<label class="maxfoote-form-section-fields-checkbox-label">Popups</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="50" />
							<label class="maxfoote-form-section-fields-checkbox-label">Portfolio</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="51" />
							<label class="maxfoote-form-section-fields-checkbox-label">Privacy Policy</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="52" />
							<label class="maxfoote-form-section-fields-checkbox-label">Qode Slider</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="53" />
							<label class="maxfoote-form-section-fields-checkbox-label">Online Quotes</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="54" />
							<label class="maxfoote-form-section-fields-checkbox-label">Registration Form</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="55" />
							<label class="maxfoote-form-section-fields-checkbox-label">Reviews</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="56" />
							<label class="maxfoote-form-section-fields-checkbox-label">RevSlider</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="57" />
							<label class="maxfoote-form-section-fields-checkbox-label">RevSlider Theme</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="58" />
							<label class="maxfoote-form-section-fields-checkbox-label">Scroll Hijacking</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="59" />
							<label class="maxfoote-form-section-fields-checkbox-label">Search</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="60" />
							<label class="maxfoote-form-section-fields-checkbox-label">Social Media Feed Integration</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="61" />
							<label class="maxfoote-form-section-fields-checkbox-label">Staff Biographies</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="62" />
							<label class="maxfoote-form-section-fields-checkbox-label">Testimonials</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="63" />
							<label class="maxfoote-form-section-fields-checkbox-label">Ticket Sales</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="64" />
							<label class="maxfoote-form-section-fields-checkbox-label">Video</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="65" />
							<label class="maxfoote-form-section-fields-checkbox-label">Video Backgrounds</label>
						</div>
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="66" />
							<label class="maxfoote-form-section-fields-checkbox-label">Virtual Tour</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input class="maxfoote-form-newsite-features" type="checkbox" value="67" />
							<label class="maxfoote-form-section-fields-checkbox-label">WP Bakery</label>
						</div>
					</div>
					<div class="maxfoote-form-section-fields-wrapper maxfoote-form-section-fields-checkboxes-wrapper maxfoote-form-section-fields-checkboxes-upsells-wrapper">
						<div class="maxfoote-form-section-fields-indiv-wrapper">
							<input type="checkbox" value="Other" id="maxfoote-form-section-fields-input-checkbox-features-other"/>
							<label class="maxfoote-form-section-fields-checkbox-label" style="margin-bottom: 10px;">Other</label>
							<div class="maxfoote-form-section-fields-input-text-additional-features-hidden">
								<input class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-text maxfoote-form-section-fields-input-text-additional-features"  data-dbname="contactcity" type="text"  />
								<div id="maxfoote-form-section-fields-new-feature-control" class="maxfoote-form-section-fields-new-thing-control"><p>Add Additional Website Feature</p><img class="maxfoote-form-section-addnewstuff-icon" src="' . MAXFOOTEDB_ROOT_IMG_URL . 'plus.svg" /></div>
							</div>
						</div>
					</div>
				</div>
				<div class="maxfoote-displayentries-response-div-wrapper">
					<button class="maxfoote-form-section-fields-input maxfoote-form-section-fields-input-button maxfoote-form-section-fields-input-button-addwebsite">Add Website</button>
					<div class="maxfoote-spinner"></div>
					<div class="maxfoote-displayentries-response-div-actual-container"></div>
				</div>';

			$string1 = '
				<div id="maxfoote-display-options-container">
					<p class="maxfoote-tab-intro-para">Add a New Website to our Database by filling out the information below. The most important items to fill out are the 3 Dates directly below, the Industry, the Upsells Section, the 3rd-Party Integrations Section, and the Website Features Section.</p>
					<p class="maxfoote-tab-intro-para">The info you provide below will allow us to Upsell items in the near future, as well as provide us a comprehensive, searchable Database of types of websites we\'ve created, features on those websites, 3rd-party integrations, etc., which will help us easily find solutions for any Potential Client\'s needs and also quickly find example sites by Industry to provide Potential Clients. It all starts with entering the best-quality information you can below!</p>
					<div class="maxfoote-form-wrapper">
						' . $contact_form_html . '
					</div>
				</div>';

			echo $string1;
		}
	}
endif;
