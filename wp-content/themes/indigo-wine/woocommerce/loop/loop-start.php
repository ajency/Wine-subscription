<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
global $woocommerce_loop;
// Store column count for displaying the grid
if(empty($woocommerce_loop['columns'])) {
	$woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 1);
}

if(is_shop() || is_product_category() || is_product_tag()) {
	$woocommerce_loop['columns'] = 4;
}

preg_match("/\[([^\]]*)\]/", urldecode($_GET['filters']), $filters);

echo "<div class='row products clearfix products-".$woocommerce_loop['columns']."' data-cat='".get_queried_object()->slug."' data-min='".$_GET['min_price']."' data-max='".$_GET['max_price']."' data-page='".get_url_var('page')."' data-filter='".$filters[1]."'>";
?>