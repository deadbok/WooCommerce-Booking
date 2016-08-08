<?php
wp_nonce_field($this->plugin_name, $fields[0]['nonce']);

$atts = array();
$atts['description'] = __('Departure calendar', 'wc-booking');
$atts['id'] = $fields[0]['name'];
$atts['name'] = $fields[0]['name'];
$atts['type'] = $fields[0]['type'];
$atts['placeholder'] = __('number of tickets', 'wc-booking');
$atts['classes'] = 'widefat';
$atts['value'] = '';
$atts['options'] = array();
// Get all wc-departures type posts.
$args = array(
		'post_type' => 'wc-departures'
);
$posts = get_posts($args);
// Add them as options to the select input
foreach ($posts as $post)
{
	
	$atts['options'][$post->ID] = $post->post_title;
}

if (!empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p class="form-field"><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p><?php

