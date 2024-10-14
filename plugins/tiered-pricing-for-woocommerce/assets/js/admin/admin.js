jQuery(document).ready(function($){

	if( $('.tier-fix-row').length < 2 ) {
		$('.tier-fix-row').find('input[type="number"]').removeAttr('min');
	}
	if( $('.tier-qty-row').length < 2 ) {
		$('.tier-qty-row').find('input[type="number"]').removeAttr('min');
	}
	$('.display-option').on('click', 'input[type="radio"]', function() {
		if ( $(this).is(':checked') && $(this).val() == 'tier_range' ) {

			$('.tier-range-row').each(function(index) {
				// Get the values from each input/select within the current tier range row
				var maxQty = parseInt( $(this).find('.maxQty').val() );
				$(this).find('.discount-value').attr('min', '0.01');
				
				// Set the min attribute of the minQty input field in the next row
				var nextRow = $(this).next('.tier-range-row');
				if (nextRow.length > 0) {
					nextRow.find('.minQty').attr('min', maxQty + 1);
				}

			});
			$('.tier-qty-row').find('input[type="number"]').removeAttr('min');
			$('.tier-fix-row').find('input[type="number"]').removeAttr('min');
		}
		else {
			$('.tier-fix-row').find('.fix-value').attr('min', '0.01');
			$('.tier-range-row').find('input[type="number"]').removeAttr('min');
			$('.tier-qty-row').find('input[type="number"]').removeAttr('min');
		}
	});

	$('#wtp-rule-select').on('change', function() {
		selected_val =  $(this).val();
		if( selected_val == 'tier_qty_rule') {
			$('.tier-qty-row').each(function(index) {
				// Get the values from each input/select within the current tier range row
				var maxQty = parseInt( $(this).find('.maxqty').val() );
				$(this).find('.qty-value').attr('min', '0.01');
				console.log($(this).find('.qty-value'));
				// Set the min attribute of the minQty input field in the next row
				var nextRow = $(this).next('.tier-qty-row');
				if (nextRow.length > 0) {
					nextRow.find('.minqty').attr('min', maxQty + 1);
				}

			});
			$('.tier-fix-row').find('input[type="number"]').removeAttr('min');
		} else {
			$('.tier-fix-row').find('.fix-value').attr('min', '0.01');
			$('.tier-qty-row').find('input[type="number"]').removeAttr('min');
		}
	});

    // range fields clone
	$(".tier-range-row-clone").on('click', ".wtp-add-range-row", function() {
        var $tr    = $(this).closest('.tier-range-row');
        var $clone = $tr.clone();
		var prvmax_val = parseInt( $tr.find('.maxQty').val() );

		if( $clone ) {
			if( prvmax_val == 0 ) {
				var prevminval = parseInt( $tr.find( '.minQty' ).val() );
				$tr.find('.maxQty').attr('min', prevminval + 1 );
			}
			$clone.closest( '.tier-range-row' ).find( '.minQty' ).attr('min', prvmax_val + 1 );
			$clone.closest( '.tier-range-row' ).find( '.minQty' ).val(0);
			$clone.closest( '.tier-range-row' ).find( '.maxQty' ).val(0);
			$clone.closest( '.tier-range-row' ).find( '.discount-value' ).val(0);
			$tr.after($clone);
		}

    });
	
	// delete range fields
    $('.tier-range-row-clone').on('click', ".wtp-delete-range-row", function () {
		if( $('.tier-range-row').length > 1 ) {
			var input_value =  $(this).closest('.tier-range-row').find('.tier-form-group').find('.minQty').val();
			var value = parseInt( $(this).parents('.tier-range-row').prev().find('.tier-form-group').find('.maxQty').val() );

			// need add max attr at the time of delete
			if( input_value > 0 ) {
				if( input_value > value ) {
					$(this).parents('.tier-range-row').next().find('.tier-form-group').find('.minQty').attr('min', value + 1);
				} else {
					$(this).parents('.tier-range-row').next().find('.tier-form-group').find('.minQty').attr('min', 1);
				}
			}
			$(this).closest('.tier-range-row').remove();
        }
		
    });
	
	// fix fields clone
	$(".tier-fix-row-clone").on('click', ".wtp-add-fix-row", function() {
		var $tr    = $(this).closest('.tier-fix-row');
		var $clone = $tr.clone();
		$clone.closest( '.tier-fix-row' ).find( '.setQty' ).val(1);
		$clone.closest( '.tier-fix-row' ).find( '.fix-value' ).val(0);
		$tr.after($clone);
	});

	// delete fix fields
	$('.tier-fix-row-clone').on('click', ".wtp-delete-fix-row", function () {
        if( $('.tier-fix-row').length > 1 ) {
            $(this).closest('.tier-fix-row').remove();
        }
    });

	// qty field clone
	$(".tier-qty-row-clone").on('click', ".wtp-add-qty-row", function() {
		var $tr    = $(this).closest('.tier-qty-row');
		var $clone = $tr.clone();
		var prvmax_val = parseInt( $tr.find('.maxqty').val() );

		if( $clone ) {
			if( prvmax_val == 0 ) {
				var prevminval = parseInt( $tr.find( '.minqty' ).val() );
				$tr.find('.maxqty').attr('min', prevminval + 1 );
			}
			$clone.closest( '.tier-qty-row' ).find( '.minqty' ).attr('min', prvmax_val + 1 );
			$clone.closest( '.tier-qty-row' ).find( '.minqty' ).val(0);
			$clone.closest( '.tier-qty-row' ).find( '.maxqty' ).val(0);
			$clone.closest( '.tier-qty-row' ).find( '.qty-value' ).val(0);
			$tr.after($clone);
		}
	});

	// qty fields delete
	$('.tier-qty-row-clone').on('click', ".wtp-delete-qty-row", function () {
        if( $('.tier-qty-row').length > 1 ) {
			var input_value =  $(this).closest('.tier-qty-row').find('.tier-form-group').find('.minqty').val();
			var value = parseInt( $(this).parents('.tier-qty-row').prev().find('.tier-form-group').find('.maxQty').val() );
			
			if (input_value > 0 ) {
				if( input_value > value ) {
					$(this).parents('.tier-qty-row').next().find('.tier-form-group').find('.minqty').attr('min', value + 1);
				} else {
					$(this).parents('.tier-range-row').next().find('.tier-form-group').find('.minqty').attr('min', 1);
				}
			}
            $(this).closest('.tier-qty-row').remove();
        }
    });

    setupRepeaterField( $ );
    $('.tier-range-row:last .maxQty').removeAttr('min');
    $('.tier-qty-row:last .maxQty').removeAttr('min');

	// hide or show fixed and range fields
	$(".wtp-tier-type").on('click', function() { 
		if( $(this).val() == 'tier_fix' ){
			$( '.tier-main' ).css( 'display', 'flex' );
			$( '.tier-range-main' ).css( 'display', 'none' );
		}else {
			$( '.tier-main' ).css( 'display', 'none' );
			$( '.tier-range-main' ).css( 'display', 'block' );
		}
	});

	// hide or show fixed fields based on select( fixed-value, qty-value )
	$("#wtp-rule-select").on('change', function() {

		if( $(this).val() == 'tier_fix_rule' ) {
			$( '.tier-fix-row-clone' ).css( 'display', 'inline-block' );
			$( '.tier-qty-row-clone' ).css( 'display', 'none' );
		} else {
			$( '.tier-fix-row-clone' ).css( 'display', 'none' );
			$( '.tier-qty-row-clone' ).css( 'display', 'inline-block' );
		}
	});

	// sample file 
	$('#wtp_sample_csv').find('a').removeAttr('download');
	$( '#select_import_type' ).on( 'change', function(){
		if( $( this ).val()  ) {
			$('.tier-sample').css( 'display', 'table-row' );
			$('#wtp_sample_csv').find('a').attr( 'href', wtp_admin_script.sample_csv +  $( this ).val() + '-sample.csv' );
		} else {
			$('.tier-sample').css( 'display', 'none' );
		}

	} );

	$(document).on('click', '#wtp_enable_rule' , function() {
        var id = $(this).data('id');
        $.ajax({
            type: "post",
            dataType: "json",
            url: ajaxurl,
            data: {
                action: 'wtp_enable_tier_post',
                postID : id,
                enable : ($(this).is(":checked") ? true : false)
            },
            success: function(response){
				if( response.status ) {
					toastr.success( response.msg )
				}
            }
        });
    });

});


