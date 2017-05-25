<?php

function highend_child_theme_enqueue_styles() {
    $parent_style = 'highend-parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'highend-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
// add_action( 'wp_enqueue_scripts', 'highend_child_theme_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'highend_parent_theme_enqueue_styles' );
add_action('wp_enqueue_scripts', 'theme_js');
function highend_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style('font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.css');
}
function theme_js() {
	wp_enqueue_script( 'readmore', get_stylesheet_directory_uri() . '/readmore.min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'theme_js', get_stylesheet_directory_uri() . '/custom.js', array( 'jquery' ), '1.0', true );
}

function wpb_custom_new_menu() {
  register_nav_menu('my-custom-menu',__( 'left menu' ));
}
add_action( 'init', 'wpb_custom_new_menu' );


function wpb_custom_new_menuu() {
  register_nav_menu('my-custom-menuu',__( 'right menu' ));
}
add_action( 'init', 'wpb_custom_new_menuu' );



//* Make Font Awesome available
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {

    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );

}

/**
 * Place a cart icon with number of items and total cost in the menu bar.
 *
 * Source: http://wordpress.org/plugins/woocommerce-menu-bar-cart/
 */

// add_filter('wp_nav_menu_items','sk_wcmenucart', 10, 2);
// function sk_wcmenucart($menu, $args) {

//     // Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
//     if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'my-custom-menuu' !== $args->theme_location || !is_user_logged_in())
//         return $menu;

//         ob_start();
//         global $woocommerce;
//         $viewing_cart = __('View your shopping cart', 'your-theme-slug');
//         $start_shopping = __('Start shopping', 'your-theme-slug');
//         $cart_url = $woocommerce->cart->get_cart_url();
//         $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
//         $cart_contents_count = $woocommerce->cart->cart_contents_count;
//         $cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'your-theme-slug'), $cart_contents_count);
//         $cart_total = $woocommerce->cart->get_cart_total();
//         // Uncomment the line below to hide nav menu cart item when there are no items in the cart
//         // if ( $cart_contents_count > 0 ) {
//             if ($cart_contents_count == 0) {
//                 $menu_item = '<li class="right"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
//             } else {
//                 $menu_item = '<li class="right"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
//             }

//             $menu_item .= '<i class="fa fa-shopping-cart"></i> ';

//             // $menu_item .= $cart_contents.' - '. $cart_total;
//             $menu_item .= $cart_contents;
//             $menu_item .= '</a></li>';
//         // Uncomment the line below to hide nav menu cart item when there are no items in the cart
//         // }
//         echo $menu_item;
//     $social = ob_get_clean();
//     return $menu . $social;

// }


/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {

    ob_start();
    $count = WC()->cart->cart_contents_count;

    ?>
    <a class="wcmenucart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">

    <?php
   
       $menu_item="";

    if ( $count > 0 ) {
   
        $cart_contents = sprintf(_n('%d item', '%d items', $count, 'indigo-wine'), $count);
        $menu_item .= '<i class="fa fa-shopping-cart"></i> ';

        $menu_item .= $cart_contents;

        echo $menu_item;        
    }
        ?></a><?php
 
    $fragments['a.wcmenucart-contents'] = ob_get_clean();
     
    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );


