<?php
/**
 * Meta box for Checkout elements.
 *
 * @package Flux_Checkout
 */
?>

<div class="flux-ce" data-settings="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>" data-categories="<?php echo esc_attr( wp_json_encode( $product_categories ) ); ?>">
	<div class="flux-ce-row flux-ce-row--position">
		<div class="flux-ce-row__label">
			<label for="fce_position">
				<strong><?php esc_html_e( 'Position', 'flux-checkout' ); ?></strong>
			</label>
			<p class='flux-cse-desc'><?php esc_html_e( 'Specify the position on the checkout page where this element will be placed.', 'flux-checkout' ); ?></p>
		</div>
		<div class="flux-ce-row__content">
			<?php include ICONIC_FLUX_PATH . 'templates/admin/checkout-elements/position-field.php'; ?>
		</div>
	</div>

	<div class="flux-ce-row">
		<div class="flux-ce-row__label">
			<label for="fce_enable_conditions">
				<strong><?php esc_html_e( 'Enable Conditional Display', 'flux-checkout' ); ?></strong>
			</label>
			<p class='flux-cse-desc'><?php echo wp_kses( __( 'Conditionally show/hide this element. Element always shows if left unchecked.', 'flux-checkout' ), Iconic_Flux_Helpers::get_kses_allowed_tags() ); ?></p>
		</div>
		<div class="flux-ce-row__content">
			<label class="flux-ce-checkbox">
				<input type="checkbox" name='fce_enable_conditions' v-model="enable_rules">
				<span class="flux-ce-checkbox__slider"></span>
			</label>
			<span class='flux-ce-checkbox__slider-text' v-if="enable_rules"><?php esc_html_e( 'Enabled', 'flux-checkout' ); ?></span>
			<span class='flux-ce-checkbox__slider-text' v-else><?php esc_html_e( 'Disabled', 'flux-checkout' ); ?></span>
		</div>
	</div>

	<div class="flux-ce-row" v-show="enable_rules">
		<div class="flux-ce-row__label">
			<label for="fce_enable_conditions">
				<strong><?php esc_html_e( 'All rules must match', 'flux-checkout' ); ?></strong>
			</label>
			<p class='flux-cse-desc'><?php esc_html_e( 'Only apply this condition if all rules match. If left unchecked, the condition will apply when any of the rules match.', 'flux-checkout' ); ?></p>
		</div>
		<div class="flux-ce-row__content">
			<label class="flux-ce-checkbox">
				<input type="checkbox" name='fce_enable_all_rules_must_match' v-model="all_rules_must_match">
				<span class="flux-ce-checkbox__slider"></span>
			</label>
			<span class='flux-ce-checkbox__slider-text' v-if="all_rules_must_match"><?php esc_html_e( 'Yes', 'flux-checkout' ); ?></span>
			<span class='flux-ce-checkbox__slider-text' v-else><?php esc_html_e( 'No', 'flux-checkout' ); ?></span>
		</div>
	</div>

	<div class="flux-ce-row" v-show="enable_rules">
		<div class="flux-ce-row__label">
			<label for="fce_enable_conditions">
				<strong><?php esc_html_e( 'Conditional Display Rules', 'flux-checkout' ); ?></strong>
			</label>
			<p class='flux-cse-desc'><?php esc_html_e( 'Add a set of rules to determine when this Element should show or hide.', 'flux-checkout' ); ?></p>
		</div>
		<div class="flux-ce-row__content">
			<div class="flux-ce-section">
				<select name="flux-ce-rule-condition" id="flux-ce-rule-condition" v-model="rule_condition">
					<option value="show"><?php esc_html_e( 'Show', 'flux-checkout' ); ?></option>
					<option value="hide"><?php esc_html_e( 'Hide', 'flux-checkout' ); ?></option>
				</select> <span class='flux-cs-show-hide-text'><?php esc_html_e( 'this Checkout Element when the following rules match', 'flux-checkout' ); ?></span>
			</div>


			<div class="flux-ce-section">
				<div class="flux-ce-rules" :class="{ 'flux-ce-rules--and': all_rules_must_match }">
					<div class="flux-ce-rule" v-for="rule in rules">
						<div class="flux-ce-rule__col flux-ce-rule__col--object">
							<select v-model="rule.object" class="flux-ce-input" @change="objectChanged(rule)">
								<option value="user_role"><?php esc_html_e( 'User Role', 'flux-checkout' ); ?></option>
								<option value="product"><?php esc_html_e( 'Product', 'flux-checkout' ); ?></option>
								<option value="product_cat"><?php esc_html_e( 'Product Category', 'flux-checkout' ); ?></option>
								<option value="cart_total"><?php esc_html_e( 'Cart total', 'flux-checkout' ); ?></option>
							</select>
						</div>
						<div class="flux-ce-rule__col flux-ce-rule__col--condition">
							<select v-model="rule.condition" class="flux-ce-input flux-ce-input--condition">
								<template v-if='["product", "product_cat"].includes(rule.object)'>
									<option value="is"><?php esc_html_e( 'is in cart', 'flux-checkout' ); ?></option>
									<option value="is_not"><?php esc_html_e( 'is not in cart', 'flux-checkout' ); ?></option>
								</template>
								<template v-if='["user_role"].includes(rule.object)'>
									<option value="is"><?php esc_html_e( 'is', 'flux-checkout' ); ?></option>
									<option value="is_not"><?php esc_html_e( 'is not', 'flux-checkout' ); ?></option>
								</template>
								<option v-if='["cart_total"].includes(rule.object)' value="<"><?php esc_html_e( 'is less than', 'flux-checkout' ); ?></option>
								<option v-if='["cart_total"].includes(rule.object)' value="<="><?php esc_html_e( 'is less than or equal to', 'flux-checkout' ); ?></option>
								<option v-if='["cart_total"].includes(rule.object)' value=">"><?php esc_html_e( 'is more than', 'flux-checkout' ); ?></option>
								<option v-if='["cart_total"].includes(rule.object)' value=">="><?php esc_html_e( 'is more than or equal to', 'flux-checkout' ); ?></option>
							</select>
						</div>

						<div class="flux-ce-rule__col flux-ce-rule__col--value">
							<v-select v-if="'product' === rule.object" placeholder="Search products" :multiple='true' @search="fetchProducts" :options="productOptions" :filterable="false" v-model="rule.value">
								<template slot="no-options">
									<?php esc_html_e( 'Type to search...', 'flux-checkout' ); ?>
								</template>
							</v-select>

							<v-select v-if="'product_cat' === rule.object" placeholder="Search categories" :multiple='true' :options="categoryOptions" v-model="rule.value">
								<template slot="no-options">
									<?php esc_html_e( 'Type to search...', 'flux-checkout' ); ?>
								</template>
							</v-select>

							<input v-if="'cart_total' === rule.object" type="number" v-model="rule.value" class="flux-ce-input flux-ce-input--value" placeholder="<?php esc_html_e( 'Cart total', 'flux-checkout' ); ?>" v-model="rule.value">
							<select v-if="'user_role' === rule.object" v-model="rule.value" class="flux-ce-input flux-ce-input--value">
								<?php
								foreach ( get_editable_roles() as $role_id => $_role ) {
									echo sprintf( '<option value="%s">%s</option>', esc_attr( $role_id ), esc_html( $_role['name'] ) );
								}
								?>
								<option value="guest"><?php esc_html_e( 'Guest', 'flux-checkout' ); ?></option>
							</select>

						</div>
						<div class="flux-ce-rule__col flux-ce-rule__col--delete">
							<button class="flux-ce-delete-btn dashicons dashicons-trash" @click="deleteRule(rule)"></button>
						</div>
					</div>
				</div>
				<div :class="{'flux-ce-add-btn__wrap': true, 'flux-ce-add-btn__wrap--empty': 0 === rules.length }" >
					<template v-if="!rules.length">
						<p class='flux-ce-add-btn__wrap_p1'><?php esc_html_e( 'No rules applied.', 'flux-checkout' ); ?></p>
						<p class='flux-ce-add-btn__wrap_p2' v-if="'show' === rule_condition"><?php esc_html_e( 'This Element will appear unconditionally without rules.', 'flux-checkout' ); ?></p>
						<p class='flux-ce-add-btn__wrap_p2' v-else><?php esc_html_e( 'This Element will hide unconditionally without rules.', 'flux-checkout' ); ?></p>
					</template>

					<button :class="{'button': true, 'button-primary': !rules.length}" @click.prevent="addRule">
						<template v-if="rules.length">
							<?php esc_html_e( 'Add Rule', 'flux-checkout' ); ?>
						</template>
						<template v-else>
							<?php esc_html_e( 'Add Your First Rule', 'flux-checkout' ); ?>
						</template>
					</button>
				</div>
			</div>
		</div>
	</div>

	<?php
	wp_nonce_field( 'fce_metabox_nonce', 'fce_metabox_nonce' );
	?>

	<input type="hidden" name='fce_settings' :value="settings">
</div>
