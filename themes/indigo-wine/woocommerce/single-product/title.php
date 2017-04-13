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
<p itemprop="name" class="hb-text-large "><?php the_title(); ?></p>
<div class="hb-accordion single-cart-option" data-initialindex="0">
<div class="hb-accordion-single">
	<div class="hb-accordion-tab">
		
		<h3>Subscribe and save</h3>
		<b>$ 200</b>
		<i class="icon-angle-right"></i>
	</div>
	<div class="hb-accordion-pane" style="display: none;">
		<div class="row">
				<div class="col-3">
					<h4>Subscribe for</h4>
				</div>
				<div class="col-6">
					<select>
						<option>
							3 months $150/Month
						</option>
						<option>
							6 months $145/Month
						</option>
						<option>
							12 months $130/Month
						</option>
					</select>	
				</div>
		</div>
		<div class="row">
				<div class="col-3">
					<h4>Quantity</h4>
				</div>
				<div class="col-6">
					<form class="cart">
					<div class="quantity"><input type="button" value="-" class="minus"><input type="number" step="1" min="1" name="quantity" value="1" title="Qty" class="input-text qty text" size="4"><input type="button" value="+" class="plus"></div>
					</form>
				</div>
		</div>
		<div class="row">
				<div class="col-3">
					
				</div>
				<div class="col-6">
					<div class="brand-button"><button class="vc_general vc_btn3 vc_btn3-color-grey">Add to cart</button></div>


				</div>
		</div>
	</div>
</div>
<div class="hb-accordion-single">
	<div class="hb-accordion-tab active-toggle">
		<h3>One time purchase</h3>
		<b>$ 250</b>
		<i class="icon-angle-right"></i>
	</div>
	<div class="hb-accordion-pane" >
		Enter your accordion content here. You can use shortcodes also…
	</div>
</div>

</div>
<br><br>
<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

	<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'n/a', 'woocommerce' ); ?></span>.</span>

<?php endif; ?>