<?php
add_action( 'admin_menu',  'fbtpfw_submenu_page');
function fbtpfw_submenu_page() {
    add_menu_page('Frequently Bought Together Setting', 'Frequently Bought Together', 'manage_options', 'fbtpfw_custom', 'fbtpfw_callback');
}

function fbtpfw_callback(){
    global $fbtpfw_comman;
    ?>
    <div class="fbtpfw_main_class">
        
        <form method="post">
            <?php wp_nonce_field( 'fbtpfw_meta_save', 'fbtpfw_meta_save_nounce' ); ?>
             <?php if(isset($_REQUEST['message'])  && $_REQUEST['message'] == 'success'){ ?>
            <div class="notice notice-success is-dismissible"> 
                <p><strong><?php echo __( 'Record updated successfully.', 'frequently-bought-together-product-for-woocommmerce' );?></strong></p>
            </div>
            <?php } ?>
            <div id="poststuff">
                <div class="card fbtpfw_notice">
                    <h2><?php echo __('Please help us spread the word & keep the plugin up-to-date', 'frequently-bought-together-product-for-woocommmerce');?></h2>
                    <p>
                        <a class="button-primary button" title="<?php echo __('Support Frequently Bought Together Product', 'frequently-bought-together-product-for-woocommmerce');?>" target="_blank" href="https://www.plugin999.com/support/"><?php echo __('Support', 'frequently-bought-together-product-for-woocommmerce'); ?></a>
                        <a class="button-primary button" title="<?php echo __('Rate Frequently Bought Together Product', 'frequently-bought-together-product-for-woocommmerce');?>" target="_blank" href="https://wordpress.org/support/plugin/frequently-bought-together-product-for-woocommerce/reviews/?filter=5"><?php echo __('Rate the plugin ★★★★★', 'frequently-bought-together-product-for-woocommmerce'); ?></a>
                    </p>
                </div>
                <div class="postbox">
                    <div class="postbox-header">
                        <h2><?php echo __('General Setting','frequently-bought-together-product-for-woocommmerce');?></h2>
                    </div>
                    <div class="inside">
                        <table class="data_table">
                             <tbody>
                                <tr>
                                    <th>
                                        <label><?php echo __('Positions for layout 1','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $single_pro_positions_l1 = $fbtpfw_comman['single_pro_positions']; ?>
                                        <select name="fbtpfw_comman[single_pro_positions]" class="regular-text">
                                            <option value="before_adtcart" <?php if($single_pro_positions_l1 == 'before_adtcart'){echo "selected";}?>><?php echo __('Before add to cart','frequently-bought-together-product-for-woocommmerce');?></option>
                                            <option value="after_adtcart" <?php if($single_pro_positions_l1 == 'after_adtcart'){echo "selected";}?>><?php echo __('After add to cart','frequently-bought-together-product-for-woocommmerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Positions for layout 2','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $single_pro_positionsl2 = $fbtpfw_comman['single_pro_positionsl2']; ?>
                                        <select name="fbtpfw_comman[single_pro_positionsl2]" class="regular-text">
                                            <option value="before_title" <?php if($single_pro_positionsl2 == 'before_title'){echo "selected";}?>><?php echo __('Before Title','frequently-bought-together-product-for-woocommmerce');?></option>
                                            <option value="before_atc" <?php if($single_pro_positionsl2 == 'before_atc'){echo "selected";}?>><?php echo __('Before add to cart','frequently-bought-together-product-for-woocommmerce');?></option>
                                            <option value="after_atc" <?php if($single_pro_positionsl2 == 'after_atc'){echo "selected";}?>><?php echo __('After add to cart','frequently-bought-together-product-for-woocommmerce');?></option>
                                            <option value="after_summary" <?php if($single_pro_positionsl2 == 'after_summary'){echo "selected";}?>><?php echo __('After Summary','frequently-bought-together-product-for-woocommmerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Default Products','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $default_products = $fbtpfw_comman['default_products']; ?>
                                        <select name="fbtpfw_comman[default_products]" class="regular-text">
                                            <option value="none" <?php if($default_products == 'none'){echo "selected";}?>><?php echo __('None','frequently-bought-together-product-for-woocommmerce');?></option>
                                            <option value="upsells" <?php if($default_products == 'upsells'){echo "selected";}?>><?php echo __('Upsells products','frequently-bought-together-product-for-woocommmerce');?></option>
                                            <option value="related" <?php if($default_products == 'related'){echo "selected";}?>><?php echo __('Related products','frequently-bought-together-product-for-woocommmerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Change quantity in cart page','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $cart_change_qty = $fbtpfw_comman['cart_change_qty']; ?>
                                        <select name="fbtpfw_comman[cart_change_qty]" class="regular-text">
                                            <option value="yes" <?php if($cart_change_qty == 'yes'){echo "selected";}?>><?php echo __('Yes','frequently-bought-together-product-for-woocommmerce');?></option>
                                            <option value="no" <?php if($cart_change_qty == 'no'){echo "selected";}?>><?php echo __('No','frequently-bought-together-product-for-woocommmerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Check products default','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $check_default_pro = $fbtpfw_comman['check_default_pro']; ?>
                                        <select name="fbtpfw_comman[check_default_pro]" class="regular-text">
                                            <option value="yes" <?php if($check_default_pro == 'yes'){echo "selected";}?>><?php echo __('Yes','frequently-bought-together-product-for-woocommmerce');?></option>
                                            <option value="no" <?php if($check_default_pro == 'no'){echo "selected";}?>><?php echo __('No','frequently-bought-together-product-for-woocommmerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Add to Cart Button Text','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $add_to_cart_text = $fbtpfw_comman['add_to_cart_text']; ?>
                                        <input type="text" class="ocwg_elimsg regular-text" name="fbtpfw_comman[add_to_cart_text]" value="<?php echo esc_attr($add_to_cart_text); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Total amount Text translate','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                         <?php $price_for_all_text = $fbtpfw_comman['price_for_all_text']; ?>
                                        <input type="text" class="ocwg_elimsg regular-text" name="fbtpfw_comman[price_for_all_text]" value="<?php echo esc_attr($price_for_all_text); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Additional Amount Text translate','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $addtional_amount_text = $fbtpfw_comman['addtional_amount_text']; ?>
                                        <input type="text" class="ocwg_elimsg regular-text" name="fbtpfw_comman[addtional_amount_text]" value="<?php echo esc_attr($addtional_amount_text); ?>">
                                    </td>
                                </tr>
                                 <tr>
                                    <th>
                                        <label><?php echo __('This Item Text translate','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                         <?php $this_item_text = $fbtpfw_comman['this_item_text']; ?>
                                        <input type="text" class="ocwg_elimsg regular-text" name="fbtpfw_comman[this_item_text]" value="<?php echo esc_attr($this_item_text); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Frequently Bought Together Heading color','frequently-bought-together-product-for-woocommmerce'); ?></label>
                                    </th>
                                    <td>
                                        <?php $fbtpfw_product_color = $fbtpfw_comman['fbtpfw_product_color']; 
                                            /*if(!empty($fbtpfw_comman['fbtpfw_product_color'])){
                                                $fbtpfw_product_color = '#000000';
                                            }else{
                                                $fbtpfw_product_color = '';
                                            }*/
                                        ?>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#000000" name="fbtpfw_comman[fbtpfw_product_color]" value="<?php echo esc_attr($fbtpfw_product_color); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Price for all Text color','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $price_all_text_color = $fbtpfw_comman['price_all_text_color'];  
                                            /*if(!empty($fbtpfw_comman['price_all_text_color'])){
                                                $price_all_text_color = '#000000';
                                            }else{
                                                $price_all_text_color = '';
                                            }*/
                                        ?>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#000000" name="fbtpfw_comman[price_all_text_color]" value="<?php echo esc_attr($price_all_text_color); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Additional Amount text Color','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $addtional_amount_text_color = $fbtpfw_comman['addtional_amount_text_color'];   
                                            /*if(!empty($fbtpfw_comman['addtional_amount_text_color'])){
                                                $addtional_amount_text_color = '#000000';
                                            }else{
                                                $addtional_amount_text_color = '';
                                            }*/
                                        ?>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#000000" name="fbtpfw_comman[addtional_amount_text_color]" value="<?php echo esc_attr($addtional_amount_text_color); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Add to cart background color','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $add_cart_back_color = $fbtpfw_comman['add_cart_back_color']; 
                                            /*if(!empty($fbtpfw_comman['add_cart_back_color'])){
                                                $add_cart_back_color = '#000000';
                                            }else{
                                                $add_cart_back_color = '';
                                            }*/
                                        ?>
                                        <?php $add_cart_back_color = $fbtpfw_comman['add_cart_back_color']; ?>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#000000" name="fbtpfw_comman[add_cart_back_color]" value="<?php echo esc_attr($add_cart_back_color); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Add to cart text color','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $add_cart_text_color = $fbtpfw_comman['add_cart_text_color']; 
                                            /*if(!empty($fbtpfw_comman['add_cart_text_color'])){
                                                $add_cart_text_color = '#ffffff';
                                            }else{
                                                $add_cart_text_color = '';
                                            }*/
                                        ?>
                                        <?php $add_cart_text_color = $fbtpfw_comman['add_cart_text_color']; ?>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#ffffff" name="fbtpfw_comman[add_cart_text_color]" value="<?php echo esc_attr($add_cart_text_color); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Discount Badge text color','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $discount_badge_text_color = $fbtpfw_comman['discount_badge_text_color'];
                                        /*if(!empty($fbtpfw_comman['discount_badge_text_color'])){
                                                $discount_badge_text_color = '#ffffff';
                                            }else{
                                                $discount_badge_text_color = '';
                                            }*/
                                        ?>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#ffffff" name="fbtpfw_comman[discount_badge_text_color]" value="<?php echo esc_attr($discount_badge_text_color); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Discount Badge Background color','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $discount_badge_back_color = $fbtpfw_comman['discount_badge_back_color'];
                                        /*if(!empty($fbtpfw_comman['discount_badge_back_color'])){
                                                $discount_badge_back_color = '#ff0000';
                                            }else{
                                                $discount_badge_back_color = '';
                                            }*/
                                        ?>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#ff0000" name="fbtpfw_comman[discount_badge_back_color]" value="<?php echo esc_attr($discount_badge_back_color); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label><?php echo __('Regular Price color','frequently-bought-together-product-for-woocommmerce');?></label>
                                    </th>
                                    <td>
                                        <?php $regular_price_color = $fbtpfw_comman['regular_price_color'];
                                        /*if(!empty($fbtpfw_comman['regular_price_color'])){
                                                $regular_price_color = '#000000';
                                            }else{
                                                $regular_price_color = '';
                                            }*/
                                        ?>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#000000" name="fbtpfw_comman[regular_price_color]" value="<?php echo esc_attr($regular_price_color); ?>"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                    <input type="hidden" name="action" value="fbtpfw_save_option">
                    <input type="submit" value="Save changes" name="submit" class="button-primary" id="ocwg_btn_space">
            </div>
        </form>
    </div>
    <?php      
}

add_action( 'init',   'fbtpfw_save_options');
function fbtpfw_save_options(){
     global $fbtpfw_comman;
    if( current_user_can('administrator') ) {

        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'fbtpfw_save_option') {
            if(!isset( $_POST['fbtpfw_meta_save_nounce'] ) || !wp_verify_nonce( $_POST['fbtpfw_meta_save_nounce'], 'fbtpfw_meta_save' ) ) {

                print 'Sorry, your nonce did not verify.';
                exit;

            } else {

               
                    foreach ($_REQUEST['fbtpfw_comman'] as $key_fbtpfw_comman => $value_fbtpfw_comman) {
                      update_option($key_fbtpfw_comman, sanitize_text_field($value_fbtpfw_comman), 'yes');
                    }   

                    wp_redirect( admin_url( '/admin.php?page=fbtpfw_custom' ) );
                    exit;
                   // }

                // $default_products = sanitize_text_field( $_REQUEST['default_products'] );
                // update_option('default_products', $default_products, 'yes');

                // $cart_change_qty = sanitize_text_field( $_REQUEST['cart_change_qty'] );
                // update_option('cart_change_qty', $cart_change_qty, 'yes');

                // $check_default_pro = sanitize_text_field( $_REQUEST['check_default_pro'] );
                // update_option('check_default_pro', $check_default_pro, 'yes');
                
                // $single_pro_positions = sanitize_text_field( $_REQUEST['single_pro_positions'] );
                // update_option('single_pro_positions', $single_pro_positions, 'yes');

                // $single_pro_positionsl2 = sanitize_text_field( $_REQUEST['single_pro_positionsl2'] );
                // update_option('single_pro_positionsl2', $single_pro_positionsl2, 'yes');

                // $add_to_cart_text = sanitize_text_field( $_REQUEST['add_to_cart_text'] );
                // update_option('add_to_cart_text', $add_to_cart_text, 'yes');

                // $price_for_all_text = sanitize_text_field( $_REQUEST['price_for_all_text'] );
                // update_option('price_for_all_text', $price_for_all_text, 'yes');

                // $addtional_amount_text = sanitize_text_field( $_REQUEST['addtional_amount_text'] );
                // update_option('addtional_amount_text', $addtional_amount_text, 'yes');

                // $this_item_text = sanitize_text_field( $_REQUEST['this_item_text'] );
                // update_option('this_item_text', $this_item_text, 'yes');

                // $fbtpfw_product_color = sanitize_text_field( $_REQUEST['fbtpfw_product_color'] );
                // update_option('fbtpfw_product_color', $fbtpfw_product_color, 'yes');

                // $addtional_amount_text_color = sanitize_text_field( $_REQUEST['addtional_amount_text_color'] );
                // update_option('addtional_amount_text_color', $addtional_amount_text_color, 'yes');

                // $add_cart_back_color = sanitize_text_field( $_REQUEST['add_cart_back_color'] );
                // update_option('add_cart_back_color', $add_cart_back_color, 'yes');

                // $add_cart_text_color = sanitize_text_field( $_REQUEST['add_cart_text_color'] );
                // update_option('add_cart_text_color', $add_cart_text_color, 'yes');

                // $price_all_text_color = sanitize_text_field( $_REQUEST['price_all_text_color'] );
                // update_option('price_all_text_color', $price_all_text_color, 'yes');

                // $discount_badge_back_color = sanitize_text_field( $_REQUEST['discount_badge_back_color'] );
                // update_option('discount_badge_back_color', $discount_badge_back_color, 'yes');

                // $discount_badge_text_color = sanitize_text_field( $_REQUEST['discount_badge_text_color'] );
                // update_option('discount_badge_text_color', $discount_badge_text_color, 'yes');

                // $regular_price_color = sanitize_text_field( $_REQUEST['regular_price_color'] );
                // update_option('regular_price_color', $regular_price_color, 'yes');
                
            }
        }
    }
}

add_action( 'plugins_loaded', 'fbtpfw_free_install', 11 );
function fbtpfw_free_install() {
    if ( ! function_exists( 'WC' ) ) {
      add_action( 'admin_notices', 'fbtpfw_install_error' );
    }
}


function fbtpfw_install_error() {
    ?>
        <div class="error">
            <p>
                <?php _e( 'Woo Frequently Bought Together is enabled but not effective. It requires WooCommerce.', 'frequently-bought-together-product-for-woocommmerce' ); ?>
            </p>
        </div>
    <?php
}

add_filter( 'woocommerce_product_data_tabs', 'fbtpfw_custom_product_tabs' );
function fbtpfw_custom_product_tabs( $tabs ) {
    $tabs['combo_product'] = array(
        'label'     => __( 'Frequently Added', 'woocommerce' ),
        'target'    => 'fbtpfw_options',
        'class'     => array( 'show_if_simple', 'show_if_variable', 'show_if_grouped', 'show_if_external' ),
    );
    return $tabs;
}


add_action( 'woocommerce_product_data_panels',  'fbtpfw_custom_product_tabs_fields' );
function fbtpfw_custom_product_tabs_fields() {
    ?> 
    <div id="fbtpfw_options" class="panel woocommerce_options_panel">
        <div class = 'options_group' >
            <p class='form-field'>
                <?php 
                    global $post, $product_object;
                    $product_id = $post->ID;
                    is_null( $product_object ) && $product_object = wc_get_product( $product_id );
                    $to_exclude = array( $product_id );
                ?>
                <label><?php _e( 'Add Product', 'woocommerce' ); ?></label>
                <select id="occp_select_serach_box" name="occp_select2[]" multiple="multiple" style="width:70%;max-width:25em;" except="<?php echo $to_exclude[0]; ?>">
                    <?php 

                        $product = get_post_meta( get_the_ID(), 'occp_select2', true );
                        
                        $occp_selected_product_array = array();
                        $occp_selected_product_ids = array();

                        if (is_array($product) || is_object($product)){
                        foreach ($product as $productId) {
                            $product = wc_get_product( $productId );
                            
                            $occp_add_current_product_title = $product->get_title();
                            $occp_add_current_product_id = $product->get_id();
                            $occp_add_current_product_price = $product->get_price();
                            $occp_add_current_product_is_variation   = $product->is_type( 'variation' ); 
                            $occp_add_current_product_real_title = $occp_add_current_product_title;

                                if( $occp_add_current_product_is_variation ) {
                                    $attributes = $product->get_variation_attributes();
                                    $variations = array();

                                    foreach( $attributes as $key => $attribute ) {
                                        $variations[] = $attribute;
                                    }

                                    if( ! empty( $variations ) )
                                    $occp_add_current_product_real_title .= ' - ' . implode( ', ', $variations );
                                }

                            $occp_add_current_product_discunt = get_post_meta( get_the_ID(), 'occp_off_per', true );
                            $occp_add_current_product_discunt_type = get_post_meta( get_the_ID(), 'occp_discount_type', true );


                            $occp_selected_product_ids[] = $occp_add_current_product_id;
                            $occp_selected_product_array[] = array(
                                'id'=>$occp_add_current_product_id,
                                'text'=>$occp_add_current_product_real_title,
                                'price'=>wc_price($occp_add_current_product_price),
                                'discount'=>$occp_add_current_product_discunt[$occp_add_current_product_id],
                                'discount_type'=>$occp_add_current_product_discunt_type[$occp_add_current_product_id]
                            );
                            
                        }
                        }

                    ?>
                </select>
                <Script>
                   var occp_selected_product_array = <?php echo json_encode($occp_selected_product_array);?>;
                   var occp_selected_product_ids = <?php echo json_encode($occp_selected_product_ids);?>;
                </Script>
            </p>
            <div class="occp_select_back">
                <label><?php _e( 'Selected', 'woocommerce' ); ?></label>
                <div class="occp_sortable">
                    <ul id="sortable"> 
                        <?php
                            $occp_drag_product = get_post_meta( get_the_ID(), 'occp_select2', true );

                            if(!empty($occp_drag_product)){
                                foreach ($occp_drag_product as $productId) {
                                    $product = wc_get_product( $productId );
                                    $occp_drag_current_product_id = $product->get_id();
                                    $occp_drag_current_product_title = $product->get_title();                        
                                    $occp_drag_current_product_is_variation = $product->is_type( 'variation' );
                                    $occp_drag_current_product_price = $product->get_price();
                                    if(empty($occp_drag_current_product_price)){
                                        $occp_drag_current_product_price = 0;
                                    }
                                    $occp_drag_current_product_discunt = get_post_meta( get_the_ID(), 'occp_off_per', true );
                                    $occp_drag_current_product_discunt_type = get_post_meta( get_the_ID(), 'occp_discount_type', true ); 

                                    ?>
                                    <li class="ui-state-default" id="<?php echo esc_attr($occp_drag_current_product_id); ?>">
                                        <span class="occp-draggble-icon"></span>
                                        <span class="product-attributes-drop"> 
                                            <?php echo esc_attr($occp_drag_current_product_title) ;                          
                                                if( $occp_drag_current_product_is_variation ) {
                                                    $attributes = $product->get_variation_attributes();
                                                    $variations = array();

                                                    foreach( $attributes as $key => $attribute ) {
                                                        $variations[] = $attribute;
                                                    }

                                                    if( ! empty( $variations ) )
                                                    echo ' &ndash; ' . esc_attr(implode( ', ', $variations )) ;
                                                }
                                            echo ' (' . wc_price($occp_drag_current_product_price) .')';
                                            ?>
                                        </span>
                                        <div class="occp_qty_box">
                                            <input type="hidden" name="occp_drag_ids[]" value="<?php echo esc_attr($occp_drag_current_product_id); ?>">
                                            <input type="number" name="occp_off_per[<?php echo $occp_drag_current_product_id ?>]" value="<?php foreach($occp_drag_current_product_discunt as $key => $val){ if($key == $occp_drag_current_product_id){ echo $val; } } ?>" max="<?php echo esc_attr($occp_drag_current_product_price); ?>">
                                            <select name="occp_discount_type[<?php echo $occp_drag_current_product_id ?>]">
                                                <option value="fixed" <?php if(!empty($occp_drag_current_product_discunt_type)){foreach($occp_drag_current_product_discunt_type as $key => $val){ if($key == $occp_drag_current_product_id && $val == "fixed"){ echo "selected"; } } }?>>
                                                    Fixed
                                                </option>
                                                <option value="percentage" <?php if(!empty($occp_drag_current_product_discunt_type)){foreach($occp_drag_current_product_discunt_type as $key => $val){ if($key == $occp_drag_current_product_id && $val == "percentage"){ echo "selected"; } } } ?>>
                                                    Percentage
                                                </option>
                                            </select>
                                        </div>
                                    </li>
                                    <?php 
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <p class='form-field'>
                <label><?php _e( 'Layout', 'woocommerce' ); ?></label>
                <input type="radio" name="rdlayout" value="layout1" <?php if(get_post_meta( get_the_ID(), 'occp_layout', true ) == "layout1"){ echo "checked"; } ?>><?php echo __('   Layout1','frequently-bought-together-product-for-woocommmerce');?>
                <input type="radio" name="rdlayout" value="layout2" <?php if(get_post_meta( get_the_ID(), 'occp_layout', true ) == "layout2" || empty(get_post_meta( get_the_ID(), 'occp_layout', true ))){ echo "checked"; } ?>><?php echo __('   Layout2','frequently-bought-together-product-for-woocommmerce');?>
                <input type="radio" name="rdlayout" value="none" <?php if(get_post_meta( get_the_ID(), 'occp_layout', true ) == "none"){ echo "checked"; } ?>><?php echo __('   None (','frequently-bought-together-product-for-woocommmerce');?><strong><?php echo __('None Stand for ','frequently-bought-together-product-for-woocommmerce');?></strong><?php echo __('not showing any layout if you want to  use custom place on product page it than you can use ','frequently-bought-together-product-for-woocommmerce');?><strong><?php echo __('[Woo_Frequently_added]','frequently-bought-together-product-for-woocommmerce');?></strong><?php echo __(' this shortcode)','frequently-bought-together-product-for-woocommmerce');?>
            </p>
            <p class='form-field width_div' style="display: none;">
                <label><?php _e( 'Block Width', 'woocommerce' ); ?></label>
                <input type="number" name="occp_block_width" value="<?php if(!empty(get_post_meta( get_the_ID(), 'occp_block_width', true ))){ echo esc_attr(get_post_meta( get_the_ID(), 'occp_block_width', true )); }  ?>">
            </p>
            <p class='form-field'>
                <label><?php _e( 'Associated Text', 'woocommerce' ); ?></label>
                <input type="text" name="occp_btassociated_txt" value="<?php if(!empty(get_post_meta( get_the_ID(), 'occp_btassociated_txt', true ))){ echo esc_attr(get_post_meta( get_the_ID(), 'occp_btassociated_txt', true )); } else { echo '(bought together %s)'; }  ?>">
                <span class="description"><?php echo __('Additional text in title for additional bought together products. Use "%s" for the main product name.','frequently-bought-together-product-for-woocommmerce');?></span>
            </p>
            <p class='form-field'>
                <label><?php _e( 'Heading Text', 'woocommerce' ); ?></label>
                <input type="text" name="occp_head_txt" value="<?php if(!empty(get_post_meta( get_the_ID(), 'occp_head_txt', true ))){ echo esc_attr(get_post_meta( get_the_ID(), 'occp_head_txt', true )); }  ?>">
            </p>
        </div>
    </div>
    <?php
}


add_action( 'wp_ajax_nopriv_occp_search_product_ajax', 'fbtpfw_search_product_ajax' );
add_action( 'wp_ajax_occp_search_product_ajax',  'fbtpfw_search_product_ajax' );
function fbtpfw_search_product_ajax(){

    $return = array();
    $fbtpfwpost_types = array( 'product','product_variation');
    $except = sanitize_text_field($_GET['except']);
 
    $search_results = new WP_Query( array( 
        's'=> sanitize_text_field($_GET['q']), // the search query
        'post_status' => 'publish',
        'post_type' => $fbtpfwpost_types,
        'posts_per_page' => -1,
        'post__not_in' => array($except),
        'post_parent__not_in' => array($except),
        'meta_query' => array(
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            )
        ));
    if( $search_results->have_posts() ) :
        while( $search_results->have_posts() ) : $search_results->the_post();   
            $productc = wc_get_product( $search_results->post->ID );
            if ( $productc && $productc->is_in_stock() && $productc->is_purchasable() ) {
                if( !$productc->is_type( 'variable' )) {
                    $title = $search_results->post->post_title;
                    $price = $productc->get_price_html();
                    $return[] = array( $search_results->post->ID, $title, $price);
                }
            }
        endwhile;
    endif;
    echo json_encode( $return );
    die;
}

// For Sanitize Text Field Or Array
function fbtpfw_recursive_sanitize_text_field( $array ) {
    foreach ( $array as $key => &$value ) {
        if ( is_array( $value ) ) {
            $value = fbtpfw_recursive_sanitize_text_field($value);
        }else{
            $value = sanitize_text_field( $value );
        }
    }
    return $array;
}
   
add_action( 'woocommerce_process_product_meta',  'fbtpfw_save_proddata_custom_fields' );
function fbtpfw_save_proddata_custom_fields( $post_id ) {
    if(isset($_REQUEST['occp_drag_ids'])) {
        $fbtpfwselect = fbtpfw_recursive_sanitize_text_field($_REQUEST['occp_drag_ids']);
        update_post_meta( $post_id, 'occp_select2', (array) $fbtpfwselect );
    }else{
        update_post_meta( $post_id, 'occp_select2','');
    }

    $fbtflayout = sanitize_text_field( $_POST['rdlayout'] );
    update_post_meta( $post_id, 'occp_layout', $fbtflayout );

    $occp_block_width = sanitize_text_field( $_POST['occp_block_width'] );
    update_post_meta( $post_id, 'occp_block_width', $occp_block_width );

    $fbtfassoc_text = sanitize_text_field( $_POST['occp_btassociated_txt'] );
    update_post_meta( $post_id, 'occp_btassociated_txt', $fbtfassoc_text );

    $fbtfhead = sanitize_text_field( $_POST['occp_head_txt'] );
    update_post_meta( $post_id, 'occp_head_txt', $fbtfhead );

    if(isset($_REQUEST['occp_off_per'])) {
        $fbtf_off_per = fbtpfw_recursive_sanitize_text_field($_POST['occp_off_per']);
        update_post_meta( $post_id, 'occp_off_per', (array) $fbtf_off_per );
    }

    if(isset($_REQUEST['occp_discount_type'])) {
        $fbtf_discount_type = fbtpfw_recursive_sanitize_text_field($_POST['occp_discount_type']);
        update_post_meta( $post_id, 'occp_discount_type', (array) $fbtf_discount_type );
    }
}