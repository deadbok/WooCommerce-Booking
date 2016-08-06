<?php


/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		http://groenholdt.net
 * @since 		1.0.0
 *
 * @package    Wc_Booking
 * @subpackage Wc_Booking/admin
 * @author 		deadbok <martin.groenholdt@gmail.com>
 */
class WC_Booking_Admin_Metaboxes
{
	
	/**
	 * The post meta data
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $meta The post meta data.
	 */
	private $meta;
	
	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;
	
	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $Now_Hiring
	 *        	The name of this plugin.
	 * @param string $version
	 *        	The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		$this->set_meta();
	}

	/**
	 * Register the stylesheets for the admin-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
	}

	/**
	 * Register the JavaScript for the admin-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script('jquery-ui-datepicker');
	}

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_metaboxes()
	{
		add_meta_box("total_tickets_meta", __("Total Tickets", 'wc-booking'), array(
				$this,
				'metabox'
		), "wc-ticket", "side", "low", array(
				'name' => 'total-tickets'
		));
		add_meta_box("ticket_price_meta", __("Price", 'wc-booking'), array(
				$this,
				'metabox'
		), "wc-ticket", "side", "low", array(
				'name' => 'price'
		));
		add_meta_box("departure_calandar_meta", __("Depature Calendar", 'wc-booking'), array(
				$this,
				'metabox'
		), "wc-ticket", "side", "low", array(
				'name' => 'departure'
		));
		add_meta_box("departures_meta", __("Departures", 'wc-booking'), array(
				$this,
				'metabox'
		), "wc-departures", "normal", "high", array(
				'name' => 'departures'
		));
	}
	// add_metaboxes()
	
	/**
	 * Check each nonce.
	 * If any don't verify, $nonce_check is increased.
	 * If all nonces verify, returns 0.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return int The value of $nonce_check
	 */
	private function check_nonces($posted)
	{
		$nonces = array();
		$nonce_check = 0;
		
		$nonces[] = 'total_tickets_nonce';
		$nonces[] = 'price_ticket_nonce';
		$nonces[] = 'departure_calendar_nonce';
		$nonces[] = 'calendar_departures_nonce';
		foreach ($nonces as $nonce)
		{
			error_log('Nonce: ' . $nonce);
			if (!isset($posted[$nonce]))
			{
				error_log('Nonce is not set');
				$nonce_check++;
			}
			if (isset($posted[$nonce]) && !wp_verify_nonce($posted[$nonce], $this->plugin_name))
			{
				error_log('Nonce is not ok');
				$nonce_check++;
			}
		}
		
		error_log('Nonce check return:' . $nonce_check);
		return $nonce_check;
	}
	// check_nonces()
	
	/**
	 * Returns an array of the all the metabox fields and their respective
	 * types
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Metabox fields and types
	 */
	private function get_metabox_fields()
	{
		$fields = array();
		
		$fields[] = array(
				'wc-booking-total-tickets',
				'number'
		);
		$fields[] = array(
				'wc-booking-price',
				'price'
		);
		$fields[] = array(
				'wc-booking-departure-calendar',
				'calendar'
		);
		$fields[] = array(
				'wc-booking-daily-departures',
				'text'
		);
		$fields[] = array(
				'wc-booking-calendar-departures',
				'calendar'
		);
		
		return $fields;
	}
	// get_metabox_fields()
	
	/**
	 * Calls a metabox file specified in the add_meta_box args.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function metabox($post, $params)
	{
		if (!is_admin())
		{
			return;
		}
		error_log('Post type: ' . $post->post_type);
		if (!(('wc-ticket' === $post->post_type) || ('wc-departures' === $post->post_type)))
		{
			return;
		}
		
		if (!empty($params['args']['classes']))
		{
			
			$classes = 'repeater ' . $params['args']['classes'];
		}
		
		error_log('Partial: ' . $params['args']['name']);
		include (plugin_dir_path(__FILE__) . 'partials/wc-booking-admin-metabox-' . $params['args']['name'] . '.php');
	}

	private function sanitizer($type, $data)
	{
		if (empty($type))
		{
			return;
		}
		if (empty($data))
		{
			return;
		}
		
		$return = '';
		$sanitizer = new WC_Booking_Sanitize();
		
		$sanitizer->set_data($data);
		$sanitizer->set_type($type);
		
		error_log($data);
		error_log($type);
		
		$return = $sanitizer->clean();
		
		unset($sanitizer);
		
		return $return;
	}

	/**
	 * Sets the class variable $options
	 */
	public function set_meta()
	{
		global $post;
		
		if (empty($post))
		{
			return;
		}
		if (!(('wc-ticket' === $post->post_type) || ('wc-departures' === $post->post_type)))
		{
			return;
		}
		
		$this->meta = get_post_custom($post->ID);
	}
	// set_meta()
	
	/**
	 * Saves metabox data
	 *
	 * Repeater section works like this:
	 * Loops through meta fields
	 * Loops through submitted data
	 * Sanitizes each field into $clean array
	 * Gets max of $clean to use in FOR loop
	 * FOR loops through $clean, adding each value to $new_value as an array
	 *
	 * @since 1.0.0
	 * @access public
	 * @param int $post_id
	 *        	The post ID
	 * @param object $object
	 *        	The post object
	 * @return void
	 */
	public function validate_meta($post_id, $object)
	{
		// wp_die('<pre>' . print_r($_POST) . '</pre>');
		error_log('Post request: ' . print_r($_POST, true));
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		{
			return $post_id;
		}
		error_log('Permission check');
		if (!current_user_can('edit_posts', $post_id))
		{
			return $post_id;
		}
		error_log('Type check');
		if ('wc-ticket' !== $object->post_type)
		{
			return $post_id;
		}
		
		error_log('Nonce check');
		$nonce_check = $this->check_nonces($_POST);
		if (0 < $nonce_check)
		{
			return $post_id;
		}
		
		$metas = $this->get_metabox_fields();
		
		error_log('Metas: ' . print_r($metas, true));
		
		foreach ($metas as $meta)
		{
			
			$name = $meta[0];
			$type = $meta[1];
			
			$new_value = $this->sanitizer($type, $_POST[$name]);
			
			update_post_meta($post_id, $name, $new_value);
		} // foreach
	} // validate_meta()
} // class
		