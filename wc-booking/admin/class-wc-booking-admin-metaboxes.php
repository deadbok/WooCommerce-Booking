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
	 * The the admin metabox fields
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $fields The admin metabox fields.
	 */
	private $fields;

	/**
	 * Initialise the class and set its properties.
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
		
		$this->fields = array();
		
		$this->fields['wc-ticket'] = array();
		$this->fields['wc-ticket']['total_tickets_meta'] = array(
				'name' => 'wc-booking-total-tickets',
				'title' => __("Total Tickets", 'wc-booking'),
				'context' => 'side',
				'priority' => 'low',
				'type' => 'number',
				'metabox' => 'total_tickets',
				'nonce' => 'total_tickets_nonce'
		);
		$this->fields['wc-ticket']['ticket_price_meta'] = array(
				'name' => 'wc-booking-ticket-price',
				'title' => __("Ticket Price", 'wc-booking'),
				'context' => 'side',
				'priority' => 'low',
				'type' => 'price',
				'metabox' => 'ticket_price',
				'nonce' => 'price_ticket_nonce'
		);
		$this->fields['wc-ticket']['return_ticket_meta'] = array(
				'name' => 'wc-booking-return-ticket',
				'title' => __("Return Ticket", 'wc-booking'),
				'context' => 'side',
				'priority' => 'low',
				'type' => 'select',
				'metabox' => 'return_ticket',
				'nonce' => 'return_ticket_nonce'
		);
		$this->fields['wc-ticket']['departure_calender_meta'] = array(
				'name' => 'wc-booking-departure-calendar',
				'title' => __("Departure", 'wc-booking'),
				'context' => 'side',
				'priority' => 'low',
				'type' => 'select',
				'metabox' => 'departure_calendar',
				'nonce' => 'departure_calendar_nonce'
		);
		$this->fields['wc-departures'] = array();
		$this->fields['wc-departures']['departure_rule_id_meta'] = array(
				'name' => 'wc-booking-departure-rule-id',
				'title' => __("Depature Rules", 'wc-booking'),
				'context' => 'normal',
				'priority' => 'high',
				'type' => 'hidden',
				'metabox' => 'departures',
				'nonce' => 'departure_rule_id_nonce'
		);
		$this->fields['wc-departures']['departure_rule_name_meta'] = array(
				'name' => 'wc-booking-departure-rule-name',
				'title' => __("Depature Rule Name", 'wc-booking'),
				'context' => 'normal',
				'priority' => 'high',
				'type' => 'text',
				'metabox' => 'departures',
				'nonce' => 'departure_rule_name_nonce'
		);
		$this->fields['wc-departures']['departure_rule_meta'] = array(
				'name' => 'wc-booking-departure-rule',
				'title' => __("Depature Rule", 'wc-booking'),
				'context' => 'normal',
				'priority' => 'high',
				'type' => 'text',
				'metabox' => 'departures',
				'nonce' => 'departure_rule_nonce'
		);
		$this->fields['wc-departures']['departure_meta'] = array(
				'name' => 'wc-booking-departure',
				'title' => __("Depature Rules", 'wc-booking'),
				'context' => 'normal',
				'priority' => 'high',
				'type' => 'select',
				'metabox' => 'departures',
				'nonce' => 'departure_nonce'
		);
		$this->fields['wc-departures']['departure_rules_meta'] = array(
				'name' => 'wc-booking-departure_rules',
				'title' => __("Depature Rules", 'wc-booking'),
				'context' => 'normal', 
				'priority' => 'high',
				'type' => 'list',
				'metabox' => 'departures',
				'nonce' => 'departure_rules_nonce'
		);
		$this->fields['wc-departures']['calendar_departures_meta'] = array(
				'name' => 'wc-booking-calendar-departures',
				'title' => __("Calender View", 'wc-booking'),
				'context' => 'normal',
				'priority' => 'high',
				'type' => 'calendar',
				'metabox' => 'departures',
				'nonce' => 'calendar_departures_nonce'
		);
		
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
		$metaboxes = array();
		foreach ($this->get_metabox_fields() as $type => $fields)
		{
			foreach ($fields as $id => $field)
			{
				//Only render each metabox group one time.
				if (!(in_array($field['metabox'], $metaboxes)))
				{
					error_log('Adding metabox: ' . $field['metabox']);
					error_log(' Type: ' . $type);
					error_log(' ID: ' . $id);
					error_log(' Field: ' . $field['name']);
					add_meta_box($id, $field['title'], array(
							$this,
							'metabox'
					), $type, $field['context'], $field['priority'], array(
							'metabox' => $field['metabox']
					));
					$metaboxes[] = $field['metabox'];
				}
			}
		}
	}

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
		$metas = $this->get_metabox_fields();
		$nonce_check = 0;
		
		foreach ($metas[$posted['post_type']] as $meta)
		{
			error_log('Meta: ' . print_r($meta, true));
			error_log('Nonce: ' . $meta['nonce']);
			if (!isset($posted[$meta['nonce']]))
			{
				error_log('Nonce is not set');
				$nonce_check++;
			}
			if (isset($posted[$meta['nonce']]) && !wp_verify_nonce($posted[$meta['nonce']], $this->plugin_name))
			{
				error_log('Nonce is not ok');
				$nonce_check++;
			}
		}
		
		error_log('Nonce check return:' . $nonce_check);
		return $nonce_check;
	}

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
		return $this->fields;
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

		if (!(('wc-ticket' === $post->post_type) || ('wc-departures' === $post->post_type)))
		{
			return;
		}
		
		error_log('Rendering metabox: ' . $params['args']['metabox']);
		error_log('Post type: ' . $post->post_type);
		$fields = array();
		foreach ($this->get_metabox_fields()[$post->post_type] as $field)
		{
			if ($field['metabox'] === $params['args']['metabox'])
			{
				error_log('Field: ' . $field['name']);
				$fields[] = $field;
			}	
		}
		
		if (count($fields) > 0)
		{
			$name = str_replace('_', '-', $params['args']['metabox']);
			include (plugin_dir_path(__FILE__) . 'partials/wc-booking-admin-metabox-' . $name . '.php');
		}
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

	/**
	 * Saves metabox data
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
		
		foreach ($metas[$object->post_type] as $meta)
		{
			
			$name = $meta['name'];
			$type = $meta['type'];
			
			$new_value = $this->sanitizer($type, $_POST[$name]);
			
			error_log($name . ': ' . $new_value);
			
			update_post_meta($post_id, $name, $new_value);
		}
	}
}
		