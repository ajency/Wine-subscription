<?php
if ( ! function_exists('subscription') ) {

// Register subscription Post Type
function subscription() {

  $labels = array(
    'name'                  => 'Subscriptions',
    'singular_name'         => 'Subscription',
    'menu_name'             => 'Subscription',
    'name_admin_bar'        => 'Subscriptions',
    'archives'              => 'Item Archives',
    'attributes'            => 'Item Attributes',
    'parent_item_colon'     => 'Parent Item:',
    'all_items'             => 'All Subscription',
    'add_new_item'          => 'Add New Subscription',
    'add_new'               => 'Add New',
    'new_item'              => 'New Item',
    'edit_item'             => 'Edit Item',
    'update_item'           => 'Update Item',
    'view_item'             => 'View Item',
    'view_items'            => 'View Items',
    'search_items'          => 'Search Item',
    'not_found'             => 'Not found',
    'not_found_in_trash'    => 'Not found in Trash',
    'featured_image'        => 'Featured Image',
    'set_featured_image'    => 'Set featured image',
    'remove_featured_image' => 'Remove featured image',
    'use_featured_image'    => 'Use as featured image',
    'insert_into_item'      => 'Insert into item',
    'uploaded_to_this_item' => 'Uploaded to this item',
    'items_list'            => 'Items list',
    'items_list_navigation' => 'Items list navigation',
    'filter_items_list'     => 'Filter items list',
  );
  $args = array(
    'label'                 => 'Subscription',
    'description'           => 'Subscription Description',
    'labels'                => $labels,
    'supports'              => array( 'title' ,'author','custom-fields' ),
    'taxonomies'            => array( ''),
    'hierarchical'          => false,
    'public'                => false,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => false,
    'can_export'            => true,
    'has_archive'           => true,    
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'capabilities' => array(
            'create_posts' => false
        )
  );
  register_post_type( 'subscription', $args );

}
add_action( 'init', 'subscription', 0 );

}


/**
 * filter to add custom columns in subscription listing in wp-dashboard
 */
add_filter( 'manage_edit-subscription_columns', 'my_subscription_columns' ) ;

function my_subscription_columns( $columns ) {

  $columns = array(
    
    'title' => __( 'Title' ),
    'author' => __( 'Subsriber Name' ),
    '_subscription_type' => __( 'Subscription Type' ),
    'date' => __( 'Date' )
  );

  return $columns;
}

/**
 * link data to custom columns in subscription listing for wp-dashboard
 */
add_action( 'manage_subscription_posts_custom_column', 'my_manage_subscription_columns', 10, 2 );

function my_manage_subscription_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    case '_subscription_type' :

      $_subscription_type = get_post_meta( $post_id, '_subscription_type', true );

      if ( empty( $_subscription_type ) )
        echo __( 'Unknown' );

      else
        printf( __( '%s' ), strtoupper($_subscription_type ));

      break;

      default :
      break;
  }
}


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
 * [add_custom_meta_data_for_order -method to add subscription custom post meta]
 */
function add_custom_meta_data_for_order($order_id, $posted ){
  print_r($posted );
  if(is_user_logged_in() && isset($_SESSION['subscription_type'])){
    
    $current_date=date('Y-m-d');
    $userid=get_current_user_id();
    $post_data=array('post_author' => $userid,'post_title' => 'Subscription-'.$current_date,'post_type' => 'subscription','post_status'=>'publish');
    $subscriptionid=wp_insert_post($post_data);
    update_post_meta( $subscriptionid, 'original_orderid', $order_id );
    update_post_meta( $subscriptionid, '_subscription_type',$_SESSION['subscription_type']);
    unset($_SESSION['subscription_type']);

    update_post_meta( $order_id, '_subscription_id', $subscriptionid );
  }

}

