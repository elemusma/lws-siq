<?php
/**
 * Package generator for WooCommerce UPS Shipping Plugin.
 *
 * @package ups-woocommerce-shipping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PH_WC_UPS_Package_Generator
 *
 * Generates packages for UPS Shipping.
 */
class PH_WC_UPS_Package_Generator {

	/**
	 * The package being generated.
	 *
	 * @var array
	 */
	public $package;

	/**
	 * Settings for package generation.
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * Context from which the package generation is invoked.
	 *
	 * @var string
	 */
	public $invoked_from;

	/**
	 * Destination details.
	 *
	 * @var string
	 */
	public $destination;

	/**
	 * Debug mode flag.
	 *
	 * @var bool
	 */
	public $debug;

	/**
	 * Silent debug mode flag.
	 *
	 * @var bool
	 */
	public $silent_debug;

	/**
	 * PH_WC_TForce_Package_Generator constructor.
	 *
	 * @param array  $settings      Settings for package generation.
	 * @param string $invoked_from  Context from which the package generation is invoked.
	 */
	public function __construct( $settings, $invoked_from = '' ) {
	
		$this->settings     = $settings;
		$this->invoked_from = $invoked_from;

		$this->debug		= $this->settings['debug'];
		$this->silent_debug = $this->settings['silent_debug'];
	}
	
	/**
	 * get_package_requests
	 *
	 * @access private
	 * @return array
	 */
	public function get_package_requests($package, $order = null, $params = array())
	{
		if (empty($package['contents']) && class_exists('wf_admin_notice')) {

			$order_id_string = ($order instanceof WC_Order) ? ' #' . $order->get_id() : '';

			wf_admin_notice::add_notice(__("UPS - Something wrong with products associated with order, or no products associated with order".$order_id_string.".", "ups-woocommerce-shipping"), 'error');
			return false;
		}
		// Choose selected packing.
		switch ( $this->settings['packing_method'] ) {
			case 'box_packing':

				if( !class_exists( 'PH_WC_UPS_Box_Shipping' )) {
					include_once 'box-pack/class-ph-wc-ups-box-shipping.php';
				}

				$box_shipping_obj = new PH_WC_UPS_Box_Shipping( $this->settings );

				$requests = $box_shipping_obj->box_shipping($package, $order, $params);
				break;

			case 'weight_based':

				if( !class_exists( 'PH_WC_UPS_Weight_Based_Shipping' )) {
					include_once 'weight-pack/class-ph-wc-ups-weight-based-shipping.php';
				}

				$weight_based_obj = new PH_WC_UPS_Weight_Based_Shipping( $this->settings );

				$requests = $weight_based_obj->weight_based_shipping($package, $order, $params);
				break;

			case 'per_item':
			default:

				if( !class_exists( 'PH_WC_UPS_Per_Item_Shipping' )) {
					include_once 'per-item/class-ph-wc-ups-per-item-shipping.php';
				}

				$per_item_obj = new PH_WC_UPS_Per_Item_Shipping( $this->settings );

				$requests = $per_item_obj->per_item_shipping($package, $order, $params);
				break;
		}

		if (empty($requests))	$requests = array();

		$request_before_resetting_min_weight = $requests;

		// check for Minimum weight required by UPS
		$requests = $this->ups_minimum_weight_required($requests);
		return apply_filters('ph_ups_generated_packages', $requests, $package, $request_before_resetting_min_weight);
	}

	/**
	 * Minimum Weight Required by UPS.
	 * @param array $ups_packages UPS packages generated by packaging Algorithms
	 * @return array UPS packages
	 */
	public function ups_minimum_weight_required($ups_packages)
	{
		switch ( $this->settings['origin_country'] ) {
			case 'IL':
				$min_weight = 0.5;
				break;
			default:
				$min_weight = 0.0001;
		}

		foreach ($ups_packages as &$ups_package) {
			if ((float) $ups_package['Package']['PackageWeight']['Weight'] < $min_weight) {
				
				Ph_UPS_Woo_Shipping_Common::debug(sprintf(__("Package Weight has been reset to Minimum Weight. [ Actual Weight - %lf Minimum Weight - %lf ]", 'ups-woocommerce-shipping'), $ups_package['Package']['PackageWeight']['Weight'], $min_weight), $this->debug, $this->silent_debug);

				// Add by Default
				Ph_UPS_Woo_Shipping_Common::phAddDebugLog(sprintf('Package Weight has been reset to Minimum Weight. [ Actual Weight - %lf Minimum Weight - %lf ]', $ups_package['Package']['PackageWeight']['Weight'], $min_weight), $this->debug);

				$ups_package['Package']['PackageWeight']['Weight'] = $min_weight;
			}
		}
		return $ups_packages;
	}

}