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
add_filter('wp_nav_menu_items','sk_wcmenucart', 10, 2);
function sk_wcmenucart($menu, $args) {

    // Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
    if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'my-custom-menuu' !== $args->theme_location )
        return $menu;

    ob_start();
        global $woocommerce;
        $viewing_cart = __('View your shopping cart', 'your-theme-slug');
        $start_shopping = __('Start shopping', 'your-theme-slug');
        $cart_url = $woocommerce->cart->get_cart_url();
        $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
        $cart_contents_count = $woocommerce->cart->cart_contents_count;
        $cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'your-theme-slug'), $cart_contents_count);
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
    $social = ob_get_clean();
    return $menu . $social;

}


 
//Enqueue Ajax Scripts
function enqueue_cart_qty_ajax() {
    wp_register_script( 'cart-qty-ajax-js', get_template_directory_uri() . '/subscription/js/cart-qty-ajax.js', array( 'jquery' ), '', true );
    wp_localize_script( 'cart-qty-ajax-js', 'cart_qty_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
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

    // Update the quantity of the item in the cart
    if ( $passed_validation ) {
        WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
    }

    // Refresh the page
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
    if( is_shop() ){
        wp_redirect( home_url( '/product-category/wine-packs/' ) );
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
    foreach ($instance->cart_contents as $cart_value) {
       $product_id=$cart_value['product_id'];
       $quantity=$cart_value['quantity'];
       $line_total=$cart_value['line_total'];
       $final_total=$final_total+indigo_discountCalculation($product_id,$quantity,$line_total);
    }

    $woocommerce->cart->total=$final_total;
    
    return wc_price($final_total); 
}; 
         
add_filter( 'woocommerce_cart_subtotal', 'indigo_wine_filter_woocommerce_cart_subtotal', 10, 3 ); 


function indigo_discountCalculation($product_id, $quantity,$product_subtotal){
    
     $price=get_post_meta($product_id,  '_price', true );

    $row_price        = $price * $quantity;
    if(indigo_rangelogic($quantity)){
        $discount_perc=get_post_meta($product_id,  '_sale_discount_percentage', true );
        $discount_price=get_post_meta($product_id,  '_sale_discount_price', true );
       
   
        if($discount_perc!='' && $discount_perc !=0){     

          $discounted_price_perc=(($discount_perc*$row_price)/100);
          $discounted_price=$row_price-$discounted_price_perc;
          return $final_product_subtotal= $discounted_price;
         
        }
        else if($discount_price!='' && $discount_price !=0){
           
            $discounted_price=$row_price-$discount_price;
            return $final_product_subtotal= $discounted_price;
              
        }  
    } 
    return $row_price; 
}

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

require get_template_directory()."/subscription/product-subscription.php";





