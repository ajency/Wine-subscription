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
register_rest_route( $namespace, '/registration', array(
  'methods' =>  WP_REST_Server::CREATABLE,
  'callback' => 'registration'
  ) );



});



function unsubscribe_session(){
  
     unset($_SESSION['subscription_type']);
     return true;
}

function unsubscribe_orders(){
  $subscriptionid=$_POST['id'];
  
  return true;
}


function registration(){

  parse_str($_REQUEST['data'], $data);

  $exists = email_exists($data['user_email']);
  if($exists!=''){
    return array("msgcode"=>"1");
  }

 createUser($data);
  
  $credentials['user_login'] =$data['user_email'];
  $credentials['user_password']  = $data['user_pass'];

  $user = wp_signon($credentials); 

  return array('msgcode' => '0');
}

/**
 * [createUser -method to create user]
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function createUser($data){
  global $wpdb;
  
  $userdata['user_login'] =$data['user_email'];
  $userdata['user_email'] = $data['user_email'];
  $userdata['user_pass']  = $data['user_pass'];
  $userdata['display_name']  = $data['first_name'].' '.$data['last_name'];


   $user_id = wp_insert_user($userdata);
    
   update_user_meta($user_id, 'first_name', $data['first_name'] );
   update_user_meta($user_id, 'last_name', $data['last_name'] );

}



