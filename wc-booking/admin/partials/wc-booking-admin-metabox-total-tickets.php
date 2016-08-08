<?php
wp_nonce_field($this->plugin_name, $fields[0]['nonce']);

$atts = array();
$atts['description'] = __('Total number of tickets', 'wc-booking');
$atts['id'] = $fields[0]['name'];
$atts['name'] = $fields[0]['name'];
$atts['type'] = $fields[0]['type'];
$atts['size'] = 5;
$atts['placeholder'] = __('number of tickets', 'wc-booking');
$atts['classes'] = 'widefat';
$atts['value'] = 1;

if (! empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p class="form-field"><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p><?php

