<?php

/**
 * Iconic WDS - Add Pickup instructions above the delivery slots fields.
 */
add_filter( 'iconic_wds_after_delivery_details_title', function( $title ) {
	// Todo1 - Add URL of the Pickup Instructions Page.
	?>
	<a href="/local-pickup-instructions/" target="_blank" id="wds-pickup-instructions" style="margin-top: -25px;
    padding-bottom: 35px;
    display: block;">Click here to read the Pickup instructions.</a>
	<?php
} );

add_action( 'wp_footer', 'wds_add_custom_js_to_toggle_pickup_instructions' );

/**
 * Add custom JS to toggle pickup instructions.
 *
 * @return void
 */
function wds_add_custom_js_to_toggle_pickup_instructions() {
	?>
	<script>
		function iconic_wds_toggle_pickup_instructions() {
			// get selected shipping method
			var selectedShippingMethod = jQuery( 'input[name="shipping_method[0]"]:checked' ).val();
			// if local pickup is selected the show the pickup instructions else hide
			if ( selectedShippingMethod.includes( 'local_pickup' ) ) {
				jQuery( '#wds-pickup-instructions' ).show();
			} else {
				jQuery( '#wds-pickup-instructions' ).show();
			}
		}

		// run iconic_wds_toggle_pickup_instructions on page load and checkout updated event
		jQuery( document ).ready( iconic_wds_toggle_pickup_instructions );
		jQuery( document ).on( 'updated_checkout', iconic_wds_toggle_pickup_instructions );
	</script>
	<?php
}

?>