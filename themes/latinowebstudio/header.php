<?php
echo '<!DOCTYPE html>';
echo '<html ';
language_attributes();
echo '>';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

echo codeHeader();

wp_head(); 

echo '</head>';
echo '<body '; 
body_class(); 
echo '>';
echo codeBody();


// $role_slug = 'client_gates_enterprises'; // Replace with the role slug you want to check

// if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
    // echo '<header class="position-relative box-shadow bg-accent w-100" style="top:0;left:0;z-index:10;margin-top:32px;">';
    // } else {
// echo '<section class="secondary-nav" style="padding:3px 0px;">';
// echo '<div class="container">';

// echo '<div class="row">';

// echo '<div class="col-md-6">';
// echo get_template_part('partials/si');
// echo '</div>';

// echo '<div class="col-md-6">';
// $current_user = wp_get_current_user();
// $user_roles = $current_user->roles;

// echo '<div class="d-flex flex-wrap justify-content-md-end justify-content-center">';

// if ( in_array( 'client_gates_enterprises', $user_roles ) ) {
// wp_nav_menu(array(
//     'menu' => 'Portfolio - Gates',
//     'menu_class'=>'menu list-unstyled d-flex justify-content-md-end justify-content-center m-0 text-black menu-secondary-nav-top'
// ));
// } else {
// wp_nav_menu(array(
//     'menu' => 'Portfolio - Public',
//     'menu_class'=>'menu list-unstyled d-flex justify-content-md-end justify-content-center m-0 text-black menu-secondary-nav-top'
// ));
// }

// wp_nav_menu(array(
//     'menu' => 'Secondary Nav Top',
//     'menu_class'=>'menu list-unstyled d-flex justify-content-md-end justify-content-center m-0 text-black menu-secondary-nav-top'
// ));

// // echo '<div class="w-100 login-logout">';


// // // Generate the logout URL
// // $logout_url = wp_logout_url(home_url());

// // echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width:15px;height:13px;fill:black;"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>';

// // if(is_user_logged_in()) {
// //     // Echo the logout button
// //     echo '<a href="' . esc_url($logout_url) . '" class="text-black">Logout</a>';
// // } else {
// //     echo '<a href="/my-account/" class="text-black">Login</a>';
// // }


// // echo '</div>';

// echo '</div>';

// echo '</div>';
// echo '</div>';
// echo '</div>';
// echo '</section>';

echo '<div class="blank-space" style=""></div>';
echo '<header class="header-nav box-shadow bg-accent w-100" style="top:0;left:0;z-index:100;padding-top:7.5px;">';
// echo '<header class="position-relative box-shadow bg-accent w-100" style="top:0;left:0;z-index:100;padding-top:7.5px;">';
// echo '</header>';
// }

echo '<div class="nav">';
echo '<div class="container-fluid">';

echo '<div class="row justify-content-end">';

// echo '<div class="col-lg-2 col-md-6 text-white d-flex align-items-center">';
//     echo '<div style="padding-bottom:25px;">';
//         echo get_template_part('partials/si');
//     echo '</div>';
// echo '</div>';

echo '<div class="col-md-6 col-4 text-white d-md-flex align-items-center justify-content-center">';
wp_nav_menu(array(
    'menu' => 'New - Left',
    'menu_class'=>'menu d-flex mobile-hidden list-unstyled text-white text-uppercase mt-0'
));
echo '<a href="' . home_url() . '" style="padding:0 25px;">';
echo '<div style="width:110px;" id="logoMain">';
echo logoSVG();
echo '</div>';
echo '</a>';

wp_nav_menu(array(
    'menu' => 'New - Right',
    'menu_class'=>'menu d-flex mobile-hidden list-unstyled text-white text-uppercase mt-0'
));

echo '</div>';

echo '<div class="col-lg-3 col-md-6 col-8 text-white text-right d-flex align-items-end justify-content-end" style="padding:0px;">';
echo '<div>';

