<?php

namespace Wpexperts\TierPricingForWoocommerce\Frontend;

use Wpexperts\TierPricingForWoocommerce\Helper;
use WCPay\MultiCurrency\MultiCurrency;
use WCPay\MultiCurrency\Utils;
use WCPay\MultiCurrency\Compatibility;

class WooTierPricingFrontend { 
	public $helper;
	public function __construct() { 
	   
		require_once ABSPATH . 'wp-includes/pluggable.php' ;
		if ( 'enabled' === get_option( 'wtp_hide_price', 'disabled' ) && ! is_user_logged_in()  ) {
			add_filter( 'woocommerce_get_price_html', array( $this, 'wtp_hide_price_addcart_not_logged_in' ), 9999, 2 );
			add_filter( 'woocommerce_subscription_price_string', array( $this, 'woocommerce_subscription_price_string_removed' ), 999, 2 );
			add_filter( 'woocommerce_subscriptions_product_price_string', array( $this, 'woocommerce_subscription_price_string_removed' ), 999, 2 );    
		} else {
			// Calculate price during adding to cart.
			add_action( 'woocommerce_before_calculate_totals', array( $this, 'wtp_product_alter_price_cart' ) );

			if ( 'enabled' === get_option( 'wtp_tier_range_price_show', 'disabled' ) && ! is_admin() ) {        
				add_filter( 'woocommerce_get_price_html', array( $this, 'wtp_tier_price_range' ), 99, 2 );
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'wtp_front_scripts' ) );

			add_action( 'wp_ajax_wtp_calculate_summary', array( $this, 'wtp_calculate_summary' ) );
			add_action( 'wp_ajax_nopriv_wtp_calculate_summary', array( $this, 'wtp_calculate_summary' ) );
			// Customization setting is for tooltip
			if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) ) {
				add_filter( 'woocommerce_get_price_html', array( $this, 'add_tooltip_for_tier_price' ), 999, 2 );
			}
			
			add_action( get_option( 'wtp_table_position', 'woocommerce_before_add_to_cart_button' ), array( $this, 'wtp_product_discount_list_preview' ), 99 );

			// Show discount list for variation product on selection of each variation via ajax
			add_action( 'wp_ajax_wtp_show_discount_list_product_variation', array( $this, 'wtp_show_discount_list_product_variation' ), 10 );
			add_action( 'wp_ajax_nopriv_wtp_show_discount_list_product_variation', array( $this, 'wtp_show_discount_list_product_variation' ), 10 );

			add_action( 'init', function () {
				woocommerce_store_api_register_update_callback(array(
					'namespace' => 'wtp',
					'callback'  => function ( $data ) { },
				));
			});

			add_filter( 'woocommerce_cart_item_price', array( $this, 'wtp_change_cart_table_price_display' ), 999, 3 );

		}
	}

	public function wtp_change_cart_table_price_display( $price, $cart_item, $cart_item_key ) {
	
		$slashed_price = $cart_item['data']->get_regular_price();
		$product      = $cart_item['data'];
		$product_id   = $cart_item['product_id'];
		$price        = get_post_meta( $product_id, '_price', true );
		if ( $product->is_type( 'variation' ) ) {
			if ( ! empty( $product->get_ID() ) ) {
				$variation_id = $product->get_ID();
				$price        = get_post_meta( $variation_id, '_price', true );
			}
		}

		$tier_post    = Helper::get_active_last_tier_post();
		$quantity     = $cart_item['quantity'];
		$new_price    = (string) $this->wtp_calculator_product( $product_id, $price, $quantity );
		if ( ! empty( $tier_post ) ) {
			$post_id = $tier_post->ID;
			$tier_type = get_post_meta( $post_id, 'wtp_tier_type', true );
			if ( '' != $new_price ) {
				$unit_price = $new_price;
				if ( 'tier_range' != $tier_type ) {
					$unit_price = $new_price / $quantity;
				}
				$price = sprintf( '<del>%s</del> <ins>%s</ins>', wc_price( $slashed_price ), wc_price( $unit_price ) );
			}
			
		}

		return $price;
	}

	public function wtp_show_discount_list_product_variation() {
		check_ajax_referer('wtp_front', 'nonce');
		if ( isset( $_POST['variation_id'] ) && ! empty( $_POST['variation_id'] ) ) {

			if ( class_exists( 'WC_Payments' ) ) {
				$multiCurrency = MultiCurrency::instance();
				$utils = new Utils();
				$compatibility = new Compatibility($multiCurrency, $utils);
			}

			$variation_id = sanitize_text_field( $_POST['variation_id'] );
			$variation    = wc_get_product( $variation_id );
			$product_id   = $variation->get_parent_id();
			$product      = wc_get_product( $product_id );
			$tier_post    = Helper::get_active_last_tier_post();
			$user         = wp_get_current_user();
			$price        = $variation->get_price();
			$currency_code = '';
			$html         = '';
			if ( ! empty( $user ) && $user->ID > 0 ) {
				$current_user_id   = $user->ID;
				$current_user_role = implode( ',', $user->roles );
			} else {
				$current_user_id   = 0;
				$current_user_role = '';
			}

			if ( ! empty( $tier_post ) ) {

				if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) ) {
					$html .= '<li class="wtp-table-head">
                        <span>' . esc_html( get_option( 'wtp_qty_col_text', 'Quantity' ) ) . '</span>
                        <span>' . esc_html( get_option( 'wtp_price_col_text', 'Price' ) ) . '</span>';

					if ( 'enabled' === get_option( 'wtp_show_discount_col', 'disabled' ) ) {
						$html .= '<span>' . esc_html( get_option( 'wtp_discount_col_text', 'Discount' ) ) . '</span>';
					}

					$html .= '</li>';
				}

				$post_id = $tier_post->ID;
							   
				$tier_type = get_post_meta( $post_id, 'wtp_tier_type', true );
				$is_available_enable = false;
				if ( 'tier_range' == $tier_type ) { 
					$rules = get_post_meta( $post_id, 'wtp_tier_clone', true );
					foreach ( $rules as $key => $value ) {
						if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
							continue;
						}

						$is_available_enable = true;
						$min_qty        = ( ! empty( $value['wtp_min_qty'] ) && $value['wtp_min_qty'] > 0 ) ? $value['wtp_min_qty'] : 1;
						$max_qty        = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty'] >= $min_qty ) ? $value['wtp_max_qty'] : -1;
						$show_max_qty        = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty'] >= $min_qty ) ? $value['wtp_max_qty'] : '&#8734;';
						$discount_type  = ! empty( $value['wtp_discount_type'] ) ? $value['wtp_discount_type'] : 'fix';
						$discount_value = ! empty( $value['wtp_discount_value'] ) ? $value['wtp_discount_value'] : 0;
				
						if ( 'percent' == $discount_type ) {
							$discount_value = ( $price - ( $discount_value / 100 ) * $price );
						} else { // fixed
							$discount_value = ( $price - $discount_value );
						}

						if ( class_exists( 'WC_Payments' ) && $compatibility->should_convert_product_price( $product ) ) {
							$currency   = $multiCurrency->get_selected_currency();
							$currency_code = $currency->code;
							$discount_value = $discount_value * $currency->rate;
						}

						$discount_value = ( $discount_value >= 0 ) ? $discount_value : 0;
						if ( 'incl' == get_option( 'woocommerce_tax_display_shop' ) ) {
							$discount_value = wc_get_price_including_tax( $variation, array( 'price' => $discount_value ) );
						}

						$html .= '<li data-min="' . esc_attr( $min_qty ) . '" data-max="' . esc_attr( $max_qty ) . '" data-price="' . esc_attr( $discount_value ) . '">';
						/**
						 * Filter wtp_change_tier_label
						 * 
						 * @since 1.0
						**/
						$html .= '<span class="ma-quantity-range">' . esc_html__( get_option( 'wtp_item_text', 'Pcs'), 'wtp' ) . ' ' . esc_attr( $min_qty ) . ' - ' . esc_attr( $show_max_qty ) . '</span>';
						$html .= '<span class="pre-inquiry-price">' . wc_price( $discount_value, array( 'currency' => $currency_code ) ) . '</span>';

						if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) && 'enabled' === get_option( 'wtp_show_discount_col', 'disabled' ) ) {
							$show_discount_percentage = 100 - ( ( $discount_value / $price ) * 100 );
							$html                    .= '<span>' . sprintf( '%1$s%2$s', esc_attr( number_format( $show_discount_percentage, 2 ) ), esc_html__( '% OFF', 'wtp' ) ) . '</span>';
						}

						$html .= '</li>';
					}
				} else {
					$tier_select = get_post_meta( $post_id, 'wtp_rule_fix_select', true );
					if ( 'tier_fix_rule' == $tier_select ) {
						$rules = get_post_meta( $post_id, 'wtp_tier_fix_clone', true );
						foreach ( $rules as $key => $value ) {

							if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
								continue;
							}
							
							$is_available_enable = true;
							$set_qty        = ( ! empty( $value['wtp_set_qty'] ) && $value['wtp_set_qty'] > 0 ) ? $value['wtp_set_qty'] : 1;
							$value        = ! empty( $value['wtp_value'] ) ? $value['wtp_value'] : 0;
							$discount_value = ( $value >= 0 ) ? $value : 0;

							if ( class_exists( 'WC_Payments' ) && $compatibility->should_convert_product_price( $product ) ) {
								$currency   = $multiCurrency->get_selected_currency();
								$currency_code = $currency->code;
								$discount_value = $discount_value * $currency->rate;
							}

							if ( 'incl' == get_option( 'woocommerce_tax_display_shop' ) ) {
								$discount_value = wc_get_price_including_tax( $variation, array( 'price' => $discount_value ) );
							}
							$html .= '<li data-set="' . esc_attr( $set_qty  ) . '" data-price="' . esc_attr( $discount_value ) . '">';
							/**
							 * Filter wtp_change_tier_label
							 * 
							 * @since 1.0
							**/
							$html .= '<span class="ma-quantity-range">' . esc_html__( get_option( 'wtp_item_text', 'Pcs'), 'wtp' ) . ' ' . esc_attr( $set_qty ) . '</span>';
							$html .= '<span class="pre-inquiry-price">' . wc_price( $discount_value, array( 'currency' => $currency_code ) ) . '</span>';

							if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) && 'enabled' === get_option( 'wtp_show_discount_col', 'disabled' ) ) {
								$show_discount_percentage = 100 - ( ( $discount_value / $price ) * 100 );
								$html                    .= '<span>' . sprintf( '%1$s%2$s', esc_attr( number_format( $show_discount_percentage, 2 ) ), esc_html__( '% OFF', 'wtp' ) ) . '</span>';
							}

							$html .= '</li>';
						}
					} else {
						$rules = get_post_meta( $post_id, 'wtp_tier_qty_clone', true );
						foreach ( $rules as $key => $value ) {

							if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
								continue;
							}

							$is_available_enable = true;
							$min_qty        = ( ! empty( $value['wtp_min_qty'] ) && $value['wtp_min_qty'] > 0 ) ? $value['wtp_min_qty'] : 1;
							$max_qty        = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty'] > 0 ) ? $value['wtp_max_qty'] : -1;
							$show_max_qty   = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty'] >= $min_qty ) ? $value['wtp_max_qty'] : '&#8734;';
							$value        = ! empty( $value['wtp_value'] ) ? $value['wtp_value'] : 0;

							$discount_value = ( $value >= 0 ) ? $value : 0;

							if ( class_exists( 'WC_Payments' ) && $compatibility->should_convert_product_price( $product ) ) {
								$currency   = $multiCurrency->get_selected_currency();
								$currency_code = $currency->code;
								$discount_value = $discount_value * $currency->rate;
							}

							if ( 'incl' == get_option( 'woocommerce_tax_display_shop' ) ) {
								$discount_value = wc_get_price_including_tax( $variation, array( 'price' => $discount_value ) );
							}

							$html .= '<li data-min="' . esc_attr( $min_qty ) . '" data-max="' . esc_attr( $max_qty ) . '" data-price="' . esc_attr( $discount_value ) . '">';
							/**
							 * Filter wtp_change_tier_label
							 * 
							 * @since 1.0
							**/
							$html .= '<span class="ma-quantity-range">' . esc_html__( get_option( 'wtp_item_text', 'Pcs'), 'wtp' ) . ' ' . esc_attr( $min_qty ) . ' - ' . esc_attr( $show_max_qty ) . '</span>';
							$html .= '<span class="pre-inquiry-price">' . wc_price( $discount_value, array( 'currency' => $currency_code ) ) . '</span>';

							if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) && 'enabled' === get_option( 'wtp_show_discount_col', 'disabled' ) ) {
								$show_discount_percentage = 100 - ( ( $discount_value / $price ) * 100 );
								$html                    .= '<span>' . sprintf( '%1$s%2$s', esc_attr( number_format( $show_discount_percentage, 2 ) ), esc_html__( '% OFF', 'wtp' ) ) . '</span>';
							}

							$html .= '</li>';
						}
					}
				}

				if ( $is_available_enable ) {

					$status['html'] = $html;
					echo json_encode( $status );
					wp_die();
				}
			}
		}
	}

	public function wtp_tier_price_range( $price, $product ) {

		$product_id   = $product->get_id();
		$price = (int) $product->get_price();
		$user = wp_get_current_user();
		if ( ! empty( $user ) && $user->ID > 0 ) {
			$current_user_id   = $user->ID;
			$current_user_role = implode( ',', $user->roles );
		} else {
			$current_user_id   = 0;
			$current_user_role = '';
		}

		$tier_post = Helper::get_active_last_tier_post();

		if ( $tier_post ) {
		
			$post_id = $tier_post->ID;
			$tier_type = get_post_meta( $post_id, 'wtp_tier_type', true );
			$data_price = array();
			if ( 'tier_range' == $tier_type ) { 

				$rules = get_post_meta( $post_id, 'wtp_tier_clone', true );
				if ( ! empty ( $rules ) ) {
					
					foreach ( $rules as $key => $value ) {

						if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
							continue;
						}

						$min_qty        = ( ! empty( $value['wtp_min_qty'] ) && $value['wtp_min_qty'] > 0 ) ? $value['wtp_min_qty'] : 1;
						$discount_type  = ! empty( $value['wtp_discount_type'] ) ? $value['wtp_discount_type'] : 'fix';
						$discount_value = ! empty( $value['wtp_discount_value'] ) ? $value['wtp_discount_value'] : 0;

						if ( 'percent' == $discount_type ) {
							$discount_value = ( $price - ( $discount_value / 100 ) * $price );
						} else { // fixed
							$discount_value = ( $price - $discount_value );
						}
						
						$discount_value = ( $discount_value >= 0 ) ? $discount_value : 0;

						if ( 'incl' == get_option( 'woocommerce_tax_display_shop' ) ) {
							$price = wc_get_price_including_tax( $product, array( 'price' => $price ) );
							$discount_value = wc_get_price_including_tax( $product, array( 'price' => $discount_value ) );

						} elseif ( 'excl' == get_option( 'woocommerce_tax_display_shop' ) ) {
							$price = wc_get_price_excluding_tax( $product, array( 'price' => $price ) );
							$discount_value = wc_get_price_excluding_tax( $product, array( 'price' => $discount_value ) );

						}

						$data_price[] = $discount_value;
					}

					if ( ! empty( $data_price ) ) {

						$min_price = min( $data_price );

						if ( 'low_high' == get_option( 'wtp_display_tier_price_range', 'low_high' ) ) {
							return wc_price( $min_price ) . ' - ' . wc_price( $price );
						} else {
							return wc_price( $price ) . ' - ' . wc_price( $min_price );
						}

					}
				}
			} else {
				$tier_select = get_post_meta( $post_id, 'wtp_rule_fix_select', true );
				if ( 'tier_fix_rule' == $tier_select ) {
					$rules = get_post_meta( $post_id, 'wtp_tier_fix_clone', true );
					
					$prices = array();
					$flag = false;
					foreach ( $rules as $key => $values ) {
					   
						if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
							continue;
						}
						$flag = true;

						$value        = ! empty( $values['wtp_value'] ) ? $values['wtp_value'] : 0;
						$prices[] = $value;
						$discount_value = ( $value >= 0 ) ? $value : 0;
						 
					}
					if ( $flag ) {
						$min_price = ( ! empty( $prices ) && is_array( $prices ) ) ? min( $prices ) : 0;
						$max_price = ( ! empty( $prices ) && $price < max( $prices ) ) ? max( $prices ) : $price;

						if ( 'incl' == get_option( 'woocommerce_tax_display_shop' ) ) {
							$max_price = wc_get_price_including_tax( $product, array( 'price' => $max_price ) );
						} elseif ( 'excl' == get_option( 'woocommerce_tax_display_shop' ) ) {
							$max_price = wc_get_price_excluding_tax( $product, array( 'price' => $max_price ) );
							$min_price = wc_get_price_excluding_tax( $product, array( 'price' => $min_price ) );
						}

						if ( 'low_high' == get_option( 'wtp_display_tier_price_range', 'low_high' ) ) {
							return wc_price( $min_price ) . ' - ' . wc_price( $max_price );
						} else {
							return wc_price( $max_price ) . ' - ' . wc_price( $min_price );
						}
					}
				} else {
					$rules = get_post_meta( $post_id, 'wtp_tier_qty_clone', true );
					$prices = array();
					$flag = false;
					foreach ( $rules as $value ) {

						if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
							continue;
						}
						$flag = true;

						$value        = ! empty( $value['wtp_value'] ) ? $value['wtp_value'] : 0;
						$prices[] = $value;
						$discount_value = ( $value >= 0 ) ? $value : 0;
 
					}

					if ( $flag ) {
						$min_price = ( ! empty( $prices ) && is_array( $prices ) ) ? min( $prices ) : 0;
						$max_price = ( ! empty( $prices ) && $price < max( $prices ) ) ? max( $prices ) : $price;

						if ( 'incl' == get_option( 'woocommerce_tax_display_shop' ) ) {
							$max_price = wc_get_price_including_tax( $product, array( 'price' => $max_price ) );
						} elseif ( 'excl' == get_option( 'woocommerce_tax_display_shop' ) ) {
							$max_price = wc_get_price_excluding_tax( $product, array( 'price' => $max_price ) );
							$min_price = wc_get_price_excluding_tax( $product, array( 'price' => $min_price ) );
						}
						
						if ( 'low_high' == get_option( 'wtp_display_tier_price_range', 'low_high' ) ) {
							return wc_price( $min_price ) . ' - ' . wc_price( $max_price );
						} else {
							return wc_price( $max_price ) . ' - ' . wc_price( $min_price );
						}
					}
				}
			}
		}
		return wc_price( $price );
	}


	public  function wtp_calculate_summary() {

		if ( isset( $_POST['_wtp_nonce'] ) ) {
			check_ajax_referer('_wtp_nonce', '_wtp_nonce');
		}

		$result = array();

		if ( isset( $_POST['price'] ) && isset( $_POST['qty'] ) ) {
			
			$unit_price = sanitize_text_field( $_POST['price'] );
			$qty        = sanitize_text_field( $_POST['qty'] );
			$type       = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : 'range';
			if ( 'range' != $type ) {
				$unit_price = $unit_price / $qty;
			}
			$subtotal = $qty * $unit_price;
			$result['price']    = $this->wtp_price( $unit_price );
			$result['subtotal'] = $this->wtp_price( $subtotal );
		}

		echo json_encode( $result );
		wp_die();
	}

	public function wtp_front_scripts() { 
		global $post;
		if ( isset( $post ) && 'product' === $post->post_type ) {
			// frontend style enqueuing for product page only.

			?>
			<style>
				:root {
					--wtp-border-color: <?php echo esc_attr( get_option( 'wtp_tooltip_icon_color', '#000' ) ); ?>;
					--wtp-active-color: <?php echo esc_attr( get_option( 'wtp_active_price_bg_color', '#ddd' ) ); ?>;
				}

				<?php
				if ( 'enabled' === get_option( 'wtp_tooltip_border', 'disabled' ) ) {
					?>
					.tippy-box {
						border:  1px solid var(--wtp-border-color)!important;
						border-radius:  4px;
					}
					<?php
				}
				?>
			</style>
			<?php

			wp_enqueue_style( 'wtp-front-style', WTP_ROOT_URL . 'assets/css/front/front-style.css', array(), '1.0.0' );
			wp_enqueue_script( 'wtp-tippy-popper', WTP_ROOT_URL . 'assets/js/front/popper.js', array( 'jquery' ), WTP_VERSION, true );
			wp_enqueue_script( 'wtp-tippy', WTP_ROOT_URL . 'assets/js/front/tippy.js', array( 'jquery', 'wtp-tippy-popper' ), WTP_VERSION, true );

			$params = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'wtp_front' ),
				'summary' => get_option( 'wtp_summary_display_type', 'none' ),
			);

			wp_register_script( 'wtp-front-script', WTP_ROOT_URL . 'assets/js/front/front-script.js', array( 'jquery', 'wtp-tippy' ), WTP_VERSION, true );
			wp_localize_script( 'wtp-front-script', 'wtp_front_script', $params );
			wp_enqueue_script('wtp-front-script');

		}
		wp_register_script( 'wtp-front-block', WTP_ROOT_URL . 'assets/js/front/cart-block.js', array( 'jquery' ), WTP_VERSION, true );
		wp_enqueue_script( 'wtp-front-block' );
	}

	public function wtp_product_discount_list_preview() {
		
		$product    = wc_get_product( get_the_id() );    
		$product_id = $product->get_id();
		$tier_post = Helper::get_active_last_tier_post();
		$user      = wp_get_current_user();

		if ( ! empty( $user ) && $user->ID > 0 ) {
			$current_user_id   = $user->ID;
			$current_user_role = implode( ',', $user->roles );
		} else {
			$current_user_id   = 0;
			$current_user_role = '';
		}

		if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) ) {
			$hide_class = 'wtp-hide';
		} else {
			$hide_class = '';
		}

		if ( 'woocommerce_before_single_product_summary' == get_option( 'wtp_table_position', 'woocommerce_before_add_to_cart_button' ) ) {
			$style = 'display: flex';
		} else {
			$style = '';
		}

		if ( ! ( 'grouped' == $product->get_type() ) && ! ( 'variable' == $product->get_type() ) && ! ( 'variation' == $product->get_type() ) && ! ( 'variable-subscription' == $product->get_type() ) ) {
			$price = $product->get_price();
			if ( ! empty( $tier_post ) ) { // Product based tier pricing.
				?>
				<div id="wtp-tier-data" class="<?php echo esc_attr( $hide_class ); ?>" style="<?php esc_attr_e( $style ); ?>">
					<div id="wtp-discount-list-container" class="wtp-simple-product-list-container wtp-product-based-tier" >
						<h4><?php echo esc_html( get_option( 'wtp_table_title', 'Discount Price List' ) ); ?></h4>
						<?php
						if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) ) {
							$wtp_table = 'wtp-table';
						} else {
							$wtp_table = '';
						}
						?>
						<ul class="<?php echo esc_attr( $wtp_table ); ?>">
							<?php
							if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) ) {
								?>
								<li class="wtp-table-head">
									<span><?php echo esc_html( get_option( 'wtp_qty_col_text', 'Quantity' ) ); ?></span>
									<span><?php echo esc_html( get_option( 'wtp_price_col_text', 'Price' ) ); ?></span>
									<?php
									if ( 'enabled' === get_option( 'wtp_show_discount_col', 'disabled' ) ) {
										?>
										<span><?php echo esc_html( get_option( 'wtp_discount_col_text', 'Discount' ) ); ?></span>
										<?php
									}
									?>
								</li>
								<?php
							}
							
							$product_stock = $product->get_stock_quantity(); // Get the product stock quantity.
							$post_id = $tier_post->ID;
							   
							$tier_type = get_post_meta( $post_id, 'wtp_tier_type', true );

							if ( 'tier_range' == $tier_type ) { 
								$rules = get_post_meta( $post_id, 'wtp_tier_clone', true );
								foreach ( $rules as $key => $value ) {
									
									if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
										continue;
									}

									$min_qty        = ( ! empty( $value['wtp_min_qty'] ) && $value['wtp_min_qty'] > 0 ) ? $value['wtp_min_qty'] : 1;
									$max_qty        = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty'] >= $min_qty ) ? $value['wtp_max_qty'] : -1;
									$show_max_qty   = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty'] >= $min_qty ) ? $value['wtp_max_qty'] : '&#8734;';
									$discount_type  = ! empty( $value['wtp_discount_type'] ) ? $value['wtp_discount_type'] : 'fix';
									$discount_value = ! empty( $value['wtp_discount_value'] ) ? $value['wtp_discount_value'] : 0;
							
									if ( 'percent' == $discount_type ) {
										$discount_value = ( $price - ( $discount_value / 100 ) * $price );
									} else { // fixed
										$discount_value = ( $price - $discount_value );
									}
							
									$discount_value = ( $discount_value >= 0 ) ? $discount_value : 0;
									if ( 'incl' == get_option( 'woocommerce_tax_display_shop' ) ) {
										$discount_value = wc_get_price_including_tax( $product, array( 'price' => $discount_value ) );
									} elseif ( 'excl' == get_option( 'woocommerce_tax_display_shop' ) ) {
										$discount_value = wc_get_price_excluding_tax( $product, array( 'price' => $discount_value ) );
									}
									
									// Check if the product stock is greater than the max quantity for this tier.
									if ( null === $product_stock || $product_stock >= $max_qty ) {
										?>
										<li data-type="range" data-min="<?php echo esc_attr( $min_qty ); ?>" data-max="<?php echo esc_attr( $max_qty ); ?>" data-price="<?php echo esc_attr( $discount_value ); ?>">
											<span class="ma-quantity-range">
												<?php
												echo esc_html__( get_option( 'wtp_item_text', 'Pcs') , 'wtp' ) . ' ' . esc_attr( $min_qty ) . ' - ' . esc_attr( $show_max_qty ); 
												?>
											</span>
											<span class="pre-inquiry-price"><?php echo wp_kses_post( wc_price( $discount_value ) ); ?></span>
											<?php
											if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) && 'enabled' === get_option( 'wtp_show_discount_col', 'disabled' ) ) {
												$show_discount_percentage = 100 - ( ( $discount_value / $price ) * 100 );
												?>
												<span><?php printf( '%1$s%2$s', esc_attr( number_format( $show_discount_percentage, 2 ) ), esc_html__( '% OFF', 'wtp' ) ); ?></span>
												<?php
											}
											?>
										</li>
										<?php
									}
								}
							} else {
								$tier_select = get_post_meta( $post_id, 'wtp_rule_fix_select', true );
								if ( 'tier_fix_rule' == $tier_select ) {
									$rules = get_post_meta( $post_id, 'wtp_tier_fix_clone', true );
									foreach ( $rules as $key => $value ) {

										if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
											continue;
										}

										$set_qty        = ( ! empty( $value['wtp_set_qty'] ) && $value['wtp_set_qty'] > 0 ) ? $value['wtp_set_qty'] : 1;
										$value        = ! empty( $value['wtp_value'] ) ? $value['wtp_value'] : 0;

										$discount_value = ( $value >= 0 ) ? $value : 0;

										if ( 'incl' == get_option( 'woocommerce_tax_display_shop' ) ) {
											$discount_value = wc_get_price_including_tax( $product, array( 'price' => $discount_value ) );
										} elseif ( 'excl' == get_option( 'woocommerce_tax_display_shop' ) ) {
											$discount_value = wc_get_price_excluding_tax( $product, array( 'price' => $discount_value ) );
										}

										// Check if the product stock is greater than the max quantity for this tier.
										if ( null === $product_stock ) {
											?>
											<li data-type="fix" data-set="<?php echo esc_attr( $set_qty  ); ?>" data-price="<?php echo esc_attr( $discount_value ); ?>">
												<span class="ma-quantity-range">
													<?php
													echo esc_html__( get_option( 'wtp_item_text', 'Pcs') , 'wtp' ) . ' ' . esc_attr( $set_qty ); 
													?>
												</span>
												<span class="pre-inquiry-price"><?php echo wp_kses_post( wc_price( $discount_value ) ); ?></span>
												<?php
												if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) && 'enabled' === get_option( 'wtp_show_discount_col', 'disabled' ) ) {
													$show_discount_percentage = 100 - ( ( $discount_value / $price ) * 100 );
													?>
													<span><?php printf( '%1$s%2$s', esc_attr( number_format( $show_discount_percentage, 2 ) ), esc_html__( '% OFF', 'wtp' ) ); ?></span>
													<?php
												}
												?>
											</li>
											<?php
										}
									}
								} else {
									$rules = get_post_meta( $post_id, 'wtp_tier_qty_clone', true );
									foreach ( $rules as $key => $value ) {

										if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
											continue;
										}

										$min_qty        = ( ! empty( $value['wtp_min_qty'] ) && $value['wtp_min_qty'] > 0 ) ? $value['wtp_min_qty'] : 1;
										$max_qty        = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty'] > 0 ) ? $value['wtp_max_qty'] : -1;
										$show_max_qty        = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty'] >= $min_qty ) ? $value['wtp_max_qty'] : '&#8734;';
										$value        = ! empty( $value['wtp_value'] ) ? $value['wtp_value'] : 0;
										$discount_value = ( $value >= 0 ) ? $value : 0;

										if ( 'incl' == get_option( 'woocommerce_tax_display_shop' ) ) {
											$discount_value = wc_get_price_including_tax( $product, array( 'price' => $discount_value ) );
										} elseif ( 'excl' == get_option( 'woocommerce_tax_display_shop' ) ) {
											$discount_value = wc_get_price_excluding_tax( $product, array( 'price' => $discount_value ) );
										}

										// Check if the product stock is greater than the max quantity for this tier.
										if ( null === $product_stock ) {
											?>
											<li data-type="qty" data-min="<?php echo esc_attr( $min_qty  ); ?>" data-max="<?php esc_attr_e( $max_qty ); ?>" data-price="<?php echo esc_attr( $discount_value ); ?>">
												<span class="ma-quantity-range">
													<?php
													echo esc_html__( get_option( 'wtp_item_text', 'Pcs') , 'wtp' ) . ' ' . esc_attr( $min_qty ) . '-' . esc_attr( $show_max_qty ); 
													?>
												</span>
												<span class="pre-inquiry-price"><?php echo wp_kses_post( wc_price( $discount_value ) ); ?></span>
												<?php
												if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) && 'enabled' === get_option( 'wtp_show_discount_col', 'disabled' ) ) {
													$show_discount_percentage = 100 - ( ( $discount_value / $price ) * 100 );
													?>
													<span><?php printf( '%1$s%2$s', esc_attr( number_format( $show_discount_percentage, 2 ) ), esc_html__( '% OFF', 'wtp' ) ); ?></span>
													<?php
												}
												?>
											</li>
											<?php
										}
									}
								}
							}
							?>
						</ul>					
					</div>
				</div>
				<?php
			}           
		} else {
			?>
			<div id="wtp-tier-data" style="<?php esc_attr_e( $style ); ?>" class="<?php echo esc_attr( $hide_class ); ?>">
				<div id="wtp-discount-list-container" class="wtp-variable-product-list-container" >
					<h4><?php echo esc_html( get_option( 'wtp_table_title', 'Discount Price List' ) ); ?></h4>
					<?php
					if ( 'tooltip' === get_option( 'wtp_display_type', 'block' ) ) {
						$wtp_table = 'wtp-table';
					} else {
						$wtp_table = '';
					}
					?>
					<ul class="<?php echo esc_attr( $wtp_table ); ?>"></ul>
				</div>
			</div>
			<?php
		}

		if ( 'none' != get_option( 'wtp_summary_display_type', 'none' ) ) {
			$this->wtp_product_summary_preview();
		}
	}

	public function wtp_product_summary_preview() {
		
		if ( 'woocommerce_before_single_product_summary' == get_option( 'wtp_table_position', 'woocommerce_before_add_to_cart_button' ) ) {
			$style = 'display: flex; flex-direction: column; align-items: center;';
		} else {
			$style = '';
		}

		if ( 'table' === get_option( 'wtp_summary_display_type' ) ) { // table summary
			?>
			<div class="wtp-summary wtp-hide" style="<?php esc_attr_e( $style ); ?>">
				<h4><?php echo esc_html__( 'Summary', 'wtp' ); ?></h4>
				<table class="has-background">
					<tbody>
						<tr>
							<th><?php echo esc_html( get_option( 'wtp_summary_inline_each_label', 'Unit Price:' ) ); ?></th>
							<td id="wtp-unit"></td>
						</tr>
						<tr>
							<th><?php echo esc_html( get_option( 'wtp_summary_inline_total_label', 'Subtotal: ' ) ); ?></th>
							<td id="wtp-subtotal"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php


		} else { // inline summary
			?>
			<div class="wtp-summary wtp-hide" style="<?php esc_attr_e( $style ); ?>">
				<h4><?php echo esc_html__( 'Summary', 'wtp' ); ?></h4>

				<ul>
					<li>
						<strong><?php echo esc_html( get_option( 'wtp_summary_inline_each_label', 'Unit Price:' ) ); ?></strong>
						<span id="wtp-unit"></span>
					</li>
					<li>
						<strong><?php echo esc_html( get_option( 'wtp_summary_inline_total_label', 'Subtotal: ' ) ); ?></strong>
						<span id="wtp-subtotal"></span>
					</li>
				</ul>
			</div>
			<?php
		}
	}

	public function woocommerce_subscription_price_string_removed( $price, $product ) {     
		return '';
	}

	public function wtp_hide_price_addcart_not_logged_in( $price, $product ) {

		if ( ! is_user_logged_in() ) {
			$price = sprintf( '<p class="wtp-non-logged">%1$s</p>', get_option( 'wtp_hide_price_text', '' ) );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		}

		return $price;
	}

	public function add_tooltip_for_tier_price( $price, $instance ) {
		global $woocommerce_loop;

		if ( ! empty( $woocommerce_loop ) && is_product() && 'variable' != $instance->get_type() && ! 'related' == $woocommerce_loop['name'] ) {
			$color   = get_option( 'wtp_tooltip_icon_color', '#000' );
			$size    = get_option( 'wtp_tooltip_icon_size', '20' );
			$tooltip = '<span id="wtp-tooltip" style="display:none"><svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" style="fill:' . $color . '"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2.033 16.01c.564-1.789 1.632-3.932 1.821-4.474.273-.787-.211-1.136-1.74.209l-.34-.64c1.744-1.897 5.335-2.326 4.113.613-.763 1.835-1.309 3.074-1.621 4.03-.455 1.393.694.828 1.819-.211.153.25.203.331.356.619-2.498 2.378-5.271 2.588-4.408-.146zm4.742-8.169c-.532.453-1.32.443-1.761-.022-.441-.465-.367-1.208.164-1.661.532-.453 1.32-.442 1.761.022.439.466.367 1.209-.164 1.661z"/></svg></span>';
			return $price . $tooltip;
		}

		return $price;
	}

	public function wtp_product_alter_price_cart( $cart ) {

		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) {
			return;
		}

		$tier_post = Helper::get_active_last_tier_post();

		if ( ! empty( $tier_post ) ) {
			$post_id = $tier_post->ID;
			$tier_type = get_post_meta( $post_id, 'wtp_tier_type', true );
		} 

		// LOOP THROUGH CART ITEMS & APPLY DISCOUNT.
		foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
			$product      = $cart_item['data'];
			$product_id   = $cart_item['product_id'];
			$price        = get_post_meta( $product_id, '_price', true );
			if ( $product->is_type( 'variation' ) ) {
				if ( ! empty( $product->get_ID() ) ) {
					$variation_id = $product->get_ID();
					$price        = get_post_meta( $variation_id, '_price', true );
				}
			}
			$quantity     = $cart_item['quantity'];
			$new_price    = (string) $this->wtp_calculator_product( $product_id, $price, $quantity );

			if ( '' != $new_price ) {
				// calculate total price on fix type based on fix-quantity or range-quantity
				if ( ! empty( $tier_type ) ) {
					if ( 'tier_range' != $tier_type ) {
						$tier_select = get_post_meta( $post_id, 'wtp_rule_fix_select', true );
						if ( 'tier_fix_rule' == $tier_select || 'tier_qty_rule' == $tier_select ) {
							$new = $new_price / $quantity;
							$cart_item['data']->set_price( $new );
						} 
					} else {
						$cart_item['data']->set_price( $new_price );
						$cart_item['data']->set_sale_price( $new_price );
						$cart_item['data']->set_regular_price( $price );
					}

				}
			} else {
				$cart_item['data']->set_price( $price );
			}
		}
	}

	public function wtp_calculator_product( $product_id, $price, $quantity ) {

		$user       = wp_get_current_user();
		if ( ! empty( $user ) && $user->ID > 0 ) {
			$current_user_id   = $user->ID;
			$current_user_role = implode( ',', $user->roles );
		} else {
			$current_user_id   = 0;
			$current_user_role = '';
		}

		$tier_post = Helper::get_active_last_tier_post();

		if ( $tier_post ) {
			
			$post_id = $tier_post->ID;

			$tier_type = get_post_meta( $post_id, 'wtp_tier_type', true );

			if ( 'tier_range' == $tier_type ) {   
				$rules = get_post_meta( $post_id, 'wtp_tier_clone', true );
				if ( ! empty ( $rules ) ) {
					
					foreach ( $rules as $key => $value ) {

						if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
							continue;
						}

						$min_qty        = ( ! empty( $value['wtp_min_qty'] ) && $value['wtp_min_qty'] > 0 ) ? $value['wtp_min_qty'] : 1;
						$max_qty        = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty'] >= $min_qty ) ? $value['wtp_max_qty'] : -1;
						$discount_type  = ! empty( $value['wtp_discount_type'] ) ? $value['wtp_discount_type'] : 'fix';
						$discount_value = ! empty( $value['wtp_discount_value'] ) ? $value['wtp_discount_value'] : 0;

						if ( 'percent' == $discount_type ) {
							$discount_value = ( $price - ( $discount_value / 100 ) * $price );
						} else { // fixed
							$discount_value = ( $price - $discount_value );
						}

						$discount_value = ( $discount_value >= 0 ) ? $discount_value : 0;

						if ( $max_qty == $min_qty ) {
							if ( $quantity >= $min_qty && $quantity <= $max_qty ) {
								return $discount_value;
							}
						} elseif ( $quantity >= $min_qty && ( $quantity <= $max_qty || -1 == $max_qty ) ) {
								return $discount_value;
						}
					}
				}
			} else {
				$tier_select = get_post_meta( $post_id, 'wtp_rule_fix_select', true );
				if ( 'tier_fix_rule' == $tier_select ) {
					$rules = get_post_meta( $post_id, 'wtp_tier_fix_clone', true );
					if ( ! empty ( $rules ) ) {
						
						foreach ( $rules as $key => $value ) {
							
							if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
								continue;
							}

							$set_qty        = ( ! empty( $value['wtp_set_qty'] ) && $value['wtp_set_qty'] > 0 ) ? $value['wtp_set_qty'] : 1;
							$value        = ( ! empty( $value['wtp_value'] ) ) ? $value['wtp_value'] : 0;
							$discount_value = ( $value >= 0 ) ? $value : 0;

							if ( $quantity == $set_qty ) {
								return $discount_value;
							}
						}
					}
				} else {
					$rules = get_post_meta( $post_id, 'wtp_tier_qty_clone', true );
					foreach ( $rules as $key => $value ) {

						if ( $this->condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) ) {
							continue;
						}

						$min_qty        = ( ! empty( $value['wtp_min_qty'] ) && $value['wtp_min_qty'] > 0 ) ? $value['wtp_min_qty'] : 1;
						$max_qty        = ( ! empty( $value['wtp_max_qty'] ) && $value['wtp_max_qty']  >= $min_qty ) ? $value['wtp_max_qty'] : -1;
						$value        = ! empty( $value['wtp_value'] ) ? $value['wtp_value'] : 0;
						$discount_value = ( $value >= 0 ) ? $value : 0;

						if ( $max_qty == $min_qty ) {
							if ( $quantity >= $min_qty && $quantity <= $max_qty ) {
								return $discount_value;
							}
						} elseif ( $quantity >= $min_qty && ( $quantity <= $max_qty || -1 == $max_qty ) ) {
								return $discount_value;
						}
					}
				}
			}
		}
	}

    public function condition_check( $product_id, $post_id, $current_user_id, $current_user_role ) {
        // Users
        $users = get_post_meta( $post_id, 'wtp_users', true );

        // User roles
        $users_roles = get_post_meta( $post_id, 'wtp_user_roles', true );

        // Rules to apply
        $apply_tier_to_these_products = Helper::tiers_to_apply( $post_id );

        // Flatten the tiers array if needed
        $flattened_tiers = array_merge(...array_map(function($tier) {
            return is_array($tier) ? $tier : [$tier];
        }, $apply_tier_to_these_products));

        if ( wc_get_product( $product_id )->is_type( 'variable' ) ) {
            foreach ( wc_get_product( $product_id )->get_children() as $variation_id ) {
                if ( ! in_array( $variation_id, $flattened_tiers ) ) {
                    return true;
                }
            }
        } elseif ( ! in_array( $product_id, $flattened_tiers ) ) {
            return true;
        }

        // Check if 'all' is present
        if ( in_array( 'all', (array)$users ) || in_array( 'all', (array)$users_roles ) ) {
            return false;
        }

        $role_flag = false;
        $user_flag = false;

        // Empty check
        if ( empty( $users_roles ) && empty( $users ) ) {
            return false;
        }

        // Role flag check
        if ( !empty( $users_roles ) && ! in_array( $current_user_role, (array)$users_roles ) ) {
            $role_flag = true;
        }

        // User flag check
        if ( ! empty( $users ) && ! in_array( $current_user_id, (array)$users ) ) {
            $user_flag = true;
        }

        // Final condition check
        if ( ( empty( $users_roles ) || $role_flag ) && ( empty( $users ) || $user_flag ) ) {
            return true;
        }

        return false;
    }


    public function wtp_price( $price, $args = array() ) {
		extract(
			/**
			 * Filter wc_price_args
			 * 
			 * @since 1.0
			**/
			apply_filters(
				'wc_price_args',
				wp_parse_args(
					$args,
					array(
						'ex_tax_label'       => false,
						'currency'           => '',
						'decimal_separator'  => wc_get_price_decimal_separator(),
						'thousand_separator' => wc_get_price_thousand_separator(),
						'decimals'           => wc_get_price_decimals(),
						'price_format'       => get_woocommerce_price_format(),
					)
				)
			)
		);

		$negative = $price < 0;
		/**
		 * Filter raw_woocommerce_price
		 * 
		 * @since 1.0
		**/
		$price    = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * -1 : $price ) );
		/**
		 * Filter formatted_woocommerce_price
		 * 
		 * @since 1.0
		**/
		$price    = apply_filters( 'formatted_woocommerce_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );
		/**
		 * Filter woocommerce_price_trim_zeros
		 * 
		 * @since 1.0
		**/
		if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $decimals > 0 ) {
			$price = wc_trim_zeros( $price );
		}

		$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( $currency ) . '</span>', $price );
		$return          = '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';

		if ( $ex_tax_label && wc_tax_enabled() ) {
			$return .= ' <small class="woocommerce-Price-taxLabel tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
		}
		/**
		 * Filter wc_price
		 * 
		 * @since 1.0
		**/
		return apply_filters( 'wc_price', $return, $price, $args );
	}
}
