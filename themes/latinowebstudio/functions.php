<?php

include_once('lws-includes/wc-special-request.php');


function google_analytics() {
	?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CF8M73L11Z"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CF8M73L11Z');
</script>
<?php
}

add_action('wp_head','google_analytics');

// add_action('wp_footer', 'klaviyo_code');

function klaviyo_code() {
	?>
<script async type='text/javascript' src='https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=ThxzDu'></script>
<?php
}


function stitch_it_quick_stylesheets() {
wp_enqueue_style('style', get_stylesheet_uri() );

wp_enqueue_style('layout', get_theme_file_uri('/css/sections/layout.css'));
wp_enqueue_style('body', get_theme_file_uri('/css/sections/body.css'));
wp_enqueue_style('nav', get_theme_file_uri('/css/sections/nav.css'));
wp_enqueue_style('popup', get_theme_file_uri('/css/sections/popup.css'));
wp_enqueue_style('hero', get_theme_file_uri('/css/sections/hero.css'));
wp_enqueue_style('contact', get_theme_file_uri('/css/sections/contact.css'));
wp_enqueue_style('img', get_theme_file_uri('/css/elements/img.css'));

// if(is_front_page()){
wp_enqueue_style('home', get_theme_file_uri('/css/sections/home.css'));
	
wp_enqueue_style('home', get_theme_file_uri('/css/sections/services.css'));

if(is_page(8)){
    wp_enqueue_style('cart-css', get_theme_file_uri('/css/sections/cart.css'));
}
	
if(is_page(10)){
    wp_enqueue_style('my-account-css', get_theme_file_uri('/css/sections/my-account.css'));
}

if(is_page(9) || is_page(10)){
    wp_enqueue_style('checkout-css', get_theme_file_uri('/css/sections/checkout.css'));
}

if (is_product()) {
	wp_enqueue_style('products-single-css', get_theme_file_uri('/css/sections/products-single.css'));
}


if(is_single() || is_page_template('templates/blog.php') || is_archive() || is_category() || is_tag() || is_404() ) {
wp_enqueue_style('blog', get_theme_file_uri('/css/sections/blog.css'));
}

wp_enqueue_style('photo-gallery', get_theme_file_uri('/css/sections/photo-gallery.css'));
wp_enqueue_style('gutenberg-custom', get_theme_file_uri('/css/sections/gutenberg.css'));
wp_enqueue_style('footer', get_theme_file_uri('/css/sections/footer.css'));
wp_enqueue_style('sidebar', get_theme_file_uri('/css/sections/sidebar.css'));
wp_enqueue_style('social-icons', get_theme_file_uri('/css/sections/social-icons.css'));
wp_enqueue_style('btn', get_theme_file_uri('/css/elements/btn.css'));
// fonts
wp_enqueue_style('fonts', get_theme_file_uri('/css/elements/fonts.css'));

wp_enqueue_style('font-poppins', get_theme_file_uri('/font-poppins/font-poppins.css'));
wp_enqueue_style('font-proxima-nova', get_theme_file_uri('/font-proxima-nova/font-proxima-nova.css'));
wp_enqueue_style('font-blair-itc', get_theme_file_uri('/font-blair-itc/font-blair-itc.css'));
wp_enqueue_style('font-aspira', get_theme_file_uri('/font-aspira/font-aspira.css'));
// wp_enqueue_style('font-pontiac', get_theme_file_uri('/font-pontiac/font-pontiac.css'));
wp_enqueue_style('font-pontiac-old', get_theme_file_uri('/font-pontiac-old/font-pontiac.css'));

}
add_action('wp_enqueue_scripts', 'stitch_it_quick_stylesheets');

