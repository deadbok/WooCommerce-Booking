<?php

/**
 * Provide a admin area view for a ticket
 *
 * @link       http://groenholdt.net
 * @since      1.0.0
 *
 * @package    Wc_Booking
 * @subpackage Wc_Booking/admin/views
 */

if ( ! defined( 'ABSPATH' ) ) {
        exit;
}
?>
<div class="wrap">
	<h1>Add ticket</h1>

	<form method="post"
		action="<?php echo esc_url(admin_url( "/wp-admin/admin-post.php")); ?>">
		<input type="hidden" name="action" value="add_foobar">
		<div id="wp_sb_ticket_add_form_name">
			<label for="wp_sb_ticket_name"><?php echo __('Name')?></label><br />
			<input name="wp_sb_ticket_name" id="wp_sb_ticket_name" value=""
				placeholder="<?php echo __('Name')?>" type="text" size="50" />
		</div>
		<div id="wp_sb_ticket_add_form_total">
			<label for="wp_sb_ticket_total"><?php echo __('Total tickets')?></label><br />
			<input name="wp_sb_ticket_total" id="wp_sb_ticket_total" value=""
				placeholder="<?php echo __('Total tickets')?>" type="text" size="15" />
		</div>
		<div id="wp_sb_ticket_add_form_price">
			<label for="wp_sb_ticket_price"><?php echo __('Price')?></label><br />
			<input name="wp_sb_ticket_price" id="wp_sb_ticket_price" value=""
				placeholder="<?php echo __('Price')?>" type="text" size="15" />
		</div>
		<p class="submit">
			<input name="submit" id="submit" class="button button-primary"
				value="<?php echo __('Save changes')?>" type="submit">
		</p>
	</form>
</div>
