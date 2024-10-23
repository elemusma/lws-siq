<?php get_header(); ?> 
<section class="body" style="padding:100px 0px;">
    <div class="container">
        <div class="row">
        <div class="col-lg-12 pr-lg-5">
<?php
echo '<div class="row pb-5 align-items-center">';
$s = get_search_query();

// Get the current user and check if they have the 'client_gates_enterprises' role
$user = wp_get_current_user();
$user_has_gates_role = in_array('client_gates_enterprises', (array) $user->roles);

// Prepare the tax_query based on user role
$tax_query = array();

if (!$user_has_gates_role) {
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

// The Query
$args = array(
    's' => $s,
    'post_type' => 'product',
    'tax_query' => $tax_query,
);

$the_query = new WP_Query($args);

if ($the_query->have_posts()) {
    echo '<div class="col-12">';
    _e("<h2 style='font-weight:bold;'>Search Results for: " . esc_html(get_query_var('s')) . "</h2>");
    echo '</div>';
    while ($the_query->have_posts()) {
        $the_query->the_post();

        echo '<div class="col-lg-4 col-md-6">';
        echo '<div class="row pb-5 align-items-center">';
        echo '<div class="col-md-6 col-5">';
        the_post_thumbnail('large', array('class' => 'w-100 h-auto img-hover', 'style' => 'mix-blend-mode:darken;'));
        echo '</div>';
        echo '<div class="col-md-6 col-7">';
        echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    ?>
    <h2 style='font-weight:bold;color:#000'>Nothing Found</h2>
    <div class="alert alert-info">
        <p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
    </div>
    <?php 
}
echo '</div>';
echo '</div>';

echo '</div>';
echo '</div>';
echo '</section>';

get_footer(); 
?>
