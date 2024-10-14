<?php 
namespace Wpexperts\TierPricingForWoocommerce;

class Helper {

	public static function allProducts() {
		
		$args = array(
			'status' => 'publish', // Fetch only published products
			'limit' => -1,         // Retrieve all products
			'type'  => array( 'simple', 'subscription' ),         
			'return' => 'ids',      // return ids only
		);

		$product_ids = wc_get_products($args);
		return $product_ids;
	}

	public static function allProductsAndVariations() {
		
		$args = array(
			'status' => 'publish', // Fetch only published products
			'limit'  => -1,         // Retrieve all products
			'type'   => 'variable', //only variable products
			'return' => 'ids',      // return ids only
		);

		$product_ids = self::allProducts();
		$variable_ids = wc_get_products($args);
		$variation_ids = array();

		// Loop through variable products
		foreach ($variable_ids as $variable_id) {
			$variable_product = wc_get_product($variable_id);
			// Loop through variations          
			foreach ($variable_product->get_children() as $variation_id) {
				$variation_ids[] = $variation_id;
			}
		}

		$product_ids = array_merge($product_ids, $variation_ids);

		return $product_ids;
	}

	public static function get_active_last_tier_post() {
		$args = array(
			'numberposts' => -1,
			'post_type'   => 'tier-rules',
			'post_status'  =>'publish',
			'meta_query' => array(
				array(
					'key' => 'wtp_enable_tier_pricing',
					'value' => 'on',
				),
			),
		);

		$tier_posts = get_posts( $args );

		$tier_post = reset( $tier_posts );
		return $tier_post;
	}

	public static function tiers_to_apply( $post_id ) {

		//include catagory and product
		$include_cats = get_post_meta( $post_id, 'wtp_include_product_cat', true );
		$include_cat_product_ids = array();
		if ( in_array( 'all', $include_cats ) ) {
			$include_cat_product_ids = array( 'all' => 'all' );
		}
		if ( ! empty( $include_cats ) && ! in_array( 'all', $include_cats ) ) {
			$include_cat_product_ids = wc_get_products( 
				array(
					'return' => 'ids',
					'product_category_id'  => $include_cats,
					'limit' => -1,
				) 
			);
		}

		$include_variable_by_cat = array();
		if ( ! in_array( 'all', $include_cats ) ) {
			foreach ( $include_cat_product_ids as $v ) {
				$id = wc_get_product( $v );
				if ( $id->is_type( 'variable' ) ) {
					if ( ! empty( $id->get_children() ) ) {
						$include_variable_by_cat[] = $id->get_children();
						
					}
				}
			}
		}

        $include_variable_product = array();
		$include_product = get_post_meta( $post_id, 'wtp_include_product', true );
		
		if ( ! in_array( 'all', $include_product ) ) {
			foreach ( $include_product as $v ) {
				$id = wc_get_product( $v );
				if ( $id->is_type( 'variable' ) ) {
					$include_variable_product = $id->get_children();
				}
			}
		}


        $include = array_merge( $include_cat_product_ids, $include_product, $include_variable_product, $include_variable_by_cat );

        // exclude catagory and product
		$exclude_cat_product_ids = array();
		$exclude_cats = get_post_meta( $post_id, 'wtp_exclude_product_cat', true );
		if ( ! empty( $exclude_cats ) ) {
			$exclude_cat_product_ids = 
			wc_get_products( 
				array(
					'return' => 'ids',
					'product_category_id'  => $exclude_cats,
					'limit' => -1,
				) 
			);
		}

		$exclude_variable_by_cat = array();
		foreach ( $exclude_cat_product_ids as $v ) {
			$id = wc_get_product( $v );
			if ( $id->is_type( 'variable' ) ) {
				if ( ! empty( $id->get_children() ) ) {
					$exclude_variable_by_cat = $id->get_children();
					
				}
			}
		}
		
		$exclude_variable_product = array();
		$exclude_product = get_post_meta( $post_id, 'wtp_exclude_product', true );
		foreach ( $exclude_product as $v ) {
			$id = wc_get_product( $v );
			if ( $id->is_type( 'variable' ) ) {
				$exclude_variable_product = $id->get_children();
			}
		}
		$exclude = array_merge( $exclude_cat_product_ids, $exclude_product, $exclude_variable_product, $exclude_variable_by_cat );
		// return ids to apply tiers
		if ( in_array( 'all', $include ) ) {
			$all_product = self::allProductsAndVariations();
			$apply_tier_to_these_products = array_diff( $all_product, $exclude );
		} else {
			$apply_tier_to_these_products = array_diff( $include, $exclude );
		}

		return $apply_tier_to_these_products;
	}
}
