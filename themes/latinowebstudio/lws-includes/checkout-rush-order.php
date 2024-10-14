<?php

add_action( 'woocommerce_review_order_before_submit', 'custom_add_rush_order_checkbox' );
function custom_add_rush_order_checkbox() {
    echo '<div id="rush_order_checkbox"><h3>Rush Order?</h3>';
    woocommerce_form_field( 'rush_order', array(
        'type' => 'checkbox',
        'class' => array('form-row rush-order-checkbox'),
        'label' => __('Add $20 for rush order'),
        ), false );
    echo '</div>';
}

add_action( 'woocommerce_cart_calculate_fees', 'custom_add_rush_order_fee' );
function custom_add_rush_order_fee() {
    if ( isset( $_POST['rush_order'] ) && $_POST['rush_order'] ) {
        WC()->cart->add_fee( 'Rush Order', 20 );
    }
}

// Shortcode to display the Rush Order checkbox
// function rush_order_checkbox_shortcode() {
//     ob_start();
//    
//     <div class="custom-fee-checkbox">
//         <input type="checkbox" id="rush_order" name="rush_order" /> 
//         <label for="rush_order">Rush Order? Add $20</label>
//     </div>
//     
//     return ob_get_clean();
// }
// add_shortcode('rush_order_checkbox', 'rush_order_checkbox_shortcode');


// function apply_rush_order_fee() {
//     if ( isset( $_POST['rush_order'] ) && $_POST['rush_order'] == 'on' ) {
//         WC()->cart->add_fee( 'Rush Order', 20 );
//     }
// }
// add_action( 'woocommerce_cart_calculate_fees', 'apply_rush_order_fee' );


// function custom_checkout_block_assets() {
//     if( is_checkout() ) {
//         wp_enqueue_script( 
//             'custom-checkout-fee-js', 
//             get_template_directory_uri() . '/js/custom-checkout-fee.js', 
//             array( 'wp-blocks', 'wp-element', 'wp-editor', 'jquery' ), 
//             '', 
//             true 
//         );
//     }
// }
// add_action( 'enqueue_block_assets', 'custom_checkout_block_assets' );

// function add_custom_fee_based_on_checkbox() {
//     if ( isset( $_POST['post_data'] ) ) {
//         parse_str( $_POST['post_data'], $post_data );
//         if ( isset( $post_data['rush_order'] ) && $post_data['rush_order'] === 'on' ) {
//             WC()->cart->add_fee( 'Rush Order', 20 );
//         }
//     }
// }
// add_action( 'woocommerce_cart_calculate_fees', 'add_custom_fee_based_on_checkbox' );
