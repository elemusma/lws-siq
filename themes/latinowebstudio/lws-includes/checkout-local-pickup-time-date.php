<?php

function custom_checkout_script() {
    if (is_page(9)) { // Check if we are on the checkout page
        ?>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Testing if this works');

                function handleLocalPickupActivation(isActive) {
                    const pickupTimeDate = document.querySelector('.orddd-lite-checkout-fields');
                    if (pickupTimeDate) {
                        console.log(pickupTimeDate);
                        if (isActive) {
                            console.log("Local Pickup selected. Activating the function.");
                            pickupTimeDate.style.display = "block";
                        } else {
                            console.log("Another shipping option selected. Deactivating the function.");
                            pickupTimeDate.style.display = "none";
                        }
                    } else {
                        console.log("pickupTimeDate is still null.");
                    }
                }

                // Attach event listeners to the radio buttons
                document.querySelectorAll('input[name="radio-control-0"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        if (radio.checked && radio.value === 'free_shipping:5') {
                            handleLocalPickupActivation(true);  // Activate the function
                        } else {
                            handleLocalPickupActivation(false); // Deactivate the function
                        }
                    });
                });

                // Use MutationObserver to watch for changes in the DOM
                const observer = new MutationObserver(function(mutationsList, observer) {
                    const pickupTimeDate = document.querySelector('.orddd-lite-checkout-fields');
                    if (pickupTimeDate) {
                        console.log('Element found!');
                        observer.disconnect(); // Stop observing once the element is found
                    }
                });

                observer.observe(document.body, { childList: true, subtree: true });
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'custom_checkout_script');


?>