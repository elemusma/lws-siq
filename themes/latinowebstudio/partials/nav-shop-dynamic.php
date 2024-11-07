<?php

global $current_user, $user_roles;

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

?>