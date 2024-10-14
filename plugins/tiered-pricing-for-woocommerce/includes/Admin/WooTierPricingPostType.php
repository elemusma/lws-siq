<?php

namespace Wpexperts\TierPricingForWoocommerce\Admin;

class WooTierPricingPostType {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'wtp_register_post' ) );
		add_action( 'admin_menu', array( $this, 'wtp_menu' ) );
		add_action( 'add_meta_boxes', array( $this, 'wtp_register_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'wtp_save_post' ), 10, 3 );
		add_filter( 'manage_tier-rules_posts_columns', array( $this, 'wtp_add_columns' ) );
		add_action( 'manage_tier-rules_posts_custom_column' , array( $this, 'wtp_column_status' ), 10, 2 );
		add_action( 'wp_ajax_wtp_enable_tier_post', array( $this, 'wtp_enable_tier_post' ) );
	}

	/**
	 * Enable/Disable The Tier through ajax.
	 *
	 */
	public function wtp_enable_tier_post() {
		$post_id = filter_input( INPUT_POST, 'postID', FILTER_SANITIZE_NUMBER_INT );
		$enable = filter_input( INPUT_POST, 'enable', FILTER_VALIDATE_BOOLEAN );
		$msg = '';
		if ( $enable ) {
			update_post_meta( $post_id, 'wtp_enable_tier_pricing', 'on' );
			$msg = esc_html__( 'Post has been enabled', 'wtp' );
		} else {
			update_post_meta( $post_id, 'wtp_enable_tier_pricing', '' );
			$msg = esc_html__( 'Post has been disabled', 'wtp' );
		}

		wp_send_json( array( 'status' => true, 'msg' => $msg ) );
	}

	/**
	 * Register a custom column "Status".
	 * To enable/disable the post
	 * 
	 */
	public function wtp_add_columns( $columns ) {

		unset( $columns['date'] );
		$columns['wtp_enable'] = __( 'Status', 'wtp' );
		if ( !isset( $columns['date'] ) ) {
			$columns['date'] = __('Date', 'wtp');
		}

		return $columns;
	}

	/**
	 * Html for custom Column.
	 *
	 */
	public function wtp_column_status( $column, $post_id ) {
		switch ( $column ) {

			case 'wtp_enable':
				wp_enqueue_script( 'wtp-admin-js' );
				wp_enqueue_script( 'wtp-admin-toastr-js' );
				wp_enqueue_style( 'wtp-admin-toastr-style' );
				wp_enqueue_style( 'wtp-admin-style' );
				$is_enabled = get_post_meta( $post_id , 'wtp_enable_tier_pricing' , true );
				$checked = isset( $is_enabled ) ? checked( 'on', $is_enabled, false ) : '';
				if ( $is_enabled ) {
					echo '<label class="wtp-tier-switch">
                            <input type="checkbox" name="wtp_enable_tier_pricing" id="wtp_enable_rule" data-id="' . esc_attr( $post_id ) . '" ' . esc_attr( $checked ) . '>
                            <span class="wtp-slider wtp-round"></span>
                        </label>';
				} else {
					echo '<label class="wtp-tier-switch">
                            <input type="checkbox" name="wtp_enable_tier_pricing" id="wtp_enable_rule" data-id="' . esc_attr( $post_id ) . '">
                            <span class="wtp-slider wtp-round"></span>
                        </label>';
				}
				break;

		}
	}

	 /**
	 * Register a custom post type called "Rule".
	 *
	 * @see get_post_type_labels() for label keys.
	 */
	public function wtp_register_post() {

		$labels = array(
			'name'               => esc_html_x( 'Rules', 'Post Type Name', 'woocommerce-wholesale-pricing' ),
			'singular_name'      => esc_html_x( 'Rule', 'Post Type Singular Name', 'woocommerce-wholesale-pricing' ),
			'menu_name'          => esc_html__( 'Rule', 'woocommerce-wholesale-pricing' ),
			'name_admin_bar'     => esc_html__( 'Rule', 'woocommerce-wholesale-pricing' ),
			'add_new'            => esc_html__( 'Add New', 'woocommerce-wholesale-pricing' ),
			'add_new_item'       => esc_html__( 'Add New Rule', 'woocommerce-wholesale-pricing' ),
			'new_item'           => esc_html__( 'New Rule', 'woocommerce-wholesale-pricing' ),
			'edit_item'          => esc_html__( 'Edit Rule', 'woocommerce-wholesale-pricing' ),
			'view_item'          => esc_html__( 'View Rule', 'woocommerce-wholesale-pricing' ),
			'all_items'          => esc_html__( 'Rules List', 'woocommerce-wholesale-pricing' ),
			'search_items'       => esc_html__( 'Search Rule', 'woocommerce-wholesale-pricing' ),
			'not_found'          => esc_html__( 'No Rule found.', 'woocommerce-wholesale-pricing' ),
			'not_found_in_trash' => esc_html__( 'No Rule found in Trash.', 'woocommerce-wholesale-pricing' ),
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
		);

		register_post_type( 'tier-rules', $args );
	}

	/**
	 * Register a custom menu "Tier Pricing Rules" in woocommerce.
	 *
	 */
	public function wtp_menu() {
		add_submenu_page(
			'woocommerce',
			'Tier Pricing Rules',
			'Tier Pricing Rules',
			'manage_options',
			'edit.php?post_type=tier-rules'
		);
	}
	
	/**
	 * Register meta box(es).
	 * 
	 */
	public function wtp_register_meta_boxes( $posttype ) {

		if ( 'tier-rules' == $posttype) {
			add_meta_box( 
				'meta-box-id', 
				__( 'Manage Rules', 'wtp' ), 
				array( $this, 'tiered_rules_callback' )
			);
		}
	}

	/**
	 * Callback function for Metabox
	 * Using Template to display HTml "metabox-managerule.php"
	 * 
	 */
	public function tiered_rules_callback( $post ) {

		$params = array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'image_url'  => WTP_ROOT_URL,
			'sample_csv' => WTP_ROOT_URL . 'sample/',
		);
		
		wp_localize_script( 'wtp-admin-js', 'wtp_admin_script', $params );
		wp_enqueue_script( 'wtp-admin-js' );
		wp_enqueue_style( 'tier-price-select2' );
		wp_enqueue_script( 'wc-enhanced-select' );
		wp_enqueue_style( 'wtp-admin-style' );
		/** 
		 * Action 
		 *                            
		 *  @since 2.0 
		*/
		do_action( 'tier_metabox_callback', $post );

		require_once WTP_ROOT_PATH . 'includes/Template/metabox/metabox-managerule.php' ;
	}

	/**
	 * Save Data in DB.
	 *
	 */
	public function wtp_save_post( $post_id, $post, $update ) { 
		
		if ( isset( $_POST['wtp_nonce'] ) && wp_verify_nonce( wc_clean( $_POST['wtp_nonce']), 'wtp_admin' ) ) {
			$post_data = $_POST;

			/**
			*  Action 
			*                            
			*  @since 2.0
			*/
			do_action( 'wtp_save_post_data', $post_data );
			
			// update the enabled
			if ( isset( $post_data['wtp_enable_tier_pricing'] ) ) {   
				update_post_meta( $post_id, 'wtp_enable_tier_pricing', $post_data['wtp_enable_tier_pricing'] );
			} else { 
				update_post_meta( $post_id, 'wtp_enable_tier_pricing', '' );
			}

			// update the product category
			if ( isset( $post_data['wtp_include_product_cat'] ) ) {
				if ( in_array( 'all', $post_data['wtp_include_product_cat'] ) ) { 
					update_post_meta( $post_id, 'wtp_include_product_cat', array( 'all' ) );
				} else {
					update_post_meta( $post_id, 'wtp_include_product_cat', $post_data['wtp_include_product_cat'] );
				}
			} else {
				update_post_meta( $post_id, 'wtp_include_product_cat', array() );
			}

			if ( isset( $post_data['wtp_exclude_product_cat'] ) ) {
				update_post_meta( $post_id, 'wtp_exclude_product_cat', $post_data['wtp_exclude_product_cat'] );
			} else {
				update_post_meta( $post_id, 'wtp_exclude_product_cat', array() );
			}
			
			// update the product
			if ( isset( $post_data['wtp_include_product'] ) ) {
				if ( in_array( 'all', $post_data['wtp_include_product'] ) ) { 
					update_post_meta( $post_id, 'wtp_include_product', array( 'all' ) );
				} else {
					update_post_meta( $post_id, 'wtp_include_product', $post_data['wtp_include_product'] );
				}
			} else {
				update_post_meta( $post_id, 'wtp_include_product', array() );
			}

			if ( isset( $post_data['wtp_exclude_product'] ) ) {
				update_post_meta( $post_id, 'wtp_exclude_product', $post_data['wtp_exclude_product'] );
			} else {
				update_post_meta( $post_id, 'wtp_exclude_product', array() );
			}

			// update the user
			if ( isset( $post_data['wtp_user_roles'] ) ) {
				if ( in_array( 'all', $post_data['wtp_user_roles'] ) ) { 
					update_post_meta( $post_id, 'wtp_user_roles', array( 'all' ) );
				} else {
					update_post_meta( $post_id, 'wtp_user_roles', $post_data['wtp_user_roles'] );
				}
			} else {
				update_post_meta( $post_id, 'wtp_user_roles', array() );
			}

			if ( isset( $post_data['wtp_users'] ) ) {
				if ( in_array( 'all', $post_data['wtp_users'] ) ) { 
					update_post_meta( $post_id, 'wtp_users', array( 'all' ) );
				} else {
					update_post_meta( $post_id, 'wtp_users', $post_data['wtp_users'] );
				}
			} else {
				update_post_meta( $post_id, 'wtp_users', array() );
			}
			
			// update the type
			if ( isset( $post_data['wtp_tier_type'] ) ) {
				update_post_meta( $post_id, 'wtp_tier_type', $post_data['wtp_tier_type'] );
			}

			// update the range fields
			if ( 'tier_range' == $post_data['wtp_tier_type'] ) {
		  
				$posted_range_tiers = $post_data['wtp_tier_clone'];
				$tiers = array();

				foreach ( $posted_range_tiers['wtp_min_qty'] as $key => $tier_min_qty ) {
					$tiers[$key]['wtp_min_qty']     = (int) $tier_min_qty;
					$tiers[$key]['wtp_max_qty']     = (int) $posted_range_tiers['wtp_max_qty'][$key];
					$tiers[$key]['wtp_discount_type']    = $posted_range_tiers['wtp_discount_type'][$key];
					$tiers[$key]['wtp_discount_value']   = (float) $posted_range_tiers['wtp_discount_value'][$key];
				}

				update_post_meta( $post_id, 'wtp_tier_clone', $tiers );

			}

			// update the select field for fix and qty
			if ( isset( $post_data['wtp_rule_fix_select'] ) ) {
				update_post_meta( $post_id, 'wtp_rule_fix_select', $post_data['wtp_rule_fix_select'] );  
			}

			// update the fix fields based on select
			if ( 'tier_fix' == $post_data['wtp_tier_type'] ) {

				if ( 'tier_fix_rule' == $post_data['wtp_rule_fix_select'] ) {

					$posted_fix_tiers = $post_data['wtp_tier_fix_clone'];
					$fix_tiers = array();

					foreach ( $posted_fix_tiers['wtp_set_qty'] as $key => $tier_set_qty ) {
						$fix_tiers[$key]['wtp_set_qty']     = (int) $tier_set_qty;
						$fix_tiers[$key]['wtp_value']     = (float) $posted_fix_tiers['wtp_value'][$key];
					}
					
					update_post_meta( $post_id, 'wtp_tier_fix_clone', $fix_tiers );
				}

				if ( 'tier_qty_rule' == $post_data['wtp_rule_fix_select'] ) {
					
					$posted_qty_tiers = $post_data['wtp_tier_qty_clone'];
					$qty_tiers = array();

					foreach ( $posted_qty_tiers['wtp_min_qty'] as $key => $tier_set_qty ) {
						$qty_tiers[$key]['wtp_min_qty']     = (int) $tier_set_qty;
						$qty_tiers[$key]['wtp_max_qty']     = (int) $posted_qty_tiers['wtp_max_qty'][$key];
						$qty_tiers[$key]['wtp_value']     = (float) $posted_qty_tiers['wtp_value'][$key];
					}
					
					update_post_meta( $post_id, 'wtp_tier_qty_clone', $qty_tiers );
				}

			}

		} else {
			return;
		}
	}
}
