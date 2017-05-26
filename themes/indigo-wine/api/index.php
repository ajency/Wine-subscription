<?php 
/**
 * REST API - hook to register the api endpoints
 */
add_action( 'rest_api_init', function () {

/**
 * [$version description]
 */
$version = '2';
$namespace = 'wp/v' . $version;

/**
 * All Product related api for admin
 */
register_rest_route( $namespace, '/unsubscribe_session', 
  array(
    'methods' =>  WP_REST_Server::CREATABLE,
    'callback' => 'unsubscribe_session',
    )
  );

/**
 * All Product related api for admin
 */
register_rest_route( $namespace, '/unsubscribe_orders', 
  array(
    'methods' =>  WP_REST_Server::CREATABLE,
    'callback' => 'unsubscribe_orders',
    )
  );

});



function unsubscribe_session(){
  
     unset($_SESSION['subscription_type']);
     return true;
}

function unsubscribe_orders(){
  $subscriptionid=$_POST['id'];
  
  return true;
}
