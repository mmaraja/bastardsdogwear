<?php
/**
 * Product
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/body/product.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 2.1
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$productClasses = apply_filters( 'xoo_wsc_product_class', $productClasses );

?>
<div data-key="<?php echo $cart_item_key ?>" class="<?php echo implode( ' ', $productClasses ) ?>">
	<?php do_action( 'xoo_wsc_product_start', $_product, $cart_item_key ); ?>
<div class="container">
		<div class="row">
            <div class="col-3 col-sm-2 p-0">
                <?php echo $thumbnail; ?>
                <?php do_action( 'xoo_wsc_product_image_col', $_product, $cart_item_key ); ?>
            </div>
            <div class="col-6 col-sm-7">
                <?php do_action( 'xoo_wsc_product_summary_col_start', $_product, $cart_item_key ); ?>
                <?php if( $showPname ): ?>
                    <span class="xoo-wsc-pname"><?php echo $product_name; ?></span>
                <?php endif; ?>
            
                <div class="xoo-wsc-pprice">
                    <?php echo $product_price ?>
                </div>
            <?php if( $showPdel ): ?>
			    <span class="xoo-wsc-smr-del delete-product-cart">Remove</span>
		    <?php endif; ?>
            </div>
            <div class="col-3 col-sm-3">
                <span><?php _e( 'Quantity:', 'side-cart-woocommerce' ) ?></span> <span><?php echo $cart_item['quantity']; ?></span>
         

            </div>
              
		</div>
		
	</div>

	<?php do_action( 'xoo_wsc_product_end', $_product, $cart_item_key ); ?>

</div>