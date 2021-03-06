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
    wp_enqueue_style( 'jquery.datetimepicker.min', get_stylesheet_directory_uri() . '/jquery.datetimepicker.min.css' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style('font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.css');
}
function theme_js() {
    $current_user=wp_get_current_user();
  
    wp_enqueue_script( 'scroll', get_stylesheet_directory_uri() . '/jquery.easeScroll.min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'readmore', get_stylesheet_directory_uri() . '/readmore.min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'datetimepicker', get_stylesheet_directory_uri() . '/jquery.datetimepicker.full.min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'theme_js', get_stylesheet_directory_uri() . '/custom.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'theme_js', 'users', array( 'email' =>  $current_user->user_email));
    wp_enqueue_script( 'theme_js' );

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
     // if ($count == 0) {
     //    $r_page_url = filter_woocommerce_return_to_shop_redirect($parameter);
     // }
     // else{
     //      $r_page_url =  WC()->cart->get_cart_url();
     // }
    $r_page_url =  WC()->cart->get_cart_url();
    ?>
    <a class="wcmenucart-contents" href="<?php echo $r_page_url; ?>" title="<?php _e( 'View your shopping cart' ); ?>">

    <?php
   
       $menu_item="";

   // if ( $count > 0 ) {
   
        $cart_contents = sprintf(_n('%d item', '%d items', $count, 'indigo-wine'), $count);
        $menu_item .= '<i class="fa fa-shopping-cart"></i> ';

        $menu_item .= $cart_contents;

        echo $menu_item;        
    //}
        ?></a><?php
 
    $fragments['a.wcmenucart-contents'] = ob_get_clean();
     
    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );


add_filter('wp_nav_menu_items','sk_wcmenucart', 10, 2);
function sk_wcmenucart($menu, $args) {

    // Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
    //if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'my-custom-menuu' !== $args->theme_location || !is_user_logged_in())
    if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'my-custom-menuu' !== $args->theme_location)
        return $menu;

        ob_start();
        global $woocommerce;
        $viewing_cart = __('View your shopping cart', 'your-theme-slug');
        $start_shopping = __('Start shopping', 'your-theme-slug');
        $cart_url = $woocommerce->cart->get_cart_url();
        $shop_page_url = filter_woocommerce_return_to_shop_redirect($parameter);
        $cart_contents_count = $woocommerce->cart->cart_contents_count;
        //if($cart_contents_count>0){
            $cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'indigo-wine'), $cart_contents_count);
            $cart_total = $woocommerce->cart->get_cart_total();
            // Uncomment the line below to hide nav menu cart item when there are no items in the cart
            // if ( $cart_contents_count > 0 ) {
                if ($cart_contents_count == 0) {
                    $menu_item = '<li class="right"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $start_shopping .'">';
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
       // }
    $social = ob_get_clean();
    return $menu . $social;

}



 
//Enqueue Ajax Scripts
function enqueue_cart_qty_ajax() {
    wp_register_script( 'cart-qty-ajax-js', get_template_directory_uri() . '/subscription/js/cart-qty-ajax.js', array( 'jquery' ), '', true );
    wp_localize_script( 'cart-qty-ajax-js', 'cart_qty_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ,'siteapiurl' => get_option('siteurl').'/wp-json/wp/v2/','homeurl' => home_url() ));
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

    unset($_SESSION['subscription_type']);
   

    if(isset($_POST['subscription']))
    {    
         
        $term_list = wp_get_post_terms($threeball_product_values['product_id'],'product_cat',array('fields'=>'ids'));
        
        $category_object = get_term_by('slug', 'wine', 'product_cat');
      
        $categories=get_term_children( $category_object->term_id, 'product_cat' );
        array_push($categories, $category_object->term_id);

           
        $totals = array_intersect($categories, $term_list);

        // if(in_array('wine', $term_list) )
        if(count($totals) > 0 )
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

   echo '<div class="options_group">';
     woocommerce_wp_text_input( 
        array( 
            'id'          => '_header_desc', 
            'label'       => __( 'Header Description', 'woocommerce' ), 
            'placeholder' => '',
            'desc_tip'    => 'true',
            'class'    => '_header_desc',
            'description' => __( 'Header Description.', 'woocommerce' ),
            'type'              => 'text', 
            'custom_attributes' => array(
                    'step'  => 'any'                   
                )  
        )
    );
    echo '</div>';
}

// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

function woo_add_custom_general_fields_save( $post_id ){
    
  
    $woocommerce_text_field = isset($_POST['_sale_discount_price']) ? $_POST['_sale_discount_price'] : 0 ;
    update_post_meta( $post_id, '_sale_discount_price', esc_attr( $woocommerce_text_field ) );
        

    $woocommerce_number_field = isset($_POST['_sale_discount_percentage']) ? $_POST['_sale_discount_percentage'] : 0 ;
    update_post_meta( $post_id, '_sale_discount_percentage', esc_attr( $woocommerce_number_field ) );

   
    $woocommerce_text_field = isset($_POST['_header_desc']) ? $_POST['_header_desc'] : 0 ;
    update_post_meta( $post_id, '_header_desc', esc_attr( $woocommerce_text_field ) );
    
}

//Login - Remember me checked by default
function login_checked_remember_me() {
    add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );

function rememberme_checked() {
    echo "<script>document.getElementById('rememberme').checked = true;</script>";
}

//Login expiry changed to 1 year
add_filter ( 'auth_cookie_expiration', 'wpdev_login_session' );
 
function wpdev_login_session( $expire ) { // Set login session limit in seconds
    return YEAR_IN_SECONDS;
    // return MONTH_IN_SECONDS;
    // return DAY_IN_SECONDS;
    // return HOUR_IN_SECONDS;
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
    if($_SERVER['X-Cache-Group']=='bot'){
      //no action
    }
    /* else if(( is_product_category() || is_product() || is_cart() || is_shop()) && !is_user_logged_in()){  // REMOVE LOGIN ON Caegory and product page */
    //else if(( is_cart() || is_shop()) && !is_user_logged_in()){
    /*else if((is_shop()) && !is_user_logged_in()){
        

        if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
            $url =  urlencode( wp_unslash("//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"));
           
        } else {
            
            $url =  urlencode( wp_unslash("https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"));
        }

          // wp_redirect( home_url('?login=true') ); 
        wp_redirect( home_url('wp-login.php?redirect_to='. $url.'&reauth=1') );
        exit();
    }*/
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

        $term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));
        $category_object = get_term_by('slug', 'wine', 'product_cat');
       
        $categories=get_term_children( $category_object->term_id, 'product_cat' );
        array_push($categories, $category_object->term_id);
     
        $totals = array_intersect($categories, $term_list);

        if((indigo_rangelogic($quantity) && count($totals) > 0) || count($totals)==0){
            $final_total=$final_total+indigo_discountCalculation($product_id,$quantity,$line_total,'getonlydiscount');
        }

    /*    $price=get_post_meta($product_id,  '_price', true );
        $row_price        = $price * $quantity;
        $final_total=$row_price-$final_total;*/
    }

    $discount=$final_total;

    if($discount!=0)
        $cart_object->add_fee('Discount', -$discount, true, '');
    
}
add_action( 'woocommerce_cart_calculate_fees', 'sale_custom_price');



