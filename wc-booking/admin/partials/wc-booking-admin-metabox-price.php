<?php
wp_nonce_field($this->plugin_name, 'price_ticket_nonce');

$atts = array();
$atts['description'] = __('The price of the ticket', 'wc-booking');
$atts['id'] = 'wc-booking-price';
$atts['name'] = 'wc-booking-price';
$atts['type'] = 'price';
$atts['size'] = 5;
$atts['placeholder'] = __('price', 'wc-booking');
;
$atts['classes'] = 'widefat';
$atts['value'] = 1.01;

if (! empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p><?php

