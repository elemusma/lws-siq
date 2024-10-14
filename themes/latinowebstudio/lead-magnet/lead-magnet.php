<?php

wp_enqueue_style('lead-magnet', get_theme_file_uri('/lead-magnet/lead-magnet.css'));

// echo '<div class=" d-flex align-items-center" style="">';
echo '<div class="text-center">';
echo '<button class="openModalBtnCustom bold lead-magnet-circle" data-modal-id="leadMagnetModal" style="line-height:1.2;border-radius:50%;width:100px;height:100px;">Want 15% OFF?';
echo '<p class="light" style="margin:0px;font-size:50%;">Click Here</p>';
echo '</button>';

echo '</div>';
// echo '</div>';

echo '<div class="lead-magnet-open-widget inactive text-center">';
echo '<button class="openModalBtnCustom bold lead-magnet-open" data-modal-id="leadMagnetModal" style="">Order $250+ Get 15% OFF Now</button>';
echo '<p class="" style="margin:0px;font-size:50%;margin-top:-15px;">Click Here</p>';
echo '<span class="lead-magnet-close" style="">X</span>';
echo '</div>';

// <!-- The first Modal -->
echo '<div id="leadMagnetModal" class="modal-custom" style="display:flex;align-items:end;background:transparent;z-index:1100;">';
echo '<div class="modal-content-custom d-flex justify-content-end align-items-center position-relative" style="padding:0px;height:auto;margin-right:0;margin-bottom:0;border:0;background:transparent;right:-100%;transition:all .75s ease-in-out;box-shadow:none;">';
echo '<span class="close-custom position-absolute" style="top:25px;right:25px;z-index:1;">&times;</span>';

echo '<div class="row justify-content-end" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);border-radius:24px;">';
echo '<div class="col-md-6 d-md-block d-none" style="padding:0px;">';
echo wp_get_attachment_image(2228,'full','',array(
    'class'=>'w-100',
    'style'=>'height:100%;object-fit:cover;border-top-left-radius:24px;border-bottom-left-radius:24px;'
));
echo '</div>';
echo '<div class="col-md-6 col-12 text-center bg-white lead-magnet-column" style="border-top-right-radius:24px;border-bottom-right-radius:24px;padding:25px;">';


echo '<div class="h-100 d-flex align-items-center" style="">';
echo '<div class="" style="">';
echo '<h2 class="h5">Order $250+<br>Get 15% OFF NOW</h2>';
echo '<p>Sign up to receive your coupon.</p>';
echo do_shortcode('[gravityform id="4" title="false" description="false" ajax="true"]');
echo '<p class="no-thanks-text small" style="margin-top:0;cursor:pointer;">No, thanks</p>';
echo '</div>';
echo '</div>';

echo '</div>';
echo '</div>';

echo '</div>'; // Close modal content
echo '</div>'; // Close modal


wp_enqueue_script('lead-magnet-vars-js', get_theme_file_uri('/lead-magnet/lead-magnet-vars.js'));
wp_enqueue_script('lead-magnet-functions-js', get_theme_file_uri('/lead-magnet/lead-magnet-functions.js'));
wp_enqueue_script('lead-magnet-btn-js', get_theme_file_uri('/lead-magnet/lead-magnet-btn.js'));

?>