function indigo_discountCalculation($product_id, $quantity,$product_subtotal,$cart_item_key=''){
    global $woocommerce;
    $price=get_post_meta($product_id,  '_price', true );

    $row_price        = $price * $quantity;

    $term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));
     
    $category_object = get_term_by('slug', 'wine', 'product_cat');
   
    $categories=get_term_children( $category_object->term_id, 'product_cat' );
    array_push($categories, $category_object->term_id);
  

    $totals = array_intersect($categories, $term_list);
    
    if((indigo_rangelogic($quantity) && count($totals) > 0) || count($totals)==0){
        $discount_perc=get_post_meta($product_id,  '_sale_discount_percentage', true );
        $discount_price=get_post_meta($product_id,  '_sale_discount_price', true );
        
   
        if($discount_perc>0 ){     
        
          $discounted_price_perc=(($discount_perc*$row_price)/100);
           if($cart_item_key=='getonlydiscount') {
            return $discounted_price_perc;
          } 
         
          
          $discounted_price=$row_price-$discounted_price_perc;

          /*$woocommerce->cart->discount_cart=$woocommerce->cart->discount_cart+$discounted_price_perc;

          if( $cart_item_key!='')
          {  
            $woocommerce->cart->cart_contents[ $cart_item_key ]['line_total']=$discounted_price;
            $woocommerce->cart->cart_contents[ $cart_item_key ]['line_subtotal']=$discounted_price;
          }*/
     
          return $final_product_subtotal= $discounted_price;
         
        }
        else if($discount_price>0){
            if($cart_item_key=='getonlydiscount') {
                return $discount_price;
            }  
            // $discounted_price=$row_price-($discount_price*$quantity);
            $discounted_price=$row_price-$discount_price;
           
            /*$woocommerce->cart->discount_cart=$woocommerce->cart->discount_cart+$discount_price;
    
            if( $cart_item_key!='')
            {    
                $woocommerce->cart->cart_contents[ $cart_item_key ]['line_total']=$discounted_price;
                $woocommerce->cart->cart_contents[ $cart_item_key ]['line_subtotal']=$discounted_price;
            }*/
       
            return $final_product_subtotal= $discounted_price;
              
        }  

         if($cart_item_key=='getonlydiscount') {
            return 0;
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

     if (is_product_category() || isset($_REQUEST['product_cat'])) {
        
        global $wp_query;
        
        $cat = $wp_query->get_queried_object();
       
        if($cat->slug=='wine-packs' || $cat->slug=='wine' ){ 
           $list_args['child_of']=$cat->term_id;
        }
        else if($cat->parent!=0){
              $list_args['child_of']=$cat->parent;
        }
        else if(isset($_REQUEST['product_cat'])){
            $cat_1= get_term_by( 'id',$_REQUEST['product_cat'], 'product_cat' );
          
            if(is_object($cat_1))
            {
                if($cat_1->parent==0){         
                  
                    $searchcat=$cat_1->term_id;
                }
                else if($cat_1->parent!=0){   
                          
                      $searchcat=$cat_1->parent;
                }
            }
            else{
              
              $searchcat=$_REQUEST['product_cat'];
            }

            $list_args['child_of']=$searchcat;
        }

    }
    
    return $list_args; 
}; 
         
add_filter( 'woocommerce_product_categories_widget_args', 'filter_woocommerce_product_categories_widget_args', 10, 1 ); 


function retitle_woo_category_widget($title, $widet_instance, $widget_id = null) {
    if ( $widget_id !== 'woocommerce_product_categories' )
        return $title;
    
    if (is_product_category()){
        global $wp_query;
        $cat = $wp_query->get_queried_object();

       
        if($cat->parent==0)         
                return __($cat->name);
        else if($cat->parent!=0){            
                $name=  get_cat_name( $cat->parent );
                return __($name); 
        }

    }
    else if(isset($_REQUEST['product_cat'])){
        $cat_1= get_term_by( 'id',$_REQUEST['product_cat'], 'product_cat' );
       
        if(is_object($cat_1))
        {
            if($cat_1->parent==0)         
                    return __($cat_1->name);
            else if($cat_1->parent!=0){ 
                
                $name1=  get_term( $cat_1->parent );
                return __($name1->name); 
            }
        }
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

    if(isset($tabs['description']))
    $tabs['description']['title'] = __( 'Wine story' );       // Rename the description tab

    if(isset($tabs['reviews']))
    $tabs['reviews']['title'] = __( 'Customer reviews' );                // Rename the reviews tab

    if(isset($tabs['additional_information']))
    $tabs['additional_information']['title'] = __( 'Wine notes' );    // Rename the additional information tab

    return $tabs;

}



// add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );

// function woo_rename_tabs( $tabs ) {

//     global $product;
    
//     if( $product->has_attributes() || $product->has_dimensions() || $product->has_weight() ) { // Check if product has attributes, dimensions or weight
//         $tabs['additional_information']['title'] = __( 'Wine notes' );
//     }
 
//     return $tabs;
 
// }



add_filter( 'woocommerce_product_tabs', 'reordered_tabs', 98 );

function reordered_tabs( $tabs ) {
    $tabs['additional_information']['priority'] = 5; 
    $tabs['description']['priority'] = 10; 
    $tabs['reviews']['priority'] = 50;
 
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
        if(is_numeric($_REQUEST['product_cat']) && $_REQUEST['product_cat']!=0){

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
        
                ) AND (((wp_posts.post_title LIKE '%".$_REQUEST['s']."%') OR (post_excerpt LIKE '%".$_REQUEST['s']."%') OR (wp_posts.post_excerpt LIKE '%".$_REQUEST['s']."%') OR (wp_posts.post_content LIKE '%".$_REQUEST['s']."%')))  AND wp_posts.post_type = 'product' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'private') ";
        }

       
    }
    if(isset($_REQUEST['search_subscriptionid'])){
       $orderids=getallorderidbysubscription($_REQUEST['s']);

        $args['where']="AND wp_posts.ID IN (".$orderids.") AND wp_posts.post_type = 'shop_order' AND ((wp_posts.post_status = 'wc-pending' OR wp_posts.post_status = 'wc-processing' OR wp_posts.post_status = 'wc-on-hold' OR wp_posts.post_status = 'wc-completed' OR wp_posts.post_status = 'wc-cancelled' OR wp_posts.post_status = 'wc-refunded' OR wp_posts.post_status = 'wc-failed'))";
        

    }
    if(isset($_REQUEST['post_type']) && $_REQUEST['post_type']=='subscription' && $_REQUEST['s']!=''){
         $args['where']="AND wp_posts.ID IN (".$_REQUEST['s'].") AND wp_posts.post_type = '".$_REQUEST['post_type']."'";
    }

    if(isset($_REQUEST['unsubscribe'])){ //backend -unsubscribe the subscription
        update_post_meta( $_REQUEST['subscription_id'], 'status', 'cancelled');
    }
    // echo '<pre>';
    // print_r($args);
    return $args;
}
     
