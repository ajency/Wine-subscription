<?php
if ( ! function_exists('subscription') ) {

// Register Custom Post Type
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


add_action( 'manage_subscription_posts_custom_column', 'my_manage_subscription_columns', 10, 2 );

function my_manage_subscription_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    /* If displaying the 'duration' column. */
    case '_subscription_type' :

      /* Get the post meta. */
      $_subscription_type = get_post_meta( $post_id, '_subscription_type', true );

      /* If no duration is found, output a default message. */
      if ( empty( $_subscription_type ) )
        echo __( 'Unknown' );

      /* If there is a duration, append 'minutes' to the text string. */
      else
        printf( __( '%s' ), strtoupper($_subscription_type ));

      break;

  
    /* Just break out of the switch statement for everything else. */
    default :
      break;
  }
}


?>