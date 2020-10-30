<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Producers Template
*/
?>
<?php get_header(); ?>
<div id="main-content">	
	<div class="container">
		<?php
		$IDbyNAME = get_term_by('name', 'Producers', 'product_cat');
		$product_cat_ID = $IDbyNAME->term_id;
		$args = array(
			'hierarchical' => 1,
			'show_option_none' => '',
			'hide_empty' => 0,
			'parent' => $product_cat_ID,
			'taxonomy' => 'product_cat'
		);
		$subcats = get_categories($args);
		echo '<ul class="producer-list">';
		foreach ($subcats as $sc) {
			$link = get_term_link( $sc->slug, $sc->taxonomy );
			$thumbnail_id = get_woocommerce_term_meta( $sc->term_id, 'thumbnail_id', true ); 
			$image = wp_get_attachment_image_src( $thumbnail_id, 'large' );
			if($image){
				echo '<li class="producer-single">
					<a class="producer-image" href="'. $link .'"><div class="producer-image-bg" style="background-image:url('.$image[0].');"></div></a>
					<a class="producer-title" href="'. $link .'">'.$sc->name.'</a>
				</li>';
			}
		}
		echo '</ul>';
		?>
	</div>
</div>
<?php get_footer(); ?>