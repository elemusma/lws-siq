<?php
/**
 * Iconic_Flux_Checkout_Element.
 *
 * Checkout Element.
 *
 * @package Iconic_Flux
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'Iconic_Flux_Checkout_Element' ) ) {
	return;
}

/**
 * Iconic_Flux_Checkout_Element.
 *
 * @class    Iconic_Flux_Checkout_Elements.
 * @package  Iconic_Flux
 */
class Iconic_Flux_Checkout_Element {

	/**
	 * Post object.
	 *
	 * @var WP_Post
	 */
	public $post;

	/**
	 * Settings
	 *
	 * @var array
	 */
	private $settings;

	/**
	 * Position
	 *
	 * @var string
	 */
	private $position;

	/**
	 * Constructor.
	 *
	 * @param int $post_id Post ID.
	 */
	public function __construct( $post_id ) {
		$this->post     = get_post( $post_id );
		$this->position = get_post_meta( $post_id, 'fce_position', true );

		$settings       = get_post_meta( $post_id, 'fce_settings', true );
		$this->settings = ! empty( $settings ) ? json_decode( $settings, true ) : array();
	}

	/**
	 * Save
	 *
	 * @param string $position Postion.
	 * @param string $settings Settings.
	 *
	 * @return void
	 */
	public function save( $position, $settings ) {
		update_post_meta( $this->post->ID, 'fce_position', $position );
		update_post_meta( $this->post->ID, 'fce_settings', $settings );
	}

	/**
	 * Get element data
	 *
	 * @return array
	 */
	public function get_element_data() {
		return array(
			'settings' => $this->settings,
			'position' => array(
				'value' => $this->position,
				'hook'  => $this->get_position_hook(),
				'wrap'  => $this->get_position_wrap(),
			),
		);
	}

	/**
	 * Get position hook.
	 *
	 * @return int
	 */
	public function get_position_hook() {
		$position = explode( ':', $this->position );
		return isset( $position[1] ) ? $position[1] : 10;
	}

	/**
	 * Get position wrap.
	 *
	 * @return string
	 */
	public function get_position_wrap() {
		$position = explode( ':', $this->position );
		return isset( $position[2] ) ? $position[2] : '';
	}

	/**
	 * Do rules match for the given checkout element.
	 *
	 * @return bool
	 */
	public function do_rules_match() {
		$data     = $this->get_element_data();
		$order_id = Iconic_Flux_Thankyou::get_thankyou_page_order_id();

		if ( empty( $data['settings'] ) ) {
			return true;
		}

		$settings      = $data['settings'];
		$need_all_true = empty( $settings['all_rules_must_match'] ) ? false : true;

		if ( empty( $settings['enable_rules'] ) || empty( $settings['rules'] ) ) {
			return true;
		}

		foreach ( $settings['rules'] as $rule ) {
			if ( empty( $rule ) ) {
				continue;
			}

			$match = null;

			if ( 'product_cat' === $rule['object'] ) {
				$category_ids = wp_list_pluck( $rule['value'], 'code' );
				$category_ids = array_map( 'intval', $category_ids );
				$present      = $order_id ? self::are_categories_present_in_order( $category_ids, $order_id ) : self::are_categories_present_in_cart( $category_ids );
				$match        = 'is' === $rule['condition'] ? $present : ! $present;
			} elseif ( 'product' === $rule['object'] ) {
				$product_ids = wp_list_pluck( $rule['value'], 'code' );
				$product_ids = array_map( 'intval', $product_ids );
				$present     = $order_id ? self::are_products_in_order( $product_ids, $order_id ) : self::are_products_in_cart( $product_ids, $order_id );
				$match       = 'is' === $rule['condition'] ? $present : ! $present;
			} elseif ( 'user_role' === $rule['object'] ) {
				$user_roles = self::get_user_roles();
				$present    = in_array( $rule['value'], $user_roles, true );
				$match      = 'is' === $rule['condition'] ? $present : ! $present;
			} elseif ( 'cart_total' === $rule['object'] ) {
				$total = $order_id ? self::get_order_total( $order_id ) : WC()->cart->cart_contents_total;
				$value = floatval( $rule['value'] );

				if ( '<' === $rule['condition'] ) {
					$match = $total < $value;
				} elseif ( '<=' === $rule['condition'] ) {
					$match = $total <= $value;
				} elseif ( '>' === $rule['condition'] ) {
					$match = $total > $value;
				} elseif ( '>=' === $rule['condition'] ) {
					$match = $total >= $value;
				} elseif ( 'is' === $rule['condition'] ) {
					$match = intval( $total ) === intval( $value );
				} elseif ( 'is_not' === $rule['condition'] ) {
					$match = intval( $total ) !== intval( $value );
				}
			}

			// If Need all contitions to be true, and we have got a false. Its clearly not a match
			// we don't need to proceed with the loop.
			if ( true === $need_all_true && false === $match ) {
				return false;
			}

			// If Need just one contitions to be true, and we have got a true
			// then also we don't need to proceed with the loop.
			if ( false === $need_all_true && true === $match ) {
				return true;
			}
		}

		/**
		 * If we get till here, it means:
		 *
		 * 1. in case of ALL RULES MUST MATCH: we haven't got any falsy match so far, so its a match(true).
		 * 2. in case of ANY RULES MUST MATCH: we haven't got any true match so far, so its not a match(false).
		 *
		 * Coincidently value of $need_all_true is true for case 1 and false for case 2. So we simply return $need_all_true.
		 */
		return $need_all_true;
	}


