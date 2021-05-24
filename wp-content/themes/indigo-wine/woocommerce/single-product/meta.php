<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="clear"></div>
<div class="hb-separator"></div>
<div class="product_meta product_attr clearfix">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in meta-div">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' ); ?>
	<?php echo wc_get_product_tag_list( $product->get_id(), '', '<span class="tagged_as meta-div">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span>' ); ?>


	<div class="classification_selected meta-div">
		<p class="meta-div mb-2">Classifications</p>
		<?php 

			$taxonomy = 'Classification';
			$tax_terms = get_terms([
			    'taxonomy' => $taxonomy,
			    'hide_empty' => false,
			]);
		?>
		<ul class="classification_block">
			<?php
			if (!empty($tax_terms) && ! is_wp_error( $tax_terms )) {
				foreach ( $tax_terms as $tax_term ) {
					$class = has_term( $tax_term->term_id, $tax_term->taxonomy ) ? 'selected' : ''; 
				    echo '<li class="' . $class . '">';
				    echo '<a href="' . esc_attr( get_term_link( $tax_term, $taxonomy ) ) . 
				        '" title="' . sprintf( __( "View all products" ), $tax_term->name ) . 
				        '" ' . '>';

				    echo '<img class="classification_img" src="' . get_field( 'image', $tax_term ) . '">';
				  
				    // $tax_terms_name = get_term_by('name', 'Awards' , $taxonomy );
				    if ( $tax_term->name == 'Awards') {
			     		echo '<p>' . get_field( 'award_count' ) . '</p>';
		     		}
				    echo '<p class="classification_name">'. $tax_term->name .'</p>';
				    echo '</a>';
				    echo '</li>';
				}
			}
			?>
		</ul>
	</div>

	<div class="bottom-meta-section hb-woo-meta">
	<?php if ( hb_options('hb_woo_enable_likes') ){ ?>
	<div class="float-right hidden">	
		<?php echo hb_print_likes(get_the_ID()); ?>
	</div>
	<?php }
	?>

	<?php if (hb_options('hb_woo_enable_share')) { ?>
	<div class="float-right share-product">
		<div class="hb-woo-like-share">
			<?php get_template_part ( 'includes/hb' , 'share' ); ?>
		</div>
	</div>
	<?php } ?>
	</div>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>