// for footer
function stitch_it_quick_stylesheets_footer() {

wp_enqueue_style('nav-mobile', get_theme_file_uri('/css/sections/nav-mobile.css'));

// // owl carousel
// wp_enqueue_style('owl.carousel.min', get_theme_file_uri('/owl-carousel/owl.carousel.min.css'));
// wp_enqueue_style('owl.theme.default', get_theme_file_uri('/owl-carousel/owl.theme.default.min.css'));

// // wp_enqueue_script('font-awesome', '//use.fontawesome.com/fff80caa08.js');

// // owl carousel
// wp_enqueue_script('jquery-min', get_theme_file_uri('/owl-carousel/jquery.min.js'));
// wp_enqueue_script('owl-carousel', get_theme_file_uri('/owl-carousel/owl.carousel.min.js'));
// wp_enqueue_script('owl-carousel-custom', get_theme_file_uri('/owl-carousel/owl-carousels.js'));



wp_enqueue_script('aos-js', get_theme_file_uri('/aos/aos.js'));
wp_enqueue_script('aos-custom-js', get_theme_file_uri('/aos/aos-custom.js'));
wp_enqueue_style('aos-css', get_theme_file_uri('/aos/aos.css'));


// general
wp_enqueue_script('nav-js', get_theme_file_uri('/js/nav.js'));
wp_enqueue_script('popup-js', get_theme_file_uri('/js/popup.js'));

if (is_single() && !is_product()) {
	wp_enqueue_script('blog-js', get_theme_file_uri('/js/blog.js'));
	}
}

add_action('get_footer', 'stitch_it_quick_stylesheets_footer');

// loads enqueued javascript files deferred
function mind_defer_scripts( $tag, $handle, $src ) {
	$defer = array( 
		'jquery-min',
		'owl-carousel',
		'owl-carousel-custom',
		'lightbox-min-js',
		'lightbox-js',
		'aos-js',
		'aos-custom-js',
		'nav-js',
		'blog-js',
		'contact-js'
	);
	if ( in_array( $handle, $defer ) ) {
		return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
	}
		
		return $tag;
	} 
	add_filter( 'script_loader_tag', 'mind_defer_scripts', 10, 3 );

function stitch_it_quick_menus() {
register_nav_menus( array(
'primary' => __( 'Primary' )));
register_nav_menus( array(
'secondary' => __( 'Secondary' )));
register_nav_menu('footer',__( 'Footer' ));
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'stitch_it_quick_menus');

// // removes sidebar
remove_action('woocommerce_sidebar','woocommerce_get_sidebar');

function set_global_user_info() {
    global $current_user, $user_roles;
    
    $current_user = wp_get_current_user();
    $user_roles = $current_user->roles;
}

add_action('init', 'set_global_user_info');


include_once('lws-includes/shortcode-type-writer.php');
include_once('lws-includes/custom-search-filter.php');
include_once('lws-includes/codestar.php');
include_once('lws-includes/custom-search-form.php');
include_once('lws-includes/exclude-category.php');
include_once('lws-includes/remove-gutenberg.php');
include_once('lws-includes/shortcode-base-url.php');
include_once('lws-includes/shortcode-divider.php');
include_once('lws-includes/shortcode-button.php');
include_once('lws-includes/shortcode-current-year.php');
include_once('lws-includes/shortcode-phone.php');
include_once('lws-includes/shortcode-page-title.php');
include_once('lws-includes/shortcode-spacer.php');
include_once('lws-includes/lws-custom-delivery-time-date.php');
include_once('lws-includes/iconic-delivery-times.php');
// include_once('lws-includes/checkout-rush-order.php');

// include_once('lws-includes/checkout-local-pickup-time-date.php');
// include_once('lws-includes/media-allow-svg.php');
// include_once('lws-includes/block-outputs.php');


// include_once('woocommerce/mods.php');
// include_once('woocommerce/mods-upload-file.php');
// include_once('woocommerce/mods-checkout.php');
include_once('woocommerce/mods-payment-methods.php');
include_once('woocommerce/mods-main-content.php');

// include_once('woocommerce/mods-search.php');

include_once('woocommerce/wc-custom-tier-pricing-table.php');
// include_once('woocommerce/mods-single-product.php');
// include_once('woocommerce/woocommerce-before-shop-loop-item.php'); // this causes the zoom feature on product page to not work
// include_once('woocommerce/mods-upload-file.php');
// include_once('woocommerce/product-sync/beanies-1500kc.php');
include_once('woocommerce/woocommerce-price.php');
include_once('woocommerce/wc-user-roles.php');
include_once('woocommerce/wc-product-page-title.php');
include_once('woocommerce/wc-alphabetical-ordering.php');
include_once('woocommerce/wc-product-input.php');
// include_once('woocommerce/woocommerce-product-gallery.php');
// include_once('woocommerce/woocommerce-tiered-pricing.php');

// Declare WooCommerce Support
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-slider' );