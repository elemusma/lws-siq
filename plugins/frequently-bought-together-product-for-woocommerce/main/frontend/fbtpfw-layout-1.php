<?php
function fbtpfw_layout1() {
      global $fbtpfw_comman;
            $product = get_post_meta( get_the_ID(), 'occp_select2', true );

            if (empty($product)) {
                $pro_id = get_the_ID();
                echo relared_upsells_common_func($pro_id);
            }

            $occp_discunt = get_post_meta( get_the_ID(), 'occp_off_per', true );
            $occp_discunt_type = get_post_meta( get_the_ID(), 'occp_discount_type', true );
            if(empty($product)) {
              return;
            }
            $main_product = wc_get_product( get_the_ID() );
            array_unshift($product, get_the_ID());
            $count  = 0; 
            $badge ='';
            $product_details = '';
            $total= 0;
            $images = '';
            foreach ($product as $productId) {
                $product = wc_get_product( $productId );

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