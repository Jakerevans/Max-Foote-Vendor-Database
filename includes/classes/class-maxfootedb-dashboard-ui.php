

<?php
/**
 * MedWestHealthPoints_Dashboard_UI Class that dispalys the login form or the user dashboard - class-medwesthealthpoints-dashboard-ui.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MedWestHealthPoints_Dashboard_UI', false ) ) :

	/**
	 * MedWestHealthPoints_Admin_Menu Class.
	 */
	class MedWestHealthPoints_Dashboard_UI {

		public $userloggedin                         = false;
		public $usertype                             = false;
		public $userobject                           = null;
		public $username                             = false;
		public $loginform_text                       = 'Already a Member? Log in below!';
		public $userapproved                         = false;
		public $currentwpuserid                      = 0;
		public $login_form_html                      = '';
		public $register_buttons_html                = '';
		public $common_dashboard_closing_html_output = '';
		public $common_dashboard_opening_html_output = '';

		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {

			// For grabbing an image from media library.
			wp_enqueue_media();

			// See if we have a currently logged-in user.
			$loggedin = is_user_logged_in();

			// If user is logged in...
			if ( $loggedin ) {

				global $wpdb;
				$currentwpuserid  = get_current_user_id();
				$this->userobject = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_users WHERE userwpuserid = ' . $currentwpuserid );
			


			} else {
				

				$this->stitch_final_register_html();



			}

		}

		/**
		 * Outputs the HTML for the login/register forms.
		 */
		public function display_login_form() {
			global $wpdb;

			$args = array(
				'echo'           => false,
				'remember'       => true,
				'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
				'form_id'        => 'medwesthealthpoints-dashboard-login-row-wrapper',
				'id_username'    => 'user_login',
				'id_password'    => 'user_pass',
				'id_remember'    => 'rememberme',
				'id_submit'      => 'wp-submit',
				'label_username' => __( 'Username' ),
				'label_password' => __( 'Password' ),
				'label_remember' => __( 'Remember Me' ),
				'label_log_in'   => __( 'Log In' ),
				'value_username' => '',
				'value_remember' => false
			);

			$this->login_form_html = '<div id="medwesthealthpoints-dashboard-container">
							<div id="medwesthealthpoints-dashboard-login-wrapper">
								<p class="medwesthealthpoints-tab-intro-para">' . $this->loginform_text . '</p>' . wp_login_form( $args ) . '</div><div class="medwesthealthpoints-spinner" id="medwesthealthpoints-spinner-1"></div></div>';









						

		}



		/**
		 * Outputs the HTML for the register buttons.
		 */
		public function display_register_buttons() {
			global $wpdb;

			$this->register_buttons_html = '
						<div id="medwesthealthpoints-dashboard-register-options-wrapper">
							<div class="medwesthealthpoints-dashboard-register-options-indiv-wrapper">
								<p class="medwesthealthpoints-tab-intro-para">Not a Member?<br/>Join This Thing Below!</p>
								<button id="medwesthealthpoints-join-as-vet" >Join This Thing<br/>Today!</button>
							</div>
						</div>';
		}

		/**
		 * Outputs the HTML for the Veteran signup form.
		 */
		public function display_default_signup_forms() {

			$this->vet_signup_form_html = '
						<div class="medwesthealthpoints-dashboard-join-form-wrapper medwesthealthpoints-displayentries-indiv-innerwrapper-form" id="medwesthealthpoints-dashboard-veteran-join-form-wrapper">
								<div class="medwesthealthpoints-displayentries-indiv-innerwrapper-form-wrapper">
									<div class="medwesthealthpoints-form-section-wrapper">
										<div class="whitetail-warriors-how-it-works-wrapper">
											<p id="whitetail-warriors-how-this-works-title">How This Works!</p>
											<ul>
												<li>Step 1</li>
												<li>Step 2</li>
												<li>Step 3</li>
												<li>Step 4</li>
												<li>Step 5</li>
											</ul>
										</div>
										<div class="medwesthealthpoints-form-section-title-wrapper">
											<p>Contact Info</p>
										</div>
										<div style="display: inline-block;" class="medwesthealthpoints-form-section-fields-wrapper">
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">First Name</label>
												<input id="medwesthealthpoints-form-firstname" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text"  data-dbtype="%s" data-dbname="firstname" type="text"  />
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Last Name</label>
												<input id="medwesthealthpoints-form-lastname" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" data-dbtype="%s" data-dbname="lastname" type="text"  />
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper-emailconfirmblock">
												<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
													<label class="medwesthealthpoints-form-section-fields-label">E-Mail</label>
													<input id="medwesthealthpoints-form-email-veteran" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-email" data-dbtype="%email" data-dbname="email" type="text"  />
												</div>
												<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
													<label class="medwesthealthpoints-form-section-fields-label">Confirm E-Mail</label>
													<input id="medwesthealthpoints-form-confirmemail-veteran" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-emailconfirm" data-dbtype="%email" data-dbname="confirmemail" type="text"  />
												</div>
												<div class="medwesthealthpoints-confirmemail-block-message-div" data-activated="false"></div>
											</div>
										</div>
										<div class="medwesthealthpoints-form-section-fields-wrapper">
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Phone</label>
												<input id="medwesthealthpoints-form-phone" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text"  data-dbtype="%s" data-dbname="phone" type="text"  />
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Street Address 1</label>
												<input id="medwesthealthpoints-form-vetstreet1" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" data-dbtype="%s" data-dbname="vetstreet1" type="text" />
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Street Address 2</label>
												<input id="medwesthealthpoints-form-vetstreet2" data-ignore="true" data-required="false" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" data-dbtype="%s" data-dbname="vetstreet2" type="text" />
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">City</label>
												<input id="medwesthealthpoints-form-vetcity" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" id="medwesthealthpoints-form-vetcity" data-dbtype="%s" data-dbname="vetcity" type="text" />
											</div>
										</div>
										<div class="medwesthealthpoints-form-section-fields-wrapper">
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">State</label>
												<select id="medwesthealthpoints-form-vetstate" data-required="true" data-ignore="false" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-select" data-dbtype="%s" data-dbname="vetstate">
													<option value="default" selected default disabled>Select A State...</option>
													<option>AL</option><option>AK</option><option>AS</option><option>AZ</option><option>AR</option><option>CA</option><option>CO</option><option>CT</option><option>DE</option><option>DC</option><option>FM</option><option>FL</option><option>GA</option><option>GU</option><option>HI</option><option>ID</option><option>IL</option><option>IN</option><option>IA</option><option>KS</option><option>KY</option><option>LA</option><option>ME</option><option>MH</option><option>MD</option><option>MA</option><option>MI</option><option>MN</option><option>MS</option><option>MO</option><option>MT</option><option>NE</option><option>NV</option><option>NH</option><option>NJ</option><option>NM</option><option>NY</option><option>NC</option><option>ND</option><option>MP</option><option>OH</option><option>OK</option><option>OR</option><option>PW</option><option>PA</option><option>PR</option><option>RI</option><option>SC</option><option>SD</option><option>TN</option><option>TX</option><option>UT</option><option>VT</option><option>VI</option><option>VA</option><option>WA</option><option>WV</option><option>WI</option><option>WY</option><option>AE</option><option>AA</option><option>AP</option>
												</select>
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Zip</label>
												<input id="medwesthealthpoints-form-vetzip" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" data-dbtype="%d" data-dbname="vetzip" type="text" />
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Username</label>
												<input id="medwesthealthpoints-form-wpusername-vet" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-username" data-dbtype="%s" data-dbname="wpusername" type="text"  />
											</div>
										</div>
										<div class="medwesthealthpoints-form-section-fields-indiv-wrapper-passwordconfirmblock">
												<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
													<label class="medwesthealthpoints-form-section-fields-label">Password</label>
													<input id="medwesthealthpoints-form-password-vet" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-password" data-dbtype="%s" data-dbname="password" type="password"  />
												</div>
												<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
													<label class="medwesthealthpoints-form-section-fields-label">Confirm Password</label>
													<input id="medwesthealthpoints-form-confirmpassword-vet" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-passwordconfirm" data-dbtype="%s" data-dbname="confirmpassword" type="password"  />
												</div>
												<div class="medwesthealthpoints-confirmpassword-block-message-div" data-activated="false"></div>
											</div>
									</div>
								</div>
								<div class="medwesthealthpoints-displayentries-response-div-wrapper">
									<button class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-button-apply" data-idtosearchthrough="medwesthealthpoints-dashboard-veteran-join-form-wrapper" data-wptablename="medwesthealthpoints_veterans" data-wptableid="" data-wpuserneeded="true">Join This Thing!</button>
									<div class="medwesthealthpoints-spinner" id="medwesthealthpoints-dashboard-veteran-join-form-spinner"></div>
									<div class="medwesthealthpoints-displayentries-response-div-actual-container"></div>
								</div>
							</div>
						</div>';

		}

		/**
		 * Builds and outputs the final HTML for individuals to register.
		 */
		public function stitch_final_register_html() {

			$this->display_login_form();
			$this->display_register_buttons();
			$this->display_default_signup_forms();
			echo $this->login_form_html . $this->register_buttons_html . $this->vet_signup_form_html . $this->landowner_signup_form_html . $this->volunteer_signup_form_html;

		}

		/**
		 * Builds and outputs the final HTML for individuals who are already registered.
		 */
		public function stitch_final_member_html() {

			$this->loginform_text = 'Log in below!';
			$this->display_login_form();

			echo $this->login_form_html;
			
		}

		/**
		 * Builds the common opening HTML for the Dashboards.
		 */
		public function common_dashboard_opening_html() {

			$this->common_dashboard_opening_html_output = '
				<div class="medwesthealthpoints-dashboard-loggedin-form-wrapper medwesthealthpoints-displayentries-indiv-innerwrapper-form" id="medwesthealthpoints-dashboard-loggedin-top-wrapper">';
			
		}

		/**
		 * Builds the common closing HTML for the Dashboards...
		 */
		public function common_dashboard_closing_html() {

			$this->common_dashboard_closing_html_output = '</div>';

		}

		/**
		 * Builds the Logged-in Dashboard HTML for landowners...
		 */
		public function loggedin_dashboard_html() {

			$titlelinkstyle = '';
			if ( '' === $this->userpropertyobject->propertytitle || null === $this->userpropertyobject->propertytitle ) {
				$titlelinkstyle = 'style="pointer-events:none;"';
			}

			$insurancelinkstyle = '';
			if ( '' === $this->userpropertyobject->propertyinsurance || null === $this->userpropertyobject->propertyinsurance ) {
				$insurancelinkstyle = 'style="pointer-events:none;"';
			}

			$missing_info_text = '';

			if ( 'approved' === $this->userpropertyobject->approvalstatus ) {
				$missing_info_text = '<p style="color:black;" class="medwesthealthpoints-missing-dashboard-text">Looks like you\'re officially an approved Member of Whitetail Warriors! The Whitetail Warrior Admins will reach out to you when a Veterans requests a Hunt on your land.</p>';
			} else {
				$missing_info_text = '<p style="color:black;" class="medwesthealthpoints-missing-dashboard-text">Looks like we\'ve got everything we need from you! A Whitetail Warrior Admin will review your Membership request shortly.</p>';
			}

			if ( ( '' === $this->userpropertyobject->propertytitle || null === $this->userpropertyobject->propertytitle ) && ( '' !== $this->userpropertyobject->propertyinsurance && null !== $this->userpropertyobject->propertyinsurance ) ) {
				$missing_info_text = '<p class="medwesthealthpoints-missing-dashboard-text">To become an approved member of Whitetail Warriors, please provide your Land Title in the space below by clicking on the "Choose File" button, and then click the "Upload Files" button to complete your submission. You may also upload photos of your land, and modify the dates your land is available for hunting.</p>';
			}

			if ( ( '' === $this->userpropertyobject->propertyinsurance || null === $this->userpropertyobject->propertyinsurance ) && ( '' !== $this->userpropertyobject->propertytitle && null !== $this->userpropertyobject->propertytitle ) ) {
				$missing_info_text = '<p class="medwesthealthpoints-missing-dashboard-text">To become an approved member of Whitetail Warriors, please provide your Liability Insurance in the space below by clicking on the "Choose File" button, and then click the "Upload Files" button to complete your submission. You may also upload photos of your land, and modify the dates your land is available for hunting.</p>';
			}

			if ( ( '' === $this->userpropertyobject->propertytitle || null === $this->userpropertyobject->propertytitle ) && ( '' === $this->userpropertyobject->propertyinsurance || null === $this->userpropertyobject->propertyinsurance )  ) {
				$missing_info_text = '<p class="medwesthealthpoints-missing-dashboard-text">To become an approved member of Whitetail Warriors, please provide your Land Title and proof of Liability Insurance in the spaces below by clicking on the "Choose File" buttons, and then click the "Upload Files" button to complete your submission. You may also upload photos of your land, and modify the dates your land is available for hunting.</p>';
			}


			$images_html = '<div class="medwesthealthpoints-form-section-fields-wrapper">
									<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">';

			// If there are multiple images saved...
			if ( false !== stripos( $this->userpropertyobject->propertyimages, '--x--' ) ) {

				$images = explode( '--x--', $this->userpropertyobject->propertyimages );
				foreach ( $images as $imagekey => $value ) {

					$remove_html  = '';
					$label_margin = '';
					if ( 0 !== $imagekey ) {
						$remove_html  = '<img src="http://whitetail-warriors.local/wp-content/uploads/2019/06/delete-img.png" class="medwesthealthpoints-dashboard-images-remove-row"/>';
						$label_margin = 'style="margin-top:15px;"';
					}

					$images_html = $images_html . '
									<div class="medwesthealthpoints-form-section-fields-indiv-images-wrapper">
										<img src="' . $value . '" class="medwesthealthpoints-form-section-fields-choosen-image" />
										<input style="margin-right:4px;" data-grouped="true" data-sep="--x--" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" id="medwesthealthpoints-form-propertyimages-' . $imagekey . '" data-dbtype="%url" data-dbname="propertyimages" type="text" value="' . $value . '" />
										<button class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-file-upload-button" id="medwesthealthpoints-form-button-propertyimages-' . $imagekey . '" data-dbtype="%s" data-dbname="propertyimages-button">Choose Image</button>
									' . $remove_html . '</div>';
				}
			} else {

				// If there's only one image saved...
				if ( null !== $this->userpropertyobject->propertyimages && '' !== $this->userpropertyobject->propertyimages ) {

					$images_html = $images_html . '
								<div class="medwesthealthpoints-form-section-fields-indiv-images-wrapper">
									<img src="' . $this->userpropertyobject->propertyimages . '" class="medwesthealthpoints-form-section-fields-choosen-image" />
									<input style="margin-right:4px;" data-grouped="true" data-sep="--x--" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" id="medwesthealthpoints-form-propertyimages-0" data-dbtype="%url" data-dbname="propertyimages" type="text" value="' . $this->userpropertyobject->propertyimages . '" />
									<button class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-file-upload-button" id="medwesthealthpoints-form-button-propertyimages-0" data-dbtype="%s" data-dbname="propertyimages-button">Choose Image</button>
								</div>';
				} else {

					// If there are no images saved...
					$images_html = $images_html . '
								<div class="medwesthealthpoints-form-section-fields-indiv-images-wrapper">
									<img src="http://whitetail-warriors.local/wp-content/uploads/2019/06/placeholder-land-image.png" class="medwesthealthpoints-form-section-fields-choosen-image" />
									<input style="margin-right:4px;" data-grouped="true" data-sep="--x--" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" id="medwesthealthpoints-form-propertyimages-0" data-dbtype="%url" data-dbname="propertyimages" type="text" value="' . $this->userpropertyobject->propertyimages . '" />
									<button class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-file-upload-button" id="medwesthealthpoints-form-button-propertyimages-0" data-dbtype="%s" data-dbname="propertyimages-button">Choose Image</button>
								</div>';
				}
			}

			$images_html = $images_html . '</div>
								<div class="medwesthealthpoints-form-section-fields-new-images-control">Add More Images</div>
								</div>';

			// An example of multiple saved date data - 2019-06-06:2019-07-06;2019-08-08:2019-09-09...
			$dates_html = '<div class="medwesthealthpoints-form-section-fields-wrapper">
								<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">';

			// If there are multiple dates saved...
			if ( false !== stripos( $this->userpropertyobject->propertydatesopen, '--x--' ) ) {

				$dates = explode( '--x--', $this->userpropertyobject->propertydatesopen );
				foreach ( $dates as $datekey => $value ) {

					$indiv_dates = explode( '--p--', $value );

					$remove_html  = '';
					$label_margin = '';
					if ( 0 !== $datekey ) {
						$remove_html  = '<img src="http://whitetail-warriors.local/wp-content/uploads/2019/06/delete-img.png" class="medwesthealthpoints-date-remove-row"/>';
						$label_margin = 'style="margin-top:15px;"';
					} else {
						$remove_html  = '<img style="pointer-events: none; opacity:0;" src="http://whitetail-warriors.local/wp-content/uploads/2019/06/delete-img.png" class="medwesthealthpoints-date-remove-row"/>';
					}

					$dates_html = $dates_html . '
								<div class="medwesthealthpoints-form-section-fields-indiv-row-wrapper">
									<div class="medwesthealthpoints-form-section-fields-indiv-date-wrapper">
										<label ' . $label_margin . ' class="medwesthealthpoints-form-section-fields-label">Start Date</label>
										<input data-grouped="true" data-sep="--p--" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-dates medwesthealthpoints-form-section-fields-input-dates-single-db-col" id="medwesthealthpoints-form-propertydatesopen-1" data-dbtype="%s" data-dbname="propertydatesopen" type="date" value="' . $indiv_dates[0] . '" />
									</div>
									<div class="medwesthealthpoints-form-section-fields-indiv-date-wrapper">
										<label ' . $label_margin . ' class="medwesthealthpoints-form-section-fields-label">End Date</label>
										<input data-grouped="truestoppairing" data-sep="--x--" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-dates medwesthealthpoints-form-section-fields-input-dates-single-db-col" id="medwesthealthpoints-form-propertydatesopen-2" data-dbtype="%s" data-dbname="propertydatesopen" type="date" value="' . $indiv_dates[1] . '" />
									</div>
									' . $remove_html . '
								</div>';
				}
			} else {

				// If there is only one date range saved...
				if ( false !== stripos( $this->userpropertyobject->propertydatesopen, '--p--' ) ) {

					$indiv_dates = explode( '--p--', $this->userpropertyobject->propertydatesopen );

					$dates_html = $dates_html . '
								<div class="medwesthealthpoints-form-section-fields-indiv-row-wrapper">
									<div class="medwesthealthpoints-form-section-fields-indiv-date-wrapper">
										<label class="medwesthealthpoints-form-section-fields-label">Start Date</label>
										<input data-grouped="true" data-sep="--p--" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-dates medwesthealthpoints-form-section-fields-input-dates-single-db-col" id="medwesthealthpoints-form-propertydatesopen-1" data-dbtype="%s" data-dbname="propertydatesopen" type="date" value="' . $indiv_dates[0] . '" />
									</div>
									<div class="medwesthealthpoints-form-section-fields-indiv-date-wrapper">
										<label class="medwesthealthpoints-form-section-fields-label">End Date</label>
										<input data-grouped="truestoppairing" data-sep="--x--" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-dates medwesthealthpoints-form-section-fields-input-dates-single-db-col" id="medwesthealthpoints-form-propertydatesopen-2" data-dbtype="%s" data-dbname="propertydatesopen" type="date" value="' . $indiv_dates[1] . '" />
									</div>
								</div>';

				} else {

					// If there are no date ranges saved whatsoever.
					$dates_html = $dates_html . '
								<div class="medwesthealthpoints-form-section-fields-indiv-row-wrapper">
									<div class="medwesthealthpoints-form-section-fields-indiv-date-wrapper">
										<label class="medwesthealthpoints-form-section-fields-label">Start Date</label>
										<input data-grouped="true" data-sep="--p--" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-dates medwesthealthpoints-form-section-fields-input-dates-single-db-col" id="medwesthealthpoints-form-propertydatesopen-1" data-dbtype="%s" data-dbname="propertydatesopen" type="date" />
									</div>
									<div class="medwesthealthpoints-form-section-fields-indiv-date-wrapper">
										<label class="medwesthealthpoints-form-section-fields-label">End Date</label>
										<input data-grouped="truestoppairing" data-sep="--x--" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-dates medwesthealthpoints-form-section-fields-input-dates-single-db-col" id="medwesthealthpoints-form-propertydatesopen-2" data-dbtype="%s" data-dbname="propertydatesopen" type="date" />
									</div>
								</div>';
				}
			}

			$dates_html = $dates_html . '</div>
									<div class="medwesthealthpoints-form-section-fields-new-dates-control">Add Additional Dates</div>
								</div>';


			$this->landowner_dashboard_html_output = '
				' . $missing_info_text . '
				<div class="medwesthealthpoints-displayentries-indiv-innerwrapper-form-wrapper">
					<div class="medwesthealthpoints-form-section-wrapper">
						<div class="medwesthealthpoints-form-section-title-wrapper">
							<div class="medwesthealthpoints-form-section-title-wrapper">
								<p>Land Images</p>
							</div>
							' . $images_html . '
					</div>
				</div>
				<div class="medwesthealthpoints-displayentries-indiv-innerwrapper-form-wrapper">
					<div class="medwesthealthpoints-form-section-wrapper">
						<div class="medwesthealthpoints-form-section-title-wrapper">
							<div class="medwesthealthpoints-form-section-title-wrapper">
								<p>Document Uploads</p>
							</div>
							<div class="medwesthealthpoints-form-section-fields-wrapper">
								<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
									<label class="medwesthealthpoints-form-section-fields-label" style="color: black;"><a ' . $titlelinkstyle . ' href="' . $this->userpropertyobject->propertytitle . '">Land Title</a></label>
									<input data-ignore="false" data-required="true" data-dbtype="%s" data-dbname="propertytitle" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" id="medwesthealthpoints-form-propertytitle-0" type="text" value="' . $this->userpropertyobject->propertytitle . '">
									<button class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-file-upload-button" id="medwesthealthpoints-form-button-propertytitle-0" data-dbtype="%s" data-dbname="propertytitle-button">Choose File</button>
								</div>
								<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
									<label class="medwesthealthpoints-form-section-fields-label"><a ' . $insurancelinkstyle . ' href="' . $this->userpropertyobject->propertyinsurance . '">Liability Insurance</a></label>
									<input data-ignore="false" data-required="true" data-dbtype="%s" data-dbname="propertyinsurance" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" id="medwesthealthpoints-form-propertyinsurance-0" data-dbtype="%url" data-dbname="propertyinsurance" type="text" value="' . $this->userpropertyobject->propertyinsurance . '" />
									<button class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-file-upload-button" data-dbtype="%s" data-dbname="propertyinsurance-button">Choose File</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="medwesthealthpoints-displayentries-indiv-innerwrapper-form-wrapper">
					<div class="medwesthealthpoints-form-section-wrapper">
						<div class="medwesthealthpoints-form-section-title-wrapper">
							<div class="medwesthealthpoints-form-section-title-wrapper">
								<p>Dates Available</p>
							</div>
							' . $dates_html . '
						</div>
					</div>
				</div>
				<div class="medwesthealthpoints-displayentries-response-div-wrapper">
					<button class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-button-saveedits" data-idtosearchthrough="medwesthealthpoints-dashboard-loggedin-top-wrapper" data-wptablename="medwesthealthpoints_properties" data-wptableid="' . $this->userpropertyobject->ID . '">Upload Files</button>
					<div class="medwesthealthpoints-spinner"></div>
					<div class="medwesthealthpoints-displayentries-response-div-actual-container"></div>
				</div>';
		}

		/**
		 * Builds and outputs the final Logged-in Dashboard HTML for landowners.
		 */
		public function stitch_final_loggedin_landowner_dashboard_html() {
			$this->common_dashboard_opening_html();
			$this->common_dashboard_closing_html();
			$this->landowner_dashboard_html();
			echo $this->common_dashboard_opening_html_output . $this->landowner_dashboard_html_output . $this->common_dashboard_closing_html_output;
		}

	}
endif;