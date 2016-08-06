<?php
if (! empty($atts['label']))
{
	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'wc-booking' ); ?>: </label><?php
}
?><div class="<?php echo esc_attr( $atts['classes'] ); ?> wc-booking-datepicker"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	type="text"
	value="<?php echo esc_attr( $atts['value'] ); ?>"></div><?php
	if (! empty($atts['description']))
	{
		?><span class="description"><?php esc_html_e( $atts['description'], 'wc-booking' ); ?></span><?php
	}