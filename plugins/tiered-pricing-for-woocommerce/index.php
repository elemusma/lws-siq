<?php
/**
 * Plugin Name: Woocommerce Tier Pricing
 * Description: You can add bulk pricing for products.
 * Version: 2.0
 * Author: wpexpertsio
 * Author URI: https://wpexperts.io/
 * Developer: wpexpertsio
 * Developer URI: https://wpexperts.io/
 * Plugin URI: https://woocommerce.com/products/tiered-pricing-for-woocommerce/
 * Text Domain: wtp
 * Domain Path: /languages
 * 
 * Woo: 8354233:fbeec76c92b0c05ff10d952d84c99e2d
 * WC requires at least: 4.0
 * WC tested up to: 9.0.2
 * 
 * License: GPLv2 or later
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

/**
 * Notice for admin For New Version
 */
if ( ! function_exists('wtp_new_ver_plugin_notice') ) {
	add_action( 'admin_notices', 'wtp_new_ver_plugin_notice' );
	function wtp_new_ver_plugin_notice() {        
		$headline  = esc_html__( 'Introducing Tier Pricing for WooCommerce v2.0 - ', 'wtp' );
		/* translators: $1: anchor tag opened, $2 anchor tag closed */
		$message   = sprintf(esc_html__( 'New features, an easy-to-use user interface, and a whole lot more! Please read our %1$sdocumentation%2$s if you have any questions, concerns, or problems regarding the recent changes', 'wtp' ), '<a href="https://woocommerce.com/document/tiered-pricing-for-woocommerce/" target="_blank">', '</a>' );        
		$message_2   = esc_html__( '⚠️IMPORTANT: Upgrading to Tier Pricing for WooCommerce v2.0 will reset your previous settings! You will need to reconfigure your settings after the update.', 'wtp' );
		$tech_text = 'documentation';
		$message_3   = esc_html__( 'I want to switch to', 'wtp' );
		$switchTo = __('Upgraded Version');
		$message_4   = esc_html__( 'I don\'t want', 'wtp' );

		$user_id = get_current_user_id();
		$user = get_user_by('id', $user_id);
		if ( in_array('administrator', $user->roles ) ) {
			if ( ! get_option( 'wtp_switch_to_new' ) && false != get_option('wc_settings_enable_tier_pricing', false) ) {
				printf( '<div class="notice notice-warning"><p style="font-size: 14px"><strong>%1$s</strong> %2$s.<br/><br/><strong style="color:red">%3$s</strong> <br/><br/> %4$s <strong><a href="' . esc_url(admin_url('index.php?switch=upgraded')) . '">%5$s</a></strong> %6$s <strong><a href="' . esc_url(admin_url('index.php?switch=no')) . '">%7$s</a></strong></p></div>', wp_kses_post( $headline ), wp_kses_post( $message ), wp_kses_post( $message_2 ), wp_kses_post($message_3), wp_kses_post($switchTo), esc_html__('or', 'gfb'), wp_kses_post($message_4) );
			}
		}
	}
}

/**
 * Check for click event. 
 */
if ( ! function_exists('gfb_plugin_notice_dismissed') ) {
	add_action( 'admin_init', 'gfb_plugin_notice_dismissed' );
	function gfb_plugin_notice_dismissed() {
		$user_id = get_current_user_id();
		if ( isset( $_GET['switch'] ) && 'no' == sanitize_text_field($_GET['switch']) ) {
			update_option('wtp_switch_to_new', 'no');
			wp_safe_redirect(admin_url('admin.php?page=wc-settings&tab=tier_pricing'));
			exit;
		}
	}
}

if ( ! function_exists('wtp_switch_to_new') ) {
	function wtp_switch_to_new() {          
		if ( isset($_GET['switch']) && 'upgraded' === sanitize_text_field($_GET['switch']) ) {
			update_option('wtp_switch_to_new', 'upgraded');
			wp_safe_redirect(admin_url('admin.php?page=wc-settings&tab=tier_pricing'));
			exit;
		}
	}
}

add_action('admin_init', 'wtp_switch_to_new');


if ( ! function_exists('wtp_woo_hpos_incompatibility') ) {
	function wtp_woo_hpos_incompatibility() {
		if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );
		}
	}

	add_action( 'before_woocommerce_init', 'wtp_woo_hpos_incompatibility' );
}


if ( 'upgraded' == get_option('wtp_switch_to_new', 'no') || false == get_option('wc_settings_enable_tier_pricing', false) ) {
	require __DIR__ . '/woo-tier-pricing.php';
} else {    
	require __DIR__ . '/deprecated/woo-tier-pricing.php';
}
