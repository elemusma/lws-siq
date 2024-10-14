jQuery( window ).load( function() {
    jQuery(document).on('click', '.wc-block-components-quantity-selector__button', function() {
        setTimeout(function() {
            if ( wc !== 'undefined' ) {
                wc.blocksCheckout.extensionCartUpdate({
                    namespace: 'wtp'
                });
            }
        }, 1500);        
    });    
});

