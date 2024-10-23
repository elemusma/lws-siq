<?php


// all the code is inside the search.php template

function restrict_gates_category_in_search( $query ) {
    // Check if it's a search query on the frontend
    if ( is_search() && !is_admin() && isset( $query->query_vars['s'] ) ) {

        // Get the current user and check if they have the 'client_gates_enterprises' role
        $user = wp_get_current_user();
        $user_has_gates_role = in_array( 'client_gates_enterprises', (array) $user->roles );

        // Debugging: Log user roles and gates role status
        if ( WP_DEBUG ) {
            error_log( 'User roles: ' . implode( ', ', $user->roles ) );
            error_log( 'User has gates role: ' . ($user_has_gates_role ? 'true' : 'false') );
        }

        // Prepare the tax_query
        $tax_query = array();

        if ( !$user_has_gates_role ) {
            // Exclude products from the 'gates' category for non-gates customers
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'gates',
                'operator' => 'NOT IN',
            );
        } else {
            // Include only products from the 'gates' category for gates customers
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'gates',
                'operator' => 'IN',
            );
        }

        // Set the tax_query in the main query
        if ( !empty($tax_query) ) {
            $query->set( 'tax_query', $tax_query );
        }

        // Ensure the query only retrieves WooCommerce products
        $query->set( 'post_type', 'product' );
    }
}

add_action( 'pre_get_posts', 'restrict_gates_category_in_search', 20 );
?>
