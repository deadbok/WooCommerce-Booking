<?php
if (!empty($atts['label']))
{
	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'wc-booking' ); ?>: </label><?php
}
?>
<select class="<?php echo esc_attr( $atts['classes'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	value="<?php echo esc_attr( $atts['value'] ); ?>">
	<?php
	foreach ($atts['options'] as $id => $option)
	{
		?>
		<option id="<?php echo $id; ?>" value="<?php echo $id; ?>"><?php echo $option; ?></option>
		<?php
	}
	?>
	</select><?php
	if (!empty($atts['description']))
	{
		?><span class="description"><?php esc_html_e( $atts['description'], 'wc-booking' ); ?></span><?php
	}