add_filter( 'posts_clauses', 'filter_posts_clauses', 10, 1 ); 




 // add_filter( 'posts_request', 'dump_request' );

function dump_request( $input ) {
    echo "sairaj";
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
    $wc_get_page_slug = isset($_SESSION['category_slug']) ? $_SESSION['category_slug'] : "/product-category/wine-packs"; 
    return home_url($wc_get_page_slug); 
}; 
         
add_filter( 'woocommerce_return_to_shop_redirect', 'filter_woocommerce_return_to_shop_redirect', 10, 1 ); 

function filter_custom_return_to_shop_redirect( $post_id ) {
    $product_cat = wp_get_post_terms($post_id, 'product_cat');
    foreach ($product_cat as $key => $value) {
        $product_category[] = $value->slug;
    }

    if (in_array("wine-packs", $product_category))
    {
        $wc_set_page_permalink= home_url()."/product-category/wine-packs";
    }
    else if (in_array("wine", $product_category))
    {
        $wc_set_page_permalink= home_url()."/product-category/wine";
    }
    else
    {
        $wc_set_page_permalink= get_permalink( wc_get_page_id( 'shop' ) );
    }

    return $wc_set_page_permalink; 
}; 
         
add_filter( 'custom_return_to_shop_redirect', 'filter_custom_return_to_shop_redirect', 10, 1 );


/**
 * Show Regular/Sale Price @ WooCommerce Cart Table
 */
 
add_filter( 'woocommerce_cart_item_price', 'indigo_change_cart_table_price_display', 30, 3 );
 
function indigo_change_cart_table_price_display( $price, $values, $cart_item_key ) {
    $slashed_price = $values['data']->get_price_html();
    $is_on_sale = $values['data']->is_on_sale();
    if ( $is_on_sale ) {
     $price = $slashed_price;
    }
    
    return $price;
}

/**
 * [wpse_lost_password_redirect -redirection when password is reseted]
 * @return [type] [description]
 */
function wpse_lost_password_redirect() {

    // Check if have submitted
    $confirm = ( isset($_GET['action'] ) && $_GET['action'] == resetpass );

    if( $confirm ) {
        wp_redirect( home_url('?login=true') );
        exit;
    }
}
// add_action('login_headerurl', 'wpse_lost_password_redirect');

// redirects for login / logout
add_filter('login_redirect', 'login_redirect');

function login_redirect($redirect_to) {
  
    if(stripos($redirect_to,'/wp-admin/') !== false)
        return home_url( '/shop' );
    else
        return $redirect_to;

}

// add_action('wp_logout','logout_redirect');

function logout_redirect(){

    wp_redirect( home_url() );
    
    exit;

}


function login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri().'/misc.css' );
    wp_enqueue_style( 'Font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
}
add_action( 'login_enqueue_scripts', 'login_stylesheet' );



function show_login_popup() {
    
    if( $_GET['login'] && $_SERVER['REQUEST_METHOD'] == 'GET') {
 
        wp_register_script( 'custom-login-popup', get_template_directory_uri() . '/scripts/custom-login-popup.js', array( 'jquery' ), '', true );
        wp_enqueue_script( 'custom-login-popup' );
   }
}
add_action('init','show_login_popup');


/*add_filter('term_link', 'term_link_filter', 10, 3);
function term_link_filter( $url, $term, $taxonomy ) {

    if($taxonomy=='product_tag'){
        global $wp_query;
        $product_cat= (isset($_GET['product_cat'])) ? $_GET['product_cat'] : $wp_query->get_queried_object_id();

        return $url . "?product_cat=".$product_cat;
    }
   
}*/

/*function login_redirect_peter($p1,$p2,$p3,$p4){
    wp_redirect(home_url());
    exit();
}
add_filter( 'rul_before_user', 'login_redirect_peter', 10, 4 );
*/



//registration page changes 