add_filter('wp_nav_menu_items','sk_wcmenucart', 10, 2);
function sk_wcmenucart($menu, $args) {

    // Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
    if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'my-custom-menuu' !== $args->theme_location || !is_user_logged_in())
        return $menu;

        ob_start();
        global $woocommerce;
        $viewing_cart = __('View your shopping cart', 'your-theme-slug');
        $start_shopping = __('Start shopping', 'your-theme-slug');
        $cart_url = $woocommerce->cart->get_cart_url();
        $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
        $cart_contents_count = $woocommerce->cart->cart_contents_count;
        if($cart_contents_count>0){
            $cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'indigo-wine'), $cart_contents_count);
            $cart_total = $woocommerce->cart->get_cart_total();
            // Uncomment the line below to hide nav menu cart item when there are no items in the cart
            // if ( $cart_contents_count > 0 ) {
                if ($cart_contents_count == 0) {
                    $menu_item = '<li class="right"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
                } else {
                    $menu_item = '<li class="right"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
                }

                $menu_item .= '<i class="fa fa-shopping-cart"></i> ';

                // $menu_item .= $cart_contents.' - '. $cart_total;
                $menu_item .= $cart_contents;
                $menu_item .= '</a></li>';
            // Uncomment the line below to hide nav menu cart item when there are no items in the cart
            // }
            echo $menu_item;
        }
    $social = ob_get_clean();
    return $menu . $social;

}



 
//Enqueue Ajax Scripts
function enqueue_cart_qty_ajax() {
    wp_register_script( 'cart-qty-ajax-js', get_template_directory_uri() . '/subscription/js/cart-qty-ajax.js', array( 'jquery' ), '', true );
    wp_localize_script( 'cart-qty-ajax-js', 'cart_qty_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ,'siteapiurl' => get_option('siteurl').'/wp-json/wp/v2/') );
    wp_enqueue_script( 'cart-qty-ajax-js' );

}
add_action('wp_enqueue_scripts', 'enqueue_cart_qty_ajax');

function ajax_qty_cart() {

    // Set item key as the hash found in input.qty's name
    $cart_item_key = $_POST['hash'];

    // Get the array of values owned by the product we're updating
    $threeball_product_values = WC()->cart->get_cart_item( $cart_item_key );

    // Get the quantity of the item in the cart
    $threeball_product_quantity = apply_filters( 'woocommerce_stock_amount_cart_item', apply_filters( 'woocommerce_stock_amount', preg_replace( "/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT)) ), $cart_item_key );

    // Update cart validation
    $passed_validation  = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity );


   

    if(isset($_POST['subscription']))
    {    
         
        $term_list = wp_get_post_terms($threeball_product_values['product_id'],'product_cat',array('fields'=>'slugs'));
        if(in_array('wine', $term_list))
        {    
            if ( $passed_validation ) {
                WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
            }
        }

        $_SESSION['subscription_type'] = $_POST['subscription'];
            
    }
    else{
          // Update the quantity of the item in the cart
        if ( $passed_validation ) {
            WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
        }

    }   

    echo do_shortcode( '[woocommerce_cart]' );
    die();

}

add_action('wp_ajax_qty_cart', 'ajax_qty_cart');
add_action('wp_ajax_nopriv_qty_cart', 'ajax_qty_cart');


// Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );

function woo_add_custom_general_fields() {

  global $woocommerce, $post;
  
  echo '<div class="options_group">';
  
 woocommerce_wp_text_input( 
    array( 
        'id'          => '_sale_discount_price', 
        'label'       => __( 'Discount Price ($)', 'woocommerce' ), 
        'placeholder' => '',
        'desc_tip'    => 'true',
        'class'    => 'discountvalue',
        'description' => __( 'Product Discount in Price.', 'woocommerce' ),
        'type'              => 'number', 
        'custom_attributes' => array(
                'step'  => 'any',
                'min'   => '0'
            )  
    )
);
 
 echo '<div style=" margin-left: 380px;"> OR </div>';

  woocommerce_wp_text_input( 
    array( 
        'id'          => '_sale_discount_percentage', 
        'label'       => __( 'Discount %', 'woocommerce' ), 
        'placeholder' => '',
        'desc_tip'    => 'true',
        'class'    => 'discountvalue',
        'description' => __( 'Product Discount in %.', 'woocommerce' ),
        'type'              => 'number', 
        'custom_attributes' => array(
                'step'  => 'any',
                'min'   => '0'
            )  
    )
);


  
  echo '</div>';
    
}

// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

function woo_add_custom_general_fields_save( $post_id ){
    
    // Text Field
    $woocommerce_text_field = isset($_POST['_sale_discount_price']) ? $_POST['_sale_discount_price'] : 0 ;
    update_post_meta( $post_id, '_sale_discount_price', esc_attr( $woocommerce_text_field ) );
        
    // Number Field
    $woocommerce_number_field = isset($_POST['_sale_discount_percentage']) ? $_POST['_sale_discount_percentage'] : 0 ;
    update_post_meta( $post_id, '_sale_discount_percentage', esc_attr( $woocommerce_number_field ) );
    
}



function add_product_admin_scripts( $hook ) {

    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'product' === $post->post_type ) {     
            wp_enqueue_script(  'addproduct', get_template_directory_uri().'/subscription/js/addproduct.js' );
        }
    }
}
add_action( 'admin_enqueue_scripts', 'add_product_admin_scripts', 10, 1 );


function custom_shop_page_redirect() {
    if(( is_product_category() || is_product() ) && !is_user_logged_in()){
        wp_redirect( home_url() );
        exit();
    }
}
add_action( 'template_redirect', 'custom_shop_page_redirect' );



function indigo_wine_woocommerce_cart_product_subtotal( $product_subtotal, $product, $quantity, $instance ) { 
    global $woocommerce;
    
    $product_id=$product->get_id();
   
    $product_subtotal= indigo_discountCalculation($product_id, $quantity,$product_subtotal);

    return wc_price($product_subtotal);
}; 

add_filter( 'woocommerce_cart_product_subtotal', 'indigo_wine_woocommerce_cart_product_subtotal', 10, 4 ); 


function indigo_wine_filter_woocommerce_cart_subtotal( $cart_subtotal, $compound, $instance ) { 
  
    global $woocommerce;
    $final_total=0;
    foreach ($instance->cart_contents as  $cart_item_key => $cart_value) {
       $product_id=$cart_value['product_id'];
       $quantity=$cart_value['quantity'];
       $line_total=$cart_value['line_total'];
       $final_total=$final_total+indigo_discountCalculation($product_id,$quantity,$line_total,$cart_item_key);
    }

    // $woocommerce->cart->total=$final_total;
    // $woocommerce->cart->cart_contents_total=$final_total;
    // $woocommerce->cart->subtotal=$final_total;
    // $woocommerce->cart->subtotal_ex_tax=$final_total;
    
    return wc_price($final_total); 
}; 
         
// add_filter( 'woocommerce_cart_subtotal', 'indigo_wine_filter_woocommerce_cart_subtotal', 10, 3 ); 


function sale_custom_price($cart_object) {
    global $woocommerce;
    $final_total=0;
    foreach ($cart_object->cart_contents as  $cart_item_key => $cart_value) {

       
       $product_id=$cart_value['product_id'];
       $quantity=$cart_value['quantity'];
       $line_total=$cart_value['line_total'];
       $final_total=$final_total+indigo_discountCalculation($product_id,$quantity,$line_total,$cart_item_key);


        $price=get_post_meta($product_id,  '_price', true );
        $row_price        = $price * $quantity;
        $final_total=$row_price-$final_total;
    }

    $discount=$final_total;
    $cart_object->add_fee('Discount', -$discount, true, '');
    
}
add_action( 'woocommerce_cart_calculate_fees', 'sale_custom_price');



function indigo_discountCalculation($product_id, $quantity,$product_subtotal,$cart_item_key=''){
    global $woocommerce;
     $price=get_post_meta($product_id,  '_price', true );

    $row_price        = $price * $quantity;

   
    $term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'slugs'));
    
    if((indigo_rangelogic($quantity) && in_array('wine', $term_list)) || !in_array('wine', $term_list)){
        $discount_perc=get_post_meta($product_id,  '_sale_discount_percentage', true );
        $discount_price=get_post_meta($product_id,  '_sale_discount_price', true );
       
   
        if($discount_perc!='' && $discount_perc !=0){     

          $discounted_price_perc=(($discount_perc*$row_price)/100);
          
          $discounted_price=$row_price-$discounted_price_perc;

          /*$woocommerce->cart->discount_cart=$woocommerce->cart->discount_cart+$discounted_price_perc;

          if( $cart_item_key!='')
          {  
            $woocommerce->cart->cart_contents[ $cart_item_key ]['line_total']=$discounted_price;
            $woocommerce->cart->cart_contents[ $cart_item_key ]['line_subtotal']=$discounted_price;
          }*/
     
          return $final_product_subtotal= $discounted_price;
         
        }
        else if($discount_price!='' && $discount_price !=0){
           
            $discounted_price=$row_price-$discount_price;
            
            /*$woocommerce->cart->discount_cart=$woocommerce->cart->discount_cart+$discount_price;
    
            if( $cart_item_key!='')
            {    
                $woocommerce->cart->cart_contents[ $cart_item_key ]['line_total']=$discounted_price;
                $woocommerce->cart->cart_contents[ $cart_item_key ]['line_subtotal']=$discounted_price;
            }*/
       
            return $final_product_subtotal= $discounted_price;
              
        }  
    } 
    
       

    return $row_price; 
}


