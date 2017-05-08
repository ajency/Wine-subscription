<?php

// define the woocommerce_cart_item_subtotal callback 
function filter_woocommerce_cart_item_subtotal( $wc, $cart_item, $cart_item_key ) { 

  if(is_page('checkout')){
    return $wc; 
  }

    for($i=1;$i<=500;$i++){
         $rangearr[]=$i;
         if($i%6==0){
          $final[]=$rangearr;
          $rangearr=array();
         }
     } 
     foreach($final as $value){
        
          if(in_array($cart_item['quantity'],$value)){
            $updateqty= max($value);
            break;
          }
     }

     if($cart_item['quantity']!=$updateqty) {  // added as new functio
?>
      <script type="text/javascript">
      
      var popup= "<?php echo isset($_REQUEST['popup'])?$_REQUEST['popup']: "true";  ?>";
      var popup='false';
      if(popup=="true"){
        var r = confirm("Do You Want to Create a Subscription! Click Yes to Create one Else click No !");
        if (r == true) {
          
             jQuery('input[name="cart[<?php echo $cart_item_key;?>][qty]"]').val(<?php echo $updateqty;?>);
         
          var item_hash = jQuery( 'input[name="cart[<?php echo $cart_item_key;?>][qty]"]' ).attr( 'name' ).replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
          var item_quantity = jQuery('input[name="cart[<?php echo $cart_item_key;?>][qty]"]').val();
          var currentVal = parseFloat(item_quantity);
          var ajax_url= "<?php echo admin_url( 'admin-ajax.php' ) ; ?>";

          function qty_cart() {

              jQuery.ajax({
                  type: 'POST',
                  url: ajax_url,
                  data: {
                      action: 'qty_cart',
                      hash: item_hash,
                      quantity: currentVal,
                      popup:true
                  },
                  success: function(data) {
                      jQuery( '.hb-main-content' ).html(data);
                  }
              });  

          }

         qty_cart();

        }
      }      
 </script>
  <?php
  }
    return $wc; 
}; 

// add_filter( 'woocommerce_cart_item_subtotal', 'filter_woocommerce_cart_item_subtotal', 10, 3 ); 



/**
 * [subscription_process_order - method to create duplicate orders based on the subscription selected]
 * @param  [type] $order_id [original order id]
 */
function subscription_process_order($order_id) {

    $order = new WC_Order( $order_id );
    $subscription_type=get_post_meta( $order_id,  '_subscription_type', true);
    $_subscription_noofmonths=get_post_meta( $order_id,  '_subscription_noofmonths', true);

    require get_template_directory().'/subscription/class-wc-admin-duplicate-order.php';
    $duplication=new WC_Admin_Duplicate_Order();
    $dupmethod= $duplication->duplicate_order_action($order_id);

}
// add_action('woocommerce_payment_complete', 'subscription_process_order', 10, 1);


/**
 * [add_custom_meta_data_for_order -method to add subscription details]
 */
function add_custom_meta_data_for_order($order_id, $posted ){
  update_post_meta( $order_id, '_subscription_type', '' );
  update_post_meta( $order_id, '_subscription_noofmonths', '' );
}

// add_action('woocommerce_checkout_update_order_meta','add_custom_meta_data_for_order', 10, 2);

?>