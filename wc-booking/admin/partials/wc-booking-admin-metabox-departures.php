<?php
//Hidden ID field for the depature rule.
wp_nonce_field($this->plugin_name, $fields[0]['nonce']);

$atts = array();
$atts['description'] = __('Some meaningful name for the departure rule.', 'wc-booking');
$atts['id'] = $fields[0]['name'];
$atts['name'] = $fields[0]['name'];
$atts['type'] = $fields[0]['type'];
$atts['classes'] = 'wc-booking-departure-rule-id';
$atts['value'] = '';

if (!empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p class="form-field"><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p><?php

//Name of the rule
wp_nonce_field($this->plugin_name, $fields[1]['nonce']);

$atts = array();
$atts['description'] = __('Some meaningful name for the departure rule.', 'wc-booking');
$atts['id'] = $fields[1]['name'];
$atts['name'] = $fields[1]['name'];
$atts['type'] = $fields[1]['type'];
$atts['label'] = 'Departure Rule Name';
$atts['classes'] = 'wc-booking-departure-rule-name';
$atts['value'] = '';
$atts['placeholder'] = 'rule name...';

if (!empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p class="form-field"><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p><?php

//The rule
wp_nonce_field($this->plugin_name, $fields[2]['nonce']);

$atts = array();
$atts['description'] = __('A rule for selecteting or clearing departures at specific times.', 'wc-booking');
$atts['id'] = $fields[2]['name'];
$atts['name'] = $fields[2]['name'];
$atts['type'] = $fields[2]['type'];
$atts['label'] = 'Departure Rule';
$atts['classes'] = 'wc-booking-departure-rule';
$atts['value'] = '';
$atts['placeholder'] = 'rule...';

if (!empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p class="form-field"><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p><?php

//Departure/No departure
wp_nonce_field($this->plugin_name, $fields[3]['nonce']);

$atts = array();
$atts['description'] = __('Whether the rule is for departures or non-departures.', 'wc-booking');
$atts['id'] = $fields[3]['name'];
$atts['name'] = $fields[3]['name'];
$atts['type'] = $fields[3]['type'];
$atts['label'] = 'Departure';
$atts['classes'] = 'wc-booking-departure';
$atts['value'] = '';
$atts['options'] = array(
		'departure' => 'Departure',
		'no_departure' => 'No Departure'
);
$atts['placeholder'] = 'Departure';

if (!empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p class="form-field"><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p>
<!-- Rule action buttons -->
<button type="button" id="wc-booking-rule-update-button"
	class="button button-primary"><?php echo __('Add/Update', 'wc-boking') ?></button>
<button type="button" class="button button-secondary"><?php echo __('Delete', 'wc-boking') ?></button>
<p id="wc-booking-departures-rule-message"></p>

<?php
//Add AJAX handler to the buttons.
add_action('admin_footer', 'wc_booking_departures_rule_update_javascript');

function wc_booking_departures_rule_update_javascript()
{
	global $fields;
	?>
<script type="text/javascript">
	jQuery('#wc-booking-rule-update-button').click(function($) {

		var data = {
			'action': 'wc_booking_rule_update',
			'id': 0,
			'name': jQuery('#<?php echo $fields[1]['name']; ?>').value,
			'rule': jQuery('#<?php echo $fields[2]['name']; ?>').value,
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#wc-booking-departures-rule-message').html('Updated ok');
		});
	});
	</script>
<?php
}

add_action('wp_ajax_wc_booking_departures_rule_update', 'wc_booking_departures_rule_update_callback');

function wc_booking_departures_rule_update_callback()
{
	error_log('Ajax request');
	error_log(' ID: ' . $_POST['id']);
	error_log(' Name: ' . $_POST['name']);
	error_log(' Rule: ' . $_POST['rule']);
	
	wp_die(); // this is required to terminate immediately and return a proper
	          // response
}
?>
<hr /><?php

//Rule list.
wp_nonce_field($this->plugin_name, $fields[4]['nonce']);

$atts = array();
$atts['description'] = __('Rules for departures', 'wc-booking');
$atts['id'] = $fields[4]['name'];
$atts['name'] = $fields[4]['name'];
$atts['type'] = $fields[4]['type'];
$atts['label'] = 'Departure Rules';
$atts['classes'] = 'wc-booking-departure_rules';
$atts['headers'] = array(
		'Name',
		'Rule'
);
$atts['rows'] = array(
		array(
				'No entries',
				''
			),
);

if (!empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p class="form-field"><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p>
<hr /><?php

//Calendar view
wp_nonce_field($this->plugin_name, $fields[5]['nonce']);

$atts = array();
$atts['description'] = __('Calendar view of rules', 'wc-booking');
$atts['id'] = $fields[5]['name'];
$atts['name'] = $fields[5]['name'];
$atts['type'] = $fields[5]['type'];
$atts['label'] = 'Calender View';
$atts['classes'] = '';
$atts['value'] = '';

if (!empty($this->meta[$atts['id']][0]))
{
	$atts['value'] = $this->meta[$atts['id']][0];
}
apply_filters($this->plugin_name . '-field-' . $atts['id'], $atts);
?><p class="form-field"><?php
include (plugin_dir_path(__FILE__) . $this->plugin_name . '-admin-field-' . $atts['type'] . '.php');
?></p><?php