/**
 * [indigo_rangelogic - added to get the max value of provided value in a given range]
 * @param  [type] $quantity [description]
 * @return [type]           [description]
 */
function indigo_rangelogic($quantity){
     for($i=1;$i<=500;$i++){
         $rangearr[]=$i;
         if($i%6==0){
          $final[]=$rangearr;
          $rangearr=array();
         }
     } 
     foreach($final as $value){
        
          if(in_array($quantity,$value)){
            $updateqty= max($value);
            break;
          }
     }

     if($updateqty==$quantity){
        return true;
     }
     return false;
}

// add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 10 );

/**
 * [filter_woocommerce_product_categories_widget_args -code to display subcategories of current product categories ]
 * @param  [type] $list_args [description]
 * @return [type]            [description]
 */
function filter_woocommerce_product_categories_widget_args( $list_args ) { 

     if (is_product_category() || isset($_REQUEST['s'])) {
        
        global $wp_query;
        
        $cat = $wp_query->get_queried_object();
        if($cat->slug=='wine-packs' || $cat->slug=='wine'){ 
           $list_args['child_of']=$cat->term_id;
        }
        else if(isset($_REQUEST['product_cat'])){
            $list_args['child_of']=$_REQUEST['product_cat'];
        }
    }
    
    return $list_args; 
}; 
         
