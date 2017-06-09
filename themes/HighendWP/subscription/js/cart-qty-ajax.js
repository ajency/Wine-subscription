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
                var prevstatus=$('#subscription_status').val();
                $('.hb-main-content').html(data);
                //var newqty=multipleofproducts(currentVal);
                
                // if(prevstatus=='yes' && newqty!=currentVal){
                /*  if(prevstatus=='yes' ){
                    $('.get-started-sub').removeClass('hidden');
                    $('.cancel-subscription').addClass('hidden');

                    $('.error,.failure').removeClass('hidden');
                    $('#subscription_status').val('no');
                    $('.subscribe-content .success').addClass('hidden');  
                    $('.subscribe-val').text('');
                    $('.subscribe-data').addClass('hidden');     
                } */
               /* else if(prevstatus=='yes'){
                    $('#subscription_status').val('yes');
                }*/
            }
        });

    });

    function qty_cart(item_hash, item_quantity, currentVal,subscription_type) {
        
       currentRequest=  $.ajax({
            type: 'POST',
            url: cart_qty_ajax.ajax_url,
            data: {
                action: 'qty_cart',
                hash: item_hash,
                quantity: currentVal,
                subscription:subscription_type
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
        $("#subscribe_btn").text("Saving...");
        $('#subscribe_btn').addClass('disabled');
        var subscription_type = $("input[name='sub-type']:checked").val();
        
      var delay=300;
        $('.subscribe-content .woocommerce-cart-form__cart-item').find('input.qty')
            .each(function () {
                delay=delay+300;
                var item_hash = $(this).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
                var item_quantity = $(this).val();
                var currentVal = parseFloat(item_quantity);

                 var newqty=multipleofproducts(currentVal);
                 setTimeout(function() {
                     qty_cart(item_hash, item_quantity, newqty,subscription_type);
                 }, delay);
                
            });
          setTimeout(function() {  

            $(".subscription-type-popup").text(subscription_type.replace(/\b[a-z]/g,function(f){return f.toUpperCase();}));  
            $('.subscribe-content .success').removeClass('hidden');  
            $('#subscription_status').val('yes');
            $('.get-started-sub').addClass('hidden');
            $('.cancel-subscription').removeClass('hidden');
            $('.error,.failure').addClass('hidden');
            $("#subscribe_btn").text("Subscribe");
            $('.subscribe-val').text(subscription_type.replace(/\b[a-z]/g,function(f){return f.toUpperCase();}));
            $('#subscribe_btn').removeClass('disabled');
            $('.subscribe-data').removeClass('hidden');     
          },delay+2000);
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
    $(document).on('click', '.open-subscription-modal', function (event) {

      $('.crop-here').addClass('hb-visible-modal');
      $('.hb-modal-window').addClass('animate-modal');
      $('.error,.failure').addClass('hidden');
        
    }); 

    /**
     * unsubscribe 
     */
    $(document).on('click', '#unsubscribe-order', function (event) {
        $.post(cart_qty_ajax.siteapiurl+'unsubscribe_session', function(data, textStatus, xhr) {
            $('.get-started-sub').removeClass('hidden');
            $('.cancel-subscription').addClass('hidden');
            $('.error,.failure').removeClass('hidden');
            $('#subscription_status').val('no');
            $('.subscribe-content .success').addClass('hidden');
            $('.subscribe-val').text('');  
            $('.subscribe-data').addClass('hidden');     
        });
   

    });  

     $(document).on('click', '.hb-accordion-tab', function (event) {
      if($('.hb-accordion-tab').hasClass('active-toggle')){
        $('.hb-accordion-tab').removeClass('active-toggle');
        $('.hb-accordion-pane').css('display','none');
      }  
      else{
        $('.hb-accordion-tab').addClass('active-toggle');
        $('.hb-accordion-pane').css('display','block');
      }
     
            
    });
     
     /** added the trigger the main proceed to checkout btn on click of dummy checkout btn which is outside the form*/
     $(document).on('click', '.checkout-btn', function(event) {
         event.preventDefault();
         /* Act on the event */
         $('.checkout-button').trigger('click');

     });

     $(document).on('click', '#subscription-check', function(event) {
        var id='subscription_status';
    
        if($('#subscription-check').is(":checked")){
            $('#'+id).val('yes');
            var subscription_type = $("input[name='sub-type']:checked").val();

            subscribe_session(subscription_type);
        }
        else{
            $('#'+id).val('no');
            $.post(cart_qty_ajax.siteapiurl+'unsubscribe_session', function(data, textStatus, xhr) {
                $('.subscribe-data').addClass('hidden');  
                $('.sub-success').addClass('hidden');   
                $('.error,.failure').removeClass('hidden'); 
                $("html, body").animate({ scrollTop: 0 }, "slow"); 
            });

        }
    
    });

     $(document).on('click', '.switch-input', function(event) {
         //event.preventDefault();
         /* Act on the event */
         var id='subscription_status';

         if($('#subscription-check').is(":checked")){
             var subscription_type = $("input[name='sub-type']:checked").val();

            subscribe_session(subscription_type);
         }
        
     });

      $(document).on('change', '.sub-select', function(event) {
         //event.preventDefault();
         /* Act on the event */
         var id='subscription_status';

         if($('#subscription-check').is(":checked")){
          
             var subscription_type = $("#sub-type-combo").val();

            subscribe_session(subscription_type);
         }
        
     });



     function subscribe_session(subscription_type){

            $.post(cart_qty_ajax.siteapiurl+'subscribe_session', {subscription: subscription_type}, function(data, textStatus, xhr) {
              var date = new Date();
              var month = new Array();
              month[0] = "Jan";month[1] = "Feb";month[2] = "Mar";month[3] = "Apr";month[4] = "May";month[5] = "Jun";
              month[6] = "Jul";month[7] = "Aug";month[8] = "Sep";month[9] = "Oct";month[10] = "Nov";month[11] = "Dec";
              var n = month[date.getMonth()];
               $('.subscribe-val').html(subscription_type.replace(/\b[a-z]/g,function(f){return f.toUpperCase();}) +"<br>"+ n+" "+date.getDate()+", "+date.getFullYear());
                $('.subscribe-data').removeClass('hidden');   
                 $('.error,.failure').addClass('hidden');   
                 $('.sub-success').removeClass('hidden');   
                  $("html, body").animate({ scrollTop: 0 }, "slow"); 
            });
     }


   // $(document).on('click', '.productcategory-menu', function (event) {
       // event.preventDefault();
       // commented as no popup required on menu
      /*  var data = {
            action: 'is_user_logged_in'
        };

        jQuery.post(ajaxurl, data, function(response) {
            if(response == 'no') {
                
               
                $('.productcategory-menu a').attr({
                    'href': '/wp-login.php',
                    'class': 'simplemodal-login'
                });

            } 
        });*/
    //});   
      
});