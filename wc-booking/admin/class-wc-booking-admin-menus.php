<?php
/**
 * The admin menu functionality of the plugin.
 *
 * @link       http://groenholdt.net
 * @since      1.0.0
 *
 * @package    Wc_Booking
 * @subpackage Wc_Booking/admin
 */
if (! defined('WPINC'))
{
	die();
}


/**
 * WC_Booking_Admin_Menus Class.
 */
class WC_Booking_Admin_Menus
{

	/**
	 * Hook in tabs.
	 */
	public function __construct()
	{
		// Add menus
		add_action('admin_menu', array(
				$this,
				'admin_menu'
		));
	}

	/**
	 * Add menu items.
	 */
	public function admin_menu()
	{
		//add_menu_page(__('WooCommerce booking'), __('WooCommerce booking'), 'manage_options', 'wc-booking', '', 'dashicons-tickets-alt');
		//add_submenu_page('wc-booking', __('Tickets'), __('Tickets'), 'manage_options', 'wc-booking-tickets-page', '');
		/*add_submenu_page('wc-booking', __('Add ticket'), __('Add ticket'), 'manage_options', 'wc-booking-ticket-page', array(
				$this,
				'ticket_page'
		));*/
	}

	public function ticket_page()
	{
		include_once ('views/wc-booking-admin-display-ticket.php');
	}
}

return new WC_Booking_Admin_Menus();