add_filter( 'woocommerce_product_categories_widget_args', 'filter_woocommerce_product_categories_widget_args', 10, 1 ); 


function retitle_woo_category_widget($title, $widet_instance, $widget_id) {

    if ( $widget_id !== 'woocommerce_product_categories' )
        return $title;


   if ( (is_product_category() || isset($_REQUEST['s'])) && has_term( 'wine-packs', 'product_cat' ) ) {
 
        return __('Wine Packs');

    // If 'Category' 2 is being viewed...
    } else if ( (is_product_category() || isset($_REQUEST['s'])) && has_term( 'wine', 'product_cat' ) ) {
        return __('Wines');
    }
    
    return $title;
}
add_filter ( 'widget_title' , 'retitle_woo_category_widget', 10, 3);
/**
 * end of the code to display subcategories of current product categories 
 */


/**
 * [indigo_start_session initialize session]
 * @return [type] [description]
 */
function indigo_start_session()
{
    if (!session_id())
        session_start();
}
add_action("init", "indigo_start_session", 1);




/**
 * [cart_script_disabled -disabled ajax call on cart page - removing items duplication issue]
 * @return [type] [description]
 */
function cart_script_disabled(){
    wp_dequeue_script( 'wc-cart' );
}
add_action( 'wp_enqueue_scripts', 'cart_script_disabled' );



add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );

function woo_rename_tabs( $tabs ) {

    $tabs['description']['title'] = __( 'Wine story' );       // Rename the description tab
    $tabs['reviews']['title'] = __( 'Customer reviews' );                // Rename the reviews tab
    $tabs['additional_information']['title'] = __( 'Wine notes' );    // Rename the additional information tab

    return $tabs;

}

require get_template_directory()."/subscription/product-subscription.php"; // custom order subscription code


require get_stylesheet_directory()."/api/index.php"; //api registration


// Sort popularity and rating removed
function my_woocommerce_catalog_orderby( $orderby ) {
    unset($orderby["popularity"]);
    unset($orderby["rating"]);
    return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "my_woocommerce_catalog_orderby", 20 );


// Logged-in user shortcode
function check_user ($params, $content = null){

  if ( !is_user_logged_in() ){
    $content = 'simplemodal-login';
    return $content;

  }

  else{

    return;

  }

}
add_shortcode('loggedin', 'check_user' );

/**
 * [ajax_check_user_logged_in js loggedin check]
 * @return [type] [description]
 */
