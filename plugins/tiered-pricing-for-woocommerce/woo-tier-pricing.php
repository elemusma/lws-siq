<?php
namespace Wpexperts\TierPricingForWoocommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined('WTP_ROOT_URL') ) {
	define( 'WTP_ROOT_URL', plugin_dir_url( __FILE__ ) );   
}

if ( ! defined('WTP_ROOT_PATH') ) {
	define( 'WTP_ROOT_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined('WTP_VERSION') ) {
	define( 'WTP_VERSION', '2.0' );
}

define( 'WTP_PLUGIN_DIRECTORY_NAME', __DIR__ );

if ( file_exists( WTP_ROOT_PATH . '/vendor/autoload.php' ) ) {
	require_once WTP_ROOT_PATH . '/vendor/autoload.php';
}

use Wpexperts\TierPricingForWoocommerce\Admin\WooTierPricingPostType as TierPostType;
use Wpexperts\TierPricingForWoocommerce\Admin\WooTierPricingSetting as TierSetting;
use Wpexperts\TierPricingForWoocommerce\Frontend\WooTierPricingFrontend as TierFront;
use Wpexperts\TierPricingForWoocommerce\Admin\TierImportExportCSV as ImportExport;

class Woo_Tier_Pricing {

	private static $_instance = null;

	public function __construct() {
		
		/**
		 *  Filter 
		 * 
		 *   @since 2.0
		*/
		$activate = apply_filters( 'tier_pricing_active_plugins', get_option( 'active_plugins' ) );

		if ( in_array( 'woocommerce/woocommerce.php', $activate ) ) {
			self::init(); 
		} else {
			add_action( 'admin_notices', array( __CLASS__, 'tier_priced_admin_notice_error' ) );
		}
	}

	/**
	 * Check Is WooCommerce install/active
	 * 
	 * @return
	 */
	public static function tier_priced_admin_notice_error() {
		$class = 'notice notice-error';
		$message = esc_html__( 'Woocommerce Tier Pricing requires WooCommerce to be install & active.', 'wtp' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_html( $class ), esc_html( $message ) ); 
	}

	/**
	 * Initalizing the Plugin Files
	 * 
	 */
	public static function init() {
		if ( function_exists( 'load_plugin_textdomain' ) ) {
			load_plugin_textdomain( 'wtp', false, basename( WTP_PLUGIN_DIRECTORY_NAME ) . '/languages/' );
		}

		new TierPostType();
		new TierFront();
		new ImportExport();     
		add_filter( 'woocommerce_get_settings_pages', array( __CLASS__, 'wtp_add_settings' ), 10 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Adding settings in Woocommerce setting tab
	 * 
	 * @param  $settings 
	 *
	 * @return 
	 */
	public static function wtp_add_settings( $settings ) {
		$settings[] = new TierSetting();
		return $settings;
	}

	/**
	 * Register style & scripts for Tier Pricing
	 *
	 * @since 1.0
	 */
	public static function admin_enqueue_scripts() {
		wp_register_script( 'wtp-admin-js', WTP_ROOT_URL . 'assets/js/admin/admin.js', array( 'jquery' ), '1.0.0' );
		wp_register_script( 'wtp-admin-toastr-js', WTP_ROOT_URL . 'assets/js//admin/toastr.js', array( 'jquery' ), '1.0.0' );
		wp_register_style( 'tier-price-select2', WTP_ROOT_URL . 'assets/css/admin/wc-enhanced-select.css', false, '1.0.0' );
		wp_register_style( 'wtp-admin-style', WTP_ROOT_URL . 'assets/css/admin/admin-style.css', false, '1.0.0' );
		wp_register_style( 'wtp-admin-toastr-style', WTP_ROOT_URL . 'assets/css/admin/toastr.css', false, '1.0.0' );
	}

	/**
	 * Instance Method to initiate class.
	 *
	 * @since 1.0
	 */
	public static function Instance() {
		if ( null === self::$_instance ) {
			self::$_instance = new Woo_Tier_Pricing();
		}

		return self::$_instance;
	}
}

if ( 'upgraded' == get_option('wtp_switch_to_new', 'no') || false == get_option('wc_settings_enable_tier_pricing', false) ) {
	Woo_Tier_Pricing::Instance();
}
