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
	<div class="col-12 col-sm-12 col-md-6 col-lg-8 p-0">
		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		
		if ( $product->is_type('variable') ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $attachment_id ), 'full' ); 
			$variations = $product->get_available_variations();

			$images_array = '{';
			foreach ($variations as $key=>$vari) {
				$vid = $vari['variation_id'];
				$imgs = $vari['variation_gallery_images'];
				$urls = array();
				if($imgs) {
					foreach ($imgs as $img) {
						array_push($urls, $img['url']);
					}
					$images_array = $images_array . $vid . ':' . json_encode($urls) . ',';
				} elseif( !$imgs) {
					$attachment_ids  = $product->get_gallery_image_ids();
					$prod_id        = $product->get_id();
					foreach ( $attachment_ids as $attachment_id ) {
						array_push($urls, $attachment_id['url']);
					}
					$images_array = $images_array . $prod_id . ':' . json_encode($urls) . ',';
				}
				//$images_array = $images_array . $vid . ':' . json_encode($urls) . ',';

			}
			$images_array = $images_array . '};';
		} elseif($product->is_type('simple')) {
			$images_array = '{';
			$attachment_ids  = $product->get_gallery_image_ids();
			$image_urls      = array();
			$prod_id        = $product->get_id();
			$image_id        = $product->get_image_id();
			if ( $image_id ) {
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );
			
				$image_urls[ 0 ] = $image_url;
			}
			
			foreach ( $attachment_ids as $attachment_id ) {
				$image_urls[] = wp_get_attachment_url( $attachment_id );
			}
			$images_array = $images_array . $prod_id . ':' . json_encode($image_urls) . ',';
			$images_array = $images_array . '};';

		}
		?>

		<script>

			<?php 
				echo "var images_array = " . $images_array . "\n";
			?>

		</script>
		<div id="gallery-wrapper"></div>
	
		<script>
			var swiperGallery;
		</script>	
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-4 mt-4 mt-md-0 d-flex align-items-end">
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
				   				  
			do_action( 'woocommerce_single_product_summary' ); ?> 		
		</div>
	</div>
</div>
</div>
<div class="container-lg after-summary">
	<div class="row">
		<p class="product-basic-description d-flex align-items-center">
			<?php 
			$product_description = $product->get_short_description();
			echo $product_description;
			?>
			
		</p>
	</div>
	<div class="row align-items-end additional-description">
	</div>
	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
	<div class="in-detail">
		<?php 
		$in_detail = get_field( "in-detail" );
		if( $in_detail ) {
			echo $in_detail;
		} else {
			echo '';
		}
		?>
	</div>
</div>
<div class="size-modal">
    <div class="size-modal-content">
        <img class="size-close-button" src="<?php echo get_template_directory_uri(); ?>/assets/popup-close-black.png">
		<table style="border-collapse: collapse;">
			<tbody>
				<tr class="desktop_sizechart">
					<td><span style="color: #000000; font-size: 24px; padding-left: 12%;">SLIM FIT</span></td>
					<td><span style="color: #000000; font-size: 24px; padding-left: 18%;">FAT FIT</span></td>
				</tr>
				<tr class="desktop_sizechart">
					<td style="border-color: #000000; border-style: solid; border-width: 0 1px 0 0;"><img src="<?php echo get_template_directory_uri(); ?>/assets/slim_fit.png" alt="Raincoat - Slim fit Sizes"/></td>
					<td><img class="ms-3" src="<?php echo get_template_directory_uri(); ?>/assets/fat_fit.png" alt="Raincoat - Fat fit Sizes"/></td>
				</tr>
				<tr class="mobile_sizechart">
					<td><span style="color: #000000; font-size: 20px; padding-left: 11%;">SLIM FIT</span></td>
					<td><img src="<?php echo get_template_directory_uri(); ?>/assets/slim_fit.png" alt="Raincoat - Slim fit Sizes"></td>
				</tr>
				<tr class="mobile_sizechart mt-3">
					<td><span style="color: #000000; font-size: 20px; padding-left: 11%;">FAT FIT</span></td>
					<td> <img src="<?php echo get_template_directory_uri(); ?>/assets/fat_fit.png" alt="Raincoat - Fat fit Sizes"></td>
				</tr>
			</tbody>
		</table>
		<span><strong>back length _</strong> torso length from end of neck to tail </span><br>
		<span><strong>elbow length_</strong> the longest part of coat, from end of neck to elbow </span><br>
		<span><strong>flap_</strong> the cross over part of coat, space between first two arms</span><br>
		<span style="font-size: 12px">All measurements are in centimeters</span>

    </div>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
