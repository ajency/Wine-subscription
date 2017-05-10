
jQuery( function( $ ) {

   $( document ).on( 'keyup', '.discountvalue', function() {

     var selval=$( this ).attr( 'id' );
      if(selval=='_sale_discount_price'){
        if($('#'+selval).val()!='' && $('#'+selval).val()>0)
          $('#_sale_discount_percentage').attr('disabled', 'disabled');
        else
        {
          $('#_sale_discount_price').removeAttr('disabled');
          $('#_sale_discount_percentage').removeAttr('disabled');
        }
      }
      else if(selval=='_sale_discount_percentage'){
        if($('#'+selval).val()!=''  && $('#'+selval).val()>0)
          $('#_sale_discount_price').attr('disabled', 'disabled');
        else
        {
          $('#_sale_discount_price').removeAttr('disabled');
          $('#_sale_discount_percentage').removeAttr('disabled');
        }
      }
   });  
   
    if($('#_sale_discount_price').val()!='' && $('#_sale_discount_price').val() > 0){
       $('#_sale_discount_percentage').attr('disabled', 'disabled');
    }
    else if($('#_sale_discount_percentage').val()!='' && $('#_sale_discount_percentage').val() > 0){
       $('#_sale_discount_price').attr('disabled', 'disabled');
    }
    
    $('#publish').click(function(){
    
      var testervar = $('[id^=\"titlediv\"]')
      .find('#title');
      if (testervar.val().length < 1)
      {
        $('[id^=\"titlediv\"]').css('background', '#F96');
        setTimeout($('#ajax-loading').css('visibility', 'hidden'), 100);
        alert('Product Name is required');
        setTimeout($('#publish').removeClass('button-primary-disabled'), 100);
        return false;
      }

      if($('#_regular_price').val() <= 0 || $('#_regular_price').val() == ''){
        alert("Please Enter Regular Price");
        return false;
      }
     /*if($('#_sale_price').val()<= 0 || $('#_sale_price').val() == ''){
        alert("Please Enter Sales Price");
        return false;
      }*/
      if($('#taxonomy-product_cat input:checked').length==0){
        alert("Please select a category");
        return false;
      }
  	
  });


});