////1. Add a new form element...
add_action( 'register_form', 'indigo_register_form' );
function indigo_register_form() {
    ?>
        <p style="display: none;">
            <label for="name"><?php _e( 'Name', 'mydomain' ) ?><br />
                <input type="text" name="name" id="name" class="input" value="<?php echo esc_attr( wp_unslash( $name ) ); ?>" size="25" /></label>
        </p>
        <?php
    $first_name = ( ! empty( $_POST['first_name'] ) ) ? trim( $_POST['first_name'] ) : '';
        
        ?>
        <p>
            <label for="first_name"><?php _e( 'First Name', 'mydomain' ) ?><span class="required-label">*</span><br />
                <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr( wp_unslash( $first_name ) ); ?>" size="25" /></label>
        </p>
        <?php  

        $last_name = ( ! empty( $_POST['last_name'] ) ) ? trim( $_POST['last_name'] ) : '';
        
        ?>
        <p>
            <label for="last_name"><?php _e( 'Last Name', 'mydomain' ) ?><span class="required-label">*</span><br />
                <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr( wp_unslash( $last_name ) ); ?>" size="25" /></label>
        </p>
        <?php

          $user_pass = ( ! empty( $_POST['user_pass'] ) ) ? trim( $_POST['user_pass'] ) : '';
        
        ?>
        <p>
            <label for="user_pass"><?php _e( 'Password', 'mydomain' ) ?><span class="required-label">*</span><br />
                <input type="password" name="user_pass" id="user_pass" class="input" size="25" /></label>
        </p>
        <?php
          $user_cpass = ( ! empty( $_POST['user_cpass'] ) ) ? trim( $_POST['user_cpass'] ) : '';
        
        ?>
        <p>
            <label for="user_cpass"><?php _e( 'Confirm Password', 'mydomain' ) ?><span class="required-label">*</span><br />
                <input type="password" name="user_cpass" id="user_cpass" class="input" size="25" /></label>
        </p>
        <?php
    }

    //2. Add validation. In this case, we make sure first_name is required.
    add_filter( 'registration_errors', 'indigo_registration_errors', 10, 3 );
    function indigo_registration_errors( $errors, $sanitized_user_login, $user_email ) {
        if ( $_POST['name'] != '' ) {
            $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: Invalid fields entered.', 'mydomain' ) );
        } 
        if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
            $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must include a first name.', 'mydomain' ) );
        }  
        if ( empty( $_POST['last_name'] ) || ! empty( $_POST['last_name'] ) && trim( $_POST['last_name'] ) == '' ) {
            $errors->add( 'last_name_error', __( '<strong>ERROR</strong>: You must include a last name.', 'mydomain' ) );
        } 
        if ( empty( $_POST['user_pass'] ) || ! empty( $_POST['user_pass'] ) && trim( $_POST['user_pass'] ) == '' ) {
            $errors->add( 'user_pass_error', __( '<strong>ERROR</strong>: Password Cannot be empty.', 'mydomain' ) );
        }
        if ( empty( $_POST['user_cpass'] ) || ! empty( $_POST['user_cpass'] ) && trim( $_POST['user_cpass'] ) == '' ) {
            $errors->add( 'user_cpass_error', __( '<strong>ERROR</strong>: Confirm Password Cannot be empty.', 'mydomain' ) );
        }
        else if ($_POST['user_cpass']!=$_POST['user_pass'] ) {
            $errors->add( 'user_cpass_error', __( '<strong>ERROR</strong>: Password Mismatch.', 'mydomain' ) );
        }
        return $errors;
    }

    //3. Finally, save our extra registration user meta.
    add_action( 'user_register', 'indigo_user_register' );
    function indigo_user_register( $user_id ) {
        if ( ! empty( $_POST['first_name'] ) ) {
            update_user_meta( $user_id, 'first_name', trim( $_POST['first_name'] ) );
        } 
        if ( ! empty( $_POST['last_name'] ) ) {

            $display_name=$_POST['first_name'].' '.$_POST['last_name'];

            update_user_meta( $user_id, 'last_name', trim( $_POST['last_name'] ) );
            wp_update_user( array( 'ID' => $user_id, 'display_name' => $display_name ) );
        }
        if ( ! empty( $_POST['user_pass'] ) ) {
             wp_set_password($_POST['user_pass'], $user_id);
        }
         $credentials['user_login'] =$_POST['user_email'];
          $credentials['user_password']  = $_POST['user_pass'];
          
          $to=$_POST['user_email'];
          $subject="Your username and password";
          $message="";

          //wp_mail( $to, $subject, $message, $headers = '', $attachments = array() );
         
          $user = wp_signon($credentials); 

          if($_POST['wp-submit'] == 'Register'){
              header('location:'.filter_woocommerce_return_to_shop_redirect($parameter));
              exit();
          }
    }


add_action('login_head', function(){
?>
    <style>
        #registerform > p:first-child{
            display:none;
        }
    </style>

    <script type="text/javascript" src="<?php echo site_url('/wp-includes/js/jquery/jquery.js'); ?>"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#registerform > p:first-child').css('display', 'none');
            jQuery('#registerform,#loginform,#lostpasswordform,#resetpassform').addClass('login-reg');
            jQuery('<p class="message login-reg-msg">Please login to see product details.</p>').insertBefore("#loginform");
            jQuery('<p class="message login-reg-msg">Enter your new password below.</p>').insertBefore("#resetpassform");
            jQuery('<p class="message login-reg-msg">Welcome to Indigo Wine Co. Register to get details of our curated wine collection.</p>').insertBefore("#registerform");
            jQuery('#registerform label[for="user_email"]').prepend('<span class="required-label">*</span>');
            jQuery('.login-action-lostpassword .message').text('Please enter your email address. You will receive a link to create a new password via email.');
            jQuery('#reg_passmail').addClass('email-notify');
            jQuery('#backtoblog a').text('← Back to Home');
            if(jQuery('#resetpassform').hasClass('login-reg')){
                jQuery('.message.reset-pass').addClass('hidden');
            }
            var label_name = $('.login label[for="user_login"]').contents().first()[0].textContent;
            $('.login label[for="user_login"]').contents().first()[0].textContent = label_name.replace("Username or Email Address", "Email Address");
        });
    </script>
<?php
});

//Remove error for username, only show error for email only.
add_filter('registration_errors', function($wp_error, $sanitized_user_login, $user_email){
    if(isset($wp_error->errors['empty_username'])){
        unset($wp_error->errors['empty_username']);
    }

    if(isset($wp_error->errors['username_exists'])){
        unset($wp_error->errors['username_exists']);
    }
    return $wp_error;
}, 10, 3);

add_action('login_form_register', function(){
    if(isset($_POST['user_login']) && isset($_POST['user_email']) && !empty($_POST['user_email'])){
        $_POST['user_login'] = $_POST['user_email'];
    }
});

// Add filter for registration email body
add_filter('wp_mail','handle_wp_mail');

function handle_wp_mail($atts) {
    
    if(isset($atts['to'])){
    if (isset ($atts ['subject']) && substr_count($atts ['subject'],'Your username and password')>0 ) {
        if (isset($atts['message'])) {
           $user = get_user_by( 'email', $atts['to'] );
           $data=array('email'=>$atts['to'],'display_name'=>$user->display_name);
           $atts['subject']='Welcome to Indigo Wine Co';
           $atts['message'] = generate_email_template('registration_mail',$data);

        }
    }

    else if (isset ($atts ['subject']) && substr_count($atts ['subject'],'Password Reset')>0 ) {
        if (isset($atts['message'])) {
            $user = get_user_by( 'email', $atts['to'] );

            $key = get_password_reset_key( $user );

            $url= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login');

            $data=array('email'=>$atts['to'],'display_name'=>$user->display_name,'message'=>$atts['message'],'url'=>$url);
            
           $atts['message'] = generate_email_template('passwordreset_mail',$data);

        }
    }
    else  if (isset ($atts ['subject']) && substr_count($atts ['subject'],'Trade Price List Enquiry')>0 ) {
        if (isset($atts['message'])) {
            $user = get_user_by( 'email', $atts['to'] );
            $data=array('email'=>$atts['to'],'display_name'=>$user->display_name);
            
           $atts['message'] = generate_email_template('trade_pricelist',$data);


            $admin_email = get_option('admin_email');
            $subject1="[Indigo Wine] - Price List Enquiry";
            $message1="Hi admin, 
            You have received a request for trade pricelist from ".$atts['to'];

            wp_mail( $admin_email, $subject1, $message1, $headers = '', $attachments = array() );


        }
    }
    }
    return ($atts);
}

