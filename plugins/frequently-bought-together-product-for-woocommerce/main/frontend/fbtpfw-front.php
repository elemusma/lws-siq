<?php
function fbtpfw_localization( $key = '', $default = '' ) {
    $str = '';
    $localization = array();

    if ( ! empty( $key ) && ! empty($localization[ $key ] ) ) {
        $str = $localization[ $key ];
    } elseif ( ! empty( $default ) ) {
        $str = $default;
    }

    return apply_filters( 'fbtpfw_localization_' . $key, $str );
}

add_action('wp_ajax_variation_switch_cus', 'fbtpfw_variation_switch_cus' );
add_action('wp_ajax_nopriv_variation_switch_cus', 'fbtpfw_variation_switch_cus');
function fbtpfw_variation_switch_cus(){
    global $fbtpfw_comman;
    if (isset($_REQUEST['attrs'])) {
        $product_id = sanitize_text_field($_REQUEST['curproid']);
        $match_attributes = sanitize_text_field($_REQUEST['attrs']);
        $data_store   = WC_Data_Store::load( 'product' );
        $variation_id = $data_store->find_matching_product_variation(
            new \WC_Product( $product_id),$match_attributes
        );
        update_post_meta($variation_id,'attr_cus',$match_attributes);
        $main_product = wc_get_product( $variation_id );
        $image_array = wp_get_attachment_image_src($main_product->image_id, 'thumbnail');
        $image_src = $image_array[0];
        $this_item_text = $fbtpfw_comman['this_item_text'];
        $regular_price_color = $fbtpfw_comman['regular_price_color'];
        $price_html = '<span class="fbtpfw_price_new" style="color:'.$regular_price_color.';">('.$main_product->get_price_html().')</span>';
        $responce['var_id'] = $variation_id;
        $responce['var_price'] = $main_product->get_price();
        $responce['var_price_html'] = $price_html;
        $responce['var_image'] = $image_src;
        $responce['var_name'] = $this_item_text.': '.$main_product->get_name();
    }
    echo wp_send_json($responce);
    die();
}

add_action('wp_ajax_variation_switch',  'fbtpfw_variation_switch' );
add_action('wp_ajax_nopriv_variation_switch',  'fbtpfw_variation_switch');
function fbtpfw_variation_switch(){
    $main_product = wc_get_product( sanitize_text_field($_REQUEST['var_id']) );
    $image_array = wp_get_attachment_image_src($main_product->image_id, 'thumbnail');
    $image_src = $image_array[0];
    $this_item_text = $fbtpfw_comman['this_item_text'];
    $regular_price_color = $fbtpfw_comman['regular_price_color'];
    $price_html = '<span class="fbtpfw_price_new" style="color:'.$regular_price_color.';">('.$main_product->get_price_html().')</span>';
    $responce['var_price'] = $main_product->get_price();
    $responce['var_price_html'] = $price_html;
    $responce['var_image'] = $image_src;
    $responce['var_name'] = $this_item_text.': '.$main_product->get_name();
    echo wp_send_json($responce);
    die(); 
}

add_action( 'wp',  'fbtpfw_get_page_id');
function fbtpfw_get_page_id() {
    global $fbtpfw_comman;
	if ( is_product() ) {
        $page_security = get_queried_object();
        if($page_security->post_type == "product") {
        	$product_id = $page_security->ID;
        	$layout     = get_post_meta($product_id , 'occp_layout', true );
            $single_pro_positions = $fbtpfw_comman['single_pro_positions'];
            if( $layout == "layout1" ) {
                $product = wc_get_product($product_id);
                if($product->is_type( 'variable' )) {
                    add_action( 'woocommerce_before_add_to_cart_button',  'fbtpfw_layout1'  );
                }else{
                    if ($single_pro_positions == 'before_adtcart') {
                        add_action( 'woocommerce_before_add_to_cart_quantity', 'fbtpfw_layout1' , 1 );
                    }elseif ($single_pro_positions == 'after_adtcart') {
                        add_action( 'woocommerce_after_add_to_cart_button', 'fbtpfw_layout1' , 1 );
                    }
                }     
            }elseif( $layout == "layout2" ) {
                $single_pro_positionsl2 = $fbtpfw_comman['single_pro_positionsl2'];
                if($single_pro_positionsl2 == 'before_title'){
                    add_action( 'woocommerce_single_product_summary',  'fbtpfw_layout2', 1 );
                }elseif($single_pro_positionsl2 == 'before_atc'){
                    add_action( 'woocommerce_before_add_to_cart_form', 'fbtpfw_layout2' , 1 );
                }elseif($single_pro_positionsl2 == 'after_atc'){
                    add_action( 'woocommerce_after_add_to_cart_form', 'fbtpfw_layout2' , 1 );
                }elseif($single_pro_positionsl2 == 'after_summary'){
                    add_filter( 'woocommerce_after_single_product_summary', 'fbtpfw_layout2', 5);
                }
            } 
        }
    }
}

/* add_action( 'woocommerce_single_product_summary',  'fbtpfw_layout2'); 
 function addcusshorcode(){
    echo do_shortcode( '[Woo_Frequently_added]' );
 }*/
