<?php

add_action('woocommerce_after_add_to_cart_form', 'custom_add_button_and_modal');
function custom_add_button_and_modal() {
	?>
<style>
.xt_wooqv-add-content .xt_wooqv-item-info .xt_wooqv-item-info-inner .special-request-container,
.xt_wooqv-add-content .xt_wooqv-item-info .xt_wooqv-item-info-inner #specialRequestModal {
    opacity: 0;
}
	

</style>
<?php
echo '<div class="special-request-container">';
// <!-- Button to open the modal -->
echo '<button type="button" class="btn-main openModalBtn" style="margin-left:0px;" data-modal-id="specialRequestModal">Have a special request?</button>';
echo '</div>';

// <!-- The Modal -->
echo '<div id="specialRequestModal" class="modal">';
// <!-- Modal content -->
echo '<div class="modal-content">';
echo '<span class="close">&times;</span>';
echo '<h2>Special Request</h2>';
echo '<p>Please fill out the form below to make a special request.</p>';
echo do_shortcode('[gravityform id="3" title="false"]');
echo '</div>';
echo '</div>';

}

// wp_enqueue_script('custom-modal-scripts', get_template_directory_uri() . '/js/custom-modal-scripts.js', array('jquery'), null, true);

// wp_enqueue_script('aos-js', get_theme_file_uri('/aos/aos.js'));

?>