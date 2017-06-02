<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); 
	
	$cartlimit=count(WC()->cart->get_cart())>4 ? 'cart-limit' : '';
 
 $_SESSION['subscription_type']='monthly';

?>

<div class="row clearfix">
<div class="col-9">

<div class="hb-notif-box error failure hidden"><div class="message-text"><p><i class="hb-moon-blocked"></i>Your current subscription has been cancelled.</p></div></div>

<!-- Go back link -->

<div class="go-back">
	<a href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="go-back__link"><i class="fa fa-angle-left" aria-hidden="true"></i>
 <?php _e('Continue Shopping', 'woocommerce'); ?></a>
</div>


<!-- why subscribe -->

<div class="why-subscribe box-shadow-wrap">
	<i class="fa fa-times close-sub-box" aria-hidden="true"></i>
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cart-bottle.png" class="alert-cover">
	<div class="why-subscribe__content">
		<h3 class="title">Why to Subscribe</h3>
		<ul class="reason">
			<li><i class="fa fa-hand-o-right" aria-hidden="true"></i> Subscribe and be a part of our esteemed club.</li>
			<li><i class="fa fa-hand-o-right" aria-hidden="true"></i> Club members have access to our limited releases.</li>
			<li><i class="fa fa-hand-o-right" aria-hidden="true"></i> Get exclusive offers and unique tastings and events.</li>
		</ul>
	</div>
</div>




<form class="cart-form woocommerce-cart-form <?php echo $cartlimit; ?>" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
<input type="hidden" id="subscription_status" name="subscription_status" value="yes">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove">&nbsp;</th>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</td>

						<td class="product-thumbnail">
							<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $product_permalink ) {
									echo $thumbnail;
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
								}
							?>
						</td>

						<td class="product-name" data-title="<?php _e( 'Product', 'woocommerce' ); ?>">
							<?php
								if ( ! $product_permalink ) {
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
								} else {
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
								}

								// Meta data
								echo WC()->cart->get_item_data( $cart_item );

								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
								}
							?>
						</td>

						<td class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>

						<td class="product-quantity" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '0',
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
							?>
						</td>

						<td class="product-subtotal" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
							<?php
								$updated_price=WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] );
								$actual_price=wc_price($cart_item['quantity']*$_product->get_price());

								if($updated_price!=	$actual_price)
								echo ' <strike>'.$actual_price. '</strike> ';

								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );

								
							?>
						</td>
					</tr>
					<?php
				}
			}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions hidden">

				<a href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="simple-read-more float-left continue-shopping"><?php _e('Continue Shopping', 'woocommerce'); ?></a>
				<input type="submit" class="button hb-update-cart" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" /> <input type="submit" class="checkout-button button alt wc-forward" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>
				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="subscription-table">
	<div class="box-shadow-wrap subscription-action">
		<div class="toggle-check">

			<input type="checkbox" value="" name="subscription-check" id="subscription-check" class="custom-check" checked />
			<div class="content">
				<p>Convert my order into a subscription</p>
			</div>
		</div>
		<div>
			<p class="type-title">Type of Subscription</p>
			<div class="switch">
				<input id="monthly" class="switch-input" checked="checked" name="sub-type" type="radio" value="monthly" autocomplete="off" />
				<label class="switch-label switch-label-off" for="monthly">Monthly</label>
				<input id="quarterly" class="switch-input" name="sub-type" type="radio" value="quarterly" autocomplete="off" /><label class="switch-label switch-label-on" for="quarterly">Quarterly</label>
				<div class="switch-selection"></div>
			</div>
		</div>
	</div>
</div>


</div>

<div class="col-3">

<!-- <div class="no-subscription get-started-sub box-wrap">
	<div class="cart-bottle"></div>
	<h5 class="title">Be a part of our club</h5>
	<h5 class="subTitle">Set up your personalized subscription and be member of Indigo Wine Co.</h5>
	<?php 
	if(is_user_logged_in()){
	?>
	<a href="javascript:void(0)" class="sub-started modal-open open-subscription-modal" id="subscribe_now">Subscribe Now</a>
	<?php 
	
	} 
	else {
	?>
	<a class="simplemodal-login" href="/wp-login.php">Subscribe Now</a>
	<?php 
	}
	?>
</div> -->

<!-- If the order is available for subscription -->

<!-- <div class="no-subscription get-started-sub box-wrap">
	<div class="cart-bottle"></div>
	<h5 class="title">Congratulations!</h5>
	<h5 class="subTitle">You can be a Indigo Wine co member your order is eligible for subscription. Just opt to subscribe and be Indigo Wine Co club member</h6>
	<?php 
	if(is_user_logged_in()){
	?>
	<a href="javascript:void(0)" class="sub-started modal-open open-subscription-modal" id="subscribe_now">Subscribe Now</a>
	<?php 
	
	} 
	else {
	?>
	<a class="simplemodal-login" href="/wp-login.php">Subscribe Now</a>
	<?php 
	}
	?>
</div> -->

<div class="subscribe-overlay hidden">
	<div class="sub-container">
		<h5 class="msg">Hi there, looks like your order is eligible for subscription.<br> Just opt to subscribe and be Indigo Wine Co club member</h5>
		<button type="button" class="close-Sub_overlay">Ok Got it!</button>
	</div>
</div>


<div class="cancel-subscription no-subscription box-wrap hidden">
	<div class="cart-bottle"></div>
	<h5 class="title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste earum.</h5>
	<a href="#" class="sub-started modal-open" id="unsubscribe-order">Unsubscribe</a>
</div>

<!-- <div class="subscription box-wrap">
	<h2 class="title">Subscribe the orders</h2>
	<label class="sub-label">Type of subscription</label>
	<select class="sub-select">
		<option>Monthly</option>
		<option>Quarterly</option>
		<option>Yearly</option>
	</select>
	<div class="brand-button">
		<button class="vc_btn3 vc_btn3-color-grey vc_general modal-open" data-modal-id="subscribe-modal" id="subscribe_now">Subscribe Now!</button>
	</div>
	<div class="no-sub unsubscribe hidden">
		Monthly subscription activated. Click <a href="#" class="un-link">here</a> if you want to unsubscribe
	</div>
</div> -->


<div class="cart-collaterals">
	<?php woocommerce_cart_totals(); ?>
	
	<div class="checkoutAction">
		<button type="button" class="checkout-btn">Proceed to checkout</button>
	</div>

</div>
</div>

</div>


<!-- How it works -->

<div class="h-i-w">
	<h1 class="title">How does subscription work?</h1>
	<div class="flex-cols">
		<div class="cols">
			<span class="c-icon cal"></span>
			<p class="content">Add products to the cart. Order qty for wine bottles has to be in multiples of 6. There is no qty constraint for wine packs.</p>
		</div>
		<div class="cols">
			<span class="c-icon sub"></span>
			<p class="content">Subscription for the order will be on when your order meets the requirement. You can opt for either a monthly or quarterly subscription and complete the payment.</p>
		</div>
		<div class="cols">
			<span class="c-icon pay"></span>
			<p class="content">For the next month/quarter, you will be notified by a mail when your order is ready. The mail will have the payment link.</p>
		</div>
		<div class="cols">
			<span class="c-icon done"></span>
			<p class="content">Your order will be shipped at your doorstep once you have made a successful payment.</p>
		</div>
	</div>

</div>


<?php do_action( 'woocommerce_after_cart' ); ?>