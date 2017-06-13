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

register_rest_route( $namespace, '/unsubscribe_session', 
  array(
    'methods' =>  WP_REST_Server::CREATABLE,
    'callback' => 'unsubscribe_session',
    )
  );

register_rest_route( $namespace, '/unsubscribe_orders', 
  array(
    'methods' =>  WP_REST_Server::CREATABLE,
    'callback' => 'unsubscribe_orders',
    )
  );

register_rest_route( $namespace, '/subscribe_session', 
  array(
    'methods' =>  WP_REST_Server::CREATABLE,
    'callback' => 'subscribe_session',
    )
  );

/**
 * registration api
 */
register_rest_route( $namespace, '/registration', array(
  'methods' =>  WP_REST_Server::CREATABLE,
  'callback' => 'registration'
  ) );

/**
 * registration api
 */
register_rest_route( $namespace, '/tradelist_email', array(
  'methods' =>  WP_REST_Server::CREATABLE,
  'callback' => 'tradelist_email'
  ) );



});



function unsubscribe_session(){
  
     unset($_SESSION['subscription_type']);
     return true;
}

function subscribe_session(){
  
     $_SESSION['subscription_type']=$_REQUEST['subscription'];
  
     return true;
}

function unsubscribe_orders(){
  $subscriptionid=$_POST['id'];
  update_post_meta( $subscriptionid, 'status','cancelled');
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
  
  $to=$data['user_email'];
  $subject="[Indigo Wine] - Account Registration";
  $message="Your Account has been Registered Successfully.";

  wp_mail( $to, $subject, $message, $headers = '', $attachments = array() );
 
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


/**
 * [tradelist_email description]
 * @return [type] [description]
 */
function tradelist_email(){
  
  $user_email=$_POST['email'];
  $to=$user_email;
  $subject="[Indigo Wine] - Trade Price List Enquiry";
  $message="Trade Price List Enquiry.";

  wp_mail( $to, $subject, $message, $headers = '', $attachments = array() );


  $admin_email = get_option('admin_email');
  $subject1="[Indigo Wine] - Price List Enquiry";
  $message1="Hi admin, 
  You have received a request for trade pricelist from ".$to;

  wp_mail( $admin_email, $subject1, $message1, $headers = '', $attachments = array() );


  return true;
}

