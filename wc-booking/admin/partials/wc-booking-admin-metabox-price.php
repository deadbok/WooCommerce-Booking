<?php wp_nonce_field( $this->plugin_name, 'price_ticket_nonce' ); ?>
<p>
	<input class="widefat" name="wc-booking-price" type="number" size="5" placeholder="<?php _e('price', 'wc-booking'); ?>" />
</p>
<?php
