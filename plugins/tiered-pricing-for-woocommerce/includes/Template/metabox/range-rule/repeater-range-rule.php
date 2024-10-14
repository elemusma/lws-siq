<?php
$i = 1;
foreach ( $wtp_tier_clone as $row ) {  ?>
	<div class="tier-range-row">
		<div class="tier-form-group">
			<input class="minQty" type="number" min="<?php echo ( 1 == $i ) ? 1 : esc_attr($row['wtp_min_qty']); ?>" oninput="this.value = Math.abs(this.value)" name="wtp_tier_clone[wtp_min_qty][]" value="<?php esc_attr_e($row['wtp_min_qty']); ?>">
			<label><?php esc_html_e( 'Minimum Quantity', 'wtp' ); ?></label>
		</div>
			
		<div class="tier-form-group">
			<input class="maxQty" type="number" min="<?php esc_attr_e( (int) $row['wtp_min_qty'] + 1 ); ?>" oninput="this.value = Math.abs(this.value)" name="wtp_tier_clone[wtp_max_qty][]" value="<?php esc_attr_e($row['wtp_max_qty']); ?>">
			<label><?php esc_html_e( 'Maximum Quantity', 'wtp' ); ?></label>
		</div>
			
		<div class="tier-form-group">
			<select class="discount-type" name="wtp_tier_clone[wtp_discount_type][]">
				<option value="fix" <?php selected('fix', $row['wtp_discount_type'], true); ?> >Fixed</option>
				<option value="percent" <?php selected('percent', $row['wtp_discount_type'], true); ?>>Percentage</option>
			</select>
			<label><?php esc_html_e( 'Discount Type', 'wtp' ); ?></label>
		</div>
			
		<div class="tier-form-group">
			<input class="discount-value" step="any" type="number" min="0.01" name="wtp_tier_clone[wtp_discount_value][]" value="<?php esc_attr_e($row['wtp_discount_value']); ?>">
			<label><?php esc_html_e( 'Discount Value', 'wtp' ); ?></label>
		</div>
		<div class="tier-form-group">
			<div>
			<svg class="wtp-delete-range-row" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24">
				<path class="delete-range-icon-path" d="M3 6.52381C3 6.12932 3.32671 5.80952 3.72973 5.80952H8.51787C8.52437 4.9683 8.61554 3.81504 9.45037 3.01668C10.1074 2.38839 11.0081 2 12 2C12.9919 2 13.8926 2.38839 14.5496 3.01668C15.3844 3.81504 15.4756 4.9683 15.4821 5.80952H20.2703C20.6733 5.80952 21 6.12932 21 6.52381C21 6.9183 20.6733 7.2381 20.2703 7.2381H3.72973C3.32671 7.2381 3 6.9183 3 6.52381Z" fill="#1C274C"/>
				<path class="delete-range-icon-path" fill-rule="evenodd" clip-rule="evenodd" d="M11.5956 22H12.4044C15.1871 22 16.5785 22 17.4831 21.1141C18.3878 20.2281 18.4803 18.7749 18.6654 15.8685L18.9321 11.6806C19.0326 10.1036 19.0828 9.31511 18.6289 8.81545C18.1751 8.31579 17.4087 8.31579 15.876 8.31579H8.12404C6.59127 8.31579 5.82488 8.31579 5.37105 8.81545C4.91722 9.31511 4.96744 10.1036 5.06788 11.6806L5.33459 15.8685C5.5197 18.7749 5.61225 20.2281 6.51689 21.1141C7.42153 22 8.81289 22 11.5956 22ZM10.2463 12.1885C10.2051 11.7546 9.83753 11.4381 9.42537 11.4815C9.01321 11.5249 8.71251 11.9117 8.75372 12.3456L9.25372 17.6087C9.29494 18.0426 9.66247 18.3591 10.0746 18.3157C10.4868 18.2724 10.7875 17.8855 10.7463 17.4516L10.2463 12.1885ZM14.5746 11.4815C14.9868 11.5249 15.2875 11.9117 15.2463 12.3456L14.7463 17.6087C14.7051 18.0426 14.3375 18.3591 13.9254 18.3157C13.5132 18.2724 13.2125 17.8855 13.2537 17.4516L13.7537 12.1885C13.7949 11.7546 14.1625 11.4381 14.5746 11.4815Z" fill="#1C274C"/>
			</svg>

			<svg class="wtp-add-range-row" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24" fill="none">
				<path class="add-range-icon-path" fill-rule="evenodd" clip-rule="evenodd" d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM12.75 9C12.75 8.58579 12.4142 8.25 12 8.25C11.5858 8.25 11.25 8.58579 11.25 9L11.25 11.25H9C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75H11.25V15C11.25 15.4142 11.5858 15.75 12 15.75C12.4142 15.75 12.75 15.4142 12.75 15L12.75 12.75H15C15.4142 12.75 15.75 12.4142 15.75 12C15.75 11.5858 15.4142 11.25 15 11.25H12.75V9Z" fill="#1C274C"/>
			</svg>
			</div>
		</div>
	</div>
	<?php 
	$i++;
} 
