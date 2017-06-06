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
    'show_in_menu'          => 'woocommerce',
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
    'id' => __( 'Subscription ID' ),
    'author' => __( 'Subsriber Name' ),
    '_subscription_type' => __( 'Subscription Type' ),
    '_subscription_status' => __( 'Status' ),
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

      case '_subscription_status' :

      $_subscription_status = get_post_meta( $post_id, 'status', true );

      if ( empty( $_subscription_status ) )
        echo __( 'Unknown' );

      else
        printf( __( '%s' ), strtoupper($_subscription_status ));

      break;

      case 'id':
          echo "<a href='/post.php?post=".$post_id."&action=edit'>#".$post_id."</a>";
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
    
    require get_template_directory().'/subscription/class-wc-admin-duplicate-order.php';
    $duplication=new WC_Admin_Duplicate_Order();
    $dupmethod= $duplication->duplicate_order_action($order_id);
    return true;
}
// add_action('woocommerce_payment_complete', 'subscription_process_order', 10, 1);


/**
 * [add_custom_meta_data_for_order -method to add subscription custom post meta]
 */
function add_custom_meta_data_for_order($order_id, $posted ){
 
  global $woocommerce;
  if(is_user_logged_in() && isset($_SESSION['subscription_type'])){
    
    $items_names = array();

    foreach($woocommerce->cart->get_cart() as $cart_item){
        $items_names[] = $cart_item['data']->post->post_title;
    }
    $string_cart_item_names = implode( ', ', $items_names );

    $current_date=date('Y-m-d');
    $userid=get_current_user_id();
    $post_data=array('post_author' => $userid,'post_title' => 'Subscription-'.$string_cart_item_names,'post_type' => 'subscription','post_status'=>'publish');
    $subscriptionid=wp_insert_post($post_data);
    update_post_meta( $subscriptionid, 'original_orderid', $order_id );
    update_post_meta( $subscriptionid, '_subscription_type',$_SESSION['subscription_type']);
    update_post_meta( $subscriptionid, 'status','active');
    update_post_meta( $subscriptionid, 'last_order_date',date('Y-m-d')); 
    update_post_meta( $order_id, '_subscription_id', $subscriptionid );
    
    unset($_SESSION['subscription_type']);
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
  
}
 
add_action( 'woocommerce_account_subscription_endpoint', 'indigo_subscription_content' );


function indigo_view_subscription_content() {
  require get_template_directory().'/woocommerce/myaccount/view-subscription.php';
  echo do_shortcode( '[view_subscription_content]' );
 
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

/**
 * [indigo_subscription_orders_columns -subscription listing in my account page]
 * @return [type] [description]
 */
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

/**
 * [nextduedate -calculation]
 * @param  [type] $subscription_id [description]
 * @return [type]                  [description]
 */
function nextduedate($subscription_id){
  global $wpdb;
  /*$sql_subscribedOrder=$wpdb->prepare("select post_id as orderid from ".$wpdb->prefix."postmeta  where meta_key='_subscription_id' and meta_value=%d order by orderid desc",$subscription_id);
  $orderid=$wpdb->get_var($sql_subscribedOrder);
  $order_date = get_post($subscription_id)->post_date;*/

  $order_date=get_post_meta( $subscription_id, 'last_order_date', true );

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

/**
 * [indigo_subscriptionaccount_orders_columns -listing columns for order details on subscription detail view]
 * @return [type] [description]
 */
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

function getallorderidbysubscription($subscription_id){
  global $wpdb;
  $sql_subscribedOrder=$wpdb->prepare("select post_id as orderid from ".$wpdb->prefix."postmeta  where meta_key='_subscription_id' and meta_value=%d order by orderid desc",$subscription_id);
  $orderid=$wpdb->get_results($sql_subscribedOrder,ARRAY_A);
  foreach ( $orderid as $value) {
    $orderids[]=$value['orderid'];
  }
  $orderids=implode(',', $orderids);
  return $orderids;
}




/**
 * Cron Process- Subscription Order
 */

function cron_process_subscription_order(){

  global $wpdb;

  $query = new WP_Query( array( 'post_type' => 'subscription','posts_per_page' => -1,  'meta_query' => array(
        array(
           'key' => 'status',
           'value' => 'active',
           'compare' => '='
        )
     )) ) ;
  $subscription_data = $query->posts;

  if(!empty($subscription_data)){

    foreach ($subscription_data as $subscription_order_val) {
      $last_order_date=get_post_meta( $subscription_order_val->ID, 'last_order_date', true );
      $_subscription_type=get_post_meta( $subscription_order_val->ID, '_subscription_type', true );

      $next_preorderdate='';
      if($_subscription_type=='monthly' && $last_order_date!=''){
        $next_preorderdate= date('Y-m-d', strtotime('+23 days', strtotime($last_order_date))); // create a order prior to 7 days of actual order date
      }
      else if($_subscription_type=='quarterly' && $last_order_date!=''){
        $next_preorderdate= date('Y-m-d', strtotime('+83 days', strtotime($last_order_date))); // create a order prior to 7 days of actual order date
      }
      
      // echo "\n".$next_preorderdate;
      if($next_preorderdate==date('Y-m-d')){

        $original_orderid=get_post_meta( $subscription_order_val->ID, 'original_orderid', true );
        $results= subscription_process_order($original_orderid);
       
        $future_date= date('Y-m-d', strtotime('+7 days', strtotime($next_preorderdate))); 
  
        update_post_meta(  $subscription_order_val->ID , 'last_order_date', date('Y-m-d',strtotime($future_date)));

      }
    }

  }
  return 'Subscription Created Succesfully';
}

// add_action( 'init', 'cron_process_subscription_order');



add_action( 'woocommerce_duplicate_order', 'woocommerce_duplicate_order_additional_fields', 10, 2 );

function woocommerce_duplicate_order_additional_fields($new_id,$post){
   
  $original_orderid= $post->id;
  $_subscription_id=get_post_meta( $original_orderid, '_subscription_id', true );

  update_post_meta( $new_id, '_subscription_id', $_subscription_id );
  /*
  $dpost = array();
  $post_date=get_the_date('',$pass_subscriptionid);
  $future_date= date('Y-m-d H:i:s', strtotime('+7 days', strtotime($post_date))); 
  
  $dpost['ID'] = $new_id; 
  $dpost['post_date'] = $future_date; 
  $dpost['post_date_gmt'] = $future_date; 
  
  update_post_meta(  $_subscription_id , 'last_order_date', date('Y-m-d',strtotime($future_date)));

  wp_update_post($dpost);*/

}
