<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
echo "<pre>";
print_r($_SESSION['subscription_type']);
  echo "<pre>";
            print_r(WC()->session->get('cart'));
wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="row clearfix" id="customer_details">

			<div class="col-8">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
				<br><br>
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>

			
			<div class="col-4">
				<div class="payout-box">
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<h4 id="order_review_heading" class="hb-heading hb-center-heading"><span><?php _e( 'Your order', 'woocommerce' ); ?></span></h4>

	<?php endif; ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			</div>
		</div>
		</div>

		

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); 
// echo "<pre>";
// print_r(WC()->cart->cart_contents);
//  $cart = WC()->session->get( 'cart', null );
 
//  print_r($cart);
//  
//  echo "<pre>";

// WC()->session->set( 'cart', WC()->cart->cart_contents );

// unset(WC()->session->cart );

// WC()->session->set( 'cart', WC()->cart->cart_contents );

 // $cart = WC()->session->get( 'cart', null );

 // print_r($cart);
//  print_r(WC()->cart_session_data);
//  
//   echo "<pre>";
// print_r(WC()->session->get('cart'));

?>
