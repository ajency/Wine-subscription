<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
function subscription_content_func(){

global $wpdb;

$user_id =get_current_user_id();
$query = new WP_Query( array( 'post_type' => 'subscription','author' => $user_id, 'posts_per_page' => -1) ) ;
$subscription_data = $query->posts;

if(!empty($subscription_data)){
?>
  <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
    <thead>
      <tr>

<?php
foreach (indigo_subscription_orders_columns() as $column_id => $column_name) {
  ?>
   <th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
   
  <?php
}
?>
</tr>
 </thead>
    <tbody> 

<?php

foreach($subscription_data as $subscription_val) {
   ?>

  <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-pending order">

   <?php foreach ( indigo_subscription_orders_columns() as $column_id => $column_name ) { ?>
            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
           
              <?php if ( 'subscription-number' === $column_id ) { ?>
                <a href="<?php echo site_url()."/my-account/view-subscription/?subid=".$subscription_val->ID; ?>">
                  <?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $subscription_val->ID ?>
                </a>
               <?php } 

                elseif ( 'subscription-date' === $column_id ) {  
                  echo  $subscription_date = get_the_date( $format, $subscription_val->ID );
                }  
                elseif ( 'subscription-type' === $column_id ) {  
                  $subscriptiontype=get_post_meta( $subscription_val->ID, '_subscription_type',true );
                  echo '<span class="status-label">'.esc_html(ucfirst($subscriptiontype)).'</span>';
                }  
                elseif ( 'subscription-nextdate' === $column_id ) {  
                  echo  nextduedate( $subscription_val->ID);
                }  
                elseif ( 'subscription-actions' === $column_id ) {  
                 
                  echo "<a href=".site_url()."/my-account/view-subscription/?subid=".$subscription_val->ID.">View</a>";
                  
                } 

                ?> 
            </td>
    <?php } ?> 
    </tr>
   
<?php } ?>

</tbody>
    </table>
<?php
}
else{
  ?>
  <div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info noData">
   <div class="empty-wine"></div>
    <?php _e( 'You do not have any subscriptions. Click here to browse our Wine Packs.', 'woocommerce' ); ?>
    <a class="woocommerce-Button button" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
      <?php _e( 'Browse our Wine Packs', 'woocommerce' ) ?>
    </a>
  </div>

  <?php
}

} 
add_shortcode( 'subscription_content', 'subscription_content_func' );