function setupRepeaterField( $ ) {

	// FOr range
	$(document).on('input keyup copy paste', '.tier-range-row .minQty', function() {
		const This = $(this);

		// get value of current min qty field.
		let min_val = parseInt(This.val());
		let max_el = This.parents('.tier-range-row').prev().find('.tier-form-group').find('.maxQty').val();
		
		if ( min_val < max_el ) {
			// adjust min value of previous maxqty input field
			This.parents('.tier-range-row').prev().find('.tier-form-group').find('.maxQty').attr('min', ( (min_val - 1) <= 1 ? 1 : (min_val - 1) ) );
		} 
		// adjust min value of sibling maxqty input field
		This.parent('.tier-form-group').siblings('.tier-form-group').find('.maxQty').attr('min', (min_val + 1));
		$('.tier-range-row:last .maxQty').removeAttr('min');
		
	});

	$(document).on('input keyup copy paste', '.tier-range-row .maxQty', function() {
		const This = $(this);

		// get value of current min qty field.
		let max_val = parseInt(This.val());
		var min_val = parseInt( This.parents('.tier-range-row').find('.minQty').val() );
		This.attr('min', min_val + 1 );

		// adjust max value of previous maxqty input field
		This.parents('.tier-range-row').next().find('.tier-form-group').find('.minQty').attr('min', (max_val +1) );
		$('.tier-range-row:last .maxQty').removeAttr('min');

	});
	//end

	// for fix quantity 
    $(document).on('input keyup copy paste', '.tier-qty-row .minqty', function() {
		const This = $(this);

		// get value of current min qty field.
		let min_val = parseInt(This.val());
		let max_el = This.parents('.tier-qty-row').prev().find('.tier-form-group').find('.maxqty').val();
		
		if ( min_val < max_el ) {
			This.parents('.tier-qty-row').prev().find('.tier-form-group').find('.maxqty').attr('min', ( (min_val - 1) <= 1 ? 1 : (min_val - 1) ) );
		}

		// adjust min value of sibling maxqty input field
		This.parent('.tier-form-group').siblings('.tier-form-group').find('.maxqty').attr('min', (min_val + 1));
		$('.tier-qty-row:last .maxQty').removeAttr('min');
		
	});

	$(document).on('input keyup copy paste', '.tier-qty-row .maxqty', function() {
		const This = $(this);

		// get value of current min qty field.
		let max_val = parseInt(This.val());
		var min_val = parseInt( This.parents('.tier-qty-row').find('.minqty').val() );
		This.attr('min', min_val + 1 );
		// adjust max value of previous maxqty input field
		This.parents('.tier-qty-row').next().find('.tier-form-group').find('.minqty').attr('min', (max_val +1) );
		$('.tier-qty-row:last .maxqty').removeAttr('min');

	});
	// end

}


 jQuery( document ).ready(function() {

	jQuery('ul.wtp-inside-subtabs').show();

	if ( jQuery('#mainform').find( 'ul.wtp-inside-subtabs' ).hasClass('unpreventSubmitBtn') ) {
		jQuery('button.woocommerce-save-button').css('visibility', 'visible');
	} else {
		jQuery('button.woocommerce-save-button').on('click', function(r){
			r.preventDefault();
		});		
	}

	/** product metabox jquery started from here **/
    jQuery('#wtp_display_type').on( 'change', function() {
    	var This = jQuery(this);
    	var val = This.val();
    	showDisplayTypeSettings( val );
    });    


    showDisplayTypeSettings();


    function showDisplayTypeSettings( val='' ) {

    	jQuery( `.type-tooltip` ).parents('table').css('display', 'none');
		jQuery( `.type-table` ).parents('table').css('display', 'none');

		if ( 'disabled' == jQuery( 'input[name="wtp_show_discount_col"]:checked' ).val() ) {
			jQuery( '#wtp_discount_col_text' ).parents('tr').css( 'display', 'none' );
		}

    	if ( '' == val ) {
    		val = jQuery('#wtp_display_type').val();
    	}

    	if ( 'tooltip' === val ) {
			jQuery( `.type-tooltip` ).parents('table').addClass('wtp-show-table');
			jQuery( `.type-table` ).parents('table').removeClass('wtp-show-table');
		} else {
			jQuery( `.type-table` ).parents('table').addClass('wtp-show-table');
			jQuery( `.type-tooltip` ).parents('table').removeClass('wtp-show-table');
		}
    }

    jQuery( 'input[name="wtp_show_discount_col"]' ).on( 'click', function() {
    	if ( jQuery(this).is(':checked') ) {
    		var val = jQuery(this).val();
    		if ( 'enabled' === val ) {
    			jQuery( '#wtp_discount_col_text' ).parents('tr').css( 'display', 'table-row' );
    		} else {
    			jQuery( '#wtp_discount_col_text' ).parents('tr').css( 'display', 'none' );
    		}
    	}
    });

    jQuery('#wtp_summary_display_type').on( 'change', function() {
    	var This = jQuery(this);
    	var val = This.val();
    	showSummaryDisplayTypeSettings( val );
    });

    showSummaryDisplayTypeSettings();

    function showSummaryDisplayTypeSettings( val='' ) {

    	jQuery( `.type-inline` ).parents('table').css('display', 'none');

    	if ( '' == val ) {
    		val = jQuery('#wtp_summary_display_type').val();
    	}

    	if ( 'inline' === val || 'table' === val ) {
			jQuery( `.type-inline` ).parents('table').addClass('wtp-show-table');			
		} else {			
			jQuery( `.type-inline` ).parents('table').removeClass('wtp-show-table');
		}
    }

    jQuery( 'input[name="wtp_hide_price"]' ).on( 'click', function() {
    	if ( jQuery(this).is(':checked') ) {
    		var val = jQuery(this).val();
    		if ( 'enabled' === val ) {
    			jQuery( '#wtp_hide_price_text' ).parents('tr').css( 'display', 'table-row' );
    		} else {
    			jQuery( '#wtp_hide_price_text' ).parents('tr').css( 'display', 'none' );
    		}
    	}
    });

    if ( 'disabled' == jQuery( 'input[name="wtp_hide_price"]:checked' ).val() ) {
		jQuery( '#wtp_hide_price_text' ).parents('tr').css( 'display', 'none' );
	}

    jQuery( 'input[name="wtp_tier_range_price_show"]' ).on( 'click', function() {
    	if ( jQuery(this).is(':checked') ) {
    		var val = jQuery(this).val();
    		if ( 'enabled' === val ) {
    			jQuery( '#wtp_display_tier_price_range' ).parents('tr').css( 'display', 'table-row' );
    		} else {
    			jQuery( '#wtp_display_tier_price_range' ).parents('tr').css( 'display', 'none' );
    		}
    	}
    });

    if ( 'disabled' == jQuery( 'input[name="wtp_tier_range_price_show"]:checked' ).val() ) {
		jQuery( '#wtp_display_tier_price_range' ).parents('tr').css( 'display', 'none' );
	}
			
	jQuery( '#mainform' ).on('submit', function(event) {
		
		if ( jQuery('#wtp_type').val() == 'wtp_import_csv' ) {

			event.preventDefault();
			jQuery('#wtp_message').html('');
			jQuery.ajax({
			    url: ajaxurl,
			    method:"POST",
			    data: new FormData(this),
			    dataType:"json",
			    contentType:false,
			    cache:false,
			    processData:false,
			    beforeSend: function() {
			    	jQuery('#wtp_import_csv').attr('disabled','disabled');
			    	jQuery('#import_runner').val('Importing');
			    	jQuery('#wtp_message').html('<div class="alert alert-warning">Data uploading is in process.</div>');
			    },
			    success:function(data) {
		     		jQuery('#wtp_import_csv').attr('disabled',false);
		     		if ( jQuery('.drop-zone__prompt').length <= 0 ) {
			     		jQuery('.drop-zone').prepend( `<span class="drop-zone__prompt">Drop file here or click to upload</span>` );
			     	}
			     	jQuery('.drop-zone__thumb').remove();
			     	jQuery('#wtp_import_csv').val('');			     	

			    	if(data.success) {
			    		var select_import_type = jQuery('#select_import_type').val();
			      		jQuery.ajax({
			      			url: ajaxurl,
			      			method: 'POST',
			      			data: {
								import_type: select_import_type,
								action: 'wtp_start_importing_to_db'
							},
			      			success: function ( data ) {
			      				if ( 'success' == data ) {
			      					setTimeout(function(){
			      						jQuery('#wtp_message').html('<div class="alert alert-success">Data imported successfully.</div>');
			      					}, 500);			      					
			      				} else if ( 'error' == data ) {
			      					setTimeout(function(){
			      						jQuery('#wtp_message').html('<div class="alert alert-danger">Please select the same Import Type.</div>');
			      					}, 500);
			      				} else {
			      					setTimeout(function(){
			      						jQuery('#wtp_message').html('<div class="alert alert-danger">Import failed. No rows affected.</div>');
			      					}, 500);			      					
			      				}

			      				jQuery('#import_runner').val('Import Data');
			      			},
			      		});			      		
			     	}
			     
			     	if(data.error) {
			      		jQuery('#wtp_message').html('<div class="alert alert-danger">'+data.error+'</div>');
			      		jQuery('#import_runner').val('Import Data');
			     	}
			    }
			});
		}

		if ( jQuery('#wtp_type').val() == 'wtp_export_csv' ) {

			event.preventDefault();
			jQuery('#wtp_message').html('');

			jQuery.ajax({
			    url: ajaxurl,
			    method:"POST",
			    data: new FormData(this),
			    dataType:"json",
			    contentType:false,
			    cache:false,
			    processData:false,			    
			    beforeSend: function() {
			    	jQuery('#export_runner').val('Exporting');
			    	jQuery('#wtp_message').html('<div class="alert alert-warning">Data exporting is in process.</div>');
			    },
			    success:function(data) {

			    	if(data.success) {
			      		jQuery('#wtp_message').html('<div class="alert alert-success">'+data.success+'</div>');
			     	}
			     
			     	if(data.error) {
			      		jQuery('#wtp_message').html('<div class="alert alert-danger">'+data.error+'</div>');
			     	}

			     	jQuery('#export_runner').val('Export Data');
			    }
			});
		}

	});

});