function fbtpfw_add_display_default_product($product){
    global $fbtpfw_comman;
    $count  = 0; 
    $badge ='';
    $product_details = '';
    $total= 0;
    $images = '';
    // echo "<pre>";
    // print_r($product);
    // echo "</pre>";
    // exit;
    $layout     = get_post_meta(get_the_ID() , 'occp_layout', true );
    $default_products = $fbtpfw_comman['default_products'];
    if( $layout == "layout1" ) {
        if ($default_products == 'related') {
            foreach ($product as $productsdata) {
                $product = wc_get_product( $productsdata->ID );
                $current_product_link =  $product->get_permalink();
                $current_product_image = $product->get_image();
                $current_product_title = $product->get_title();
                $current_product_price = $product->get_price();
                $current_product_id = $product->get_id();
                $current_product_is_variation   = $product->is_type( 'variation' );
                $current_product_discount='';
                $current_product_discount_type='';
                if(!empty($occp_discunt[$current_product_id])) {
                    $current_product_discount = $occp_discunt[$current_product_id];
                }
                if(!empty($occp_discunt_type[$current_product_id])) {
                    $current_product_discount_type = $occp_discunt_type[$current_product_id];
                }
                

                $current_product_exact_price = fbtpfw_get_price($current_product_price, $current_product_discount, $current_product_discount_type);
                if($count == 0) {
                    $current_product_exact_prices = 0;
                } else {
                    $current_product_exact_prices = $current_product_exact_price;
                }
                
                $dis_type = get_post_meta( get_the_ID(), 'occp_discount_type' );
                $dis_amt = get_post_meta( get_the_ID(), 'occp_off_per' );
                $discount_badge_text_color =$fbtpfw_comman['discount_badge_text_color'];
                $discount_badge_back_color = $fbtpfw_comman['discount_badge_back_color'];;

                if(!empty($dis_amt[0][$current_product_id])) {
                    if(get_option('woocommerce_currency_pos') == 'left' || get_option('woocommerce_currency_pos') == 'left_space'){
                        if($dis_type[0][$current_product_id] == "percentage") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                        }else if($dis_type[0][$current_product_id] == "fixed") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.get_woocommerce_currency_symbol().$dis_amt[0][$current_product_id].'</span></div>';
                        }
                    }else{
                        if($dis_type[0][$current_product_id] == "percentage") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                        }else if($dis_type[0][$current_product_id] == "fixed") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].get_woocommerce_currency_symbol(). '</span></div>';
                        }
                    }
                }

                $images .= '<td class="fbtpfw_img" image_pro_id="'.$current_product_id.'"><div class="fbtpfw_img_div"><a href="' . $current_product_link . '">' . $current_product_image . '</a>'.$badge.'</div></td>';
                ob_start();
                $check_default_pro =  $fbtpfw_comman['check_default_pro'];
                ?>
                <div class="fbtpfw_each_item <?php if($count == 0) { echo 'fbtpfw_each_curprod'; } ?>">
                    <div class="fbtpfw_product_check">
                        <input type="checkbox" name="proID[]" id="proID_<?php echo esc_attr($count); ?>" class="product_check" value="<?php echo esc_attr($current_product_id); ?>" price="<?php echo esc_attr($current_product_exact_price) ; ?>" <?php if($count == 0){ echo "checked disabled"; }elseif($check_default_pro == 'yes'){echo "checked";} ?>/>
                    </div>

                    <div class="fbtpfw_product_image">
                        <?php echo $product->get_image();?>
                    </div>

                    <div class="fbtpfw_product_title">
                        <?php $this_item_text = $fbtpfw_comman['this_item_text']; ?>
                        <span>
                            <?php
                            if($count == 0) {
                                echo esc_attr($this_item_text).': '.esc_attr($current_product_title);
                            } else {
                                echo '<a href="'.esc_url($current_product_link).'">'.esc_attr($current_product_title).'</a>';
                            }
                            ?>
                        </span>
                        <?php
                            if( $current_product_is_variation ) {
                                $attributes = $product->get_variation_attributes();
                                $variations = array();

                                foreach( $attributes as $key => $attribute ) {
                                    $variations[] = $attribute;
                                }

                                if( ! empty( $variations ) )
                                echo '<span class="product-attributes"> &ndash; ' . esc_attr(implode( ', ', $variations )) . '</span>';
                            }
                        ?>
                    </div>

                    <div class="fbtpfw_product_price">
                        <?php 
                            if(!empty($product->get_sale_price())) { 
                                $price = wc_price($product->get_regular_price()); 
                            }elseif(!empty($current_product_exact_price)){
                                $price = wc_price($product->get_regular_price()); 
                            }else { 
                                $price = "";
                            }
                            $regular_price_color = $fbtpfw_comman['regular_price_color'];
                            echo '<span class="fbtpfw_price_old">' . $price . '</span><span class="fbtpfw_price_new" style="color:'.esc_attr($regular_price_color).';">('. wc_price($current_product_exact_price) .')</span>';
                        ?>
                    </div>
                </div>
                <?php
                $product_details .= ob_get_clean();
                // increment total
                $total += floatval( $current_product_exact_prices );
                $count++;
            }
            ?>

            <input type="hidden" name="formate" value="<?php echo esc_attr(get_woocommerce_currency_symbol()); ?>" class="formate">
            <input type="hidden" name="layout" value="layout1" class="layout">
            <div class="fbtpfw_main layout1">
                 <?php $fbtpfw_product_color = $fbtpfw_comman['fbtpfw_product_color']; ?>
                <h3 style="color:<?php echo esc_attr($fbtpfw_product_color); ?>"><?php echo esc_attr(get_post_meta( get_the_ID(), 'occp_head_txt', true )); ?></h3>
                <div class="fbtpfw_div">
                    <?php echo $product_details;?>
                </div>
                <div class="fbtpfw_cart_div">
                    <div class="fbtpfw_price">
                         <?php $addtional_amount_text_color = $fbtpfw_comman['addtional_amount_text_color']; ?>
                        <span class="fbtpfw_price_label" style="color: <?php echo esc_attr($addtional_amount_text_color); ?>;">
                            <?php $addtional_amount_text = $fbtpfw_comman['addtional_amount_text']; ?>
                            <?php echo esc_attr($addtional_amount_text)." : "; ?>
                        </span>
                        &nbsp;
                        <span class="fbtpfw_price_total" data-total="<?php echo esc_attr($total) ?>">
                            <?php echo wc_price( $total ); ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php
        }elseif ($default_products == 'upsells') {
            foreach ($product as $productsdata) {
                $product = wc_get_product( $productsdata );
                $current_product_link =  $product->get_permalink();
                $current_product_image = $product->get_image();
                $current_product_title = $product->get_title();
                $current_product_price = $product->get_price();
                $current_product_id = $product->get_id();
                $current_product_is_variation   = $product->is_type( 'variation' );
                $current_product_discount='';
                $current_product_discount_type='';
                if(!empty($occp_discunt[$current_product_id])) {
                    $current_product_discount = $occp_discunt[$current_product_id];
                }
                if(!empty($occp_discunt_type[$current_product_id])) {
                    $current_product_discount_type = $occp_discunt_type[$current_product_id];
                }
                

                $current_product_exact_price = fbtpfw_get_price($current_product_price, $current_product_discount, $current_product_discount_type);
                if($count == 0) {
                    $current_product_exact_prices = 0;
                } else {
                    $current_product_exact_prices = $current_product_exact_price;
                }
                
                $dis_type = get_post_meta( get_the_ID(), 'occp_discount_type' );
                $dis_amt = get_post_meta( get_the_ID(), 'occp_off_per' );
                $discount_badge_text_color =$fbtpfw_comman['discount_badge_text_color'];
                $discount_badge_back_color = $fbtpfw_comman['discount_badge_back_color'];;

                if(!empty($dis_amt[0][$current_product_id])) {
                    if(get_option('woocommerce_currency_pos') == 'left' || get_option('woocommerce_currency_pos') == 'left_space'){
                        if($dis_type[0][$current_product_id] == "percentage") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                        }else if($dis_type[0][$current_product_id] == "fixed") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.get_woocommerce_currency_symbol().$dis_amt[0][$current_product_id].'</span></div>';
                        }
                    }else{
                        if($dis_type[0][$current_product_id] == "percentage") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                        }else if($dis_type[0][$current_product_id] == "fixed") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].get_woocommerce_currency_symbol(). '</span></div>';
                        }
                    }
                }

                $images .= '<td class="fbtpfw_img" image_pro_id="'.$current_product_id.'"><div class="fbtpfw_img_div"><a href="' . $current_product_link . '">' . $current_product_image . '</a>'.$badge.'</div></td>';
                ob_start();
                $check_default_pro =  $fbtpfw_comman['check_default_pro'];
                ?>
                <div class="fbtpfw_each_item <?php if($count == 0) { echo 'fbtpfw_each_curprod'; } ?>">
                    <div class="fbtpfw_product_check">
                        <input type="checkbox" name="proID[]" id="proID_<?php echo esc_attr($count); ?>" class="product_check" value="<?php echo esc_attr($current_product_id); ?>" price="<?php echo esc_attr($current_product_exact_price) ; ?>" <?php if($count == 0){ echo "checked disabled"; }elseif($check_default_pro == 'yes'){echo "checked";} ?>/>
                    </div>

                    <div class="fbtpfw_product_image">
                        <?php echo $product->get_image();?>
                    </div>

                    <div class="fbtpfw_product_title">
                        <?php $this_item_text = $fbtpfw_comman['this_item_text']; ?>
                        <span>
                            <?php
                            if($count == 0) {
                                echo esc_attr($this_item_text).': '.esc_attr($current_product_title);
                            } else {
                                echo '<a href="'.esc_url($current_product_link).'">'.esc_attr($current_product_title).'</a>';
                            }
                            ?>
                        </span>
                        <?php
                            if( $current_product_is_variation ) {
                                $attributes = $product->get_variation_attributes();
                                $variations = array();

                                foreach( $attributes as $key => $attribute ) {
                                    $variations[] = $attribute;
                                }

                                if( ! empty( $variations ) )
                                echo '<span class="product-attributes"> &ndash; ' . esc_attr(implode( ', ', $variations )) . '</span>';
                            }
                        ?>
                    </div>

                    <div class="fbtpfw_product_price">
                        <?php 
                            if(!empty($product->get_sale_price())) { 
                                $price = wc_price($product->get_regular_price()); 
                            }elseif(!empty($current_product_exact_price)){
                                $price = wc_price($product->get_regular_price()); 
                            }else { 
                                $price = "";
                            }
                            $regular_price_color = $fbtpfw_comman['regular_price_color'];
                            echo '<span class="fbtpfw_price_old">' . $price . '</span><span class="fbtpfw_price_new" style="color:'.esc_attr($regular_price_color).';">('. wc_price($current_product_exact_price) .')</span>';
                        ?>
                    </div>
                </div>
                <?php
                $product_details .= ob_get_clean();
                // increment total
                $total += floatval( $current_product_exact_prices );
                $count++;
            }
            ?>

            <input type="hidden" name="formate" value="<?php echo esc_attr(get_woocommerce_currency_symbol()); ?>" class="formate">
            <input type="hidden" name="layout" value="layout1" class="layout">
            <div class="fbtpfw_main layout1">
                 <?php $fbtpfw_product_color = $fbtpfw_comman['fbtpfw_product_color']; ?>
                <h3 style="color:<?php echo esc_attr($fbtpfw_product_color); ?>"><?php echo esc_attr(get_post_meta( get_the_ID(), 'occp_head_txt', true )); ?></h3>
                <div class="fbtpfw_div">
                    <?php echo $product_details;?>
                </div>
                <div class="fbtpfw_cart_div">
                    <div class="fbtpfw_price">
                         <?php $addtional_amount_text_color = $fbtpfw_comman['addtional_amount_text_color']; ?>
                        <span class="fbtpfw_price_label" style="color: <?php echo esc_attr($addtional_amount_text_color); ?>;">
                            <?php $addtional_amount_text = $fbtpfw_comman['addtional_amount_text']; ?>
                            <?php echo esc_attr($addtional_amount_text)." : "; ?>
                        </span>
                        &nbsp;
                        <span class="fbtpfw_price_total" data-total="<?php echo esc_attr($total) ?>">
                            <?php echo wc_price( $total ); ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php
        }
    }elseif ($layout == "layout2") {
        $occp_count = count((array)$product);
        $occp_badge = 'true';

        if(wp_is_mobile()) {
            if($occp_count > 2) {
                $occp_badge = 'false';
            }
        }

        $occp_discunt = get_post_meta( get_the_ID(), 'occp_off_per', true );
        $occp_discunt_type = get_post_meta( get_the_ID(), 'occp_discount_type', true );
        $count = 0;
        $badge = '';
        $product_details = '';
        $total= 0;
        $images = '';

        if ($default_products == 'related') {
            foreach ($product as $productId) {
                $product = wc_get_product( $productId->ID );
                $current_product_link = $product->get_permalink();
                $current_product_image = $product->get_image();
                $current_product_title = $product->get_title();
                $current_product_price = $product->get_price();
                $current_product_id = $product->get_id();
                $current_product_is_variation   = $product->is_type( 'variation' );
                $current_product_discount='';
                $current_product_discount_type='';
                if(!empty($occp_discunt[$current_product_id])) {
                    $current_product_discount = $occp_discunt[$current_product_id];
                }
                if(!empty($occp_discunt_type[$current_product_id])) {
                    $current_product_discount_type = $occp_discunt_type[$current_product_id];
                }
                
                $current_product_exact_price = fbtpfw_get_price($current_product_price, $current_product_discount, $current_product_discount_type);

                $dis_type = get_post_meta( get_the_ID(), 'occp_discount_type' );
                $dis_amt = get_post_meta( get_the_ID(), 'occp_off_per' );
                $discount_badge_text_color = $fbtpfw_comman['discount_badge_text_color'];
                $discount_badge_back_color = $fbtpfw_comman['discount_badge_back_color'];;
                                
                if(!empty($dis_amt[0][$current_product_id])) {
                    if(get_option('woocommerce_currency_pos') == 'left' || get_option('woocommerce_currency_pos') == 'left_space'){
                        if($dis_type[0][$current_product_id] == "percentage") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                        }else if($dis_type[0][$current_product_id] == "fixed") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.get_woocommerce_currency_symbol().$dis_amt[0][$current_product_id].'</span></div>';
                        }
                    }else{
                        if($dis_type[0][$current_product_id] == "percentage") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                        }else if($dis_type[0][$current_product_id] == "fixed") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].get_woocommerce_currency_symbol(). '</span></div>';
                        }
                    }
                }

                if($occp_badge == 'true') {
                    $badge = $badge;
                } else {
                    $badge = '';
                }

                $images .= '<td class="fbtpfw_img" image_pro_id="'.$current_product_id.'"><div class="fbtpfw_img_div"><a href="' . $current_product_link . '">' . $current_product_image . '</a>'.$badge.'</div></td>';

                if( $count < $occp_count ) {
                    $isimplfirst = '';
                    if($count == 0) {
                        $isimplfirst = 'fbtpfw_img_plus_first';
                    }
                    $images .= '<td class="fbtpfw_img_plus '.$isimplfirst.'" fbtpfw_imgpls_id="'.$current_product_id.'">+</td>';
                }
               
                ob_start();
                $check_default_pro = $fbtpfw_comman['check_default_pro'];
                ?>
                <li class="fbtpfw_each_item">
                    <input type="checkbox" name="proID[]" id="proID_<?php echo esc_attr($count) ?>" class="product_check" value="<?php echo esc_attr($current_product_id); ?>" price="<?php echo esc_attr($current_product_exact_price); ?>" <?php if($count == 0) { echo 'checked style="opacity: .6;pointer-events: none;"'; }elseif($check_default_pro == 'yes'){echo "checked";} ?> />
                    <span class="fbtpfw_product_title">
                        <?php $this_item_text = $fbtpfw_comman['this_item_text']; ?>
                        <?php
                        if($count == 0) {
                            echo esc_attr($this_item_text.' : '.$current_product_title);
                        } else {
                            echo '<a href="'.esc_url($current_product_link).'">'.esc_attr($current_product_title).'</a>';
                        }
                        ?>
                    </span>
                    <?php
                        if( $current_product_is_variation ) {
                            $attributes = $product->get_variation_attributes();
                            $variations = array();

                            foreach( $attributes as $key => $attribute ) {
                                $variations[] = $attribute;
                            }

                            if( ! empty( $variations ) ){
                                echo '<span class="product-attributes"> &ndash; ' . esc_attr(implode( ', ', $variations )) . '</span>';
                            }

                        }
                       
                        if(!empty($product->get_price())) { 
                            $price = wc_price($product->get_price()); 
                        }else { 
                            $price = wc_price(0);
                        }
                        if(!empty($product->get_sale_price())) { 
                            $price = wc_price($product->get_regular_price()); 
                        }elseif(!empty($current_product_exact_price)){
                            $price = wc_price($product->get_regular_price()); 
                        }else { 
                            $price = "";
                        }
                        $regular_price_color = $fbtpfw_comman['regular_price_color'];
                        echo ' &ndash; <span class="fbtpfw_price_old">' . $price. '</span><span class="fbtpfw_price_new" style="color:'.esc_attr($regular_price_color).';">('. wc_price($current_product_exact_price) .')</span>';

                        $productaaaaa = wc_get_product( get_the_ID() );
                        if($productaaaaa->get_type() == 'variable'){
                            $attributesqwqww = $productaaaaa->get_variation_attributes();
                            $available_variations = $productaaaaa->get_available_variations();
                            if( $current_product_is_variation ) {
                                if ( is_array( $attributesqwqww ) && ( count( $attributesqwqww ) > 0 ) ) {
                                    echo "<div class='oc_cust_variation' currentproid=".get_the_id().">";

                                    if ( is_array( $attributes ) && ( count( $attributes ) > 0 ) ) {
                                        echo '<div class="variations_form" data-product_id="' . absint( get_the_id() ) . '" data-product_variations="' . htmlspecialchars( wp_json_encode( $available_variations ) ) . '">';
                                        echo '<div class="variations">';
                                        foreach ( $attributesqwqww as $attribute_name => $options ) { ?>
                                            <div class="variation">
                                                <div class="label">
                                                    <?php echo wc_attribute_label( $attribute_name ); ?>
                                                </div>
                                                <div class="select">
                                                    <?php
                                                    $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $productaaaaa->get_variation_default_attribute( $attribute_name );
                                                        wc_dropdown_variation_attribute_options( array(
                                                            'options'          => $options,
                                                            'attribute'        => $attribute_name,
                                                            'product'          => $productaaaaa,
                                                            'selected'         => $selected,
                                                        ) );
                                                    ?>
                                                </div>
                                            </div>
                                        <?php }
                                        echo '<div class="reset">' . apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . fbtpfw_localization( 'clear', esc_html__( 'Clear', 'woo-bought-together' ) ) . '</a>' ) . '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo "</div>";
                                    }
                                }
                            }
                        }
                    ?>
                </li>
                <?php
                $product_details .= ob_get_clean();
                // increment total
                $total += floatval( $current_product_exact_price );
                $badge = '';
                $count++;
            }
            ?>
            <input type="hidden" name="formate" value="<?php echo esc_attr(get_woocommerce_currency_symbol()); ?>" class="formate">
            <input type="hidden" name="layout" value="layout2" class="layout">
            <div class="fbtpfw_main layout2">
                <form class="fbtpfw_product_form" method="post" action="">
                    <?php $fbtpfw_product_color = $fbtpfw_comman['fbtpfw_product_color']; ?>
                    <h3 style="color:<?php echo esc_attr($fbtpfw_product_color); ?>" ><?php echo esc_attr(get_post_meta( get_the_ID(), 'occp_head_txt', true )); ?></h3>
                    <table class="fbtpfw_product_images">
                        <tbody>
                            <tr>
                                <?php echo $images;  ?>
                                
                            </tr>
                        </tbody>
                    </table>
                    <div class="fbtpfw_cart_div">
                        <div class="fbtpfw_price">
                             <?php $price_all_text_color = $fbtpfw_comman['price_all_text_color']; ?>
                            <span class="fbtpfw_price_label" style="color:<?php echo esc_attr($price_all_text_color);  ?>">
                                <?php $price_for_all_text = $fbtpfw_comman['price_for_all_text']; ?>
                                <?php echo esc_attr($price_for_all_text)." : "; 
                                ?>
                            </span>
                            &nbsp;
                            <span class="fbtpfw_price_total" data-total="<?php echo esc_attr($total); ?>">
                                <?php echo wc_price( $total ); ?>
                            </span>
                        </div>
                        <?php $add_to_cart_text =$fbtpfw_comman['add_to_cart_text']; ?>
                        <?php $add_cart_back_color =  $fbtpfw_comman['add_cart_back_color']; ?>
                        <?php $add_cart_text_color = $fbtpfw_comman['add_cart_text_color']; ?>
                        <input type="submit" style="color:<?php echo esc_attr($add_cart_text_color); ?>;background: <?php echo esc_attr($add_cart_back_color); ?>" class="occp_add_cart_button button" value="<?php echo esc_attr($add_to_cart_text); ?>" name="occp_add_to_cart">
                    </div> 

                    <ul class="fbtpfw_ul">
                        <?php echo $product_details;  ?>
                    </ul>        
                </form>
            </div>
            <?php
        }elseif ($default_products == 'upsells') {
            foreach ($product as $productId) {
                $product = wc_get_product( $productId );
                $current_product_link = $product->get_permalink();
                $current_product_image = $product->get_image();
                $current_product_title = $product->get_title();
                $current_product_price = $product->get_price();
                $current_product_id = $product->get_id();
                $current_product_is_variation   = $product->is_type( 'variation' );
                $current_product_discount='';
                $current_product_discount_type='';
                if(!empty($occp_discunt[$current_product_id])) {
                    $current_product_discount = $occp_discunt[$current_product_id];
                }
                if(!empty($occp_discunt_type[$current_product_id])) {
                    $current_product_discount_type = $occp_discunt_type[$current_product_id];
                }
                
                $current_product_exact_price = fbtpfw_get_price($current_product_price, $current_product_discount, $current_product_discount_type);

                $dis_type = get_post_meta( get_the_ID(), 'occp_discount_type' );
                $dis_amt = get_post_meta( get_the_ID(), 'occp_off_per' );
                $discount_badge_text_color = $fbtpfw_comman['discount_badge_text_color'];
                $discount_badge_back_color = $fbtpfw_comman['discount_badge_back_color'];;
                                
                if(!empty($dis_amt[0][$current_product_id])) {
                    if(get_option('woocommerce_currency_pos') == 'left' || get_option('woocommerce_currency_pos') == 'left_space'){
                        if($dis_type[0][$current_product_id] == "percentage") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                        }else if($dis_type[0][$current_product_id] == "fixed") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.get_woocommerce_currency_symbol().$dis_amt[0][$current_product_id].'</span></div>';
                        }
                    }else{
                        if($dis_type[0][$current_product_id] == "percentage") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                        }else if($dis_type[0][$current_product_id] == "fixed") {
                            $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].get_woocommerce_currency_symbol(). '</span></div>';
                        }
                    }
                }

                if($occp_badge == 'true') {
                    $badge = $badge;
                } else {
                    $badge = '';
                }

                $images .= '<td class="fbtpfw_img" image_pro_id="'.$current_product_id.'"><div class="fbtpfw_img_div"><a href="' . $current_product_link . '">' . $current_product_image . '</a>'.$badge.'</div></td>';

                if( $count < $occp_count ) {
                    $isimplfirst = '';
                    if($count == 0) {
                        $isimplfirst = 'fbtpfw_img_plus_first';
                    }
                    $images .= '<td class="fbtpfw_img_plus '.$isimplfirst.'" fbtpfw_imgpls_id="'.$current_product_id.'">+</td>';
                }
               
                ob_start();
                $check_default_pro = $fbtpfw_comman['check_default_pro'];
                ?>
                <li class="fbtpfw_each_item">
                    <input type="checkbox" name="proID[]" id="proID_<?php echo esc_attr($count) ?>" class="product_check" value="<?php echo esc_attr($current_product_id); ?>" price="<?php echo esc_attr($current_product_exact_price); ?>" <?php if($count == 0) { echo 'checked style="opacity: .6;pointer-events: none;"'; }elseif($check_default_pro == 'yes'){echo "checked";} ?> />
                    <span class="fbtpfw_product_title">
                        <?php $this_item_text = $fbtpfw_comman['this_item_text']; ?>
                        <?php
                        if($count == 0) {
                            echo esc_attr($this_item_text.' : '.$current_product_title);
                        } else {
                            echo '<a href="'.esc_url($current_product_link).'">'.esc_attr($current_product_title).'</a>';
                        }
                        ?>
                    </span>
                    <?php
                        if( $current_product_is_variation ) {
                            $attributes = $product->get_variation_attributes();
                            $variations = array();

                            foreach( $attributes as $key => $attribute ) {
                                $variations[] = $attribute;
                            }

                            if( ! empty( $variations ) ){
                                echo '<span class="product-attributes"> &ndash; ' . esc_attr(implode( ', ', $variations )) . '</span>';
                            }

                        }
                       
                        if(!empty($product->get_price())) { 
                            $price = wc_price($product->get_price()); 
                        }else { 
                            $price = wc_price(0);
                        }
                        if(!empty($product->get_sale_price())) { 
                            $price = wc_price($product->get_regular_price()); 
                        }elseif(!empty($current_product_exact_price)){
                            $price = wc_price($product->get_regular_price()); 
                        }else { 
                            $price = "";
                        }
                        $regular_price_color = $fbtpfw_comman['regular_price_color'];
                        echo ' &ndash; <span class="fbtpfw_price_old">' . $price. '</span><span class="fbtpfw_price_new" style="color:'.esc_attr($regular_price_color).';">('. wc_price($current_product_exact_price) .')</span>';

                        $productaaaaa = wc_get_product( get_the_ID() );
                        if($productaaaaa->get_type() == 'variable'){
                            $attributesqwqww = $productaaaaa->get_variation_attributes();
                            $available_variations = $productaaaaa->get_available_variations();
                            if( $current_product_is_variation ) {
                                if ( is_array( $attributesqwqww ) && ( count( $attributesqwqww ) > 0 ) ) {
                                    echo "<div class='oc_cust_variation' currentproid=".get_the_id().">";

                                    if ( is_array( $attributes ) && ( count( $attributes ) > 0 ) ) {
                                        echo '<div class="variations_form" data-product_id="' . absint( get_the_id() ) . '" data-product_variations="' . htmlspecialchars( wp_json_encode( $available_variations ) ) . '">';
                                        echo '<div class="variations">';
                                        foreach ( $attributesqwqww as $attribute_name => $options ) { ?>
                                            <div class="variation">
                                                <div class="label">
                                                    <?php echo wc_attribute_label( $attribute_name ); ?>
                                                </div>
                                                <div class="select">
                                                    <?php
                                                    $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $productaaaaa->get_variation_default_attribute( $attribute_name );
                                                        wc_dropdown_variation_attribute_options( array(
                                                            'options'          => $options,
                                                            'attribute'        => $attribute_name,
                                                            'product'          => $productaaaaa,
                                                            'selected'         => $selected,
                                                        ) );
                                                    ?>
                                                </div>
                                            </div>
                                        <?php }
                                        echo '<div class="reset">' . apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . fbtpfw_localization( 'clear', esc_html__( 'Clear', 'woo-bought-together' ) ) . '</a>' ) . '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo "</div>";
                                    }
                                }
                            }
                        }
                    ?>
                </li>
                <?php
                $product_details .= ob_get_clean();
                // increment total
                $total += floatval( $current_product_exact_price );
                $badge = '';
                $count++;
            }
            ?>
            <input type="hidden" name="formate" value="<?php echo esc_attr(get_woocommerce_currency_symbol()); ?>" class="formate">
            <input type="hidden" name="layout" value="layout2" class="layout">
            <div class="fbtpfw_main layout2">
                <form class="fbtpfw_product_form" method="post" action="">
                    <?php $fbtpfw_product_color = $fbtpfw_comman['fbtpfw_product_color']; ?>
                    <h3 style="color:<?php echo esc_attr($fbtpfw_product_color); ?>" ><?php echo esc_attr(get_post_meta( get_the_ID(), 'occp_head_txt', true )); ?></h3>
                    <table class="fbtpfw_product_images">
                        <tbody>
                            <tr>
                                <?php echo $images;  ?>
                                
                            </tr>
                        </tbody>
                    </table>
                    <div class="fbtpfw_cart_div">
                        <div class="fbtpfw_price">
                             <?php $price_all_text_color = $fbtpfw_comman['price_all_text_color']; ?>
                            <span class="fbtpfw_price_label" style="color:<?php echo esc_attr($price_all_text_color);  ?>">
                                <?php $price_for_all_text = $fbtpfw_comman['price_for_all_text']; ?>
                                <?php echo esc_attr($price_for_all_text)." : "; 
                                ?>
                            </span>
                            &nbsp;
                            <span class="fbtpfw_price_total" data-total="<?php echo esc_attr($total); ?>">
                                <?php echo wc_price( $total ); ?>
                            </span>
                        </div>
                        <?php $add_to_cart_text =$fbtpfw_comman['add_to_cart_text']; ?>
                        <?php $add_cart_back_color =  $fbtpfw_comman['add_cart_back_color']; ?>
                        <?php $add_cart_text_color = $fbtpfw_comman['add_cart_text_color']; ?>
                        <input type="submit" style="color:<?php echo esc_attr($add_cart_text_color); ?>;background: <?php echo esc_attr($add_cart_back_color); ?>" class="occp_add_cart_button button" value="<?php echo esc_attr($add_to_cart_text); ?>" name="occp_add_to_cart">
                    </div> 

                    <ul class="fbtpfw_ul">
                        <?php echo $product_details;  ?>
                    </ul>        
                </form>
            </div>
            <?php
        }
    }
    
    
}