add_filter( 'wp_mail_content_type', function( $content_type ) {
    return 'text/html';
});

require get_stylesheet_directory()."/email-template/email-template.php";
//end of the registration form changes

/**
 * Additing column to orders post type
 */
add_filter( 'manage_edit-shop_order_columns', 'custom_shop_order_column',11);
function custom_shop_order_column($columns)
{
  
    $columns                     = array();
    $columns['cb']               = $existing_columns['cb'];
    $columns['order_status']     = '<span class="status_head tips" data-tip="' . esc_attr__( 'Status', 'woocommerce' ) . '">' . esc_attr__( 'Status', 'woocommerce' ) . '</span>';
    
    $columns['order_title']      = __( 'Order', 'woocommerce' );
    
    $columns['subscription'] = __( 'Subscription ID','indigo-wine');
    
    $columns['billing_address']  = __( 'Billing', 'woocommerce' );
    $columns['shipping_address'] = __( 'Ship to', 'woocommerce' );
    //$columns['customer_message'] = '<span class="notes_head tips" data-tip="' . esc_attr__( 'Customer message', 'woocommerce' ) . '">' . esc_attr__( 'Customer message', 'woocommerce' ) . '</span>';
    //$columns['order_notes']      = '<span class="order-notes_head tips" data-tip="' . esc_attr__( 'Order notes', 'woocommerce' ) . '">' . esc_attr__( 'Order notes', 'woocommerce' ) . '</span>';
    $columns['order_date']       = __( 'Date', 'woocommerce' );
    $columns['order_total']      = __( 'Total', 'woocommerce' );
    $columns['order_actions']    = __( 'Actions', 'woocommerce' );

   return $columns;
}

// adding the data to columns 
add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 10, 2 );
function custom_orders_list_column_content( $column )
{
    global $post, $woocommerce, $the_order;
    $order_id = $the_order->id;

    switch ( $column )
    {
        case 'subscription' :
            $_subscription_id = get_post_meta(  $order_id, '_subscription_id', true );
            if($_subscription_id!=''){
                //echo "<a href='edit.php?s=".$_subscription_id."&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1&action2=-1&search_subscriptionid=yes'>#".$_subscription_id."</a><br><a href='/post.php?post=".$_subscription_id."&action=edit'>View</a>"; 
                echo "<a href='edit.php?s=".$_subscription_id."&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1&action2=-1&search_subscriptionid=yes'>#".$_subscription_id."</a>";
            }
            break;

        
    }
}

/**
 * end of the adding columnn code
 */




add_action('woocommerce_review_order_after_cart_contents','checkout_subscription_type');

function checkout_subscription_type(){
    if(isset($_SESSION['subscription_type'])){
        $date=date('M j, Y'); 
            echo '<tr class="cart_item">
                        <td class="product-name sub-height">
                            Subscription Type <br> Start Date</td>
                        <td class="product-total sub-height">
                            <span class="woocommerce-Price-amount amount">'.ucfirst($_SESSION['subscription_type']).' <br>'.$date.'</span>
                        </td>
                    </tr>';
    }
}



remove_filter( 'lostpassword_url', 'wc_lostpassword_url' );


add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
  function jk_related_products_args( $args ) {
    $args['posts_per_page'] = 5; // 4 related products
    $args['columns'] = 4; // arranged in 2 columns
    return $args;
}


/**
 * [subscription_details_on_orderpage - subscription details on order page]
 * @param  [type] $order [description]
 * @return [type]        [description]
 */
function subscription_details_on_orderpage($order){

     $_preferred_date = $order->get_meta( '_preferred_date' );
      $_preferred_time = $order->get_meta( '_preferred_time' );
    echo "<h3 style='margin-top: 30px;'> Preferred Delivery Slot</h2>
                <p>Preferred Day : ".$_preferred_date."</p>
                <p>Preferred Time: ".$_preferred_time."</p>";

    $field_value = $order->get_meta( '_subscription_id' );

    if($field_value!='')
    { 
        $_subscription_type=get_post_meta($field_value,  '_subscription_type', true );
        $status=get_post_meta($field_value,  'status', true );
        $post_date=get_the_date('M, d Y',$field_value);
        $next_duedate=nextduedate($field_value);
        echo "<h3 style='margin-top: 30px;'> Subscription <a href='edit.php?s=".$field_value."&post_status=all&post_type=subscription&action=-1&m=0&paged=1&subscription_id=''&action2=-1'>#".$field_value."</a></h2>
                <p>Subscription Type : ".ucfirst($_subscription_type)."</p>
                <p>Start Date : ".$post_date."</p>";

        if( $status== 'active' ){      
           echo "<p>Status : ".ucfirst($status)."</p>";  
         echo "<p>Next Due : ".$next_duedate."</p>";
        }
        else
            echo "<p>Status: ".ucfirst($status)."</p>";
    }

}
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'subscription_details_on_orderpage', 10, 1 );


/**
 * [disable_shipping_calc_on_cart method to hide the shiping method on cart totals n checkout]
 * @param  [type] $show_shipping [description]
 * @return [type]                [description]
 */
/*function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() || is_checkout()) {
        return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );*/

/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available( $rates ) {
    $free = array();
    foreach ( $rates as $rate_id => $rate ) {
        if ( 'free_shipping' === $rate->method_id ) {
            $free[ $rate_id ] = $rate;
            break;
        }
    }
    return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );



// Subscription Details on orders email

add_action('woocommerce_email_after_order_table','subscription_order_details',10,4);

