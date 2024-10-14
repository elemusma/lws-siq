<?php
function fbtpfw_layout2() {
       global $fbtpfw_comman;
            $product = get_post_meta( get_the_ID(), 'occp_select2', true );

            if (empty($product)) {
                $pro_id = get_the_ID();
                echo relared_upsells_common_func($pro_id);
            }

            $occp_count = count((array)$product);
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