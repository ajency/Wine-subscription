<?php
/**
 * Duplicate order functionality
 *
 * @author      WooThemes
 * @category    Admin
 * @package     WooCommerce/Admin
 * @version     2.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_Admin_Duplicate_Order' ) ) :

/**
 * WC_Admin_Duplicate_Order Class.
 */
class WC_Admin_Duplicate_Order {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_action_duplicate_order', array( $this, 'duplicate_order_action' ) );
		add_filter( 'post_row_actions', array( $this, 'dupe_link' ), 10, 2 );
		add_filter( 'page_row_actions', array( $this, 'dupe_link' ), 10, 2 );

    // TODO: This should probably go directly into includes/admin/meta-boxes/class-wc-meta-box-order-actions.php
    // directly above the delete_action
    // Cannot use the 'woocommerce_order_actions_start' hook as it does not retain the same order as for 
    // duplicationg products
		add_action( 'post_submitbox_start', array( $this, 'dupe_button' ) );
	}

	/**
	 * Show the "Duplicate" link in admin orders list.
	 * @param  array   $actions
	 * @param  WP_Post $post Post object
	 * @return array
	 */
	public function dupe_link( $actions, $post ) {
		// TODO: Add new permission woocommerce_duplicate_order_capability
		if ( ! current_user_can( apply_filters( 'woocommerce_duplicate_product_capability', 'manage_woocommerce' ) ) ) {
			return $actions;
		}

		if ( $post->post_type != 'shop_order' ) {
			return $actions;
		}

		$actions['duplicate'] = '<a href="' . wp_nonce_url( admin_url( 'edit.php?post_type=shop_order&action=duplicate_order&amp;post=' . $post->ID ), 'woocommerce-duplicate-order_' . $post->ID ) . '" title="' . esc_attr__( 'Make a duplicate from this order', 'woocommerce' )
			. '" rel="permalink">' .  __( 'Duplicate', 'woocommerce' ) . '</a>';

		return $actions;
	}

	/**
	 * Show the dupe order link in admin.
	 */
	public function dupe_button() {
		global $post;

		// TODO: Add new permission woocommerce_duplicate_order_capability
		if ( ! current_user_can( apply_filters( 'woocommerce_duplicate_product_capability', 'manage_woocommerce' ) ) ) {
			return;
		}

		if ( ! is_object( $post ) ) {
			return;
		}

		if ( $post->post_type != 'shop_order' ) {
			return;
		}

		if ( isset( $_GET['post'] ) ) {
			$notifyUrl = wp_nonce_url( admin_url( "edit.php?post_type=shop_order&action=duplicate_order&post=" . absint( $_GET['post'] ) ), 'woocommerce-duplicate-order_' . $_GET['post'] );
			?>
			<div id="duplicate-action"><a class="submitduplicate duplication" href="<?php echo esc_url( $notifyUrl ); ?>"><?php _e( 'Copy to a new draft', 'woocommerce' ); ?></a></div>
			<?php
		}
	}

	/**
	 * Duplicate a order action.
	 */
	public function duplicate_order_action($original_order_id='') {

 		if($original_order_id!=''){
 			$_REQUEST['post']=$original_order_id;
 		}
		if ( empty( $_REQUEST['post'] ) ) {
			wp_die( __( 'No order to duplicate has been supplied!', 'woocommerce' ) );
		}

		// Get the original page
		$id = isset( $_REQUEST['post'] ) ? absint( $_REQUEST['post'] ) : '';

		//check_admin_referer( 'woocommerce-duplicate-order_' . $id );

		$post = wc_get_order( $id );

		// Copy the page and insert it
		if ( ! empty( $post ) ) {
			$new_id = $this->duplicate_order( $post );

			// If you have written a plugin which uses non-WP database tables to save
			// information about a page you can hook this action to dupe that data.
			// TODO: Document this hook
			do_action( 'woocommerce_duplicate_order', $new_id, $post );

			// Redirect to the edit screen for the new draft page
			//wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_id ) );
			//exit;
		} else {
			//wp_die( __( 'Order creation failed, could not find original order:', 'woocommerce' ) . ' ' . $id );
		}
	}

	/**
	 * Function to create the duplicate of the order.
	 *
	 * @param mixed $post
	 * @return int
	 */
	public function duplicate_order( $post ) {
		global $wpdb;

		$original_order_id = $post->id;
		$original_order = $post;

		$order_id = $this->create_order($original_order_id);

		if ( is_wp_error( $order_id ) ){
			$msg = 'Unable to create order: ' . $order_id->get_error_message();;
			throw new Exception( $msg );
		} else {

			$order = new WC_Order($order_id);

			$this->duplicate_order_header($original_order_id, $order_id);
			$this->duplicate_billing_fieds($original_order_id, $order_id);
			$this->duplicate_shipping_fieds($original_order_id, $order_id);

			$this->duplicate_line_items($original_order, $order_id);
			$this->duplicate_shipping_items($original_order, $order_id);
			$this->duplicate_coupons($original_order, $order_id);
			$this->duplicate_payment_info($original_order_id, $order_id, $order);
      $order->calculate_taxes();
			$this->add_order_note($original_order_id, $order);

			return $order_id;
		}
	}

	private function create_order($original_order_id) {
		$new_post_author    = wp_get_current_user();
		$new_post_date      = current_time( 'mysql' );
		$new_post_date_gmt  = get_gmt_from_date( $new_post_date );

		$order_data =  array(
			'post_author'   => $new_post_author->ID,
			'post_date'     => $new_post_date,
			'post_date_gmt' => $new_post_date_gmt,
			'post_type'     => 'shop_order',
			'post_title'    => __( 'Duplicate Order', 'woocommerce' ),
			/* 'post_status'   => 'draft', */
			'post_status'   => 'wc-pending',
			'ping_status'   => 'closed',
			/* 'post_excerpt'  => 'Duplicate Order based on original order ' . $original_order_id, */
			//'post_password' => uniqid( 'order_' ),   // Protects the post just in case
			'post_modified'             => $new_post_date,
			'post_modified_gmt'         => $new_post_date_gmt
		);

		$new_post_id = wp_insert_post( $order_data, true );

		return $new_post_id;
	}

	private function duplicate_order_header($original_order_id, $order_id) {
		update_post_meta( $order_id, '_order_shipping',         get_post_meta($original_order_id, '_order_shipping', true) );
		update_post_meta( $order_id, '_order_discount',         get_post_meta($original_order_id, '_order_discount', true) );
		update_post_meta( $order_id, '_cart_discount',          get_post_meta($original_order_id, '_cart_discount', true) );
		update_post_meta( $order_id, '_order_tax',              get_post_meta($original_order_id, '_order_tax', true) );
		update_post_meta( $order_id, '_order_shipping_tax',     get_post_meta($original_order_id, '_order_shipping_tax', true) );
		update_post_meta( $order_id, '_order_total',            get_post_meta($original_order_id, '_order_total', true) );

		update_post_meta( $order_id, '_order_key',              'wc_' . apply_filters('woocommerce_generate_order_key', uniqid('order_') ) );
		update_post_meta( $order_id, '_customer_user',          get_post_meta($original_order_id, '_customer_user', true) );
		update_post_meta( $order_id, '_order_currency',         get_post_meta($original_order_id, '_order_currency', true) );
		update_post_meta( $order_id, '_prices_include_tax',     get_post_meta($original_order_id, '_prices_include_tax', true) );
		update_post_meta( $order_id, '_customer_ip_address',    get_post_meta($original_order_id, '_customer_ip_address', true) );
		update_post_meta( $order_id, '_customer_user_agent',    get_post_meta($original_order_id, '_customer_user_agent', true) );
	}

	private function duplicate_billing_fieds($original_order_id, $order_id) {
		update_post_meta( $order_id, '_billing_city',           get_post_meta($original_order_id, '_billing_city', true));
		update_post_meta( $order_id, '_billing_state',          get_post_meta($original_order_id, '_billing_state', true));
		update_post_meta( $order_id, '_billing_postcode',       get_post_meta($original_order_id, '_billing_postcode', true));
		update_post_meta( $order_id, '_billing_email',          get_post_meta($original_order_id, '_billing_email', true));
		update_post_meta( $order_id, '_billing_phone',          get_post_meta($original_order_id, '_billing_phone', true));
		update_post_meta( $order_id, '_billing_address_1',      get_post_meta($original_order_id, '_billing_address_1', true));
		update_post_meta( $order_id, '_billing_address_2',      get_post_meta($original_order_id, '_billing_address_2', true));
		update_post_meta( $order_id, '_billing_country',        get_post_meta($original_order_id, '_billing_country', true));
		update_post_meta( $order_id, '_billing_first_name',     get_post_meta($original_order_id, '_billing_first_name', true));
		update_post_meta( $order_id, '_billing_last_name',      get_post_meta($original_order_id, '_billing_last_name', true));
		update_post_meta( $order_id, '_billing_company',        get_post_meta($original_order_id, '_billing_company', true));
	}

	private function duplicate_shipping_fieds($original_order_id, $order_id) {
		update_post_meta( $order_id, '_shipping_country',       get_post_meta($original_order_id, '_shipping_country', true));
		update_post_meta( $order_id, '_shipping_first_name',    get_post_meta($original_order_id, '_shipping_first_name', true));
		update_post_meta( $order_id, '_shipping_last_name',     get_post_meta($original_order_id, '_shipping_last_name', true));
		update_post_meta( $order_id, '_shipping_company',       get_post_meta($original_order_id, '_shipping_company', true));
		update_post_meta( $order_id, '_shipping_address_1',     get_post_meta($original_order_id, '_shipping_address_1', true));
		update_post_meta( $order_id, '_shipping_address_2',     get_post_meta($original_order_id, '_shipping_address_2', true));
		update_post_meta( $order_id, '_shipping_city',          get_post_meta($original_order_id, '_shipping_city', true));
		update_post_meta( $order_id, '_shipping_state',         get_post_meta($original_order_id, '_shipping_state', true));
		update_post_meta( $order_id, '_shipping_postcode',      get_post_meta($original_order_id, '_shipping_postcode', true));
	}

  // TODO: same as duplicating order from user side
	private function duplicate_line_items($original_order, $order_id) {
		foreach($original_order->get_items() as $originalOrderItem){
			$itemName = $originalOrderItem['name'];
			$qty = $originalOrderItem['qty'];
			$lineTotal = $originalOrderItem['line_total'];
			$lineTax = $originalOrderItem['line_tax'];
			$productID = $originalOrderItem['product_id'];

			$item_id = wc_add_order_item( $order_id, array(
					'order_item_name'       => $itemName,
					'order_item_type'       => 'line_item'
			) );

			wc_add_order_item_meta( $item_id, '_qty', $qty );
      // TODO: Is it ok to uncomment this?
			wc_add_order_item_meta( $item_id, '_tax_class', $originalOrderItem['tax_class'] );
			wc_add_order_item_meta( $item_id, '_product_id', $productID );
      // TODO: Is it ok to uncomment this?
			wc_add_order_item_meta( $item_id, '_variation_id', $originalOrderItem['variation_id'] );
			wc_add_order_item_meta( $item_id, '_line_subtotal', wc_format_decimal( $lineTotal ) );
			wc_add_order_item_meta( $item_id, '_line_total', wc_format_decimal( $lineTotal ) );
			/* wc_add_order_item_meta( $item_id, '_line_tax', wc_format_decimal( '0' ) ); */
			wc_add_order_item_meta( $item_id, '_line_tax', wc_format_decimal( $lineTax ) );
      // TODO: Is it ok to uncomment this?
			/* wc_add_order_item_meta( $item_id, '_line_subtotal_tax', wc_format_decimal( '0' ) ); */
			wc_add_order_item_meta( $item_id, '_line_subtotal_tax', wc_format_decimal( $originalOrderItem['line_subtotal_tax'] ) );
		}

    // TODO This is what is in order_again of class-wc-form-handler.php  
    // Can it be reused or refactored into own function?
    //
		// Copy products from the order to the cart
		/* foreach ( $order->get_items() as $item ) { */
		/* 	// Load all product info including variation data */
		/* 	$product_id   = (int) apply_filters( 'woocommerce_add_to_cart_product_id', $item['product_id'] ); */
		/* 	$quantity     = (int) $item['qty']; */
		/* 	$variation_id = (int) $item['variation_id']; */
		/* 	$variations   = array(); */
		/* 	$cart_item_data = apply_filters( 'woocommerce_order_again_cart_item_data', array(), $item, $order ); */

		/* 	foreach ( $item['item_meta'] as $meta_name => $meta_value ) { */
		/* 		if ( taxonomy_is_product_attribute( $meta_name ) ) { */
		/* 			$variations[ $meta_name ] = $meta_value[0]; */
		/* 		} elseif ( meta_is_product_attribute( $meta_name, $meta_value[0], $product_id ) ) { */
		/* 			$variations[ $meta_name ] = $meta_value[0]; */
		/* 		} */
		/* 	} */
	}

	private function duplicate_shipping_items($original_order, $order_id) {
		$original_order_shipping_items = $original_order->get_items('shipping');

		foreach ( $original_order_shipping_items as $original_order_shipping_item ) {
			$item_id = wc_add_order_item( $order_id, array(
				'order_item_name'       => $original_order_shipping_item['name'],
				'order_item_type'       => 'shipping'
			) );
			if ( $item_id ) {
				wc_add_order_item_meta( $item_id, 'method_id', $original_order_shipping_item['method_id'] );
				wc_add_order_item_meta( $item_id, 'cost', wc_format_decimal( $original_order_shipping_item['cost'] ) );

        // TODO: Does not store the shipping taxes
				/* wc_add_order_item_meta( $item_id, 'taxes', $original_order_shipping_item['taxes'] ); */
			}
		}
	}

	private function duplicate_coupons($original_order, $order_id) {
		$original_order_coupons = $original_order->get_items('coupon');
		foreach ( $original_order_coupons as $original_order_coupon ) {
			$item_id = wc_add_order_item( $order_id, array(
				'order_item_name'       => $original_order_coupon['name'],
				'order_item_type'       => 'coupon'
			) );
			// Add line item meta
			if ( $item_id ) {
				wc_add_order_item_meta( $item_id, 'discount_amount', $original_order_coupon['discount_amount'] );
			}
		}
	}

	private function duplicate_payment_info($original_order_id, $order_id, $order) {
		update_post_meta( $order_id, '_payment_method',         get_post_meta($original_order_id, '_payment_method', true) );
		update_post_meta( $order_id, '_payment_method_title',   get_post_meta($original_order_id, '_payment_method_title', true) );
		/* update_post_meta( $order->id, 'Transaction ID',         get_post_meta($original_order_id, 'Transaction ID', true) ); */
		/* $order->payment_complete(); */
	}

	private function add_order_note($original_order_id, $order) {
		$updateNote = 'This is generated from subscription order ' . $original_order_id . '.';
		 $order->update_status('pending'); 
		$order->add_order_note($updateNote);
	}

}

endif;

// return new WC_Admin_Duplicate_Order();