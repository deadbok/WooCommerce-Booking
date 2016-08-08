<?php
if (! empty($atts['label']))
{
	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'wc-booking' ); ?>: </label><?php
}
?><input class="<?php echo esc_attr( $atts['classes'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	type="number" step="0.01"
	value="<?php echo esc_attr( $atts['value'] ); ?>" /><br /><?php
	if (! empty($atts['description']))
	{
		?><span class="description"><?php esc_html_e( $atts['description'], 'wc-booking' ); ?></span><?php
	}