function relared_upsells_common_func($pro_id){
    global $fbtpfw_comman;
    $default_products = $fbtpfw_comman['default_products'];
    if ($default_products == 'upsells') {
        $productaaa = new WC_Product($pro_id);
        $upsells = $productaaa->get_upsell_ids();
        if (!$upsells){
            return;
        }
        $meta_query = WC()->query->get_meta_query();
        $args = array(
            'post_type' => 'product',
            'ignore_sticky_posts' => 1,
            'no_found_rows' => 1,
            'posts_per_page' => -1,
            'post__in' => $upsells,
            'post__not_in' => array($productaaa->id),
            'meta_query' => $meta_query
        );
        $products = new WP_Query($args);
        $product = $products->posts;
        //$main_productpost = get_post( get_the_ID() );
        array_unshift($product, get_the_ID());
        echo fbtpfw_add_display_default_product($product);
    }elseif ($default_products == 'related') {
        $terms = wp_get_post_terms( $pro_id, 'product_cat' );
        foreach ( $terms as $term ) {
            $children = get_term_children( $term->term_id, 'product_cat' );
            if ( !sizeof( $children ) )
            $cats_array[] = $term->term_id;
        }
        $args = apply_filters( 'woocommerce_related_products_args', array(
            'post_type' => 'product',
            'post__not_in' => array( $pro_id ),
            'ignore_sticky_posts' => 1,
            'no_found_rows' => 1,
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $cats_array
                ),
            )
        ));
        $products = new WP_Query( $args );
        $product = $products->posts;
        $main_productpost = get_post( get_the_ID() );
        array_unshift($product, $main_productpost);
        echo fbtpfw_add_display_default_product($product);
    }elseif ($default_products == 'none'){
        $product = '';
    }
}