function ajax_check_user_logged_in() {
    echo is_user_logged_in()?'yes':'no';
    die();
}
add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');

/**
 * [filter_posts_clauses - modify query -product filter in current product-category]
 * @param  [type] $args [description]
 * @return [type]       [description]
 */
function filter_posts_clauses( $args ) { 
    global $wpdb;
  
    if(isset($_REQUEST['product_cat']))
    {
        $categories=get_term_children( $_REQUEST['product_cat'], 'product_cat' );
        array_push($categories, $_REQUEST['product_cat']);

        $args['join'] .= " LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)  ";
        $args['where'] = "  AND (
              wp_posts.ID NOT IN (
                            SELECT object_id
                            FROM wp_term_relationships
                            WHERE term_taxonomy_id IN (11)
                        ) 
              AND wp_term_relationships.term_taxonomy_id IN (".implode(',', $categories).")  
    
            ) AND (((wp_posts.post_title LIKE '%my%') OR (post_excerpt LIKE '%".$_REQUEST['s']."%') OR (wp_posts.post_excerpt LIKE '%".$_REQUEST['s']."%') OR (wp_posts.post_content LIKE '%".$_REQUEST['s']."%')))  AND wp_posts.post_type = 'product' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'private') ";

       
    }
    return $args;
}
     
add_filter( 'posts_clauses', 'filter_posts_clauses', 10, 1 ); 




 // add_filter( 'posts_request', 'dump_request' );

function dump_request( $input ) {

    var_dump($input);

    return $input;
}



/**
 * [indigo_tag_cloud_class_active method add active-tag class against selected tag]
 * @param  [type] $tags_data [description]
 * @return [type]            [description]
 */
function indigo_tag_cloud_class_active($tags_data) { 
    
    $body_class = get_body_class(); 
    foreach ($tags_data as $key => $tag) {
        if(in_array('term-'.$tag['id'], $body_class)) { 
            $tags_data[$key]['class'] = $tags_data[$key]['class'] ." active-tag"; 
        } 
    }

    return $tags_data; 
 }

add_filter('wp_generate_tag_cloud_data', 'indigo_tag_cloud_class_active');



/**
 * [mandatory_excerpt addded to set description when creating products]
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function mandatory_excerpt($data) {
   if ( 'product' == $data['post_type'] ) {
       
        $excerpt = $data['post_excerpt'];
        $post_content = $data['post_content'];

        if (empty($post_content)) {
        
            if ($data['post_status'] === 'publish') {
              add_filter('redirect_post_location', 'content_error_message_redirect', '99');
            }
        
            $data['post_status'] = 'draft';
        } 
        else if (empty($excerpt)) {
        
            if ($data['post_status'] === 'publish') {
              add_filter('redirect_post_location', 'excerpt_error_message_redirect', '99');
            }
        
            $data['post_status'] = 'draft';
        }
   } 

  return $data;
}


add_filter('wp_insert_post_data', 'mandatory_excerpt');

function excerpt_error_message_redirect($location) {
  remove_filter('redirect_post_location', __FILTER__, '99');
  return add_query_arg('excerpt_required', 1, $location);
}


function content_error_message_redirect($location) {
  remove_filter('redirect_post_location', __FILTER__, '99');
  return add_query_arg('excerpt_required', 2, $location);
}


function excerpt_admin_notice() {
  if (!isset($_GET['excerpt_required'])) return;
    switch (absint($_GET['excerpt_required'])) {
        case 1:
          $message = 'Product Short Description is mandatory.';
          break;
        case 2:
          $message = 'Product  Description is mandatory.';

          break;
        default:
          $message = 'Unexpected error';
    }
  echo '<div id="notice" class="error"><p>' . $message . '</p></div>';
}


add_action('admin_notices', 'excerpt_admin_notice');

/**
 * End of the mandatory description code
 */

function filter_woocommerce_return_to_shop_redirect( $wc_get_page_permalink ) { 
    $wc_get_page_permalink= home_url()."/product-category/wine-packs"; ;
    return $wc_get_page_permalink; 
}; 
         
add_filter( 'woocommerce_return_to_shop_redirect', 'filter_woocommerce_return_to_shop_redirect', 10, 1 ); 




