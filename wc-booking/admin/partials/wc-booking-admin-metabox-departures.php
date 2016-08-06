<?php
wp_nonce_field($this->plugin_name, 'total_tickets_nonce');

$atts = array();
$atts['description'] = __('Calendar view', 'wc-booking');
$atts['id'] = 'wc-booking-calendar-departures';
$atts['name'] = 'wc-booking-calendar-departures';
$atts['type'] = 'calendar';
$atts['classes'] = '';
$atts['value'] = '';

if (! empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p><?php