/*design for shortcode*/
add_shortcode( 'Woo_Frequently_added', 'fbtpfw_woo_combo');
function fbtpfw_woo_combo($atts, $content = null) {
      global $fbtpfw_comman;
    ob_start();

    $page_security = get_queried_object();
    if(get_post_meta( $page_security->ID, 'occp_layout', true ) == "none"){
        $product = get_post_meta( get_the_ID(), 'occp_select2', true );
        if (empty($product)) {
            $pro_id = get_the_ID();
            echo relared_upsells_common_func($pro_id);
        }

        $occp_count = count($product);
        $occp_badge = 'true';

        if(wp_is_mobile()) {
            if($occp_count > 2) {
                $occp_badge = 'false';
            }
        }

        $occp_discunt = get_post_meta( get_the_ID(), 'occp_off_per', true );
        $occp_discunt_type = get_post_meta( get_the_ID(), 'occp_discount_type', true );

        if(empty($product)) {
            return;
        }

        $main_product = wc_get_product( get_the_ID() );
        if( $main_product->has_child() ) {
            $product_variable = new WC_Product_Variable( get_the_ID() );
            $variations = $product_variable->get_available_variations();
            $vari = 0;
            foreach ($variations as $variation) {
                $vari++;
                if($vari == 1){
                    if (in_array($variation['variation_id'], $product)){ 
                
                    }else{
                        array_unshift($product,$variation['variation_id']);
                    }
                }
            }
        } else {
            array_unshift($product, get_the_ID());
        }
        $count = 0;
        $badge = '';
        $product_details = '';
        $total= 0;
        $images = '';

        foreach ($product as $productId) {
            $product = wc_get_product( $productId );
            $current_product_link = $product->get_permalink();
            $current_product_image = $product->get_image();
            $current_product_title = $product->get_title();
            $current_product_price = $product->get_price();
            $current_product_id = $product->get_id();
            $current_product_is_variation   = $product->is_type( 'variation' );
            $current_product_discount='';
            $current_product_discount_type='';
            if(!empty($occp_discunt[$current_product_id])) {
                $current_product_discount = $occp_discunt[$current_product_id];
            }
            if(!empty($occp_discunt_type[$current_product_id])) {
                $current_product_discount_type = $occp_discunt_type[$current_product_id];
            }
            
            $current_product_exact_price = fbtpfw_get_price($current_product_price, $current_product_discount, $current_product_discount_type);

            $dis_type = get_post_meta( get_the_ID(), 'occp_discount_type' );
            $dis_amt = get_post_meta( get_the_ID(), 'occp_off_per' );
            $discount_badge_text_color = $fbtpfw_comman['discount_badge_text_color'];
            $discount_badge_back_color = $fbtpfw_comman['discount_badge_back_color'];;
                            
            if(!empty($dis_amt[0][$current_product_id])) {
                if(get_option('woocommerce_currency_pos') == 'left' || get_option('woocommerce_currency_pos') == 'left_space'){
                    if($dis_type[0][$current_product_id] == "percentage") {
                        $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                    }else if($dis_type[0][$current_product_id] == "fixed") {
                        $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.get_woocommerce_currency_symbol().$dis_amt[0][$current_product_id].'</span></div>';
                    }
                }else{
                    if($dis_type[0][$current_product_id] == "percentage") {
                        $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].' %</span></div>';
                    }else if($dis_type[0][$current_product_id] == "fixed") {
                        $badge = '<div class="fbtpfw_badge" style="border:2px solid '.$discount_badge_back_color.';"><span style="color:'.$discount_badge_text_color.';background:'.$discount_badge_back_color.';"><p>off</p>- '.$dis_amt[0][$current_product_id].get_woocommerce_currency_symbol(). '</span></div>';
                    }
                }
            }

            if($occp_badge == 'true') {
                $badge = $badge;
            } else {
                $badge = '';
            }

            $images .= '<td class="fbtpfw_img" image_pro_id="'.$current_product_id.'"><div class="fbtpfw_img_div"><a href="' . $current_product_link . '">' . $current_product_image . '</a>'.$badge.'</div></td>';

            if( $count < $occp_count ) {
                $isimplfirst = '';
                if($count == 0) {
                    $isimplfirst = 'fbtpfw_img_plus_first';
                }
                $images .= '<td class="fbtpfw_img_plus '.$isimplfirst.'" fbtpfw_imgpls_id="'.$current_product_id.'">+</td>';
            }
           
            ob_start();
            $check_default_pro = $fbtpfw_comman['check_default_pro'];
            ?>
            <li class="fbtpfw_each_item">
                <input type="checkbox" name="proID[]" id="proID_<?php echo esc_attr($count) ?>" class="product_check" value="<?php echo esc_attr($current_product_id); ?>" price="<?php echo esc_attr($current_product_exact_price); ?>" <?php if($count == 0) { echo 'checked style="opacity: .6;pointer-events: none;"'; }elseif($check_default_pro == 'yes'){echo "checked";} ?> />
                <span class="fbtpfw_product_title">
                    <?php $this_item_text = $fbtpfw_comman['this_item_text'];  ?>
                    <?php
                    if($count == 0) {
                        echo esc_attr($this_item_text.' : '.$current_product_title);
                    } else {
                        echo '<a href="'.esc_url($current_product_link).'">'.esc_attr($current_product_title).'</a>';
                    }
                    ?>
                </span>
                <?php
                    if( $current_product_is_variation ) {
                        $attributes = $product->get_variation_attributes();
                        $variations = array();

                        foreach( $attributes as $key => $attribute ) {
                            $variations[] = $attribute;
                        }

                        if( ! empty( $variations ) ){
                            echo '<span class="product-attributes"> &ndash; ' . esc_attr(implode( ', ', $variations )) . '</span>';
                        }

                    }
                   
                    if(!empty($product->get_price())) { 
                        $price = wc_price($product->get_price()); 
                    }else { 
                        $price = wc_price(0);
                    }
                    if(!empty($product->get_sale_price())) { 
                        $price = wc_price($product->get_regular_price()); 
                    }elseif(!empty($current_product_exact_price)){
                        $price = wc_price($product->get_regular_price()); 
                    }else { 
                        $price = "";
                    }
                    $regular_price_color =$fbtpfw_comman['regular_price_color'];
                    echo ' &ndash; <span class="fbtpfw_price_old">' . $price . '</span><span class="fbtpfw_price_new" style="color:'.esc_attr($regular_price_color).';">('. wc_price($current_product_exact_price) .')</span>';

                    $productaaaaa = wc_get_product( get_the_ID() );
                    if($productaaaaa->get_type() == 'variable'){
                        $attributesqwqww = $productaaaaa->get_variation_attributes();
                        $available_variations = $productaaaaa->get_available_variations();
                        if( $current_product_is_variation ) {
                            if ( is_array( $attributesqwqww ) && ( count( $attributesqwqww ) > 0 ) ) {
                                echo "<div class='oc_cust_variation' currentproid=".get_the_id().">";

                                if ( is_array( $attributes ) && ( count( $attributes ) > 0 ) ) {
                                    echo '<div class="variations_form" data-product_id="' . absint( get_the_id() ) . '" data-product_variations="' . htmlspecialchars( wp_json_encode( $available_variations ) ) . '">';
                                    echo '<div class="variations">';
                                    foreach ( $attributesqwqww as $attribute_name => $options ) { ?>
                                        <div class="variation">
                                            <div class="label">
                                                <?php echo wc_attribute_label( $attribute_name ); ?>
                                            </div>
                                            <div class="select">
                                                <?php
                                                $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $productaaaaa->get_variation_default_attribute( $attribute_name );
                                                    wc_dropdown_variation_attribute_options( array(
                                                        'options'          => $options,
                                                        'attribute'        => $attribute_name,
                                                        'product'          => $productaaaaa,
                                                        'selected'         => $selected,
                                                    ) );
                                                ?>
                                            </div>
                                        </div>
                                    <?php }
                                    echo '<div class="reset">' . apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' .fbtpfw_localization( 'clear', esc_html__( 'Clear', 'woo-bought-together' ) ) . '</a>' ) . '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo "</div>";
                                }
                            }
                        }
                    }
                ?>
            </li>
            <?php
            $product_details .= ob_get_clean();
            // increment total
            $total += floatval( $current_product_exact_price );
            $badge = '';
            $count++;
        }
        ?>
        <input type="hidden" name="formate" value="<?php echo esc_attr(get_woocommerce_currency_symbol()); ?>" class="formate">
        <input type="hidden" name="layout" value="layout2" class="layout">
        <div class="fbtpfw_main layout2">
            <form class="fbtpfw_product_form" method="post" action="">
                <?php $fbtpfw_product_color = $fbtpfw_comman['fbtpfw_product_color']; ?>
                <h3 style="color:<?php echo esc_attr($fbtpfw_product_color); ?>" ><?php echo esc_attr(get_post_meta( get_the_ID(), 'occp_head_txt', true )); ?></h3>
                <table class="fbtpfw_product_images">
                    <tbody>
                        <tr>
                            <?php echo esc_attr($images);?>
                            
                        </tr>
                    </tbody>
                </table>
                <div class="fbtpfw_cart_div">
                    <div class="fbtpfw_price">
                         <?php $addtional_amount_text_color = $fbtpfw_comman['addtional_amount_text_color']; ?>
                        <span class="fbtpfw_price_label" style="color:<?php echo esc_attr($addtional_amount_text_color);  ?>">
                            <?php $price_for_all_text = $fbtpfw_comman['price_for_all_text']; ?>
                            <?php echo esc_attr($price_for_all_text)." : "; 
                            ?>
                        </span>
                        &nbsp;
                        <span class="fbtpfw_price_total" data-total="<?php echo esc_attr($total); ?>">
                            <?php echo wc_price( $total ); ?>
                        </span>
                    </div>
                    <?php $add_to_cart_text = $fbtpfw_comman['add_to_cart_text']; ?>
                    <?php $add_cart_back_color =  $fbtpfw_comman['add_cart_back_color']; ?>
                    <?php $add_cart_text_color = $fbtpfw_comman['add_cart_text_color']; ?>
                    <input type="submit" style="color:<?php echo esc_attr($add_cart_text_color); ?>;background: <?php echo esc_attr($add_cart_back_color); ?>" class="occp_add_cart_button button" value="<?php echo esc_attr($add_to_cart_text); ?>" name="occp_add_to_cart">
                </div> 

                <ul class="fbtpfw_ul">
                    <?php echo $product_details;?>
                </ul>        
            </form>
        </div>
        <?php
        }
        $content = ob_get_clean();
        return $content;
}


