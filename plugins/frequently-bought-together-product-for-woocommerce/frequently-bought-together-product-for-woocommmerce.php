<?php
/**
* Plugin Name: Frequently Bought Together Product For Woocommerce
* Description: This plugin allows create Frequently Bought Together Product For Woocommerce  plugin.
* Version: 1.0
* Copyright: 2023
* Text Domain: frequently-bought-together-product-for-woocommmerce
* Domain Path: /languages 
*/


// Define Plugin Dir
if (!defined('FBTPFW_PLUGIN_DIR')) {
    define('FBTPFW_PLUGIN_DIR',plugins_url('', __FILE__));
}

// Define Plugin File
if (!defined('FBTPFW_PLUGIN_FILE')) {
  define('FBTPFW_PLUGIN_FILE', __FILE__);
}

// Define Plugin Base Name
if (!defined('FBTPFW_BASE_NAME')) {
define('FBTPFW_BASE_NAME', plugin_basename(__FILE__));
}

/* Backend file include*/
include_once('main/backend/fbtpfw-backend.php');
include_once('main/backend/fbtpfw-comman.php');

/* Fronend file include*/
include_once('main/frontend/fbtpfw-front.php');
include_once('main/frontend/fbtpfw-layout-1.php');
include_once('main/frontend/fbtpfw-layout-2.php');

/* Resources file include*/
include_once('main/resources/fbtpfw-installation-require.php');
include_once('main/resources/fbtpfw-language.php');
include_once('main/resources/fbtpfw-load-js-css.php');

function FBTPFW_support_and_rating_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
    if ($plugin_file_name !== plugin_basename(__FILE__)) {
      return $links_array;
    }

    $links_array[] = '<a href="https://www.plugin999.com/support/">'. __('Support', 'frequently-bought-together-product-for-woocommmerce') .'</a>';
    $links_array[] = '<a href="https://wordpress.org/support/plugin/frequently-bought-together-product-for-woocommerce/reviews/?filter=5">'. __('Rate the plugin ★★★★★', 'frequently-bought-together-product-for-woocommmerce') .'</a>';

    return $links_array;

}
add_filter( 'plugin_row_meta', 'FBTPFW_support_and_rating_links', 10, 4 );