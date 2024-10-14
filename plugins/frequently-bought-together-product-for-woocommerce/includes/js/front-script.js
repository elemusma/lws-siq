jQuery( document ).ready(function() {

	var attrs = {};
	jQuery('.oc_cust_variation').find('.variation select[name^=attribute]').change(function() {

		jQuery('.oc_cust_variation').find('.variation select[name^=attribute]').each(function(){
			var null_value = jQuery(this).val();
			jQuery(this).closest('.fbtpfw_main').find('.occp_add_cart_button').addClass('disabled');
			if (null_value == '') {
				jQuery(this).closest('.fbtpfw_main').find('.occp_add_cart_button').addClass('disabled');
			}else{
				jQuery(this).closest('.fbtpfw_main').find('.occp_add_cart_button').removeClass('disabled');
		      	var attribute = jQuery(this).attr('name');
		      	var attribute_value = jQuery(this).val();
		      	attrs[attribute] = attribute_value;
		      	var proid = jQuery('.oc_cust_variation').attr('currentproid');
		      	jQuery.ajax({
					url: fbtpfw_OBJECT.ajaxurl,
					type: 'POST',
					data: {
						action : 'variation_switch_cus',
						attrs : attrs,
						curproid : proid
					},
					success : function(response) {
						if (jQuery('.fbtpfw_main.layout2').length != 0) {
							jQuery('ul.fbtpfw_ul .fbtpfw_each_item:eq(0) .product-attributes').hide();
							jQuery('ul.fbtpfw_ul .fbtpfw_each_item:eq(0) .fbtpfw_price_old').hide();
							jQuery('.fbtpfw_product_images tr td.fbtpfw_img:eq(0)').attr('image_pro_id', response.var_id);
							jQuery('.fbtpfw_product_images tr td.fbtpfw_img:eq(0) .fbtpfw_img_div img').attr('src', response.var_image);
							jQuery('ul.fbtpfw_ul .fbtpfw_each_item:eq(0) .product_check').val(response.var_id);
							jQuery('ul.fbtpfw_ul .fbtpfw_each_item:eq(0) .product_check').attr('price', response.var_price);
							jQuery('ul.fbtpfw_ul .fbtpfw_each_item:eq(0) .fbtpfw_product_title').html(response.var_name+', ');
							jQuery('ul.fbtpfw_ul .fbtpfw_each_item:eq(0) .fbtpfw_price_new').html(response.var_price_html);
						}

						var counter = 0;
				        var priceForAll = 0;
						jQuery(".product_check").each(function(index, value) {
					        if(jQuery(this).is(":checked")) {
					            $price = jQuery(this).attr('price');
					            priceForAll = priceForAll + $price * 1;
					        }
					        counter++;
					    });
					    jQuery(".fbtpfw_price_total").html(currency + priceForAll.toFixed(2));
					}
				});
			}
		});

    });

    jQuery('.oc_cust_variation').closest('.fbtpfw_main.layout2').find('.occp_add_cart_button').addClass('disabled');

    jQuery('body').on('click','.occp_add_cart_button.disabled',function(){
    	alert('Please select a variation!');
    	return false;
    });

    jQuery('.variation_id').change(function(){
		var var_id = jQuery(this).val();
		if (var_id != "" && var_id != 0) {
			jQuery.ajax({
				url: fbtpfw_OBJECT.ajaxurl,
				type: 'POST',
				data: 'action=variation_switch&var_id='+var_id,
				success : function(response) {
					if (jQuery('.fbtpfw_main.layout1').length != 0) {
						jQuery('.fbtpfw_each_curprod .product_check').val(var_id);
						jQuery('.fbtpfw_each_curprod .product_check').attr('price', response.var_price);
						jQuery('.fbtpfw_each_curprod .fbtpfw_product_title span').html(response.var_name);
						jQuery('.fbtpfw_each_curprod .fbtpfw_product_price').html(response.var_price_html);
						jQuery('.fbtpfw_each_curprod .fbtpfw_product_image img').attr('src', response.var_image);
					}

					var counter = 0;
			        var priceForAll = 0;
					jQuery(".product_check").each(function(index, value) {
				        if(jQuery(this).is(":checked")) {
				            $price = jQuery(this).attr('price');
				            priceForAll = priceForAll + $price * 1;
				        }
				        counter++;
				    });
				    jQuery(".fbtpfw_price_total").html(currency + priceForAll.toFixed(2));
				}
			});
		}
	});

	var price = jQuery(".fbtpfw_price_total").attr("data-total");
	var currency = jQuery(".formate").val();
	var total_items = jQuery(".product_check:checked").length;

	if(jQuery(".layout").val() == "layout1") {
    	jQuery(".product .single_add_to_cart_button").html(fbtpfw_OBJECT.add_to_cart_text+"("+total_items+")");
    } else {
    	jQuery(".occp_add_cart_button").val(fbtpfw_OBJECT.add_to_cart_text+"("+total_items+")");
    }


	jQuery(".product_check").change(function() {
		var total_items = jQuery(".product_check:checked").length;
		var pro_id = jQuery(this).val();
		if(jQuery(".layout").val() == "layout1") {
			jQuery(".product .single_add_to_cart_button").html(fbtpfw_OBJECT.add_to_cart_text+"("+total_items+")");
		} else {
        	jQuery(".occp_add_cart_button").val(fbtpfw_OBJECT.add_to_cart_text+"("+total_items+")");
        }

        var counter = 0;
        var priceForAll = 0;
    	jQuery(".product_check").each(function(index, value) {

    		loop_pro_id = jQuery(this).val();

    		imgPlus = jQuery(".product_check");

    		if(index > 0) {
    			loop_pro_img_id = jQuery(imgPlus[index - 1]).val();
    		} else {
    			loop_pro_img_id = 'false';
    		}


	        if(jQuery(this).is(":checked")) {
	            $price = jQuery(this).attr('price');
	            priceForAll = priceForAll + $price * 1;
	            jQuery(".fbtpfw_product_images").find(".fbtpfw_img[image_pro_id='"+loop_pro_id+"']").show();
	            if(loop_pro_img_id != 'false') {
	            	jQuery(".fbtpfw_product_images").find(".fbtpfw_img_plus[fbtpfw_imgpls_id='"+loop_pro_img_id+"']").show();
	            }

	        } else {

	        	jQuery(".fbtpfw_product_images").find(".fbtpfw_img[image_pro_id='"+loop_pro_id+"']").hide();
          		if(loop_pro_img_id != 'false') {
	        		jQuery(".fbtpfw_product_images").find(".fbtpfw_img_plus[fbtpfw_imgpls_id='"+loop_pro_img_id+"']").hide();
	        	}
	        }
	        counter++;
	    });

    	jQuery(".fbtpfw_price_total").html(currency + priceForAll.toFixed(2));

    });
});