function fbtpfw_get_price($price, $discount, $discount_type) {
	if(empty($price)){
		$price = 0;
	}else{
		if(empty($discount)) {
			$price = $price;
		}else{
			if($discount_type == "percentage") {
    			$price = $price - ( $price * $discount / 100 );
    		} else {
    			$price = $price - $discount;
    		}
		}
	}
	return $price;
}


add_filter( 'woocommerce_add_cart_item_data',  'fbtpfw_add_cart_item_data', 10, 3 );
function fbtpfw_add_cart_item_data( $cart_item_data, $product_id ) {
    if(isset($_POST['proID']) && !empty($_POST['proID'])) {
        $fbtpfw_combo_ids =  fbtpfw_recursive_sanitize_text_field($_POST['proID']);
    }
    
    if( empty( $fbtpfw_combo_ids ) ) {
        return;
    }
    
    if ( ! empty( $fbtpfw_combo_ids ) ) {
        $cart_item_data['combo_ids'] = $fbtpfw_combo_ids;
    }

    return $cart_item_data;
}


/*add to cart for layout1*/
add_action( 'woocommerce_add_to_cart', 'fbtpfw_add_to_cart' , 10, 6 );
function fbtpfw_add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
	
    if ( isset( $cart_item_data['combo_ids'] ) && $cart_item_data['combo_ids'] != '' ) {

        $fbtpfwitems = $cart_item_data['combo_ids'];

        remove_action( 'woocommerce_add_to_cart', 'fbtpfw_add_to_cart', 10, 6 );

        foreach ($fbtpfwitems as $keya => $valuea) {
            $occp_product = wc_get_product( $valuea );
            if ( $occp_product && $occp_product->is_in_stock() && $occp_product->is_purchasable() ) {
                $cart_item_keya = WC()->cart->add_to_cart($valuea, 1, 0, array(), array("fbtpfw_parent_id" => $product_id, "fbtpfw_parent_key" => $cart_item_key) );
                if ( $cart_item_keya ) {
                    WC()->cart->cart_contents[ $cart_item_key ]['fbtpfw_child_keys'][] = $cart_item_keya;
                }
            }
        }
    }
}


