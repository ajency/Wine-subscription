<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
$sub_category = get_queried_object();
$thumbnail_id = get_woocommerce_term_meta( $sub_category->term_id, 'thumbnail_id', true ); 
$imageURL = wp_get_attachment_image_src( $thumbnail_id, 'full')[0];
if($sub_category->taxonomy == "product_cat"){
	$category = get_term($sub_category->parent);
	if($category->name == "Producers"){ 
		$producer_page = true;
		?>
		<div class="producer-category-container">
			<div class="producer-category-image-container" style="background-image:url(<?php echo $imageURL; ?>);">
			</div>
			<div class="producer-category-description-container">
				<div class="producer-category-description-inner">
					<h1 class="producer-category-description-title  site-title">
						<?php echo $sub_category->name; ?>
					</h1>
					<div class="producer-category-description-info">
						<?php echo $sub_category->description; ?>
					</div>
				</div>
			</div>
			<div class="clearfix mb-2"></div>
		</div>
		<div class="clearfix"></div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				image_height = jQuery(".producer-category-image-container").outerHeight();
				content_height = jQuery(".producer-category-description-container").outerHeight();
				if(image_height < content_height){
					jQuery(".producer-category-image-container").css("height", content_height+"px");
				}
				if (jQuery(window).width() < 767) {
					jQuery(".producer-category-image-container").css("height", "320px");
				}
			});
			
		</script>
	<?php
	}
}
do_action( 'woocommerce_before_main_content' );

?>


<?php
/**
 * Hook: woocommerce_archive_description.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */
$product_view = isset($_GET['view']) ? $_GET['view'] : 'grid';
if(!isset($producer_page)){
	do_action( 'woocommerce_archive_description' );
	$product_view = 'list';
}

?>
<?php

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */

	?>

	<?php do_action( 'woocommerce_before_shop_loop' );?>
	<div class="clear"></div>
	<div class="basel-products-loader"></div>
	<?php
	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product-'.$product_view );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	wc_get_template( 'loop/no-products-found.php' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