document.addEventListener("DOMContentLoaded", () => {

	/** Drag & Drop function starts here*/
	document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {  
	
	const dropZoneElement = inputElement.closest(".drop-zone");

	dropZoneElement.addEventListener("click", (e) => {
		inputElement.click();
	});

	inputElement.addEventListener("change", (e) => {  	
		if (inputElement.files.length) {
		updateThumbnail(dropZoneElement, inputElement.files[0]);
		}
	});

	dropZoneElement.addEventListener("dragover", (e) => {
		e.preventDefault();
		dropZoneElement.classList.add("drop-zone--over");
	});

	["dragleave", "dragend"].forEach((type) => {
		dropZoneElement.addEventListener(type, (e) => {
		dropZoneElement.classList.remove("drop-zone--over");
		});
	});

	dropZoneElement.addEventListener("drop", (e) => {
		e.preventDefault();

		if (e.dataTransfer.files.length) {
		inputElement.files = e.dataTransfer.files;
		updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
		}

		dropZoneElement.classList.remove("drop-zone--over");
	});
	});

	/**
	 * Updates the thumbnail on a drop zone element.
	 *
	 * @param {HTMLElement} dropZoneElement
	 * @param {File} file
	 */
	function updateThumbnail(dropZoneElement, file) {	
	let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

	// First time - remove the prompt
	if (dropZoneElement.querySelector(".drop-zone__prompt")) {
		dropZoneElement.querySelector(".drop-zone__prompt").remove();
	}

	// First time - there is no thumbnail element, so lets create it
	if (!thumbnailElement) {
		thumbnailElement = document.createElement("div");
		thumbnailElement.classList.add("drop-zone__thumb");
		dropZoneElement.appendChild(thumbnailElement);
	}

	thumbnailElement.dataset.label = file.name;

	// Show thumbnail for image files
	if (file.type.startsWith("image/")) {
		const reader = new FileReader();

		reader.readAsDataURL(file);
		reader.onload = () => {
		thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
		};
	} else {
		thumbnailElement.style.background = `url('${wtp_admin_script.image_url}assets/images/file-csv-icon.png') no-repeat center / contain`;
	}
	}
	/** Drag & Drop function ends here*/


});