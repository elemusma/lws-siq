<?php

namespace Wpexperts\TierPricingForWoocommerce\Admin;

class WooTierPricingSetting extends \WC_Settings_Page { 

	protected $id = 'tier_pricing';

	public function __construct() {
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 50 ); 
		// WC_Settings_Page class function.
		add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
		// WC_Settings_Page class function.
		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
		// WC_Settings_Page class function.
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		// Admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'wtp_enqueue_scripts' ) );
	}

	public function wtp_enqueue_scripts( $hook ) {

		global $post;
		if ( ( isset( $_GET['tab'] ) && 'tier_pricing' === sanitize_text_field( $_GET['tab'] ) ) ) {
			wp_enqueue_style( 'wtp-admin-style' );

			$params = array(
				'ajaxurl'             => admin_url( 'admin-ajax.php' ),
				'image_url'           => WTP_ROOT_URL,
				'sample_csv'  => WTP_ROOT_URL . 'sample/',
			);
			wp_localize_script( 'wtp-admin-js', 'wtp_admin_script', $params );
			wp_enqueue_script( 'wtp-admin-js' );
		}
	}

	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs[ $this->id ] = __( 'Tier Pricing', 'wtp' );
		return $settings_tabs;
	}

	public function get_sections() {
		$sections = array(
			'wtp_customization'              => __( 'Customization', 'wtp' ),
			'wtp_price_display_setting'      => __( 'Price Display Settings', 'wtp' ),
			'wtp_import_and_export'          => __( 'Import & Export', 'wtp' ),
		);
		/**
		 * Filter woocommerce_get_sections_
		 * 
		 * @since 1.0
		**/
		return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}

	public function get_settings( $section = 'wtp_customization' ) {

		if ( isset( $_GET['section'] ) && ! empty( $_GET['section'] ) ) {
			$section = sanitize_text_field( $_GET['section'] );
		}

		switch ( $section ) {

			case 'wtp_customization':
				$settings = include WTP_ROOT_PATH . 'includes/Template/Woo-settings-tabs/customization.php' ;
				break;
			case 'wtp_price_display_setting':
				$settings = include WTP_ROOT_PATH . 'includes/Template/Woo-settings-tabs/price-display.php' ;
				break;
			case 'wtp_import_and_export':
				$settings = include WTP_ROOT_PATH . 'includes/Template/Woo-settings-tabs/import-export.php' ;
				break;
			default:
				$settings =  include WTP_ROOT_PATH . 'includes/Template/Woo-settings-tabs/customization.php' ;
				break;
		}
		/**
		 * Filter wc_settings_tab_
		 * 
		 * @since 1.0
		**/
		return apply_filters( 'wc_settings_tab_' . $this->id, $settings, $section );
	}
}
