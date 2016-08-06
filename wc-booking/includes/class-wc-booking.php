<?php


/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://groenholdt.net
 * @since      1.0.0
 *
 * @package    Wc_Booking
 * @subpackage Wc_Booking/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 1.0.0
 * @package Wc_Booking
 * @subpackage Wc_Booking/includes
 * @author Martin Grønholdt <martin.groenholdt@gmail.com>
 */
class Wc_Booking
{
	
	/**
	 * The loader that's responsible for maintaining and registering all hooks
	 * that power
	 * the plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var Wc_Booking_Loader $loader Maintains and registers all hooks for the
	 *      plugin.
	 */
	protected $loader;
	
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $plugin_name The string used to uniquely identify this
	 *      plugin.
	 */
	protected $plugin_name;
	
	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout
	 * the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the
	 * admin area and
	 * the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->plugin_name = 'wc-booking';
		$this->version = '1.0.0';
		
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_metabox_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wc_Booking_Loader. Orchestrates the hooks of the plugin.
	 * - Wc_Booking_i18n. Defines internationalization functionality.
	 * - Wc_Booking_Admin. Defines all hooks for the admin area.
	 * - Wc_Booking_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the
	 * hooks
	 * with WordPress.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function load_dependencies()
	{
		
		/**
		 * The class responsible for orchestrating the actions and filters of
		 * the core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wc-booking-loader.php';
		
		/**
		 * The class responsible for defining internationalization
		 * functionality of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wc-booking-i18n.php';
		
		/**
		 * The class responsible for defining all actions that occur in the
		 * admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wc-booking-admin.php';
		
		/**
		 * The class responsible for defining all actions that occur in the
		 * public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wc-booking-public.php';
		
		/**
		 * The class responsible for defining all actions relating to
		 * metaboxes.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wc-booking-admin-meta-boxes.php';
		
		/**
		 * The class responsible for sanitizing user input
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wc-booking-sanitize.php';
		
		// Post types.
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wc-booking-post-types.php';
		
		$this->loader = new Wc_Booking_Loader();
		$this->post_types = new WC_Booking_Post_types($this->get_plugin_name(), $this->get_version());
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wc_Booking_i18n class in order to set the domain and to
	 * register the hook
	 * with WordPress.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function set_locale()
	{
		$plugin_i18n = new Wc_Booking_i18n();
		
		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function define_admin_hooks()
	{
		$plugin_admin = new Wc_Booking_Admin($this->get_plugin_name(), $this->get_version());
		
		$this->loader->add_action('init', $this->post_types, 'register_wc_booking_ticket_type');
		
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function define_public_hooks()
	{
		$plugin_public = new Wc_Booking_Public($this->get_plugin_name(), $this->get_version());
		
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function define_metabox_hooks()
	{
		$plugin_metaboxes = new WC_Booking_Admin_Metaboxes($this->get_plugin_name(), $this->get_version());
		
		$this->loader->add_action('add_meta_boxes', $plugin_metaboxes, 'add_metaboxes');
		$this->loader->add_action('add_meta_boxes_wc-ticket', $plugin_metaboxes, 'set_meta');
		$this->loader->add_action('save_post_wc-ticket', $plugin_metaboxes, 'validate_meta', 10, 2);
		//$this->loader->add_action('publish_post', $plugin_metaboxes, 'validate_meta', 10, 2);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context
	 * of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since 1.0.0
	 * @return string The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since 1.0.0
	 * @return Wc_Booking_Loader Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since 1.0.0
	 * @return string The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
