<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit; ?>

		
<?php global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div class="container-fluid" id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
<div class="row">
	<div class="col-sm-12 col-md-8 col-lg-8 p-0">
		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		
		$attachment_ids = $product->get_gallery_image_ids();

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $attachment_id ), 'full' ); 
		$variations = $product->get_available_variations();
			$images_array = '{';
			foreach ($variations as $key=>$vari) {
				$vid = $vari['variation_id'];
				$imgs = $vari['variation_gallery_images'];
				$urls = array();
				foreach ($imgs as $img) {
					array_push($urls, $img['url']);
				}
				$images_array = $images_array . $vid . ':' . json_encode($urls) . ',';

			}
			$images_array = $images_array . '};';
		
		?>

		<script>
			<?php 
				echo "var images_array = " . $images_array . "\n";
			?>
		</script>
		<div id="gallery-wrapper">
		</div>
<script>
	var swiperGallery;
</script>
					


		
	</div>
	<div class=" col-lg-4 col-md-4 mt-4 mt-md-0 d-flex align-items-end">
		<div class="summary entry-summary product-sum" >
			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
				   				  
					do_action( 'woocommerce_single_product_summary' );
					

					?> 
				
						
		</div>
	</div>
</div>
</div>

				
	</div>
</div>



<?php do_action( 'woocommerce_after_single_product' ); ?>
