<?php wp_nonce_field( basename( __FILE__ ), 'total_tickets_nonce' ); ?>
<p>
	<input class="widefat" type="number" size="5" name="wc-booking-total-tickets" placeholder="<?php _e('total tickets', 'wc-booking') ?>" />
</p>
