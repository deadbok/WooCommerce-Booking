<?php
/**
 * The post types used by the booking system.
 * 
 *  * Tickets
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
 * WC_Booking_Post_Types Class.
 */
class WC_Booking_Post_Types
{
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	//Register ticket type.
	public static function register_wc_booking_ticket_type()
	{
		$labels = array(
				'name'                  => _x( 'Tickets', 'Post Type General Name', 'wc-booking' ),
				'singular_name'         => _x( 'Ticket', 'Post Type Singular Name', 'wc-booking' ),
				'menu_name'             => __( 'Tickets', 'wc-booking' ),
				'name_admin_bar'        => __( 'Tickets', 'wc-booking' ),
				'archives'              => __( 'Ticket Archives', 'wc-booking' ),
				'parent_item_colon'     => __( 'Parent Ticket:', 'wc-booking' ),
				'all_items'             => __( 'All Tickets', 'wc-booking' ),
				'add_new_item'          => __( 'Add New Ticket', 'wc-booking' ),
				'add_new'               => __( 'Add New', 'wc-booking' ),
				'new_item'              => __( 'New Ticket', 'wc-booking' ),
				'edit_item'             => __( 'Edit Ticket', 'wc-booking' ),
				'update_item'           => __( 'Update Ticket', 'wc-booking' ),
				'view_item'             => __( 'View Ticket', 'wc-booking' ),
				'search_items'          => __( 'Search Ticket', 'wc-booking' ),
				'not_found'             => __( 'Not found', 'wc-booking' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'wc-booking' ),
				'featured_image'        => __( 'Featured Image', 'wc-booking' ),
				'set_featured_image'    => __( 'Set featured image', 'wc-booking' ),
				'remove_featured_image' => __( 'Remove featured image', 'wc-booking' ),
				'use_featured_image'    => __( 'Use as featured image', 'wc-booking' ),
				'insert_into_item'      => __( 'Insert into ticket', 'wc-booking' ),
				'uploaded_to_this_item' => __( 'Uploaded to this ticket', 'wc-booking' ),
				'items_list'            => __( 'Ticket list', 'wc-booking' ),
				'items_list_navigation' => __( 'Ticket list navigation', 'wc-booking' ),
				'filter_items_list'     => __( 'Filter ticket list', 'wc-booking' ),
		);
		$capabilities = array(
				'edit_post'             => 'edit_post',
				'read_post'             => 'read_post',
				'delete_post'           => 'delete_post',
				'edit_posts'            => 'edit_posts',
				'edit_others_posts'     => 'edit_others_posts',
				'publish_posts'         => 'publish_posts',
				'read_private_posts'    => 'read_private_posts',
				'publish_posts '		=> 'publish_posts',
				'create_post'			=> 'create_post',
		);
		$args = array(
				'label'                 => __( 'Ticket', 'wc-booking' ),
				'description'           => __( 'WooCommerce booking ticket', 'wc-booking' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'author', 'custom-fields', ),
				'taxonomies'            => array( 'category' ),
				'hierarchical'          => true,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 20,
				'menu_icon'             => 'dashicons-tickets-alt',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => true,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				//'capabilities'          => $capabilities,
				'capability_type'		=> 'post',
				'map_meta_cap'			=> true,
		);
		register_post_type( 'wc-ticket', $args );
	}
	
	//Register depatures type.
	public static function register_wc_booking_departures_type()
	{
		$labels = array(
				'name'                  => _x( 'Departures', 'Post Type General Name', 'wc-booking' ),
				'singular_name'         => _x( 'Departure', 'Post Type Singular Name', 'wc-booking' ),
				'menu_name'             => __( 'Departures', 'wc-booking' ),
				'name_admin_bar'        => __( 'Departures', 'wc-booking' ),
				'archives'              => __( 'Departure Archives', 'wc-booking' ),
				'parent_item_colon'     => __( 'Parent Departure:', 'wc-booking' ),
				'all_items'             => __( 'All Departures', 'wc-booking' ),
				'add_new_item'          => __( 'Add New Departure', 'wc-booking' ),
				'add_new'               => __( 'Add New', 'wc-booking' ),
				'new_item'              => __( 'New Departure', 'wc-booking' ),
				'edit_item'             => __( 'Edit Departure', 'wc-booking' ),
				'update_item'           => __( 'Update Departure', 'wc-booking' ),
				'view_item'             => __( 'View Departure', 'wc-booking' ),
				'search_items'          => __( 'Search Departure', 'wc-booking' ),
				'not_found'             => __( 'Not found', 'wc-booking' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'wc-booking' ),
				'featured_image'        => __( 'Featured Image', 'wc-booking' ),
				'set_featured_image'    => __( 'Set featured image', 'wc-booking' ),
				'remove_featured_image' => __( 'Remove featured image', 'wc-booking' ),
				'use_featured_image'    => __( 'Use as featured image', 'wc-booking' ),
				'insert_into_item'      => __( 'Insert into ticket', 'wc-booking' ),
				'uploaded_to_this_item' => __( 'Uploaded to this ticket', 'wc-booking' ),
				'items_list'            => __( 'Departure list', 'wc-booking' ),
				'items_list_navigation' => __( 'Departure list navigation', 'wc-booking' ),
				'filter_items_list'     => __( 'Filter departure list', 'wc-booking' ),
		);
		$capabilities = array(
				'edit_post'             => 'edit_post',
				'read_post'             => 'read_post',
				'delete_post'           => 'delete_post',
				'edit_posts'            => 'edit_posts',
				'edit_others_posts'     => 'edit_others_posts',
				'publish_posts'         => 'publish_posts',
				'read_private_posts'    => 'read_private_posts',
				'publish_posts '		=> 'publish_posts',
				'create_post'			=> 'create_post',
		);
		$args = array(
				'label'                 => __( 'Departures', 'wc-booking' ),
				'description'           => __( 'WooCommerce booking departures', 'wc-booking' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'author', 'custom-fields', ),
				'taxonomies'            => array( 'category' ),
				'hierarchical'          => true,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 20,
				'menu_icon'             => 'dashicons-calendar-alt',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => true,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				//'capabilities'          => $capabilities,
				'capability_type'		=> 'post',
				'map_meta_cap'			=> true,
		);
		register_post_type( 'wc-departures', $args );
	}
}
