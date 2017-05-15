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
});



function unsubscribe_session(){
  
     unset($_SESSION['subscription_type']);
     return true;
}

