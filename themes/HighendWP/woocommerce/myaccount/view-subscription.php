<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

?>
<p>

<?php

function view_subscription_content_func(){
  $pass_subscriptionid=$_GET['subid'];
  $order_id =get_post_meta( $pass_subscriptionid, 'original_orderid', true );
  $subscriptiontype_val=get_post_meta( $pass_subscriptionid, '_subscription_type',true );
  $subscriptiontype_title= ucfirst($subscriptiontype_val);
  
  $order = new WC_Order( $order_id );
  /* translators: 1: order number 2: order date 3: order status */
  printf(
    __( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
    '<mark class="order-number">' . $order->get_order_number() . '</mark>',
    '<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
    '<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
  );
?></p>

<?php
// $order = wc_get_order( $order_id );

$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?>

<section class="woocommerce-order-details">

  <!-- <h2 class="woocommerce-order-details__title"><?//php _e( 'Order details', 'woocommerce' ); ?></h2> -->
  <div class="orderDetail">
   
      <div class="product-entry"> 
        <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
          <thead>
            <tr>
              <th class="woocommerce-table__product-name product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
              <th class="woocommerce-table__product-table product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
            </tr>
          </thead>

          <tbody>
            <?php
              foreach ( $order->get_items() as $item_id => $item ) {
                $product = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );

                wc_get_template( 'order/order-details-item.php', array(
                  'order'          => $order,
                  'item_id'        => $item_id,
                  'item'           => $item,
                  'show_purchase_note' => $show_purchase_note,
                  'purchase_note'      => $product ? $product->get_purchase_note() : '',
                  'product'          => $product,
                ) );
              }
            ?>
          
          </tbody>

        </table>
    </div>
    <div class="sub-type">
      <h3 class="title">Subscription Type</h3>
        <?php echo '<p class="type status-label">'.$subscriptiontype_title.'</p>' ;?>
    </div>

  </div>
 
</section>

<?php


global $wpdb;

$user_id =get_current_user_id();
$query = new WP_Query( array( 'post_status'=>array('wc-pending','wc-processing','wc-on-hold','wc-completed','wc-cancelled','wc-refunded' ,'wc-failed'),
  'post_type' => 'shop_order',
  'author' => $user_id,
  'posts_per_page' => -1,
    'meta_query' => array(
        array(
           'key' => '_subscription_id',
           'value' => $pass_subscriptionid,
           'compare' => '='
        )
     )
  ) ) ;
$subscription_orders_data = $query->posts;

?>

<h4 class="order-title">Order Details</h4>

<div class="subscription-orders">
  <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
    <thead>
      <tr>

<?php
foreach (indigo_subscriptionaccount_orders_columns() as $column_id => $column_name) {
  ?>
   <th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
   
  <?php
}
?>
</tr>
 </thead>
    <tbody> 

<?php
if(!empty($subscription_orders_data)){

foreach($subscription_orders_data as $subscription_order_val) {

$order_d = new WC_Order( $subscription_order_val->ID);
$item_count = $order->get_item_count();
   ?>

    <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-pending order">

     <?php foreach ( indigo_subscriptionaccount_orders_columns() as $column_id => $column_name ) { ?>
              <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
             
                <?php if ( 'order-number' === $column_id ) { ?>
                  <a href="#">
                    <?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $subscription_order_val->ID ?>
                  </a>
                 <?php } 

                  elseif ( 'order-date' === $column_id ) {  
                    echo  $subscription_date = get_the_date( $format, $subscription_order_val->ID );
                  }  
                 
                  elseif ( 'order-status' === $column_id ) {  
                      echo esc_html( wc_get_order_status_name( $order_d->get_status() ) ); 
                  }  
                  elseif ( 'order-total' === $column_id ) {  
                   
                    printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order_d->get_formatted_order_total(), $item_count );
                    
                  } 
                  elseif ( 'order-actions' === $column_id ) {  
                   
                     echo "<a href=".site_url()."/my-account/view-order/".$subscription_order_val->ID.">View</a>";
                    
                  } 

                  ?> 
              </td>
      <?php } ?> 
      </tr>
     
  <?php } ?>

  </tbody>
      </table>
      </div>

    <?php  
  }
}
add_shortcode( 'view_subscription_content', 'view_subscription_content_func' );

?>