function subscription_order_details( $order, $sent_to_admin, $plain_text, $email ){
 $orderid=$order->get_order_number();
 $preferred_date=get_post_meta( $orderid, '_preferred_date', true );
 $preferred_time=get_post_meta( $orderid, '_preferred_time', true );

 $html= '<h2>Preferred Delivery Slot</h2>
        <table style="width: 100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color: #636363;border-collapse: collapse;text-align: center;">
            <thead>
                <tr>
                    <th style="border: 2px solid #e5e5e5;padding: 12px;color: #636363;">Preferred Day</th>
                    <th style="border: 2px solid #e5e5e5;padding: 12px;color: #636363;">Preferred Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 2px solid #eee;word-wrap: break-word;color: #636363;padding: 12px;vertical-align: middle;">'.$preferred_date.'</td>
                    <td style="border: 2px solid #eee;word-wrap: break-word;color: #636363;padding: 12px;vertical-align: middle;">'.$preferred_time.'</td>
                  </tr>
            </tbody>        
        </table>';
                        
    
    $subscription_id=get_post_meta( $orderid, '_subscription_id', true );
    

    if($subscription_id!=""){
        $subscription_type=get_post_meta( $subscription_id, '_subscription_type', true );
        $startdate=get_the_date( $d = 'M d, Y', $subscription_id );
        $orderdate=get_post_meta( $subscription_id, 'last_order_date', true );
          $_scheduler_generated_order=get_post_meta( $orderid, '_scheduler_generated_order', true );

   
        $html.= '<h2>Subscription Details</h2>
            <table style="width: 100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color: #636363;border-collapse: collapse;text-align: center;">
                <thead>
                    <tr>
                        <th style="border: 2px solid #e5e5e5;padding: 12px;color: #636363;">ID</th>
                        <th style="border: 2px solid #e5e5e5;padding: 12px;color: #636363;">Type</th>
                        <th style="border: 2px solid #e5e5e5;padding: 12px;color: #636363;">Start Date</th>';
                    
                    if($_scheduler_generated_order=='yes'){
                        $html.=    '<th style="border: 2px solid #e5e5e5;padding: 12px;color: #636363;">Subscription for</th>';
                    }
                   
                   $html.=  '</tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 2px solid #eee;word-wrap: break-word;color: #636363;padding: 12px;vertical-align: middle;">#'.$subscription_id.'</td>
                        <td style="border: 2px solid #eee;word-wrap: break-word;color: #636363;padding: 12px;vertical-align: middle;">'.ucfirst($subscription_type).'</td>
                        <td style="border: 2px solid #eee;word-wrap: break-word;color: #636363;padding: 12px;vertical-align: middle;">'.$startdate.'</td>';
                        
                        if($_scheduler_generated_order=='yes'){
                           $html.=  '<td style="border: 2px solid #eee;word-wrap: break-word;color: #636363;padding: 12px;vertical-align: middle;">'.$orderdate.'</td>';
                        }

                     $html.='</tr>
                </tbody>        
            </table>
        ';

        
    }
    echo $html;
}


add_action('woocommerce_email_before_order_table','subscription_order_details_before',10,4);

function subscription_order_details_before($order, $sent_to_admin, $plain_text, $email ){
    $orderid=$order->get_order_number();
    $_scheduler_generated_order=get_post_meta( $orderid, '_scheduler_generated_order', true );

    if($_scheduler_generated_order=='yes'){
        $_order_key=get_post_meta( $orderid, '_order_key', true );  
        $_customer_user=get_post_meta( $orderid, '_customer_user', true );  
        $user = get_user_by( 'ID', $_customer_user );
        $user_name= $user->display_name;  
        $subscription_id=get_post_meta( $orderid, '_subscription_id', true );
        $subscription_type=get_post_meta( $subscription_id, '_subscription_type', true );

        echo '<div style="font-size: 15px;line-height: 1.5;margin-top: 15px;margin-bottom: 10px;"><span style="display: block;margin-bottom: 5px;">Hi '.$user_name.',</span>
                Your '.ucfirst($subscription_type).' subscription order is ready and is awaiting payment. Please visit the link below to make your payment. Your order will be shipped after your payment is successful.</div>
                <div style="text-align: center;margin: 30px 0;"><a href='.site_url().'/checkout/order-pay/'.$orderid.'?pay_for_order=true&key='.$_order_key.' style="background-color: #022c4c;color: #fff;padding-top: 0.8em;padding-bottom:0.8em;padding-left: 1.5em;padding-right: 1.5em;text-decoration: none;">Payment link</a></div>
            ';
    } 
}


add_filter( 'woocommerce_thankyou_order_received_text', 'thankyou_msg_checkout', 10);

function thankyou_msg_checkout(){
    return 'Thank you. Your order has been received. <a href="/my-account/orders" > Click here to go to your  orders list </a>';
}

function sp_api_request_url($api_request_url, $request, $ssl) {
    if ($request !== 'WC_Gateway_Paypal') {
        return $api_request_url;
    }
    //Due to permalink configuration gateway url is http://xxxxxxxx/wc-api/WC_Gateway_Paypal/ when actually it WORKS as http://xxxxxxxx/?wc-api=WC_Gateway_Paypal
    //So we use the part of the code from woocommerce which we know works
    if (is_null($ssl)) {
        $scheme = parse_url(home_url(), PHP_URL_SCHEME);
    } elseif ($ssl) {
        $scheme = 'https';
    } else {
        $scheme = 'http';
    }
    $fix_api_request_url = add_query_arg('wc-api', $request, trailingslashit(home_url('', $scheme)));
    return $fix_api_request_url;
}

// add_filter('woocommerce_api_request_url', 'sp_api_request_url', 10, 3);

/*
* Add customer email to Cancelled Order recipient list
*/
function wc_cancelled_order_add_customer_email( $recipient, $order ){
return $recipient . ',' . $order->billing_email;
}
add_filter( 'woocommerce_email_recipient_cancelled_order', 'wc_cancelled_order_add_customer_email', 10, 2 );



/**
 * HIde admin Bar
 */
add_filter('show_admin_bar', '__return_false');


add_filter('wp_mail_from', 'indigo_mail_from');
add_filter('wp_mail_from_name', 'indigo_mail_from_name');

function indigo_mail_from($old) {
 return 'support@indigowinco.com';
}
function indigo_mail_from_name($old) {
 return 'Support';
}

/* 
function child_stylesheet_uri( $stylesheet_uri, $stylesheet_dir_uri ) { 
    
    $stylesheet_dir_uri = get_stylesheet_directory_uri();
    $stylesheet_uri = $stylesheet_dir_uri . '/style.min.css';
    return $stylesheet_uri; 
}; 
         
add_filter( 'stylesheet_uri', 'child_stylesheet_uri', 10, 2 ); 
 */


function set_http_headers_cache() {
   /*header( 'X-UA-Compatible: IE=edge,chrome=1' );
    session_cache_limiter('');
    header("Cache-Control: public, s-maxage=120");
  if( !session_id() )
  {
    session_start();
  }*/

    $seconds_to_cache =   60 * 60 * 24 *  14; //60s x 60m x 24h x 3d  //13600;
    $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
    $ex_date = date(DATE_RFC822,strtotime("14 days"));

    header("Expires: ".$ex_date);
    header("Pragma: cache");
    header("Cache-Control: max-age=$seconds_to_cache");
}
// add_action( 'send_headers', 'set_http_headers_cache' );



