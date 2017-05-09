<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post,$product;

?>
<p itemprop="name" class="hb-text-large productTitle"><?php the_title(); ?></p>
<!-- <div class="hb-accordion single-cart-option" data-initialindex="0">
<div class="hb-accordion-single">
	
	<div class="product_amount">
		<h1 class="title">$20</h1>
	</div>


	<div class="cartStuff">
		<div class="cartHolder">
			<form class="cart">
			<div class="quantity"><input type="button" value="-" class="minus"><input type="number" step="1" min="1" name="quantity" value="1" title="Qty" class="input-text qty text" size="4"><input type="button" value="+" class="plus"></div>
			</form>
		</div>
		<div class="cartAction">
			<div class="brand-button"><button class="vc_general vc_btn3 vc_btn3-color-grey">Add to cart</button></div>
		</div>
	</div>


</div>

</div>
<br><br> -->
<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

	<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'n/a', 'woocommerce' ); ?></span>.</span>

<?php endif; ?>