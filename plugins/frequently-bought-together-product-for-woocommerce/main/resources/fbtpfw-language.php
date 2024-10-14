<?php

/*translation word*/
add_action( 'plugins_loaded', 'FBTPFW_load_textdomain_pro' );
function FBTPFW_load_textdomain_pro() {
    load_plugin_textdomain( 'frequently-bought-together-product-for-woocommmerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

function FBTPFW_load_my_own_textdomain_pro( $mofile, $domain ) {
    if ( 'frequently-bought-together-product-for-woocommmerce' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
        $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
    }
    return $mofile;
}
add_filter( 'load_textdomain_mofile', 'FBTPFW_load_my_own_textdomain_pro', 10, 2 );