/*add to cart for layout2 and shortcode*/
add_action( 'template_redirect',  'fbtpfw_iconic_add_to_cart' );
function fbtpfw_iconic_add_to_cart() {
    global $woocommerce;
    $occp_main_id = get_the_ID();

    if(isset($_REQUEST['occp_add_to_cart'])) {

        $product_cust = fbtpfw_recursive_sanitize_text_field( $_POST['proID'] );
        $linked_prods = fbtpfw_recursive_sanitize_text_field( $_POST['proID'] );
		if( empty( $product_cust ) ) {
            return;
        }
        
        // array_unshift($product_cust, $occp_main_id);

        remove_action( 'woocommerce_add_to_cart', 'fbtpfw_add_to_cart', 10, 6 );
            
        $fbtpfw_parent_key = '';
        $fbtpfw_child_keys = array();

        $count_pro = 0;
        foreach( $product_cust as $id ) {
            $occp_product = wc_get_product( $id );

            if($occp_product->get_type() == 'variation' && $count_pro == 0){
                $fbtpfw_parent_key = WC()->cart->add_to_cart( $occp_main_id, 1, $id, get_post_meta($id,'attr_cus',true) );
            }else{

                if($id == $occp_main_id) {
                	$custom_data = array(
	                    				"fbtpfw_ids" => $linked_prods,
	                    			);
                } else {
                	$custom_data = array(
	                    				"fbtpfw_parent_id" => $occp_main_id
	                    			);
                }

                if ( $occp_product && $occp_product->is_in_stock() && $occp_product->is_purchasable() ) {
                    if($id == $occp_main_id ) {
                        $fbtpfw_parent_key = WC()->cart->add_to_cart( $id, 1, 0, array(), $custom_data );
                    } else {
                        $custom_data['fbtpfw_parent_key'] = $fbtpfw_parent_key;
                        $fbtpfw_child_keys[] = WC()->cart->add_to_cart( $id, 1, 0, array(), $custom_data );
                    }
                }
            }
            $count_pro++;
        }
        
        if ( !empty($fbtpfw_child_keys) ) {
            $woocommerce->cart->cart_contents[$fbtpfw_parent_key]['fbtpfw_child_keys'] = $fbtpfw_child_keys;
            $woocommerce->cart->set_session();
        }

        $cart_url = $woocommerce->cart->get_cart_url();
        wp_redirect( $cart_url );
        exit;
    }
}


