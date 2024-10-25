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
$current_user = wp_get_current_user();
$user_roles = $current_user->roles;

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


// // echo '</div>'; // end of login-logout

// echo '</div>';

// echo '</div>';
// echo '</div>';
// echo '</div>';
// echo '</section>';

// Generate the logout URL
$logout_url = wp_logout_url(home_url());

$userIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width:15px;height:13px;fill:white;transition: all 0s ease-in-out;"><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>';

$loginIcon = '<svg id="Layer_2" style="width:15px;height:13px;fill:white;transition: all 0s ease-in-out;" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 472.72 472.72">
  <g id="Layer_1-2" data-name="Layer 1">
    <g id="kyQ20e">
      <path class="" fill="var(--accent-primary)" d="M215.09,0c14.18,0,28.36,0,42.54,0,2.62.71,5.2,1.74,7.87,2.08,95.82,12.28,173.78,79.85,198.79,172.79,3.55,13.2,5.65,26.8,8.42,40.22v42.54c-.78,3.38-1.74,6.73-2.3,10.14-15.1,92.15-65.99,155.93-152.69,190.21-18.32,7.24-38.44,9.94-57.73,14.74h-49.64c-2.2-.71-4.35-1.76-6.61-2.1-95.76-14.29-171.95-82.23-196.15-175.25C4.57,283.71,2.51,271.79,0,259.99c0-15.76,0-31.51,0-47.27.71-2.17,1.74-4.29,2.1-6.52C17.28,111.67,69.44,46.98,159.19,13.61,177.04,6.97,196.41,4.43,215.09,0ZM221.89,273.12c-61.93-25.37-85.91-59.93-77.85-109.66,6.93-42.77,42.91-75.6,85.56-78.08,44.54-2.59,83.97,24.4,96.15,66.33,7.73,26.62,4.75,52.22-9.66,76.08-14.51,24.03-36.8,37.56-63.45,45.11,67.78,8.52,117.58,42.71,150.76,101.61,62.78-67.75,77.05-200.68-11.52-290.8C303.62-6.1,160.19-3.49,74.92,89.9c-84.3,92.34-64.84,222.31-5.27,284.68,32.16-60.29,83.34-92.39,152.24-101.46Z"/>
    </g>
  </g>
</svg>';

$logoutIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:15px;height:13px;fill:white;transition: all 0s ease-in-out;"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>';

echo '<div class="blank-space" style=""></div>';
echo '<header class="header-nav box-shadow bg-accent w-100" style="top:0;left:0;z-index:100;padding-top:7.5px;">';
// echo '<header class="position-relative box-shadow bg-accent w-100" style="top:0;left:0;z-index:100;padding-top:7.5px;">';
// echo '</header>';
// }

echo '<div class="nav">';
echo '<div class="container-fluid">';

echo '<div class="row justify-content-end desktop-hidden">';

echo '<div class="col-12">';
echo get_search_form();
echo '</div>';

echo '<div class="col-4">';
echo '<a href="' . home_url() . '" style="padding:0 25px;">';
echo '<div style="width:110px;" id="logoMain">';
echo logoSVG();
echo '</div>';
echo '</a>';
echo '</div>';

echo '<div class="col-8 text-right text-white" style="padding-top:15px;">';

if(is_user_logged_in()) {
  // echo the logout button
  echo '<a href="/my-account/" class="login-logout" style="margin-right:15px;">' . $userIcon . ' My Account</a>';
  echo '<a href="' . esc_url($logout_url) . '" class="login-logout">' . $logoutIcon . ' Logout</a>';
} 

