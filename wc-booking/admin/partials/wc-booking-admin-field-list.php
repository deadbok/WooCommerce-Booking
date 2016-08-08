<?php
if (! empty($atts['label']))
{
	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'wc-booking' ); ?>:&nbsp;</label><?php
}
?>
<table class="wp-list-table widefat fixed striped <?php echo esc_attr( $atts['classes'] ); ?> wc-booking-field-list widefat"
	id="<?php echo esc_attr( $atts['id'] ); ?>">
	<thead class="<?php echo esc_attr( $atts['classes'] ); ?> wc-booking-field-list-headers">
<?php
$i = 0;
foreach ($atts['headers'] as $header)
{?>
		<th class="sortable <?php echo esc_attr( $atts['classes'] ); ?> wc-booking-field-list-header-<?php echo $i; ?>">
			<?php echo esc_attr($header); ?>
		</th><?php
	$i++;
}?>
	</thead>
	<tbody class="<?php echo esc_attr( $atts['classes'] ); ?> wc-booking-field-list-entries">
<?php 
$i = 0;
foreach ($atts['rows'] as $row)
{
	$j = 0;?>
		<tr class="<?php echo esc_attr( $atts['classes'] ); ?> wc-booking-field-list-entry-<?php echo $i; ?>">
		<?php
	foreach ($row as $entry)
	{?>
			<td class="<?php echo esc_attr( $atts['classes'] ); ?> wc-booking-field-list-entry-<?php echo $i; ?>-<?php echo $j; ?>">
				<?php echo esc_attr($entry); ?>
			</td><?php
		$j++;
	}
	$i++;
}?>
	</tbody>
</table><br /><?php
if (! empty($atts['description']))
{
	?><span class="description panel panel-default"><?php esc_html_e( $atts['description'], 'wc-booking' ); ?></span><?php
}
