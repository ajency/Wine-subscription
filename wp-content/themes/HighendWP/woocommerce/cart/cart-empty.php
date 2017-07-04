<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

?>

<h4 class="hb-heading hb-center-heading cart-empty"><img src="<?php bloginfo('template_url'); ?>/../indigo-wine/img/package.png" class="center-block cart-image"/><span><?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?></span></h4>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>

<p class="aligncenter"><a class="hb-button hb-small-button hb-third-dark" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" target="_self"><?php _e( 'Return To Shop', 'woocommerce' ) ?></a></p>


<!-- How it works -->

<div class="h-i-w">
	<h1 class="title">How does subscription work?</h1>
	<div class="flex-cols">
		<div class="cols">
			<span class="c-icon cal"></span>
			<p class="content">Add wine pack or bottles (in multiples of 6) to your cart. Multiple wine packs can be ordered.</p>
		</div>
		<div class="cols">
			<span class="c-icon sub"></span>
			<p class="content">Once required order quantities reached, set your subscription period for monthly, bimonthly or  quarterly and check the subscription box.</p>
		</div>
		<div class="cols">
			<span class="c-icon pay"></span>
			<p class="content">Email notification will be sent to you prior to your next subscription delivery. Click on payment link to initiate payment process.</p>
		</div>
		<div class="cols">
			<span class="c-icon done"></span>
			<p class="content">Your personalised order will be dispatched for delivery to your door, once payment processed.</p>
		</div>
	</div>

</div>