function indigo_woocommerce_add_to_cart(  ) { 
   unset($_SESSION['subscription_type']);
}; 
          
add_action( 'woocommerce_add_to_cart', 'indigo_woocommerce_add_to_cart', 10, 0 ); 



// add_action('wp_enqueue_scripts', 'rudr_move_jquery_to_footer');  
 
// function rudr_move_jquery_to_footer() {  
//     // unregister the jQuery at first
//         wp_deregister_script('jquery');  
 
//         // register to footer (the last function argument should be true)
//         wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), false, null, true);  
 
//         wp_enqueue_script('jquery');  
// }


function indigo_save_extra_checkout_fields( $order_id ){
    update_post_meta( $order_id, '_preferred_time', $_POST['preferred_time']  );
    update_post_meta( $order_id, '_preferred_date', $_POST['preferred_date']  ); 
}
add_action( 'woocommerce_checkout_update_order_meta', 'indigo_save_extra_checkout_fields', 10, 1 );

/**
 * Process the checkout
 */
add_action('woocommerce_checkout_process', 'indigo_checkout_field_process');

function indigo_checkout_field_process() {
    // Check if set, if its not set add an error.
    if ( ! $_POST['preferred_date'] )
        wc_add_notice( __( 'Preferred Day is a required field.' ), 'error' ); 
    if ( ! $_POST['preferred_time'] )
        wc_add_notice( __( 'Preferred Time is a required field.' ), 'error' );
}



// action to add the flat discount coupon based on the quantity
add_action('woocommerce_before_cart_table', 'discount_when_quantity_greater_than_5');
function discount_when_quantity_greater_than_5() {
    $coupon_code = FLAT_DISCOUNT_COUPON;
    
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    $total_qty=0;
      foreach($items as $item => $values) { 

        $_product = $values['data']->post; 
        $product_id= $values['product_id'];
        $product_qty= $values['quantity'];

        $product_cats_ids = wc_get_product_term_ids( $product_id, 'product_cat' );

        foreach( $product_cats_ids as $cat_id ) {
          $term = get_term_by( 'id', $cat_id, 'product_cat' );
          if($term->slug=='wine'){
            $total_qty=$total_qty+$product_qty;
          }
          if($term->slug == 'wine-packs'){
            $total_qty=$total_qty+$product_qty*6;
          }
        }

    }
    
    if($total_qty>=6)
    {  
        if (!$woocommerce->cart->add_discount( sanitize_text_field( $coupon_code ))) {
           // echo '<div class="woocommerce_message"><strong>The number of Product in your order is greater than 10 so a 10% Discount has been Applied!</strong></div>';
        }
    }
    else{
         $woocommerce->cart->remove_coupon( $coupon_code );
    }  
 
}

// filter to disable the remove coupon code used for specific coupon
function indigo_filter_woocommerce_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) { 
  
    if($coupon->code== FLAT_DISCOUNT_COUPON){
        return $discount_amount_html; 
    }
    return $coupon_html;
}; 
         
add_filter( 'woocommerce_cart_totals_coupon_html', 'indigo_filter_woocommerce_cart_totals_coupon_html', 10, 3 ); 



function indigo_woocommerce_cart_totals_coupon_label( $sprintf, $coupon ) { 
   
   if($coupon->code==FLAT_DISCOUNT_COUPON){
        $sprintf= 'Bottle Disc';
   }
   return $sprintf; 
}; 
add_filter( 'woocommerce_cart_totals_coupon_label', 'indigo_woocommerce_cart_totals_coupon_label', 10, 2 ); 


function indigo_view_order($orderid){
 $preferred_date=get_post_meta( $orderid, '_preferred_date', true );
 $preferred_time=get_post_meta( $orderid, '_preferred_time', true );

  echo '<div class="preferred-delivery">
    <h3>Preferred Delivery Slot</h3>
    <table ><tr>
                <td>Preferred Day:</td>
                <td>'.$preferred_date.'</td>
            </tr>
            <tr>
                <td>Preferred Time:</td>
                <td>'.$preferred_time.'</td>
            </tr>      
   </table>

    </div>';
}
add_action('woocommerce_view_order','indigo_view_order',10,1);

add_action('wpcf7_before_send_mail', 'user_signup', 10, 3);
function user_signup ($contact_form, &$abort, $object){

    if ($contact_form->title == "Signup"){
        if($_POST['name'] != ""){
            $abort = true;
            $object->set_response("Invalid data entered.");
        }
        else{
            $ulogin = $_POST['first-name'];
            $check = username_exists($ulogin);
            if (!empty($check)) {
                $suffix = 2;
                while (!empty($check)) {
                    $alt_ulogin = $ulogin . '-' . $suffix;
                    $check = username_exists($alt_ulogin);
                    $suffix++;
                }
                $ulogin = $alt_ulogin;
            }
            if(email_exists($_POST['email'])){
                $abort = true;
                $object->set_response("Email already exists.");       
            }
            elseif ( is_wp_error( $user ) ) {
                $abort = true;
                $object->set_response("There was an error creating the user. Please try again.");
            }
            else{
                $password = wp_generate_password(6, false);
                $user_id = wp_insert_user( [
                    'user_login'    =>  $ulogin,
                    'user_email'    =>  $_POST['email'],
                    'user_pass'     =>  $password, 
                    'first_name'    =>  $_POST['first-name'],
                    'last_name'     =>  $_POST['last-name'],
                    'display_name'  =>  $_POST['first-name'].' '.  $_POST['last-name']
                ] ) ;
                $user = new WP_User( (int) $user_id );
                $adt_rp_key = get_password_reset_key( $user );
                $rp_link = '<a href="' . wp_login_url()."?action=rp&key=$adt_rp_key&login=" . rawurlencode($ulogin) . '">Click here to set your password</a>';
                $data = [
                    'email' => $_POST['email'],
                    'display_name' => $user->display_name,
                    'rp_link' => $rp_link
                ];
                $subject = 'Welcome to Indigo Wine Co';
                $message = generate_email_template('registration_mail', $data);
                wp_mail( $_POST['email'], $subject, $message, $headers = '', $attachments = array() );
                $user = wp_signon([
                    'user_login' => $_POST['email'],
                    'user_password' => $password,
                ]);
                sync_mailchimp([
                    'email' => $_POST['email'],
                    'firstname' => $_POST['first-name'],
                    'lastname' => $_POST['last-name'],
                    'status' => 'subscribed'
                ]);
            }
        }
    }
}

