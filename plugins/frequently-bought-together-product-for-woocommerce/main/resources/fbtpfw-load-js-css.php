<?php

/* admin style and script */
function FBTPFW_load_admin_script_style() {
    wp_enqueue_style('FBTPFW-back-style', FBTPFW_PLUGIN_DIR . '/includes/css/back-style.css', false, '1.0.0' );
    wp_enqueue_style('wp-color-picker' );
    wp_enqueue_script('wp-color-picker-alpha', FBTPFW_PLUGIN_DIR . '/includes/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0.0', true );
    $color_picker_strings = array(
        'clear'            => __( 'Clear', 'textdomain' ),
        'clearAriaLabel'   => __( 'Clear color', 'textdomain' ),
        'defaultString'    => __( 'Default', 'textdomain' ),
        'defaultAriaLabel' => __( 'Select default color', 'textdomain' ),
        'pick'             => __( 'Select Color', 'textdomain' ),
        'defaultLabel'     => __( 'Color value', 'textdomain' ),
    );
    wp_localize_script( 'wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );
    wp_enqueue_script( 'wp-color-picker-alpha' );
    $ocscreen = get_current_screen();
    if($ocscreen->id == 'product') {
      wp_enqueue_script('FBTPFW-back-script', FBTPFW_PLUGIN_DIR .'/includes/js/backend-script.js', array( 'jquery', 'select2'));
      wp_localize_script( 'ajaxloadpost', 'ajax_postajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }
}
add_action( 'admin_enqueue_scripts',  'FBTPFW_load_admin_script_style');

function FBTPFW_load_script_style() {
    wp_enqueue_script('jquery', false, array(), false, false);
    wp_enqueue_style( 'FBTPFW-front-style', FBTPFW_PLUGIN_DIR . '/includes/css/front-style.css', false, '1.0.0' );
    wp_enqueue_script( 'FBTPFW-front-script', FBTPFW_PLUGIN_DIR . '/includes/js/front-script.js', false, '1.0.0' );
    wp_localize_script( 'FBTPFW-front-script', 'fbtpfw_OBJECT', array( 
        'add_to_cart_text' => get_option('add_to_cart_text','Add to Cart'),
        'ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action( 'wp_enqueue_scripts', 'FBTPFW_load_script_style');