<?php
if (! empty($atts['label']))
{
	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'wc-booking' ); ?>:&nbsp;</label><?php
}
?><input class="<?php echo esc_attr( $atts['classes'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	value="<?php echo esc_attr( $atts['value'] ); ?>" />&nbsp;<?php
	if (! empty($atts['description']))
	{
		?><span class="description panel panel-default"><?php esc_html_e( $atts['description'], 'wc-booking' ); ?></span><?php
	}