add_action('woocommerce_checkout_update_order_meta','add_custom_meta_data_for_order', 10, 2);

 
function indigo_add_subscription_endpoint() {
    add_rewrite_endpoint( 'subscription', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'view-subscription', EP_ROOT | EP_PAGES );
}
 
add_action( 'init', 'indigo_add_subscription_endpoint' );
 

function indigo_subscription_query_vars( $vars ) {
    $vars[] = 'subscription';
    $vars[] = 'view-subscription';
    return $vars;
}
 
add_filter( 'query_vars', 'indigo_subscription_query_vars', 0 );
 
 
function indigo_add_subscription_link_my_account( $items ) {
    $items = array(
      'orders'          => __( 'Orders', 'woocommerce' ),     
      'subscription'          => __( 'Subscription', 'woocommerce' ),
      'edit-address'    => __( 'Addresses', 'woocommerce' ),
      'edit-account'    => __( 'Account details', 'woocommerce' ),
    );
    return $items;
}
 
add_filter( 'woocommerce_account_menu_items', 'indigo_add_subscription_link_my_account' );
 

function indigo_subscription_content() {

  require get_template_directory().'/woocommerce/myaccount/subscription.php';
  echo do_shortcode( '[subscription_content]' );
  die();
}
 
add_action( 'woocommerce_account_subscription_endpoint', 'indigo_subscription_content' );


function indigo_view_subscription_content() {
  require get_template_directory().'/woocommerce/myaccount/view-subscription.php';
  echo do_shortcode( '[view_subscription_content]' );
  die();
}
 
add_action( 'woocommerce_account_view-subscription_endpoint', 'indigo_view_subscription_content' );


function filter_woocommerce_account_orders_columns( $array ) { 

  $array=array(
    'order-number'  => __( 'Order', 'woocommerce' ),
    'order-date'    => __( 'Date', 'woocommerce' ),
    'order-subtype'    => __( 'Subscription Type', 'woocommerce' ),
    'order-status'  => __( 'Status', 'woocommerce' ),
    'order-total'   => __( 'Total', 'woocommerce' ),
    'order-actions' => 'Action',
  ); 

    return $array; 
}; 
add_filter( 'woocommerce_account_orders_columns', 'filter_woocommerce_account_orders_columns', 10, 1 ); 

         
function indigo_subscription_orders_columns() {
  $columns = array(
    'subscription-number'  => __( 'Subscription ID', 'woocommerce' ),
    'subscription-date'    => __( ' Date', 'woocommerce' ),
    'subscription-type'  => __( 'Type', 'woocommerce' ),
    'subscription-nextdate'   => __( 'Next due on', 'woocommerce' ),
    'subscription-actions' => 'Action',
  ) ;

  return $columns;
}

function nextduedate($subscription_id){
  global $wpdb;
  $sql_subscribedOrder=$wpdb->prepare("select post_id as orderid from ".$wpdb->prefix."postmeta  where meta_key='_subscription_id' and meta_value=%d order by orderid desc",$subscription_id);
  $orderid=$wpdb->get_var($sql_subscribedOrder);
  $order_date = get_post($subscription_id)->post_date;

  $_subscription_type=get_post_meta( $subscription_id, '_subscription_type', true );
  if($_subscription_type=='monthly'){
    $nextduedate= date('Y-m-d', strtotime('+30 days', strtotime($order_date)));
  }
  elseif($_subscription_type=='quarterly'){
    $nextduedate= date('Y-m-d', strtotime('+90 days', strtotime($order_date)));
  }
  else{
    return $nextduedate="";
  }
  return date('M d, Y',strtotime($nextduedate));


}

function indigo_subscriptionaccount_orders_columns() { 

  $array=array(
    'order-number'  => __( 'Order', 'woocommerce' ),
    'order-date'    => __( 'Date', 'woocommerce' ),
    'order-status'  => __( 'Status', 'woocommerce' ),
    'order-total'   => __( 'Total', 'woocommerce' ),
    'order-actions' => 'Action',
  ); 

    return $array; 
}; 


?>