<?php
if (!defined('ABSPATH')){
    exit;
}

// Default values and save settings
add_action('init','fbtpfw_comman_file');
function fbtpfw_comman_file(){
    global $fbtpfw_comman;
    
    $optionget = array(
        'single_pro_positions' => 'before_adtcart',
        'single_pro_positionsl2' => 'after_summary',
        'default_products' => 'none',
        'cart_change_qty' => 'yes',
        'check_default_pro' => 'yes',
        'add_to_cart_text' => 'Add to Cart',
        'price_for_all_text' => 'Price for all',
        'addtional_amount_text' => 'Additional Amount',
        'this_item_text' => 'This Item',
        'fbtpfw_product_color' => '#000000',
        'price_all_text_color' => '#000000',
        'addtional_amount_text_color' => '#000000',
        'add_cart_back_color' => '#000000',
        'add_cart_text_color' => '#ffffff',
        'discount_badge_text_color' => '#ffffff',
        'discount_badge_back_color' => '#ff0000',
        'regular_price_color' => '#000000',


    );

    foreach ($optionget as $key_optionget => $value_optionget) {
       $fbtpfw_comman[$key_optionget] = get_option( $key_optionget,$value_optionget );
    }
}