	/**
	 * Are given products in cart.
	 *
	 * @param int $product_ids Product Ids.
	 *
	 * @return bool
	 */
	public static function are_products_in_cart( $product_ids ) {
		if ( empty( WC()->cart ) ) {
			return false;
		}

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$product_id = $cart_item['product_id'];

			if ( $cart_item['data']->is_type( 'variation' ) ) {
				$product_id = $cart_item['data']->get_parent_id();
			}

			if ( in_array( $product_id, $product_ids ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Are categories present in the cart.
	 *
	 * @param array $category_ids array of categories ID, slug or name.
	 *
	 * @return bool
	 */
	public static function are_categories_present_in_cart( $category_ids ) {
		if ( empty( WC()->cart ) ) {
			return false;
		}

		$has_item = false;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$product    = $cart_item['data'];
			$product_id = ! empty( $product->get_parent_id() ) ? $product->get_parent_id() : $product->get_id();

			if ( has_term( $category_ids, 'product_cat', $product_id ) ) {
				$has_item = true;

				// Break because we only need one "true" to matter here.
				break;
			}
		}

		return $has_item;
	}

	/**
	 * Get user roles.
	 *
	 * @return array
	 */
	public static function get_user_roles() {
		if ( ! is_user_logged_in() ) {
			return array( 'guest' );
		}

		global $current_user;
		return $current_user->roles;
	}

	/**
	 * Returns true if the products belonging to these category IDs present in this Order.
	 *
	 * @param int $category_ids Category IDS.
	 * @param int $order_id     Order ID.
	 *
	 * @return bool
	 */
	public static function are_categories_present_in_order( $category_ids, $order_id ) {
		$order = wc_get_order( $order_id );

		if ( empty( $order ) ) {
			return false;
		}

		$items = $order->get_items();

		foreach ( $items as $item ) {
			$product_id = $item->get_product_id();

			if ( has_term( $category_ids, 'product_cat', $product_id ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Are given product IDs present in the given order.
	 *
	 * @param array $product_ids Array of product IDs.
	 * @param int   $order_id    Order Id.
	 *
	 * @return bool
	 */
	public static function are_products_in_order( $product_ids, $order_id ) {
		$order = wc_get_order( $order_id );

		if ( empty( $order ) ) {
			return false;
		}

		$items = $order->get_items();

		foreach ( $items as $item ) {
			$product_id = $item->get_product_id();

			if ( in_array( $product_id, $product_ids, true ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get Order total.
	 *
	 * @param int $order_id Order ID.
	 *
	 * @return float
	 */
	public static function get_order_total( $order_id ) {
		$order = wc_get_order( $order_id );

		if ( empty( $order ) ) {
			return false;
		}

		return $order->get_total();
	}
}
