<?php
echo get_template_part('/lead-magnet/lead-magnet');

echo '<footer>';
echo '<section class="bg-accent" style="padding-top:120px;padding-bottom:100px;">';
echo '<div class="container">';
echo '<div class="row">';

echo '<div class="col-lg-2 col-md-6 text-white d-flex align-items-center">';
    echo '<div style="padding-bottom:25px;">';
        echo get_template_part('partials/si');
    echo '</div>';
echo '</div>';

echo '<div class="col-lg-8 col-6 text-white d-md-flex align-items-center justify-content-center">';
wp_nav_menu(array(
    'menu' => 'New - Left',
    'menu_class'=>'menu d-flex list-unstyled text-white text-uppercase mt-0'
));
echo '<a href="' . home_url() . '" style="padding:0 25px;">';
echo '<div style="width:125px;">';
echo logoSVG();
echo '</div>';
echo '</a>';

wp_nav_menu(array(
    'menu' => 'New - Right',
    'menu_class'=>'menu d-flex list-unstyled text-white text-uppercase mt-0'
));

echo '</div>';

echo '<div class="col-lg-2 col-md-6 col-6 text-white text-center d-flex align-items-center justify-content-center">';

echo '<div>';
echo '<img src="https://latinowebstudio.com/wp-content/uploads/2024/10/Headphones.png" style="width:80px;height:auto;object-fit:cover;" class="" alt="Give Stitch It Quick" />';

echo '<a href="tel:+1720.891.0811" style="font-style:italic;" class="font-aspira lead d-block">720.891.0811</a>';
echo '</div>';

echo '</div>';


echo '</div>'; // end of row
echo '</div>';
echo '</section>';

echo '<section class="pt-5 bg-accent">';
echo '<div class="container">';
echo '<div class="row justify-content-center">';
echo '<div class="col-12">';



echo '</div>';
echo '<div class="col-12 text-center text-white">';

// echo get_template_part('partials/si');

echo '<div class="text-gray-1 pt-4">';

// the_field('website_message','options');

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</section>';
echo '<div class="text-center bg-light" style="padding:15px;">';
    echo '<div class="d-flex justify-content-center align-items-center">';
        echo '<small class=""><a href="https://latinowebstudio.com/" target="_blank" rel="noopener noreferrer" title="Web Design, Web Development & SEO done by Latino Web Studio in Denver, CO" style="" class="">Web Design, Web Development & SEO in Denver, CO</a> done by Latino Web Studio</small>';
    echo '</div>';
echo '</div>';

// <!-- The first Modal -->
echo '<div id="mobileMenu" class="modal mobile-menu" style="z-index:100;">';
//   <!-- Modal content -->
echo '<div class="modal-content-menu modal-content" style="background:var(--accent-primary);padding-top:50px;">';
echo '<span class="close" id="navMenuClose">&times;</span>';

// echo do_shortcode('[spacer style="height:25px;"]');

echo '<div style="width:100%;max-width:105px;">';
echo '<a href="' . home_url() . '" title="Stitch It Quick">';
// echo wp_get_attachment_image(logoImg()['id'],'full','',[
//     'class'=>'w-100 h-auto',
// ]);
echo logoSVG();
echo '</a>';
echo '</div>';

echo '<div class="spacer" style="height:50px;"></div>';

// echo get_template_part('partials/dealer-menu');

wp_nav_menu(array(
    'menu' => 'New - Left',
    'menu_class'=>'menu list-unstyled mb-0 m-0'
));

wp_nav_menu(array(
    'menu' => 'New - Right',
    'menu_class'=>'menu list-unstyled mb-0 m-0'
));

// wp_nav_menu(array(
//     'menu' => 'Shopping Cart AJAX',
//     'menu_class'=>'menu list-unstyled mb-0 d-flex m-0'
// ));

echo get_template_part('partials/si');

echo '</div>';
echo '</div>';
// end of mobile nav menu

// search menu modal
echo '<div id="searchMenu" class="modal" style="background:rgba(0,0,0,.8);">';
//   <!-- Modal content -->
echo '<div class="modal-content text-right" style="background:transparent;border:none;box-shadow:none !important;">';
// echo '<div class="text-right">';
echo '<span class="close" style="float:none;" id="navMenuClose">&times;</span>';
// echo '</div>';

echo get_search_form();


echo '</div>';
echo '</div>';

echo '</footer>';

// echo '<div class="modal-content search-icon position-fixed w-100 h-100" style="opacity:0;z-index:20;">';
// echo '<div class="bg-overlay" style="background: rgba(0, 0, 0, 0.8);"></div>';
// echo '<div class="bg-content text-md-center text-left" style="background:transparent;padding: 150px 25px 50px;">';
// echo '<div class="bg-content-inner">';
// echo '<div class="close text-white" id="" style="background:transparent;font-size:2rem;right:55px;">X</div>';
                
// echo get_search_form();

// echo '</div>';
// echo '</div>';
// echo '</div>';

echo codeFooter();
// if(get_field('footer', 'options')) { the_field('footer', 'options'); }
// if(get_field('footer_code')) { the_field('footer_code'); }

wp_footer();

echo '</body>';
echo '</html>';
?>