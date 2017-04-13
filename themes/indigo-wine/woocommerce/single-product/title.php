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
<h3 itemprop="name" class="hb-heading"><span><?php the_title(); ?></span></h3>
<div class="hb-accordion-single"><div class="hb-accordion-tab active-toggle"><i class="hb-moon-support"></i>Accordion Title 1<i class="icon-angle-right"></i></div><div class="hb-accordion-pane" style="display: block;">Enter your accordion content here. You can use shortcodes also…</div></div>
<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

	<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'n/a', 'woocommerce' ); ?></span>.</span>

<?php endif; ?>