<?php
/**
* Display meta box main HTML 
*
*/
$is_enable = get_post_meta( $post->ID, 'wtp_enable_tier_pricing', true );
$include_products = get_post_meta( $post->ID, 'wtp_include_product', true );
$exclude_products = get_post_meta( $post->ID, 'wtp_exclude_product', true );
$include_product_cats = get_post_meta( $post->ID, 'wtp_include_product_cat', true );
$exclude_products_cats = get_post_meta( $post->ID, 'wtp_exclude_product_cat', true );
$selected_roles = get_post_meta( $post->ID, 'wtp_user_roles', true );
$selected_users = get_post_meta( $post->ID, 'wtp_users', true );
$tier_type = get_post_meta( $post->ID, 'wtp_tier_type', true );
$tier_fix_select = get_post_meta( $post->ID, 'wtp_rule_fix_select', true );
$wtp_tier_clone = get_post_meta( $post->ID, 'wtp_tier_clone', true );
$wtp_tier_fix_clone = get_post_meta( $post->ID, 'wtp_tier_fix_clone', true );
$wtp_tier_qty_clone = get_post_meta( $post->ID, 'wtp_tier_qty_clone', true );

if ( empty( $tier_type ) ) {
	$tier_type = 'tier_range';
}

if ( empty( $tier_fix_select ) ) {
	$tier_fix_select = 'tier_fix_rule';
}

$all_products = get_posts( 
	array(
		'post_type' => 'product',
		'numberposts' => -1,
		'fields' => 'ids',
		'post_status' => 'publish',
	)
);

$all_categories = get_terms(
	array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => 1,
	)
);

$all_users = get_users();
$all_roles = get_editable_roles();

