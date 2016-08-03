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
		
		foreach ($nonces as $nonce)
		{
			
			if (! isset($posted[$nonce]))
			{
				$nonce_check++;
			}
			if (isset($posted[$nonce]) && ! wp_verify_nonce($posted[$nonce], $this->plugin_name))
			{
				$nonce_check++;
			}
		}
		
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
				'total_tickets',
				'text'
		);
		$fields[] = array(
				'price_ticket',
				'text'
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
		if (! is_admin())
		{
			return;
		}
		if ('wc-ticket' !== $post->post_type)
		{
			return;
		}
		
		if (! empty($params['args']['classes']))
		{
			
			$classes = 'repeater ' . $params['args']['classes'];
		}
		
		include (plugin_dir_path(__FILE__) . 'partials/wc-booking-admin-metabox-' . $params['args']['name'] . '.php');
	}
	// metabox()
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
	// sanitizer()
	
	/**
	 * Saves button order when buttons are sorted.
	 */
	public function save_files_order()
	{
		check_ajax_referer('wc-booking-file-order-nonce', 'fileordernonce');
		
		$order = $this->meta['file-order'];
		$new_order = implode(',', $_POST['file-order']);
		$this->meta['file-order'] = $new_order;
		$update = update_post_meta('file-order', $new_order);
		
		esc_html_e('File order saved.', 'wc-booking');
		
		die();
	}
	// save_files_order()
	
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
		if ('wc-ticket' != $post->post_type)
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
		error_log('validate');
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		{
			return $post_id;
		}
		error_log('No autosave');
		$current_user = wp_get_current_user();
		error_log(print_r($current_user->get_role_caps(), true));
		if (! current_user_can('edit_posts', $post_id))
		{
			return $post_id;
		}
		error_log('user ok');
		
		error_log($object->post_type);
		if ('wc-ticket' !== $object->post_type)
		{
			return $post_id;
		}
		
		error_log('type ok');
		error_log(print_r($_POST));
		
		$nonce_check = $this->check_nonces($_POST);
		
		if (0 < $nonce_check)
		{
			return $post_id;
		}
		
		error_log('nonce ok');
		
		$metas = $this->get_metabox_fields();
		
		foreach ($metas as $meta)
		{
			
			$name = $meta[0];
			$type = $meta[1];
			
			$new_value = $this->sanitizer($type, $_POST[$name]);
			
			update_post_meta($post_id, $name, $new_value);
		} // foreach
	} // validate_meta()
} // class
		