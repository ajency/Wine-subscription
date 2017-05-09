jQuery(function ($) {

    /**
     * onchange of the qty will update the cart page qty and subtotal
     */
     var currentRequest = null; 
    $(document).on('change', 'input.qty', function () {

        var item_hash = $(this).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
        var item_quantity = $(this).val();
        var currentVal = parseFloat(item_quantity);

   
       currentRequest=  $.ajax({
            type: 'POST',
            url: cart_qty_ajax.ajax_url,
            data: {
                action: 'qty_cart',
                hash: item_hash,
                quantity: currentVal,
            },
            beforeSend : function()    { 
                
                if(currentRequest != null) {
                    currentRequest.abort();
                }
            },
            success: function (data) {
                $('.hb-main-content').html(data);
            }
        });

    });

    function qty_cart(item_hash, item_quantity, currentVal) {
     
       currentRequest=  $.ajax({
            type: 'POST',
            url: cart_qty_ajax.ajax_url,
            data: {
                action: 'qty_cart',
                hash: item_hash,
                quantity: currentVal,
            },
            success: function (data) {
                $('.hb-main-content').html(data);
            }
        });

    }

/**
 * Onlick on subscribe btn (Popup) it will update the qty and price
 */
   
    $(document).on('click', '#subscribe_btn', function (event) {
        $('#subscribe_btn').addClass('disabled');

      var delay=300;
        $('.subscribe-content .woocommerce-cart-form__cart-item').find('input.qty')
            .each(function () {
                delay=delay+300;
                var item_hash = $(this).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
                var item_quantity = $(this).val();
                var currentVal = parseFloat(item_quantity);

                 var newqty=multipleofproducts(currentVal);
                 setTimeout(function() {
                     qty_cart(item_hash, item_quantity, newqty);
                 }, delay);
                
            });
          setTimeout(function() {  
            $('.subscribe-content .success').removeClass('hidden');  
          },delay);
    });
   

    function multipleofproducts(currentVal) {

        var rangearr = [];
        var final = [];
        for (var i = 1; i <= 500; i++) {
            rangearr.push(i);
            if (i % 6 == 0) {
                final.push(rangearr);
                rangearr = [];
            }
        }
        var newqty;
        $.each(final, function (index, val) {

            if ($.inArray(currentVal, val) >= 0) {
                newqty = Math.max(...val);
                console.log('j',newqty);
                return newqty;
            }
        });

        return newqty;
       
    }

      
    /**
     * subscribe now popup show
     */
    $(document).on('click', '#subscribe_now', function (event) {

      $('.crop-here').addClass('hb-visible-modal');
      $('.hb-modal-window').addClass('animate-modal');
        
    });   
});