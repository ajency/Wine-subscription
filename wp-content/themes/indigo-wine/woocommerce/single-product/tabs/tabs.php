<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
$show_wine_pack_product = true;
$wine_pack_product_key = 'wine-pack-product';
if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="tabs wc-tabs">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<?php if($key != $wine_pack_product_key): ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</a>
				</li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<?php if($key != $wine_pack_product_key): ?>
			<div class="panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				if($show_wine_pack_product){
					if ( isset( $product_tab['callback'] ) ) : ?>
					<div class="product-accordion">
					<?php
						$wine_pack_product_content =  $product_tabs[$wine_pack_product_key]['content'];
						$wine_product_contents = explode("<h2>", $wine_pack_product_content);
						array_shift($wine_product_contents);
						foreach ($wine_product_contents as $index => $wine_product_content) : 
							$content_parts = explode("</h2>", $wine_product_content); ?>
							<div class="card">
								<div class="card-header">
									<h2 class="card-title <?php echo (!$index) ? 'card-header-opened' : 'card-header-closed'; ?>" data-target="product-description-<?php echo $index;?>">
										<?php echo $content_parts[0]; ?>
									</h2>
								</div>
								<div id="product-description-<?php echo $index; ?>" class="card-content <?php echo (!$index) ? 'card-content-opened' : 'card-content-closed'; ?>">
									<div class="card-body">
										<?php echo $content_parts[1]; ?>
									</div>
								</div>
							</div>
						<?php endforeach; 
						//preg_match_all("/<\/h2>(.*)/s", $wine_pack_product_content, $matches);
						//echo '<script type="text/plain">'.json_encode($wine_products).'</script>';
						$show_wine_pack_product = false;
					?>
					</div>
					<?php endif; 
					}
				?>
			</div>
			<?php endif; ?>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

<?php endif; ?>
