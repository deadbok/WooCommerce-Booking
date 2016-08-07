<?php
wp_nonce_field($this->plugin_name, $fields[0]['nonce']);

$atts = array();
$atts['description'] = __('Rule for minute by minute departures', 'wc-booking');
$atts['id'] = $fields[0]['name'];
$atts['name'] = $fields[0]['name'];
$atts['type'] = $fields[0]['type'];
$atts['label'] = 'Minute by minute departures';
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

wp_nonce_field($this->plugin_name, $fields[1]['nonce']);

$atts = array();
$atts['description'] = __('Rules for hourly departures', 'wc-booking');
$atts['id'] = $fields[1]['name'];
$atts['name'] = $fields[1]['name'];
$atts['type'] = $fields[1]['type'];
$atts['label'] = 'Hourly departures';
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

wp_nonce_field($this->plugin_name, $fields[2]['nonce']);

$atts = array();
$atts['description'] = __('Calendar view of rules', 'wc-booking');
$atts['id'] = $fields[2]['name'];
$atts['name'] = $fields[2]['name'];
$atts['type'] = $fields[2]['type'];
$atts['label'] = 'Calender View';
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