// Ensure WooCommerce is active
if ( class_exists( 'WooCommerce' ) ) {
    // Get the number of items in the cart
    $cart_count = WC()->cart->get_cart_contents_count();
    
    if(!is_page(8) && !is_page(9)) {
        // Display the cart count
        echo '<div class="cart-count" style="padding-bottom:15px;">';
        echo '<a href="' . wc_get_cart_url() . '" class="text-white font-aspira d-flex align-items-center" style="font-style:italic;"><span>Shopping Cart (' . esc_html( $cart_count ) . ')</span>';
        echo '<div style="width:20px;height:20px;border-radius:50%;background:var(--accent-secondary);padding:10px;margin-left:15px;" class="d-flex align-items-center justify-content-center">';
        echo '<svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 62.76 55.79">
  <g id="Layer_1-2" data-name="Layer 1">
    <g>
      <path class="cls-1" style="fill:#fff;stroke-width:0px;" d="M28.06,35.46c.75,2.02,1.36,3.82,2.12,5.56.13.29.88.42,1.34.42,5.74.03,11.49.02,17.23.02.56,0,1.12.01,1.66.12,1.07.21,1.77,1.09,1.76,2.11,0,1.06-.79,1.95-1.91,2.11-.39.06-.8.07-1.19.07-6.38,0-12.77.01-19.15,0-2.38,0-2.87-.36-3.69-2.6-4.54-12.47-9.1-24.93-13.6-37.41-.4-1.12-.91-1.55-2.12-1.51-2.67.09-5.34.04-8.02.02C.99,4.37.02,3.51,0,2.24-.01.98.96.04,2.47.02,6.06-.01,9.65,0,13.24.02c1.31,0,2.16.72,2.61,1.92.62,1.64,1.27,3.27,1.79,4.94.3.97.81,1.25,1.8,1.25,13.24-.03,26.49-.02,39.73-.02.4,0,.8-.01,1.2,0,1.91.07,2.83,1.36,2.19,3.17-1.45,4.09-2.95,8.17-4.43,12.25-1.2,3.3-2.39,6.59-3.6,9.89-.62,1.69-1.12,2.04-2.92,2.05-7.3,0-14.6,0-21.9,0-.46,0-.92,0-1.64,0ZM29.17,12.49c.34,1.69.59,3.17.96,4.62.06.24.57.53.87.54,1.87.05,3.73,0,5.6.03.65,0,.95-.2.93-.89-.03-1.15-.03-2.3,0-3.46.01-.61-.23-.86-.84-.85-.95.02-1.91,0-2.86,0-1.49,0-2.99,0-4.66,0ZM48.1,12.51c-2.73,0-5.23-.02-7.72.03-.24,0-.65.47-.66.74-.07,1.19-.09,2.39,0,3.57.02.3.54.78.85.79,1.94.07,3.89.06,5.84,0,.29,0,.75-.36.82-.62.33-1.42.57-2.86.88-4.51ZM19.81,12.5c.15.56.22.9.35,1.23.51,1.29.7,3.02,1.65,3.71.9.65,2.6.21,3.94.24.72.01,1.43,0,2.26,0-.32-1.69-.54-3.06-.87-4.4-.08-.31-.54-.74-.84-.75-2.1-.06-4.2-.03-6.49-.03ZM57.45,12.5c-2.35,0-4.46-.02-6.56.03-.25,0-.65.36-.71.62-.32,1.43-.56,2.87-.87,4.51,2.05,0,3.95.01,5.85-.02.18,0,.46-.21.53-.39.58-1.51,1.13-3.03,1.75-4.75ZM43.26,19.73c-.88,0-1.76-.05-2.63.03-.32.03-.86.35-.87.55-.05,1.1-.15,2.28.19,3.28.11.32,1.52.21,2.34.29.24.02.48,0,.72,0,3.59-.08,2.75.6,3.52-2.93.02-.08.04-.16.05-.23.15-.67-.13-.98-.8-.98-.84,0-1.67,0-2.51,0ZM34.07,19.73s0,0,0,0c-.87,0-1.75-.04-2.62.03-.26.02-.73.39-.71.54.15,1.06.37,2.11.65,3.14.05.2.48.4.74.41,1.51.04,3.02.05,4.53,0,.29-.01.76-.33.82-.59.68-2.76.07-3.53-2.69-3.53-.24,0-.48,0-.72,0ZM42.61,25.92c-3.26.07-2.93-.54-2.94,2.62,0,3.05-.22,2.52,2.53,2.52,2.82,0,2.26.44,2.8-2.28.57-2.86.56-2.87-2.4-2.87ZM37.53,28.48q0-2.56-2.61-2.56c-3.13,0-3.17,0-2.54,3.01.52,2.43-.03,2.14,2.59,2.15,2.55.01,2.55,0,2.55-2.6ZM22.55,19.73c.63,3.86.96,4.15,4.42,4.15.2,0,.4,0,.6,0,1.65,0,1.68-.01,1.34-1.66-.59-2.82,0-2.47-2.94-2.49-1.13,0-2.25,0-3.42,0ZM24.61,25.94c.62,1.69,1.11,3.1,1.66,4.5.1.25.4.59.62.6,1.2.06,2.4.03,3.76.03-.33-1.68-.59-3.11-.92-4.53-.05-.23-.4-.56-.62-.57-1.41-.05-2.83-.03-4.5-.03ZM54.82,19.73c-1.11,0-1.97,0-2.82,0-3.3,0-3.28,0-3.72,3.28-.09.68.12.87.73.87,1.19,0,2.39.05,3.58-.03.34-.02.82-.35.96-.66.46-1.01.78-2.07,1.29-3.46ZM52.57,25.94c-1.62,0-2.96-.02-4.3.02-.21,0-.54.26-.58.44-.33,1.49-.6,3-.93,4.67,1.3,0,2.36.02,3.42-.01.2,0,.51-.15.58-.31.61-1.53,1.17-3.08,1.82-4.82Z"/>
      <path class="cls-1" style="fill:#fff;stroke-width:0px;" d="M45.42,47.16c2.35,0,4.37,2.02,4.34,4.36-.03,2.31-1.99,4.26-4.3,4.28-2.35.01-4.35-2-4.32-4.36.02-2.32,1.98-4.26,4.29-4.27Z"/>
      <path class="cls-1" style="fill:#fff;stroke-width:0px;" d="M28.9,51.44c.01-2.35,1.91-4.27,4.24-4.28,2.37-.02,4.32,1.95,4.3,4.35-.02,2.35-1.92,4.27-4.25,4.28-2.37.02-4.3-1.94-4.29-4.35Z"/>
    </g>
  </g>
</svg>';
echo '</div>';
        // <img src="https://latinowebstudio.com/wp-content/uploads/2024/10/Shopping-Cart-Icon-Circle-Orange.png" style="width:45px;height:45px;padding-left:15px;" class="" />
        echo '</a>';
        echo '</div>';
    }
}
echo '<div style="padding-bottom: 15px;padding-right: 25px;">';
echo '<a id="mobileMenuToggle" class="openModalBtn nav-toggle" data-modal-id="mobileMenu" title="mobile menu nav toggle">';
echo '<div>';
echo '<div class="line-1 bg-accent-secondary"></div>';
echo '<div class="line-2 bg-accent-secondary"></div>';
echo '<div class="line-3 bg-accent-secondary"></div>';
echo '</div>';
echo '</a>';
echo '</div>';

echo '<a href="/dealer-login/" class="bg-accent-secondary d-inline-block font-aspira" style="padding:15px 45px;border-top-left-radius:25px;font-style:italic;">';
echo '<span href="/dealer-login/" class="text-accent">Wholesale Login</span>';
echo '</a>';
// echo '<div>';
// echo '<img src="https://latinowebstudio.com/wp-content/uploads/2024/10/Headphones.png" style="width:80px;height:auto;object-fit:cover;" class="" alt="Give Stitch It Quick" />';

// echo '<a href="tel:+1720.891.0811" style="font-style:italic;" class="font-aspira lead d-block">720.891.0811</a>';
// echo '</div>';



echo '</div>';

echo '</div>'; // end of col


echo '</div>'; // end of row
echo '</div>'; // end of container

echo '</div>'; // end of nav

echo '</header>';
?>