function sync_mailchimp($data) {
    $listId = MEMBERS_LIST; // Free members
    $memberId = md5(strtolower($data['email']));
    $dataCenter = substr(MAILCHIMP_KEY,strpos(MAILCHIMP_KEY,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;
    $json = json_encode(array(
        'email_address' => $data['email'],
        'status'        => $data['status'], 
        'merge_fields'  => array(
            'FNAME'         => $data['firstname'],
            'LNAME'         => $data['lastname'],
        )
    ));
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . MAILCHIMP_KEY);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                             
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $httpCode;
}

add_action( 'wp_footer', 'signup_redirect' );
function signup_redirect() {
    ?>
    <script type="text/javascript">
        document.addEventListener( 'wpcf7mailsent', function( event ) {
            location = '<?php echo home_url(); ?>';
        }, false );
    </script>
    <?php
}

function product_view_container (){
    $view = isset($_GET['view']) ? $_GET['view'] : 'grid';
    $grid_class = ($view == 'grid') ? 'view-options-active' : '';
    $list_class = ($view == 'list') ? 'view-options-active' : '';
    echo '<div class= "view-panel">
        <a class="grid-option view-options '.$grid_class.'" data-type="grid" href="'.admin_url("admin-ajax.php").'"><i class="fa fa-th" aria-hidden="true"></i></a>
        <a class="list-option view-options '.$list_class.'" data-type="list" href="'.admin_url("admin-ajax.php").'"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
    </div>';
}

add_action ( 'woocommerce_before_shop_loop' ,  'product_view_container');

add_action( 'wp_ajax_change_product_view', 'change_product_view' );
add_action( 'wp_ajax_nopriv_change_product_view', 'change_product_view' );
function change_product_view(){
    ob_start();
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 20,
        'post_status' => 'publish',
        'paged' => $_GET['page'],
        'tax_query' => array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',
            ),
        ),
    );

    if ($_GET['category'] != '') {
        $args['product_cat'] = $_GET['category']; 
    }

    if ($_GET['classification'] != '') {
        $args['tax_query'][]  =  array(
            'taxonomy' => 'Classification',
            'field'    => 'slug',
            'terms'    =>  $_GET['classification'],
        );
    }


    $filters = array_filter(explode("-", $_GET['filter']));
    if(!empty($filters)){
        $args['tax_query']['relation'] = 'AND';
        $args['tax_query'][1] = array(
            'taxonomy'  => 'product_tag',
            'field'     => 'term_id',
            'terms'     => $filters,
        );
    }
    if($_GET['min_price'] && $_GET['max_price']){
        $args['meta_query'] = array(
            array(
                'key' => '_price',
                'value' => array($_GET['min_price'], $_GET['max_price']),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ),
        );
    }
    switch ($_GET['orderby']) {
        case 'date':
            $args['orderby'] = 'date';  
            $args['order'] = 'desc';   
            break;
        case 'price':
            $args['orderby'] = 'meta_value_num';    
            $args['meta_key'] = '_price';   
            $args['order'] = 'asc';  
            break;
        case 'price-desc':
             $args['orderby'] = 'meta_value_num';    
            $args['meta_key'] = '_price';   
            $args['order'] = 'desc';  
            break;
    }
    $loop = new WP_Query( $args );
    
    //print_r($args);

    echo "<div class='row products clearfix products-4' data-cat='".$_GET['category']."' data-classification='".$_GET['classification']."' data-min='".$_GET['min_price']."' data-max='".$_GET['max_price']."' data-page='".$_GET['page']."' data-filter='".$_GET['filter']."'>";
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : 
            $loop->the_post();
            do_action( 'woocommerce_shop_loop' );
            wc_get_template_part( 'content', 'product-'.$_GET['product_view_option'] );
        endwhile;
    } else {
        echo '<p class="woocommerce-info">No products were found matching your selection.</p>';
    }
    echo '</div>';
    $data['products'] = ob_get_contents();
    $data['args'] = $args;
    wp_reset_postdata();
    ob_end_clean();
    echo json_encode($data);
    die();
}

function get_url_var($name)
{
    $strURL = $_SERVER['REQUEST_URI'];
    $arrVals = explode("/",$strURL);
    $found = 0;
    foreach ($arrVals as $index => $value) 
    {
        if($value == $name) $found = $index;
    }
    $place = $found + 1;
    return ($found == 0) ? 1 : $arrVals[$place];
}

add_action( 'init', 'custom_taxonomy_Item' );

// Register Custom Taxonomy
function custom_taxonomy_Item() {

$labels = array(
    'name' => 'Classifications',
    'singular_name' => 'Classification',
    'menu_name' => 'Classifications',
    'all_items' => 'All Classifications',
    'parent_item' => 'Parent Classifications',
    'parent_item_colon' => 'Parent Classifications:',
    'new_item_name' => 'New Classification Name',
    'add_new_item' => 'Add New Classification',
    'edit_item' => 'Edit Classification',
    'update_item' => 'Update Classification',
    'separate_items_with_commas' => 'Separate Classification with commas',
    'search_items' => 'Search Classification',
    'add_or_remove_items' => 'Add or remove Classification',
    'choose_from_most_used' => 'Choose from the most popular Classification',
    );
$args = array(
    'labels' => $labels,
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_tagcloud' => true,
    );
register_taxonomy( 'Classification', 'product', $args );
}

if (!function_exists('showclassification')) {
    
    function showclassification(){
        $term_arr = array();
        $terms = get_terms( array(
            'taxonomy' => 'Classification',
            'orderby' => 'name',
            'hide_empty' => false,
        ) );
        foreach ( $terms as $term ) {
            $class = $term->name;
            $slug = $term->slug;
            if(!array_key_exists($letter, $term_arr))
                $term_arr[$letter] = array($slug => $class);
            else
                $term_arr[$letter][$slug] = $class;
        }
    
        $output = '<div class="list-container widget_meta">';
        foreach( $term_arr as $key_letter => $terms_in_letter ){
            $output .= '<ul class="list">';
                foreach( $terms_in_letter as $key => $value ){
                    $slug = 'classification';
                    $output .= '<li><a href="/'.$slug.'/'.$key.'/">'.$value.'</a></li>';
                }
            $output .= '</ul>';
        }
        $output .= '</div>';
        return $output;
    }
    add_shortcode( 'showclassification', 'showclassification' );
}