?>
<div class="wrap woocommerce">
	<table class="form-table">
		<thead>
		<tr valign="top" style="display:none;">
			<td>
				<?php wp_nonce_field( 'wtp_admin', 'wtp_nonce' ); ?>
			</td>
		</tr>
			<tr valign="top">
				<th scope="row" class="titledesc"><?php esc_html_e( 'Enable Rule', 'wtp' ); ?></th>
				<td class="forminp forminp-checkbox">
					<input type="checkbox" name="wtp_enable_tier_pricing" <?php isset( $is_enable ) ? checked( 'on', $is_enable, true ) : ''; ?>>
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th colspan="2">
					<h3 class="sub-heading"><?php esc_html_e( 'Category', 'wtp' ); ?></h3>
				</th> 
			</tr>  
			<tr valign="top">
				<td>
				<?php esc_html_e( 'Include Product Categories', 'wtp' ); ?>
				</td>
				<td class="forminp forminp-select">
					<select name="wtp_include_product_cat[]" class="wc-enhanced-select test" multiple>
						<option value="all" <?php ( isset( $include_product_cats ) && ! empty( $include_product_cats ) ) ? selected( true, in_array( 'all', maybe_unserialize( $include_product_cats ), true ) ) : ''; ?> ><?php echo esc_html_e( 'All Categories', 'wtp' ); ?></option>
						<?php 
						if ( is_array( $all_categories ) && count( $all_categories ) > 0 ) {
							foreach ( $all_categories as $category_obj ) {
								?>
								<option title="<?php echo esc_attr( $category_obj->name ); ?>" value="<?php esc_attr_e( $category_obj->term_id ); ?>" <?php ( isset( $include_product_cats ) && ! empty( $include_product_cats ) ) ? selected( true, in_array( $category_obj->term_id, maybe_unserialize( $include_product_cats ) ), true ) : ''; ?>><?php echo esc_html( $category_obj->name ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<?php esc_html_e( 'Exclude Product Categories', 'wtp' ); ?>
				</td>
				<td class="forminp forminp-select">
					<div class="abc">
				<select name="wtp_exclude_product_cat[]" class="wc-enhanced-select" multiple>
						<?php 
						if ( is_array( $all_categories ) && count( $all_categories ) > 0 ) {
							foreach ( $all_categories as $category_obj ) {
								?>
								<option value="<?php esc_attr_e( $category_obj->term_id ); ?>" <?php isset( $exclude_products_cats ) && ! empty( $exclude_products_cats ) ? selected( true, in_array( $category_obj->term_id, maybe_unserialize( $exclude_products_cats ) ), true ) : ''; ?>><?php echo esc_html( $category_obj->name ); ?></option>
								<?php
							}
						}
						?>
					</select>
					</div>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<h3 class="sub-heading"><?php esc_html_e( 'Product', 'wtp' ); ?></h3>
				</th> 
			</tr>  
			<tr valign="top">
				<td>
				<?php esc_html_e( 'Include Product', 'wtp' ); ?>
				</td>
				<td class="forminp forminp-select">
					<select name="wtp_include_product[]" class="wc-enhanced-select" multiple>
					<option value="all" <?php isset( $include_products ) && ! empty( $include_products ) ? selected( true, in_array( 'all', maybe_unserialize( $include_products ), true ) ) : ''; ?> ><?php esc_html_e( 'All Products', 'wtp' ); ?></option>
						<?php 
						if ( is_array( $all_products ) && count( $all_products ) > 0 ) {
							foreach ( $all_products as $product_id ) {
								?>
									<option value="<?php esc_attr_e( $product_id ); ?>" <?php isset( $include_products ) && ! empty( $include_products ) ? selected( true, in_array( $product_id, maybe_unserialize( $include_products ) ), true ) : ''; ?>><?php echo esc_html( get_the_title( $product_id ) ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<?php esc_html_e( 'Exclude Product', 'wtp' ); ?>
				</td>
				<td class="forminp forminp-select">
					<select name="wtp_exclude_product[]" class="wc-enhanced-select" multiple>
						<?php 
						if ( is_array( $all_products ) && count( $all_products ) > 0 ) {
							foreach ( $all_products as $product_id ) {
								?>
									<option value="<?php esc_attr_e( $product_id ); ?>" <?php isset( $exclude_products ) && ! empty( $exclude_products ) ? selected( true, in_array( $product_id, maybe_unserialize( $exclude_products ) ), true ) : ''; ?>><?php echo esc_html( get_the_title( $product_id ) ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<h3 class="sub-heading"><?php esc_html_e( 'User', 'wtp' ); ?></h3>
				</th> 
			</tr>  
			<tr valign="top">
				<td>
					<?php esc_html_e( 'User Role', 'wtp' ); ?> 
				</td>
				<td class="forminp forminp-select">
					<select name="wtp_user_roles[]" class="wc-enhanced-select" multiple>
						<option value="all" <?php isset( $selected_roles ) && ! empty( $selected_roles ) ? selected( true, in_array( 'all', maybe_unserialize( $selected_roles ), true ) ) : ''; ?>><?php esc_html_e( 'All Roles', 'wtp' ); ?></option>
						<?php 
						foreach ( $all_roles as $key => $val ) {
							?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php isset( $selected_roles ) && ! empty( $selected_roles ) ? selected( true, in_array( $key, maybe_unserialize( $selected_roles ) ), true ) : ''; ?>><?php echo esc_html( $val['name'] ); ?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td>
				<?php esc_html_e( 'User', 'wtp' ); ?>
				</td>
				<td class="forminp forminp-select">
					<select name="wtp_users[]" class="wc-enhanced-select" multiple>
						<option value="all" <?php isset( $selected_users ) && ! empty( $selected_users ) ? selected( true, in_array( 'all', maybe_unserialize( $selected_users ) ), true ) : ''; ?> ><?php esc_html_e( 'All Users', 'wtp' ); ?></option>
						<?php 
						foreach ( $all_users as $key => $val ) {
							if ( isset( $val->data ) ) { 
								?>
								<option value="<?php echo esc_attr( $val->data->ID ); ?> " <?php isset( $selected_users ) && ! empty( $selected_users ) ? selected( true, in_array( $val->data->ID, maybe_unserialize( $selected_users ) ), true ) : ''; ?>><?php echo esc_html( $val->data->display_name . ' ( ' . $val->data->user_email . ' ) ' ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<h3 class="sub-heading"><?php esc_html_e( 'Tier Pricing', 'wtp' ); ?></h3>
				</th> 
			</tr>
			<tr valign="top">
				<td></td>
				<td class="display-option">
					<input class="wtp-tier-type" id="wtp_tier_range" type="radio" name="wtp_tier_type" value="tier_range" <?php checked($tier_type, 'tier_range', true); ?>>
					<label for="wtp_tier_range"><?php esc_html_e('Tier Range Pricing', 'wtp'); ?></label>
					<div class="wtp-tooltip"> ?
						<span class="wtp-tooltiptext"><?php esc_html_e( 'Tier Range Pricing applies discounts.', 'wtp' ); ?></span>
					</div>
					&nbsp;&nbsp;
					<input class="wtp-tier-type" id="wtp_tier_fix" type="radio" name="wtp_tier_type" value="tier_fix" <?php checked($tier_type, 'tier_fix', true); ?>>
					<label for="wtp_tier_fix"><?php esc_html_e('Tier Fixed Pricing', 'wtp'); ?></label>
					<div class="wtp-tooltip"> ?
						<span class="wtp-tooltiptext"><?php esc_html_e( 'Tier Fixed Pricing replaces the original value.', 'wtp' ); ?></span>
					</div>
				</td>
			</tr>
		</tbody>
	</table>

	<?php 
	// Display Range Tier Type
	if ( 'tier_range' == $tier_type ) { 
		$style = 'display:block';
	} else {
		$style = 'display:none';
	} 
	if ( ! empty( $wtp_tier_clone ) && count( $wtp_tier_clone ) > 1 ) { 
		?>
		
		<div class="tier-range-main" style="<?php esc_attr_e( $style ); ?>"> 
			<div class="tier-range-row-clone">
				<?php require_once WTP_ROOT_PATH . 'includes/Template/metabox/range-rule/repeater-range-rule.php' ; ?>
			</div>
		</div>
		<?php
	
	} else { 
		?>
		
		<div class="tier-range-main" style="<?php esc_attr_e( $style ); ?>">
			<div class="tier-range-row-clone">
				<?php require_once WTP_ROOT_PATH . 'includes/Template/metabox/range-rule/initial-range-rule.php' ; ?>
			</div>
		</div> 
		<?php

	}
	// end range type
	
	// Display FIxed Tier Type 
	if ( 'tier_fix' == $tier_type ) { 
		$fix_style = 'display:flex';
	} else {
		$fix_style = 'display:none';
	} 
	
	// Display Fixed/Qty Fields based on the select
	if ( 'tier_fix_rule' == $tier_fix_select ) {
		$fixed_rule = 'display:inline-block';
		$qty_rule = 'display:none';
	} else {
		$fixed_rule = 'display:none';
		$qty_rule = 'display:inline-block';
	}
	?>
	<div class="tier-main" style="<?php esc_attr_e( $fix_style ); ?>">
		<div class="tier-fix-row-select">
			<div class="tier-form-group">
				<select name="wtp_rule_fix_select" id="wtp-rule-select">
					<option value="tier_fix_rule" <?php selected( true, 'tier_fix_rule' == $tier_fix_select, true ); ?>>Fixed Discount</option>
					<option value="tier_qty_rule" <?php selected( true, 'tier_qty_rule' == $tier_fix_select, true ); ?>>Quantity Discount</option>
				</select>
			</div>
		</div> 
		<?php
		// Display Fixed Fields
		if ( ! empty( $wtp_tier_fix_clone ) && count( $wtp_tier_fix_clone ) ) { 
			?>
			<div class="tier-fix-row-clone" style="<?php esc_attr_e( $fixed_rule ); ?>">
				<?php require_once WTP_ROOT_PATH . 'includes/Template/metabox/fix-rule/repeater-fix-rule.php' ; ?>
			</div> 
			<?php
		} else { 
			?>
			<div class="tier-fix-row-clone" style="<?php esc_attr_e( $fixed_rule ); ?>">
				<?php require_once WTP_ROOT_PATH . 'includes/Template/metabox/fix-rule/initial-fix-rule.php' ; ?>
			</div> 
			<?php
		}

		// Display Qty Fields
		if ( ! empty( $wtp_tier_qty_clone ) && count( $wtp_tier_qty_clone ) ) { 
			?>
			<div class="tier-qty-row-clone" style="<?php esc_attr_e( $qty_rule ); ?>"> 
				<?php require_once WTP_ROOT_PATH . 'includes/Template/metabox/fix-rule/repeater-qty-rule.php' ; ?>
			</div> 
			<?php 
		} else { 
			?>
			<div class="tier-qty-row-clone" style="<?php esc_attr_e( $qty_rule ); ?>"> 
				<?php require_once WTP_ROOT_PATH . 'includes/Template/metabox/fix-rule/initial-qty-rule.php' ; ?>
			</div> 
			<?php 
		} 
		?>

	</div>
	<!-- end Fixed Tier type -->
</div>
