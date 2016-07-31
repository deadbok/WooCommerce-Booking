<?php


/**
 * Fired during plugin activation
 *
 * @link       http://groenholdt.net
 * @since      1.0.0
 *
 * @package    Wc_Booking
 * @subpackage Wc_Booking/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 1.0.0
 * @package Wc_Booking
 * @subpackage Wc_Booking/includes
 * @author Martin Grønholdt <martin.groenholdt@gmail.com>
 */
class Wc_Booking_Activator
{

	/**
	 * Short Description.
	 * (use period)
	 *
	 * Long Description.
	 *
	 * @since 1.0.0
	 */
	public static function activate()
	{
		//Post types.
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wc-booking-post-types.php';
		
		WC_Booking_Post_Types::register_wc_booking_ticket_type();
		
		flush_rewrite_rules();
	}
}
