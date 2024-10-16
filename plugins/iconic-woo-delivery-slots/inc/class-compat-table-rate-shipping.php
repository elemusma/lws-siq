<?php
/**
 * Compatiblity with Table Rate Shipping plugin.
 *
 * @package Iconic_WDS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use WooCommerce\Shipping\Table_Rate\Helpers;

/**
 * Compatiblity with Table Rate Shipping plugin.
 * https://woocommerce.com/products/table-rate-shipping/
 *
 * @class    Iconic_Compat_Table_Rate_Shipping
 * @version  1.0.0
 */
class Iconic_WDS_Compat_Table_Rate_Shipping {
	/**
	 * Run.
	 */
	public static function run() {
		add_filter( 'iconic_wds_zone_based_shipping_method', array( __CLASS__, 'shipping_method_options' ), 10, 3 );
	}

	/**
	 * Add shipping method options.
	 *
	 * @param array            $shipping_method_options Shipping method options.
	 * @param object           $method                  Shipping method.
	 * @param WC_Shipping_Zone $shipping_zone           Shipping Zone.
	 *
	 * @return array
	 */
	public static function shipping_method_options( $shipping_method_options, $method, $shipping_zone ) {
		if ( ! function_exists( 'woocommerce_get_shipping_method_table_rate' ) ) {
			return $shipping_method_options;
		}

		$class = str_replace( 'wc_shipping_', '', strtolower( get_class( $method ) ) );

		if ( 'table_rate' !== $class ) {
			return $shipping_method_options;
		}

		$rates = self::get_shipping_rates( $method );

		if ( empty( $rates ) ) {
			return $shipping_method_options;
		}

		foreach ( $rates as $rate ) {
			$id                             = sprintf( 'table_rate:%s:%s', $method->get_instance_id(), $rate->rate_id );
			$shipping_method_options[ $id ] = esc_html( sprintf( '%s: %s - %s', $shipping_zone->get_zone_name(), $method->title, $rate->rate_label ) );
		}

		return $shipping_method_options;
	}

	/**
	 * Get shipping rates.
	 *
	 * @param WC_Shipping_Table_Rate $method Shipping method.
	 *
	 * @return object
	 */
	public static function get_shipping_rates( $method ) {
		if ( ! is_a( $method, 'WC_Shipping_Table_Rate' ) ) {
			return false;
		}

		$instance_id = $method->get_instance_id();
		$rates       = array();

		if ( class_exists( 'WooCommerce\Shipping\Table_Rate\Helpers' ) ) {
			$rates = Helpers::get_shipping_rates( $instance_id );
		} elseif ( method_exists( $method, 'get_shipping_rates' ) ) {
			$rates = $method->get_shipping_rates();
		}

		return $rates;
	}
}
