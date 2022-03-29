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
 * @package WooCommerce\Templates
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
do_action( 'woocommerce_before_main_content' );


?>

<div class="shop-page">
    <div class="container-lg">
    <div class="row h-100 mb-5">
        <div class="col-3 col-sm-2 col-md-1 col-lg-1 hero-div-arrow">
            <div class="hero-arrow-container blog-arrow">
                <div class="arrow-hero">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/arrow-hero.png" width="40" alt="ScrollDown">
                </div>
            </div>
        </div>
        <div class="col-9 col-sm-10 col-md-8 col-lg-8 blog-text ps-0 position-relative">
            <h1 class="shop-hero-header">BASTARDS wardrobe</h1>
        </div>
    </div>
    <?php if ( woocommerce_product_loop() ) {

        /* Category - SubCategory START */
        $term 			= get_queried_object();
        $parent_id 		= empty( $term->term_id ) ? 0 : $term->term_id;

        $product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'child_of' => $parent_id) );

        if(empty($product_categories)) {
            woocommerce_product_loop_start();
            if ( wc_get_loop_prop( 'total' ) ) {
                while ( have_posts() ) {
                    the_post();

                    /**
                     * Hook: woocommerce_shop_loop.
                     *
                     * @hooked WC_Structured_Data::generate_product_data() - 10
                     */
                    do_action( 'woocommerce_shop_loop' );

                    wc_get_template_part( 'content', 'product' );
                }
            }
            woocommerce_product_loop_end();

        } else {

            $i = 1;
            foreach ($product_categories as $product_category) {
                echo '<h2 class="category-name">'.$product_category->name.'</h2>';
                woocommerce_product_loop_start(); //open ul

                $args = array(
                    'posts_per_page' => -1,
                    'tax_query' => array(
                    'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $product_category->slug
                        ),
                    ),
                    'post_type' => 'product',
                    'orderby' => 'menu_order',
                    'order' => 'asc',
                );
                $cat_query = new WP_Query( $args );

                while ( $cat_query->have_posts() ) : $cat_query->the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile; // end of the loop.
                wp_reset_postdata();
                woocommerce_product_loop_end(); //close ul
                if ( $i < count($product_categories) )
                    echo '<div class="content-seperator"></div>';
                $i++;
            }//foreach
        }
        /* Category - SubCategory END */

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
        do_action( 'woocommerce_no_products_found' );
    } ?>
    </div>
</div>



<?php get_footer( 'shop' );