/*set price discount wise*/
add_action( 'woocommerce_before_calculate_totals', 'fbtpfw_custom_price_to_cart_item' , 99 );
function fbtpfw_custom_price_to_cart_item( $cart_object ) {

    if( !WC()->session->__isset( "reload_checkout" )) {

        foreach ( $cart_object->get_cart() as $key => $value ) {
    
            if( isset( $value["fbtpfw_parent_id"] ) ) {
                
                $product_id = $value['data']->get_id();
                $ID = $value["fbtpfw_parent_id"];
                $product = get_post_meta( $ID, 'occp_select2', true );
                $fbtpfw_discunt = get_post_meta( $ID, 'occp_off_per', true );
                $fbtpfw_discunt_type = get_post_meta( $ID, 'occp_discount_type', true );
                
                $product = wc_get_product( $product_id );
                $price = $product->get_price();
                
                if(!empty($fbtpfw_discunt[$product_id])){
                	$fbtpfw_discount = $fbtpfw_discunt[$product_id];
                }
                
                if(!empty($fbtpfw_discunt_type[$product_id])){
                	$fbtpfw_discount_type = $fbtpfw_discunt_type[$product_id];
                }
                
                if(isset($fbtpfw_discount) && isset($fbtpfw_discount_type)) {

                	$fbtpfw_exact_price = fbtpfw_get_price($price, $fbtpfw_discount, $fbtpfw_discount_type);
                    
                	$value['data']->set_price( $fbtpfw_exact_price );
                }
            }
        } 
    }   
}


