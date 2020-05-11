<?php

/**
 * Class MaxFootedb_Ajax_Functions - class-maxfoote-ajax-functions.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes
 * @version  6.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('MaxFootedb_Ajax_Functions', false)) :
	/**
	 * MaxFootedb_Ajax_Functions class. Here we'll do things like enqueue scripts/css, set up menus, etc.
	 */
	class MaxFootedb_Ajax_Functions
	{

		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct()
		{
		}

		public function maxfootedb_admin_delete_entry_fromdb_action_callback()
		{

			function console_log($output)
			{
				$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
					');';
				echo $js_code;
			}

			global $wpdb;
			$vendor_table = $wpdb->prefix . 'maxfootedb_vendors';
			$vendor_cities_table = $wpdb->prefix . 'maxfootedb_vendor_cities';
			$vendor_zips_table = $wpdb->prefix . 'maxfootedb_vendor_zips';
			$vendor_trades_table = $wpdb->prefix . 'maxfootedb_vendor_trades';
			$vendor_certs_table = $wpdb->prefix . 'maxfootedb_vendor_certs';

			$vendors_in_db = $wpdb->get_results("SELECT * FROM $vendor_table");

			$ID = '';
			$vendorcity = '';

			if (isset($_POST['ID'])) {
				$ID = filter_var(wp_unslash($_POST['ID']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorcity'])) {
				$vendorcity = filter_var(wp_unslash($_POST['vendorcity']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorstate'])) {
				$vendorstate = filter_var(wp_unslash($_POST['vendorstate']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorzip'])) {
				$vendorzip = filter_var(wp_unslash($_POST['vendorzip']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendortrade'])) {
				$vendortrade = filter_var(wp_unslash($_POST['vendortrade']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorcerts'])) {
				$vendorcerts = filter_var(wp_unslash($_POST['vendorcerts']), FILTER_SANITIZE_STRING);
			}


			$number_of_cities = 0;
			$number_of_zips = 0;
			$number_of_trades = 0;
			$number_of_certs = 0;


			foreach ($vendors_in_db as $vendor) {
				if ($vendor->vendorcity === $vendorcity) {
					$number_of_cities++;
				}
				if ($vendor->vendorzip === $vendorzip) {
					$number_of_zips++;
				}
				if ($vendor->vendortrade === $vendortrade) {
					$number_of_trades++;
				}
				if ($vendor->vendorcerts === $vendorcerts) {
					$number_of_certs++;
				}
			}

			if ($number_of_cities == 1) {
				$vendor_cities_table_array = array('vendorcity' => $vendorcity);
				$vendor_cities_table_mask_array = array('%s');
				$wpdb->delete($vendor_cities_table, $vendor_cities_table_array, $vendor_cities_table_mask_array);
			}

			if ($number_of_zips == 1) {
				$vendor_zips_table_array = array('vendorzip' => $vendorzip);
				$vendor_zips_table_mask_array = array('%s');
				$wpdb->delete($vendor_zips_table, $vendor_zips_table_array, $vendor_zips_table_mask_array);
			}

			if ($number_of_trades == 1) {
				$vendor_trades_table_array = array('vendortrade' => $vendortrade);
				$vendor_trades_table_mask_array = array('%s');
				$wpdb->delete($vendor_trades_table, $vendor_trades_table_array, $vendor_trades_table_mask_array);
			}

			if ($number_of_certs == 1) {
				$vendor_certs_table_array = array('vendorcerts' => $vendorcerts);
				$vendor_certs_table_mask_array = array('%s');
				$wpdb->delete($vendor_certs_table, $vendor_certs_table_array, $vendor_certs_table_mask_array);
			}

			$vendor_array = array(
				'ID'        => $ID
			);

			$vendor_mask_array = array(
				'%s'
			);


			//returns the id of the entry that was deleted or 0/False if it fails
			$result = $wpdb->delete($vendor_table, $vendor_array, $vendor_mask_array);

			wp_die($result);
		}

		public function maxfootedb_admin_update_search_tables($vendorname, $vendorcity, $vendorzip, $vendortrade, $vendorcerts)
		{
			global $wpdb;

			// function console_log($output)
			// {
			// 	$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
			// 		');';
			// 	echo $js_code;
			// }

			$vendor_cities_table_entry = ucwords($vendorcity);
			$vendor_zips_table_entry = $vendorzip;
			$vendor_trades_table_entry = ucwords($vendortrade);
			$vendor_certs_table_entry = ucwords($vendorcerts);

			$vendor_table = $wpdb->prefix . 'maxfootedb_vendors';
			$vendor_cities_table = $wpdb->prefix . 'maxfootedb_vendor_cities';
			$vendor_zips_table = $wpdb->prefix . 'maxfootedb_vendor_zips';
			$vendor_trades_table = $wpdb->prefix . 'maxfootedb_vendor_trades';
			$vendor_certs_table = $wpdb->prefix . 'maxfootedb_vendor_certs';

			$vendor_cities_in_db = $wpdb->get_results("SELECT * FROM $vendor_cities_table");

			$vendor_zips_in_db = $wpdb->get_results("SELECT * FROM $vendor_zips_table");

			$vendor_trades_in_db = $wpdb->get_results("SELECT * FROM $vendor_trades_table");

			$vendor_certs_in_db = $wpdb->get_results("SELECT * FROM $vendor_certs_table");

			$vendor_cities_table_array = array('vendorcity' => $vendor_cities_table_entry);
			$vendor_cities_table_mask_array = array('%s');

			$vendor_zips_table_array = array('vendorzip' => $vendor_zips_table_entry);
			$vendor_zips_table_mask_array = array('%s');

			$vendor_trades_table_array = array('vendortrade' => $vendor_trades_table_entry);
			$vendor_trades_table_mask_array = array('%s');

			$vendor_certs_table_array = array('vendorcerts' => $vendor_certs_table_entry);
			$vendor_certs_table_mask_array = array('%s');

			$results = $wpdb->get_row("SELECT * FROM $vendor_table WHERE vendorname = '$vendorname'");

			$original_city = $results->vendorcity;
			$original_zip = $results->vendorzip;
			$original_trades = $results->vendortrades;
			$original_certs = $results->vendorcerts;

			$delete_vendor_cities_table_array = array('vendorcity' => $original_city);
			$delete_vendor_cities_table_mask_array = array('%s');

			$delete_vendor_zips_table_array = array('vendorzip' => $original_zip);
			$delete_vendor_zips_table_mask_array = array('%s');

			$delete_vendor_trades_table_array = array('vendortrade' => $original_trades);
			$delete_vendor_trades_table_mask_array = array('%s');

			$delete_vendor_certs_table_array = array('vendorcerts' => $original_certs);
			$delete_vendor_certs_table_mask_array = array('%s');

			$add_city = true;
			$add_zip = true;
			$add_trades = true;
			$add_certs = true;

			$original_city_count = 0;
			$original_zip_count = 0;
			$original_trades_count = 0;
			$original_certs_count = 0;

			// console_log("starting search logic");

			foreach ($vendor_cities_in_db as $vendor_city) {
				if ($vendor_city->vendorcity === $vendor_cities_table_entry) {
					$add_city = false;
					// console_log("same city");
					break;
				}
				if ($vendor_city->vendorcity === $original_city) {
					// console_log("same city as the original");
					$original_city_count++;
					if ($original_city_count > 1) {
						break;
					}
				}
				// console_log("original city count: " . $original_city_count);
			}

			// console_log("passed city logic");

			if ($add_city) {
				$add_vendor_cities_table_entry = $wpdb->insert($vendor_cities_table, $vendor_cities_table_array, $vendor_cities_table_mask_array);
				// console_log("city added in search table");
			}

			if ($original_city_count == 1) {
				$delete_vendor_cities_table_entry = $wpdb->delete($vendor_cities_table, $delete_vendor_cities_table_array, $delete_vendor_cities_table_mask_array);
				// console_log("original city deleted from search table");
			} else {
				// console_log("original city stays");
				return;
			}


			foreach ($vendor_zips_in_db as $vendor_zip) {
				if ($vendor_zip->vendorzip === $vendor_zips_table_entry) {
					$add_zip = false;
					// console_log("The zip already exists!");
					break;
				}
				if ($vendor_zip->vendorzip === $original_zip) {
					$original_zip_count++;
				}
			}

			if ($add_zip) {
				$add_vendor_zips_table_entry = $wpdb->insert($vendor_zips_table, $vendor_zips_table_array, $vendor_zips_table_mask_array);
			}

			if ($original_zip_count = 1) {
				$delete_vendor_zips_table_entry = $wpdb->delete($vendor_zips_table, $delete_vendor_zips_table_array, $delete_vendor_zips_table_mask_array);
			}


			foreach ($vendor_trades_in_db as $vendor_trades) {
				// console_log($vendor_trades);
				if ($vendor_trades->vendortrade === $vendor_trades_table_entry) {
					$add_trades = false;
					// console_log("The trade already exists!");
					break;
				}
				if ($vendor_trades->vendortrade === $original_trades) {
					$original_trades_count++;
				}
			}

			if ($add_trades) {
				$add_vendor_trades_table_entry = $wpdb->insert($vendor_trades_table, $vendor_trades_table_array, $vendor_trades_table_mask_array);
			}

			if ($original_trades_count = 1) {
				$delete_vendor_trades_table_entry = $wpdb->delete($vendor_trades_table, $delete_vendor_trades_table_array, $delete_vendor_trades_table_mask_array);
			}


			foreach ($vendor_certs_in_db as $vendor_certs) {
				// console_log($vendor_certs);
				if ($vendor_certs->vendorcerts === $vendor_certs_table_entry) {
					$add_certs = false;
					// console_log("The cert already exists!");
					break;
				}
				if ($vendor_certs->vendorcerts === $original_certs) {
					$original_certs_count++;
				}
			}

			if ($add_certs) {
				$add_vendor_certs_table_entry = $wpdb->insert($vendor_certs_table, $vendor_certs_table_array, $vendor_certs_table_mask_array);
			}

			if ($original_certs_count = 1) {
				$delete_vendor_certs_table_entry = $wpdb->delete($vendor_certs_table, $delete_vendor_certs_table_array, $delete_vendor_certs_table_mask_array);
			}

			if (null === $results) {
				wp_die('Something is very wrong');
			} else {
				// The techincal correct way to stop this entire function from executing, and correctly return data back to our requesting Javascript function, to then use that data to display a message back to the user of some kind.
				wp_die($results);
			}
		}

		/**
		 * Callback function for adding a Vendor from the Admin.
		 */
		public function maxfootedb_admin_save_todb_action_callback()
		{
			function console_log($output)
			{
				$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
					');';
				echo $js_code;
			}

			global $wpdb;

			$vendorname = '';
			$vendortype = '';
			$vendorcerts = '';
			$vendorlicense = '';
			$vendortrade = '';
			$vendoraddress = '';
			$vendoraddress2 = '';
			$vendorcity = '';
			$vendorstate = '';
			$vendorzip = '';
			$vendorphone = '';
			$vendorcontact = '';
			$vendoremail = '';
			$vendorenterprise = '';
			$vendorlastupdated = '';
			$eventlocation = '';
			$vendornotes = '';

			// First set the variables we'll be passing to class-wpbooklist-book.php to ''.
			if (isset($_POST['vendorname'])) {
				$vendorname = filter_var(wp_unslash($_POST['vendorname']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendortype'])) {
				$vendortype = filter_var(wp_unslash($_POST['vendortype']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorcerts'])) {
				$vendorcerts = filter_var(wp_unslash($_POST['vendorcerts']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorlicense'])) {
				$vendorlicense = filter_var(wp_unslash($_POST['vendorlicense']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendortrade'])) {
				$vendortrade = filter_var(wp_unslash($_POST['vendortrade']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendoraddress'])) {
				$vendoraddress = filter_var(wp_unslash($_POST['vendoraddress']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendoraddress2'])) {
				$vendoraddress2 = filter_var(wp_unslash($_POST['vendoraddress2']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorcity'])) {
				$vendorcity = filter_var(wp_unslash($_POST['vendorcity']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorstate'])) {
				$vendorstate = filter_var(wp_unslash($_POST['vendorstate']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorzip'])) {
				$vendorzip = filter_var(wp_unslash($_POST['vendorzip']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorphone'])) {
				$vendorphone = filter_var(wp_unslash($_POST['vendorphone']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorcontact'])) {
				$vendorcontact = filter_var(wp_unslash($_POST['vendorcontact']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendoremail'])) {
				$vendoremail = filter_var(wp_unslash($_POST['vendoremail']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorenterprise'])) {
				$vendorenterprise = filter_var(wp_unslash($_POST['vendorenterprise']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorlastupdated'])) {
				$vendorlastupdated = filter_var(wp_unslash($_POST['vendorlastupdated']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['eventlocation'])) {
				$eventlocation = filter_var(wp_unslash($_POST['eventlocation']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendornotes'])) {
				$vendornotes = filter_var(wp_unslash($_POST['vendornotes']), FILTER_SANITIZE_STRING);
			}

			$vendor_array = array(
				'vendorname'        => $vendorname,
				'vendortype'        => $vendortype,
				'vendorcerts'       => $vendorcerts,
				'vendorlicense'     => $vendorlicense,
				'vendortrade'       => $vendortrade,
				'vendoraddress'     => $vendoraddress,
				'vendoraddress2'    => $vendoraddress2,
				'vendorcity'        => $vendorcity,
				'vendorstate'       => $vendorstate,
				'vendorzip'         => $vendorzip,
				'vendorphone'       => $vendorphone,
				'vendorcontact'     => $vendorcontact,
				'vendoremail'       => $vendoremail,
				'vendorenterprise'  => $vendorenterprise,
				'vendorlastupdated' => $vendorlastupdated,
				'eventlocation'     => $eventlocation,
				'vendornotes'		=> $vendornotes
			);

			$vendor_mask_array = array(
				'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
			);


			/* This one needs to be used when you are pretty sure there are multiple items that will be returned from the Database.
			$wpdb->get_results()
			// This one needs to be used when you are positive there is only one possbille result that could be grabbed from the Database.
			$wpdb->get_row();
			*/

			$vendor_table = $wpdb->prefix . 'maxfootedb_vendors';

			$results = $wpdb->get_row("SELECT * FROM $vendor_table WHERE vendorname = '$vendorname'");

			console_log($results);

			if (null === $results) {

				$result = $wpdb->insert($wpdb->prefix . 'maxfootedb_vendors', $vendor_array, $vendor_mask_array);

				$this->maxfootedb_admin_update_search_tables(
					$vendorname,
					$vendorcity,
					$vendorzip,
					$vendortrade,
					$vendorcerts
				);
			} else {
				wp_die("Entry already exists");
			}
		}


		/**
		 * Callback function for updating a Vendor from the Admin.
		 */
		public function maxfootedb_admin_update_entry_indb_action_callback()
		{
			function console_log($output)
			{
				$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
					');';
				echo $js_code;
			}

			global $wpdb;

			$ID = '';
			$vendorname = '';
			$vendortype = '';
			$vendorcerts = '';
			$vendorlicense = '';
			$vendortrade = '';
			$vendoraddress = '';
			$vendoraddress2 = '';
			$vendorcity = '';
			$vendorstate = '';
			$vendorzip = '';
			$vendorphone = '';
			$vendorcontact = '';
			$vendoremail = '';
			$vendorenterprise = '';
			$vendorlastupdated = '';
			$eventlocation = '';
			$vendornotes = '';

			if (isset($_POST['ID'])) {
				$ID = filter_var(wp_unslash($_POST['ID']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorname'])) {
				$vendorname = filter_var(wp_unslash($_POST['vendorname']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendortype'])) {
				$vendortype = filter_var(wp_unslash($_POST['vendortype']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorcerts'])) {
				$vendorcerts = filter_var(wp_unslash($_POST['vendorcerts']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorlicense'])) {
				$vendorlicense = filter_var(wp_unslash($_POST['vendorlicense']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendortrade'])) {
				$vendortrade = filter_var(wp_unslash($_POST['vendortrade']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendoraddress'])) {
				$vendoraddress = filter_var(wp_unslash($_POST['vendoraddress']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendoraddress2'])) {
				$vendoraddress2 = filter_var(wp_unslash($_POST['vendoraddress2']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorcity'])) {
				$vendorcity = filter_var(wp_unslash($_POST['vendorcity']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorstate'])) {
				$vendorstate = filter_var(wp_unslash($_POST['vendorstate']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorzip'])) {
				$vendorzip = filter_var(wp_unslash($_POST['vendorzip']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorphone'])) {
				$vendorphone = filter_var(wp_unslash($_POST['vendorphone']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorcontact'])) {
				$vendorcontact = filter_var(wp_unslash($_POST['vendorcontact']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendoremail'])) {
				$vendoremail = filter_var(wp_unslash($_POST['vendoremail']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorenterprise'])) {
				$vendorenterprise = filter_var(wp_unslash($_POST['vendorenterprise']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendorlastupdated'])) {
				$vendorlastupdated = filter_var(wp_unslash($_POST['vendorlastupdated']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['eventlocation'])) {
				$eventlocation = filter_var(wp_unslash($_POST['eventlocation']), FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['vendornotes'])) {
				$vendornotes = filter_var(wp_unslash($_POST['vendornotes']), FILTER_SANITIZE_STRING);
			}

			$vendor_array = array(
				'vendorname'        => $vendorname,
				'vendortype'        => $vendortype,
				'vendorcerts'       => $vendorcerts,
				'vendorlicense'     => $vendorlicense,
				'vendortrade'       => $vendortrade,
				'vendoraddress'     => $vendoraddress,
				'vendoraddress2'    => $vendoraddress2,
				'vendorcity'        => $vendorcity,
				'vendorstate'       => $vendorstate,
				'vendorzip'         => $vendorzip,
				'vendorphone'       => $vendorphone,
				'vendorcontact'     => $vendorcontact,
				'vendoremail'       => $vendoremail,
				'vendorenterprise'  => $vendorenterprise,
				'vendorlastupdated' => $vendorlastupdated,
				'eventlocation'     => $eventlocation,
				'vendornotes'		=> $vendornotes
			);

			$vendor_table = $wpdb->prefix . 'maxfootedb_vendors';
			$results = $wpdb->get_row("SELECT * FROM $vendor_table WHERE vendorname = '$vendorname'");

			if (null === $results) {
				// The techincal correct way to stop this entire function from executing, and correctly return data back to our requesting Javascript function, to then use that data to display a message back to the user of some kind.
				wp_die('Something is not right');
			} else {
				$format       = array('%s');
				$where        = array('ID' => $ID);
				$where_format = array('%d');
				$result = $wpdb->update($vendor_table, $vendor_array, $where, $format, $where_format);

				$this->maxfootedb_admin_update_search_tables(
					$vendorname,
					$vendorcity,
					$vendorzip,
					$vendortrade,
					$vendorcerts
				);

				wp_die($result);
			}
		}






		/**
		 * Callback function for bulk-uploading by CSV from the admin dashboard.
		 */
		public function maxfootedb_admin_bulk_csv_upload_action_callback()
		{

			global $wpdb;

			$finaldocurl = '';

			if (isset($_POST['finaldocurl'])) {
				$finaldocurl = filter_var(wp_unslash($_POST['finaldocurl']), FILTER_SANITIZE_STRING);
			}

			// Open the file for reading
			if (($h = fopen($finaldocurl, "r")) !== FALSE) {
				$row = 1;
				// Convert each line into the local $data variable
				while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {


					$num = count($data);

					for ($c = 0; $c < $num; $c++) {
						//error_log($c);

						$vendorname = $data[2];
						$vendortype = $data[0];
						$vendorcerts = $data[1];
						$vendorlicense = '';
						$vendortrade = $data[8];
						$vendoraddress = $data[3];
						$vendoraddress2 = $data[4];
						$vendorcity = $data[5];
						$vendorstate = $data[6];
						$vendorzip = $data[7];
						$vendorphone = $data[10];
						$vendorcontact = $data[11] . ' ' . $data[12];
						$vendoremail = $data[14];
						$vendorenterprise = '';
						$vendorlastupdated = date('Y-m-d', time());
						$eventlocation = '';
						$vendornotes = '';

						//  error_log($data[2]);

						$vendor_array = array(
							'vendorname'        => $vendorname,
							'vendortype'        => $vendortype,
							'vendorcerts'       => $vendorcerts,
							'vendorlicense'     => $vendorlicense,
							'vendortrade'       => $vendortrade,
							'vendoraddress'     => $vendoraddress,
							'vendoraddress2'    => $vendoraddress2,
							'vendorcity'        => $vendorcity,
							'vendorstate'       => $vendorstate,
							'vendorzip'         => $vendorzip,
							'vendorphone'       => $vendorphone,
							'vendorcontact'     => $vendorcontact,
							'vendoremail'       => $vendoremail,
							'vendorenterprise'  => $vendorenterprise,
							'vendorlastupdated' => $vendorlastupdated,
							'eventlocation'     => $eventlocation,
							'vendornotes'		=> $vendornotes
						);
					}

					$vendor_mask_array = array(
						'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
					);


					/* This one needs to be used when you are pretty sure there are multiple items that will be returned from the Database.
				$wpdb->get_results()
				// This one needs to be used when you are positive there is only one possbille result that could be grabbed from the Database.
				$wpdb->get_row();
				*/


					$result = $wpdb->insert($wpdb->prefix . 'maxfootedb_vendors', $vendor_array, $vendor_mask_array);

					$this->maxfootedb_admin_update_search_tables($vendorname, $vendorcity, $vendorzip, $vendortrade, $vendorcerts);


					// Read the data from a single line
				}

				// Close the file
				fclose($h);
			}



			wp_die('Vendors have been uploaded via csv');
		}
	}
endif;

/*



function maxfootedb_settings_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		$("#maxfootedb-img-remove-1").click(function(event){
  			$('#maxfootedb-preview-img-1').attr('src', '<?php echo ROOT_IMG_ICONS_URL ?>'+'book-placeholder.svg');
  		});

  		$("#maxfootedb-img-remove-2").click(function(event){
  			$('#maxfootedb-preview-img-2').attr('src', '<?php echo ROOT_IMG_ICONS_URL ?>'+'book-placeholder.svg');
  		});



	  	$("#maxfootedb-save-settings").click(function(event){

	  		$('#maxfootedb-success-div').html('');
	  		$('#maxfoote-spinner-storfront-lib').animate({'opacity':'1'});

	  		var callToAction = $('#maxfootedb-call-to-action-input').val();
	  		var libImg = $('#maxfootedb-preview-img-1').attr('src');
	  		var bookImg = $('#maxfootedb-preview-img-2').attr('src');

		  	var data = {
				'action': 'maxfootedb_settings_action',
				'security': '<?php echo wp_create_nonce( "maxfootedb_settings_action_callback" ); ?>',
				'calltoaction':callToAction,
				'libimg':libImg,
				'bookimg':bookImg			
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	$('#maxfoote-spinner-storfront-lib').animate({'opacity':'0'});
			    	$('#maxfootedb-success-div').html('<span id="maxfoote-add-book-success-span">Success!</span><br/><br/> You\'ve saved your MaxFootedb Settings!<div id="maxfoote-addstylepak-success-thanks">Thanks for using WPBooklist! If you happen to be thrilled with Maxfoote, then by all means, <a id="maxfoote-addbook-success-review-link" href="https://wordpress.org/support/plugin/maxfoote/reviews/?filter=5">Feel Free to Leave a 5-Star Review Here!</a><img id="maxfoote-smile-icon-1" src="http://evansclienttest.com/wp-content/plugins/maxfoote/assets/img/icons/smile.png"></div>')
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}


function maxfootedb_settings_action_callback(){
	global $wpdb;
	check_ajax_referer( 'maxfootedb_settings_action_callback', 'security' );
	$call_to_action = filter_var($_POST['calltoaction'],FILTER_SANITIZE_STRING);
	$lib_img = filter_var($_POST['libimg'],FILTER_SANITIZE_URL);
	$book_img = filter_var($_POST['bookimg'],FILTER_SANITIZE_URL);
	$table_name = TOPLEVEL_PREFIX.'maxfootedb_jre_toplevel_options';

	if($lib_img == '' || $lib_img == null || strpos($lib_img, 'placeholder.svg') !== false){
		$lib_img = 'Purchase Now!';
	}

	if($book_img == '' || $book_img == null || strpos($book_img, 'placeholder.svg') !== false){
		$book_img = 'Purchase Now!';
	}

	$data = array(
        'calltoaction' => $call_to_action, 
        'libraryimg' => $lib_img, 
        'bookimg' => $book_img 
    );
    $format = array( '%s','%s','%s'); 
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );


	wp_die();
}


function maxfootedb_save_default_action_javascript() { 

	$trans1 = __("Success!", 'maxfoote');
	$trans2 = __("You've saved your default Toplevel WooCommerce Settings!", 'maxfoote');
	$trans6 = __("Thanks for using Maxfoote, and", 'maxfoote');
	$trans7 = __("be sure to check out the Maxfoote Extensions!", 'maxfoote');
	$trans8 = __("If you happen to be thrilled with Maxfoote, then by all means,", 'maxfoote');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'maxfoote');

	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#maxfootedb-woo-settings-button").click(function(event){

	  		$('#maxfootedb-woo-set-success-div').html('');
	  		$('.maxfoote-spinner').animate({'opacity':'1'});

	  		var salePrice = $( "input[name='book-woo-sale-price']" ).val();
			var regularPrice = $( "input[name='book-woo-regular-price']" ).val();
			var stock = $( "input[name='book-woo-stock']" ).val();
			var length = $( "input[name='book-woo-length']" ).val();
			var width = $( "input[name='book-woo-width']" ).val();
			var height = $( "input[name='book-woo-height']" ).val();
			var weight = $( "input[name='book-woo-weight']" ).val();
			var sku = $("#maxfoote-addbook-woo-sku" ).val();
			var virtual = $("input[name='maxfoote-woocommerce-vert-yes']").prop('checked');
			var download = $("input[name='maxfoote-woocommerce-download-yes']").prop('checked');
			var salebegin = $('#maxfoote-addbook-woo-salebegin').val();
			var saleend = $('#maxfoote-addbook-woo-saleend').val();
			var purchasenote = $('#maxfoote-addbook-woo-note').val();
			var productcategory = $('#maxfoote-woocommerce-category-select').val();
			var reviews = $('#maxfoote-woocommerce-review-yes').prop('checked');
			var upsells = $('#select2-upsells').val();
			var crosssells = $('#select2-crosssells').val();

			var upsellString = '';
			var crosssellString = '';

			// Making checks to see if Toplevel extension is active
			if(upsells != undefined){
				for (var i = 0; i < upsells.length; i++) {
					upsellString = upsellString+','+upsells[i];
				};
			}

			if(crosssells != undefined){
				for (var i = 0; i < crosssells.length; i++) {
					crosssellString = crosssellString+','+crosssells[i];
				};
			}

			if(salebegin != undefined && saleend != undefined){
				// Flipping the sale date start
				if(salebegin.indexOf('-')){
					var finishedtemp = salebegin.split('-');
					salebegin = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}

				// Flipping the sale date end
				if(saleend.indexOf('-')){
					var finishedtemp = saleend.split('-');
					saleend = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}	
			}

		  	var data = {
				'action': 'maxfootedb_save_action_default',
				'security': '<?php echo wp_create_nonce( "maxfootedb_save_default_action_callback" ); ?>',
				'saleprice':salePrice,
				'regularprice':regularPrice,
				'stock':stock,
				'length':length,
				'width':width,
				'height':height,
				'weight':weight,
				'sku':sku,
				'virtual':virtual,
				'download':download,
				'salebegin':salebegin,
				'saleend':saleend,
				'purchasenote':purchasenote,
				'productcategory':productcategory,
				'reviews':reviews,
				'upsells':upsellString,
				'crosssells':crosssellString
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);


			    	$('#maxfootedb-woo-set-success-div').html("<span id='maxfoote-add-book-success-span'><?php echo $trans1 ?></span><br/><br/>&nbsp;<?php echo $trans2 ?><div id='maxfoote-addtemplate-success-thanks'><?php echo $trans6 ?>&nbsp;<a href='http://maxfoote.com/index.php/extensions/'><?php echo $trans7 ?></a><br/><br/>&nbsp;<?php echo $trans8 ?> &nbsp;<a id='maxfoote-addbook-success-review-link' href='https://wordpress.org/support/plugin/maxfoote/reviews/?filter=5'><?php echo $trans9 ?></a><img id='maxfoote-smile-icon-1' src='http://evansclienttest.com/wp-content/plugins/maxfoote/assets/img/icons/smile.png'></div>");

			    	$('.maxfoote-spinner').animate({'opacity':'0'});

			    	$('html, body').animate({
				        scrollTop: $("#maxfootedb-woo-set-success-div").offset().top-100
				    }, 1000);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function maxfootedb_save_default_action_callback(){
	global $wpdb;
	check_ajax_referer( 'maxfootedb_save_default_action_callback', 'security' );
	$saleprice = filter_var($_POST['saleprice'],FILTER_SANITIZE_STRING);
	$regularprice = filter_var($_POST['regularprice'],FILTER_SANITIZE_STRING);
	$stock = filter_var($_POST['stock'],FILTER_SANITIZE_STRING);
	$length = filter_var($_POST['length'],FILTER_SANITIZE_STRING);
	$width = filter_var($_POST['width'],FILTER_SANITIZE_STRING);
	$height = filter_var($_POST['height'],FILTER_SANITIZE_STRING);
	$weight = filter_var($_POST['weight'],FILTER_SANITIZE_STRING);
	$sku = filter_var($_POST['sku'],FILTER_SANITIZE_STRING);
	$virtual = filter_var($_POST['virtual'],FILTER_SANITIZE_STRING);
	$download = filter_var($_POST['download'],FILTER_SANITIZE_STRING);
	$woofile = filter_var($_POST['woofile'],FILTER_SANITIZE_STRING);
	$salebegin = filter_var($_POST['salebegin'],FILTER_SANITIZE_STRING);
	$saleend = filter_var($_POST['saleend'],FILTER_SANITIZE_STRING);
	$purchasenote = filter_var($_POST['purchasenote'],FILTER_SANITIZE_STRING);
	$productcategory = filter_var($_POST['productcategory'],FILTER_SANITIZE_STRING);
	$reviews = filter_var($_POST['reviews'],FILTER_SANITIZE_STRING);
	$crosssells = filter_var($_POST['crosssells'],FILTER_SANITIZE_STRING);
	$upsells = filter_var($_POST['upsells'],FILTER_SANITIZE_STRING);


	$data = array(
		'defaultsaleprice' => $saleprice,
		'defaultprice' => $regularprice,
		'defaultstock' => $stock,
		'defaultlength' => $length,
		'defaultwidth' => $width,
		'defaultheight' => $height,
		'defaultweight' => $weight,
		'defaultsku' => $sku,
		'defaultvirtual' => $virtual,
		'defaultdownload' => $download,
		'defaultsalebegin' => $salebegin,
		'defaultsaleend' => $saleend,
		'defaultnote' => $purchasenote,
		'defaultcategory' => $productcategory,
		'defaultreviews' => $reviews,
		'defaultcrosssell' => $crosssells,
		'defaultupsell' => $upsells
	);

 	$table = $wpdb->prefix."maxfootedb_jre_toplevel_options";
   	$format = array( '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'); 
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    $result = $wpdb->update( $table, $data, $where, $format, $where_format );

	echo $result;



	wp_die();
}


function maxfootedb_upcross_pop_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

		  	var data = {
				'action': 'maxfootedb_upcross_pop_action',
				'security': '<?php echo wp_create_nonce( "maxfootedb_upcross_pop_action_callback" ); ?>',
			};

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split('–sep-seperator-sep–');
			    	var upsellstitles = '';
			    	var crosssellstitles = '';


			    	if(response[0] != 'null'){
				    	upsellstitles = response[0];
				    	if(upsellstitles.includes(',')){
				    		var upsellArray = upsellstitles.split(',');
				    	} else {
				    		var upsellArray = upsellstitles;
				    	}

				    	$("#select2-upsells").val(upsellArray).trigger('change');
			    	}

			    	if(response[1] != 'null'){
				    	crosssellstitles = response[1];
				    	if(crosssellstitles.includes(',')){
				    		var upsellArray = crosssellstitles.split(',');
				    	} else {
				    		var upsellArray = crosssellstitles;
				    	}

				    	$("#select2-crosssells").val(upsellArray).trigger('change');
			    	}


			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});


	});
	</script>
	<?php
}

// Callback function for creating backups
function maxfootedb_upcross_pop_action_callback(){
	global $wpdb;
	check_ajax_referer( 'maxfootedb_upcross_pop_action_callback', 'security' );
		
	// Get saved settings
    $settings_table = $wpdb->prefix."maxfootedb_jre_toplevel_options";
    $settings = $wpdb->get_row("SELECT * FROM $settings_table");

    echo $settings->defaultupsell.'–sep-seperator-sep–'.$settings->defaultcrosssell;

	wp_die();
}

/*
// For adding a book from the admin dashboard
add_action( 'admin_footer', 'maxfootedb_action_javascript' );
add_action( 'wp_ajax_maxfootedb_action', 'maxfootedb_action_callback' );
add_action( 'wp_ajax_nopriv_maxfootedb_action', 'maxfootedb_action_callback' );


function maxfootedb_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#maxfoote-admin-addbook-button").click(function(event){

		  	var data = {
				'action': 'maxfootedb_action',
				'security': '<?php echo wp_create_nonce( "maxfootedb_action_callback" ); ?>',
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function maxfootedb_action_callback(){
	global $wpdb;
	check_ajax_referer( 'maxfootedb_action_callback', 'security' );
	//$var1 = filter_var($_POST['var'],FILTER_SANITIZE_STRING);
	//$var2 = filter_var($_POST['var'],FILTER_SANITIZE_NUMBER_INT);
	echo 'hi';
	wp_die();
}*/