// Ensure WooCommerce is active
if ( class_exists( 'WooCommerce' ) ) {
  // Get the number of items in the cart
  $cart_count = WC()->cart->get_cart_contents_count();
  
  if(!is_page(8) && !is_page(9)) {
      // Display the cart count
      echo '<div class="cart-count" style="padding:15px 0px;">';
      echo '<a href="' . wc_get_cart_url() . '" class="text-white font-aspira d-flex align-items-center justify-content-end" style="font-style:italic;"><span>Shopping Cart (' . esc_html( $cart_count ) . ')</span>';
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

echo '<div style="padding-bottom:15px;">';
echo '<a id="mobileMenuToggle" class="openModalBtn nav-toggle" data-modal-id="mobileMenu" title="mobile menu nav toggle">';
echo '<div>';
echo '<div class="line-1 bg-accent-secondary"></div>';
echo '<div class="line-2 bg-accent-secondary"></div>';
echo '<div class="line-3 bg-accent-secondary"></div>';
echo '</div>';
echo '</a>';
echo '</div>';

echo '</div>'; // end of col-8 mobile

echo '<div class="col-6" style="padding-left:0px;">';
if(is_user_logged_in()) {
  echo '<a href="/my-account/orders/" class="bg-accent-secondary d-inline-block font-aspira w-75" style="padding:15px 25px;border-top-right-radius:25px;font-style:italic;">';
  echo '<svg style="width:14px;margin-right: 5px;" id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 169.4 184.14">
    <g id="Layer_1-2" data-name="Layer 1">
      <g id="wEx2ig">
        <g>
          <path class="" style="stroke-width: 0px;fill:var(--accent-primary);" d="M87.16,28.04v13.5c-1.28.71-1.65,2.5-3.73,2.62-2.06.12-3.8-.5-5.37-1.58-7.67-5.25-15.33-10.52-22.88-15.94-1.36-.98-2.18-2.7-3.25-4.08.96-2.71,2.56-4.46,5.01-6.04,7.02-4.53,13.73-9.56,20.56-14.38,1.02-.72,2.03-1.75,3.17-1.97,2.52-.49,4.93-.06,6.4,2.69v12.78c3.56,1.21,7.3,1.05,10.9,1.64,4.25.69,8.6,1.53,12.71,3.01,4.05,1.46,8.14,2.95,11.92,4.98,5.69,3.05,11.19,6.42,16.09,10.78,2.16,1.92,4.6,3.61,6.54,5.78,6.21,6.99,12.04,14.33,15.73,22.97,2.73,6.39,5.67,12.83,6.09,19.97,2.21,2.72.52,6.15,1.77,9.26,1.1,2.72.35,6.25.19,9.4-.11,2.04-.6,4.06-.96,6.09-.36,2.02.98,4.33-.99,6.09.81,3.68-1.82,6.66-2.09,10.16-.14,1.76-1.23,3.46-1.91,5.18-2.76,6.98-6.3,13.48-10.78,19.55-3.85,5.22-8.52,9.63-13.22,13.95-5.78,5.32-12.66,9.18-19.71,12.66-5.44,2.69-11.29,4.2-17.05,5.87-3.34.97-7.02.92-10.55,1.08-3.83.17-7.66,0-11.5.04-11.75.13-22.58-3.28-33.05-8.33-10.62-5.12-19.52-12.49-27.13-21.3-7.5-8.69-12.72-18.8-15.99-29.83-1.57-5.3-3.05-10.62-3.07-16.25,0-2.03-.96-4.07-.87-6.08.14-2.87-.69-5.72.7-8.69,1.18-2.53.19-5.6.98-8.55.84-3.12,1.52-6.39,2.26-9.6.39-1.71,1.34-3.12,2.51-4.48,1.45-1.69,3.05-2.42,5.16-1.7,2.76.93,4.31,2.95,4.31,5.61,0,1.75-.32,3.38-.84,5.13-1.13,3.75-2.16,7.6-2.2,11.63-.02,1.7-.74,3.38-.91,5.09-.17,1.65-.02,3.33-.04,5-.05,5.31,1.04,10.53,2.19,15.63.59,2.61.96,5.46,2.44,7.96,1.41,2.36,2.11,5.13,3.4,7.58,2.95,5.62,6.23,11.02,10.8,15.53,2.14,2.11,4.26,4.22,6.36,6.36,2.6,2.64,5.48,4.95,8.74,6.67,3.13,1.65,5.92,3.74,9.49,4.89,3.62,1.16,7.39,2.32,10.84,3.93,2.27,1.06,4.92-.15,6.76,1.81,4.19.33,8.52,1.47,12.55.82,6.64-1.07,13.7-.27,19.88-3.78,4.28.07,7.61-2.6,11.28-4.13,3.73-1.56,7.28-3.61,10.36-6.42,2.7-2.46,6.15-4.17,8.58-6.84,3.74-4.12,7.57-8.24,10.31-13.18.98-1.76,2.12-3.45,2.97-5.27,1.43-3.07,2.78-6.18,4-9.34,1.17-3.02,1.61-6.3,2.95-9.28.06-.14.1-.32.07-.47-.72-3.47,1.14-6.67,1.03-10.09-.11-3.5.49-7.09-.14-10.48-1.06-5.66-1.74-11.45-3.9-16.85-2.07-5.18-4.73-10.05-7.51-14.9-3.28-5.7-7.35-10.64-12.2-14.87-4.02-3.51-8.27-6.74-13.04-9.41-6.85-3.83-14.2-6.09-21.59-8.23-3.61-1.05-7.56-.91-11.5-1.33Z"/>
          <path class="" style="stroke-width: 0px;fill:var(--accent-primary);" d="M37.03,55.09h-10.5c-3.66-3.79-3.67-4.18,0-7.97h16.97c1.41,1.31,2.19,2.74,2.75,4.82,1.14,4.23,1.61,8.59,3.12,13.16h3.6c22.48,0,44.95.02,67.43-.02,2.33,0,4.37.32,6.2,1.99,1.26,1.15,1.9,2.5,1.39,3.9-2.16,6.03-2.67,12.45-4.71,18.52-1.53,4.56-1.86,9.53-3.37,14.11-.84,2.55.11,6.15-4.44,7.51h-55.28c-.17,2.68-.83,5.36,1.68,7.88h52.46c1.14,1.24,2.64,1.96,2.82,4.19.2,2.47-1.31,3.54-2.63,4.92-19.68,0-39.33,0-58.97,0-1.37-1.38-3.19-2.53-2.51-4.95-2.42-6.45-3.04-13.34-4.82-19.95-.67-2.5-.99-5.28-1.57-7.88-.58-2.6-.78-5.29-1.63-7.8-1.81-5.33-1.64-11.14-3.97-16.33.43-4.07-2.05-7.62-2.1-11.66-.02-1.42-1.18-2.82-1.91-4.43Z"/>
          <path class="" style="stroke-width: 0px;fill:var(--accent-primary);" d="M114.04,141.3c.28,2.81-1.45,4.64-3.21,6.58-1.42,1.57-3.54,1.99-5.07,2-1.95.02-4.37-1.11-5.74-2.55-1.5-1.57-2.03-4.07-2.98-6.16,1.29-1.42.68-3.62,2.35-5.03,2.01-1.7,3.87-3.18,6.73-3.08,4.72.17,7.97,3.39,7.92,8.24Z"/>
          <path class="" style="stroke-width: 0px;fill:var(--accent-primary);" d="M73.04,137.72c0,1.64.1,3.31-.02,4.97-.19,2.62-.98,4.72-3.83,5.86-4.29,1.71-6.68,1.47-9.96-1.76-.71-.7-1.41-1.41-2.09-2.08-.57-4.78-.18-9.23,5.06-11.21,4.45-1.68,7.77.52,10.84,4.23Z"/>
        </g>
      </g>
    </g>
  </svg>';
  echo '<span class="text-accent">Re-order</span>';
  echo '</a>';
  } else {
    echo '<a href="/my-account/" class="bg-accent-secondary d-inline-block font-aspira w-75" style="padding:15px 25px;border-top-right-radius:25px;font-style:italic;">';
    echo '<span class="text-accent">' . $loginIcon . 'Account Login</span>';
    echo '</a>';
  }
echo '</div>'; // end of col-6 mobile left

echo '<div class="col-6 text-right" style="padding-right:0px;">';
echo '<a href="/dealer-login/" class="bg-accent-secondary d-inline-block font-aspira w-75" style="padding:15px 25px;border-top-left-radius:25px;font-style:italic;">';
echo '<span href="/dealer-login/" class="text-accent">Wholesale Login</span>';
echo '</a>';
echo '</div>'; // end of col-6 mobile right

echo '</div>'; // end of row for mobile

echo '<div class="row justify-content-end mobile-hidden">';

echo '<div class="col-lg-3 col-6 order-lg-1 order-2" style="padding-left:0px;">';
// echo '<div style="padding-bottom:25px;">';
//     echo get_template_part('partials/si');
// echo '</div>';

echo '<div style="padding-left:15px;">';
echo get_search_form();

echo '<div class="w-100 text-white" style="padding-top:15px;">';



if(is_user_logged_in()) {
    // echo the logout button
    echo '<a href="/my-account/" class="login-logout" style="margin-right:15px;">' . $userIcon . ' My Account</a>';
    echo '<a href="' . esc_url($logout_url) . '" class="login-logout">' . $logoutIcon . ' Logout</a>';
} 
// else {
//     echo '<a href="/my-account/" class="login-logout">' . $loginIcon . ' Login to Account</a>';
// }


echo '</div>'; // end of login-logout
echo '</div>'; //

echo '<div style="padding-top:15px;">';
if(is_user_logged_in()) {
echo '<a href="/my-account/orders/" class="bg-accent-secondary d-inline-block font-aspira" style="padding:15px 45px;border-top-right-radius:25px;font-style:italic;">';
echo '<svg style="width:14px;margin-right: 5px;" id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 169.4 184.14">
  <g id="Layer_1-2" data-name="Layer 1">
    <g id="wEx2ig">
      <g>
        <path class="" style="stroke-width: 0px;fill:var(--accent-primary);" d="M87.16,28.04v13.5c-1.28.71-1.65,2.5-3.73,2.62-2.06.12-3.8-.5-5.37-1.58-7.67-5.25-15.33-10.52-22.88-15.94-1.36-.98-2.18-2.7-3.25-4.08.96-2.71,2.56-4.46,5.01-6.04,7.02-4.53,13.73-9.56,20.56-14.38,1.02-.72,2.03-1.75,3.17-1.97,2.52-.49,4.93-.06,6.4,2.69v12.78c3.56,1.21,7.3,1.05,10.9,1.64,4.25.69,8.6,1.53,12.71,3.01,4.05,1.46,8.14,2.95,11.92,4.98,5.69,3.05,11.19,6.42,16.09,10.78,2.16,1.92,4.6,3.61,6.54,5.78,6.21,6.99,12.04,14.33,15.73,22.97,2.73,6.39,5.67,12.83,6.09,19.97,2.21,2.72.52,6.15,1.77,9.26,1.1,2.72.35,6.25.19,9.4-.11,2.04-.6,4.06-.96,6.09-.36,2.02.98,4.33-.99,6.09.81,3.68-1.82,6.66-2.09,10.16-.14,1.76-1.23,3.46-1.91,5.18-2.76,6.98-6.3,13.48-10.78,19.55-3.85,5.22-8.52,9.63-13.22,13.95-5.78,5.32-12.66,9.18-19.71,12.66-5.44,2.69-11.29,4.2-17.05,5.87-3.34.97-7.02.92-10.55,1.08-3.83.17-7.66,0-11.5.04-11.75.13-22.58-3.28-33.05-8.33-10.62-5.12-19.52-12.49-27.13-21.3-7.5-8.69-12.72-18.8-15.99-29.83-1.57-5.3-3.05-10.62-3.07-16.25,0-2.03-.96-4.07-.87-6.08.14-2.87-.69-5.72.7-8.69,1.18-2.53.19-5.6.98-8.55.84-3.12,1.52-6.39,2.26-9.6.39-1.71,1.34-3.12,2.51-4.48,1.45-1.69,3.05-2.42,5.16-1.7,2.76.93,4.31,2.95,4.31,5.61,0,1.75-.32,3.38-.84,5.13-1.13,3.75-2.16,7.6-2.2,11.63-.02,1.7-.74,3.38-.91,5.09-.17,1.65-.02,3.33-.04,5-.05,5.31,1.04,10.53,2.19,15.63.59,2.61.96,5.46,2.44,7.96,1.41,2.36,2.11,5.13,3.4,7.58,2.95,5.62,6.23,11.02,10.8,15.53,2.14,2.11,4.26,4.22,6.36,6.36,2.6,2.64,5.48,4.95,8.74,6.67,3.13,1.65,5.92,3.74,9.49,4.89,3.62,1.16,7.39,2.32,10.84,3.93,2.27,1.06,4.92-.15,6.76,1.81,4.19.33,8.52,1.47,12.55.82,6.64-1.07,13.7-.27,19.88-3.78,4.28.07,7.61-2.6,11.28-4.13,3.73-1.56,7.28-3.61,10.36-6.42,2.7-2.46,6.15-4.17,8.58-6.84,3.74-4.12,7.57-8.24,10.31-13.18.98-1.76,2.12-3.45,2.97-5.27,1.43-3.07,2.78-6.18,4-9.34,1.17-3.02,1.61-6.3,2.95-9.28.06-.14.1-.32.07-.47-.72-3.47,1.14-6.67,1.03-10.09-.11-3.5.49-7.09-.14-10.48-1.06-5.66-1.74-11.45-3.9-16.85-2.07-5.18-4.73-10.05-7.51-14.9-3.28-5.7-7.35-10.64-12.2-14.87-4.02-3.51-8.27-6.74-13.04-9.41-6.85-3.83-14.2-6.09-21.59-8.23-3.61-1.05-7.56-.91-11.5-1.33Z"/>
        <path class="" style="stroke-width: 0px;fill:var(--accent-primary);" d="M37.03,55.09h-10.5c-3.66-3.79-3.67-4.18,0-7.97h16.97c1.41,1.31,2.19,2.74,2.75,4.82,1.14,4.23,1.61,8.59,3.12,13.16h3.6c22.48,0,44.95.02,67.43-.02,2.33,0,4.37.32,6.2,1.99,1.26,1.15,1.9,2.5,1.39,3.9-2.16,6.03-2.67,12.45-4.71,18.52-1.53,4.56-1.86,9.53-3.37,14.11-.84,2.55.11,6.15-4.44,7.51h-55.28c-.17,2.68-.83,5.36,1.68,7.88h52.46c1.14,1.24,2.64,1.96,2.82,4.19.2,2.47-1.31,3.54-2.63,4.92-19.68,0-39.33,0-58.97,0-1.37-1.38-3.19-2.53-2.51-4.95-2.42-6.45-3.04-13.34-4.82-19.95-.67-2.5-.99-5.28-1.57-7.88-.58-2.6-.78-5.29-1.63-7.8-1.81-5.33-1.64-11.14-3.97-16.33.43-4.07-2.05-7.62-2.1-11.66-.02-1.42-1.18-2.82-1.91-4.43Z"/>
        <path class="" style="stroke-width: 0px;fill:var(--accent-primary);" d="M114.04,141.3c.28,2.81-1.45,4.64-3.21,6.58-1.42,1.57-3.54,1.99-5.07,2-1.95.02-4.37-1.11-5.74-2.55-1.5-1.57-2.03-4.07-2.98-6.16,1.29-1.42.68-3.62,2.35-5.03,2.01-1.7,3.87-3.18,6.73-3.08,4.72.17,7.97,3.39,7.92,8.24Z"/>
        <path class="" style="stroke-width: 0px;fill:var(--accent-primary);" d="M73.04,137.72c0,1.64.1,3.31-.02,4.97-.19,2.62-.98,4.72-3.83,5.86-4.29,1.71-6.68,1.47-9.96-1.76-.71-.7-1.41-1.41-2.09-2.08-.57-4.78-.18-9.23,5.06-11.21,4.45-1.68,7.77.52,10.84,4.23Z"/>
      </g>
    </g>
  </g>
</svg>';
echo '<span class="text-accent">Re-Order Here</span>';
echo '</a>';
} else {
  echo '<a href="/my-account/" class="bg-accent-secondary d-inline-block font-aspira" style="padding:15px 45px;border-top-right-radius:25px;font-style:italic;">';
  echo '<span class="text-accent">' . $loginIcon . 'Account Login</span>';
  echo '</a>';
}
echo '</div>';


echo '</div>'; // end of col

echo '<div class="col-md-6 col-4 order-lg-2 order-3 text-white d-md-flex align-items-center justify-content-center">';
wp_nav_menu(array(
    'menu' => 'New - Left',
    'menu_class'=>'menu d-flex mobile-hidden list-unstyled text-white text-uppercase mt-0 flex-wrap justify-content-md-end'
));
echo '<a href="' . home_url() . '" style="padding:0 25px;">';
echo '<div style="width:110px;" id="logoMain">';
echo logoSVG();
echo '</div>';
echo '</a>';

// wp_nav_menu(array(
//   'menu' => 'New - Right',
//   'menu_class'=>'menu d-flex mobile-hidden list-unstyled text-white text-uppercase mt-0 flex-wrap'
// ));

if ( in_array( 'client_gates_enterprises', $user_roles ) ) {
wp_nav_menu(array(
    'menu' => 'Shop New - Gates',
    'menu_class'=>'menu d-flex mobile-hidden list-unstyled text-white text-uppercase mt-0 flex-wrap'
));
} else {
  wp_nav_menu(array(
    'menu' => 'Shop New - Public',
    'menu_class'=>'menu d-flex mobile-hidden list-unstyled text-white text-uppercase mt-0 flex-wrap'
));
}

echo '</div>';

echo '<div class="col-lg-3 col-6 order-lg-3 order-2 text-white text-right d-flex align-items-end justify-content-end" style="padding:0px;">';
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


echo '</div>'; // end of row desktop
echo '</div>'; // end of container

echo '</div>'; // end of nav

echo '</header>';
?>