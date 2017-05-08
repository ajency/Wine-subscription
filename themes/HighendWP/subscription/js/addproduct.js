
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
   
   function editproductdiscount(){
    if($('#_sale_discount_price').val()!='' && $('#_sale_discount_price').val() > 0){
       $('#_sale_discount_percentage').attr('disabled', 'disabled');
    }
    else if($('#_sale_discount_percentage').val()!='' && $('#_sale_discount_percentage').val() > 0){
       $('#_sale_discount_price').attr('disabled', 'disabled');
    }
   }

   editproductdiscount();

});