add_filter( 'woocommerce_cart_item_name', 'fbtpfw_bought_together_item_name', 10, 2 );
add_filter( 'woocommerce_order_item_name', 'fbtpfw_bought_together_item_name', 10, 2 );
function fbtpfw_bought_together_item_name( $item_name, $item ) {

    if ( isset( $item['fbtpfw_parent_id'] ) && ! empty( $item['fbtpfw_parent_id'] ) ) {

        $occp_btassociated_txt = get_post_meta( $item['fbtpfw_parent_id'], 'occp_btassociated_txt', true );

        if($occp_btassociated_txt != '') {
            $fbtpfw_btogether_text = esc_html__( $occp_btassociated_txt, 'fbtpfw' );
        } else {
            $fbtpfw_btogether_text = esc_html__( '(bought together %s)', 'fbtpfw' );
        }

        if ( strpos( $item_name, '</a>' ) !== false ) {
            $name = sprintf( $fbtpfw_btogether_text, '<a href="' . get_permalink( $item['fbtpfw_parent_id'] ) . '">' . get_the_title( $item['fbtpfw_parent_id'] ) . '</a>' );
        } else {
            $name = sprintf( $fbtpfw_btogether_text, get_the_title( $item['fbtpfw_parent_id'] ) );
        }

        $item_name .= ' <span class="fbtpfw_parent_name">' . apply_filters( 'fbtpfw_parent_name', $name, $item ) . '</span>';
    }

    return $item_name;
}

function  fbtpfw_inita(){
    global $fbtpfw_comman;
    $cart_change_qty = $fbtpfw_comman['cart_change_qty'];
    if ($cart_change_qty == 'no') {
        add_filter( 'woocommerce_cart_item_quantity',  'fbtpfw_cart_item_quantity', 10, 3 );
    } 
}
add_action('init', 'fbtpfw_inita');

function fbtpfw_cart_item_quantity($product_quantity, $cart_item_key, $cart_item){
    if( is_cart() ){
        if (isset($cart_item['fbtpfw_parent_id'])) {
        // code...
            // echo $cart_item['fbtpfw_parent_id'];
            $product_quantity = sprintf(
                '%2$s <input type="hidden" name="cart[%1$s][qty]" value="%2$s" />',
                $cart_item_key,
                $cart_item['quantity']
            );
        }
    }
    return $product_quantity;
}


add_action( 'woocommerce_cart_item_removed', 'fbtpfw_cart_item_removed' , 10, 2 );
function fbtpfw_cart_item_removed( $cart_item_key, $cart ) {
    if ( isset( $cart->removed_cart_contents[ $cart_item_key ]['fbtpfw_child_keys'] ) ) {
        $keys = $cart->removed_cart_contents[ $cart_item_key ]['fbtpfw_child_keys'];
        foreach ( $keys as $key ) {
            unset( $cart->cart_contents[ $key ] );
        }
    }
}

    
 