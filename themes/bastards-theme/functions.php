<?php
function add_theme_scripts() {
  wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array() );
  wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/style.css', false, 1, 'all' );

    // all scripts
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'), '1', true );
  wp_register_script( 'theme-script', get_template_directory_uri() . '/js/functions.js' , array('jquery'), '1.1', true);
  wp_enqueue_script( 'theme-script');

  
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

register_nav_menus(
  array(
  'primary-menu' => __( 'Primary Menu' ),
  'secondary-menu' => __( 'Secondary Menu' ),
  'products-footer' => __('Products footer menu'),
  'about-footer' => __('About menu footer'),
  'need-help-footer' => __('Need help footer'),
  'follow-us' => __('Follow us')
  )
);


add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
   add_theme_support( 'woocommerce' );
}     

function new_widgets_init() {

	register_sidebar( array(
		'name'          => 'How to measure',
		'id'            => 'measurment',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
	) );

}
add_action( 'widgets_init', 'new_widgets_init' );

function mytheme_post_thumbnails() {
  add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'mytheme_post_thumbnails' );
add_action('do_meta_boxes', 'add_featured_image_box');  
function add_featured_image_box()  
{  
    add_meta_box('postimagediv', __('Feature image'), 'post_thumbnail_meta_box', 'post', 'side', 'low');  
}

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 2; // 2 products per row
	}
}
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// removed rating s single-product strani
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
//removed SKU and category single-product stran
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// add description product
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_before_variations_form', 'the_content', 40 );

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );


function show_title_with_price() {
    global $product;
    $title = $product->get_title();
    $price = $product->get_price();
    $sale_price = $product->get_sale_price();
    $symbol = get_woocommerce_currency_symbol();
    
      
      if ($product->is_type('variable')) {
        $regular_price  =  $product->get_price( 'min' );
        $min_sale_price = $product->get_sale_price( 'min' );
        if($product->is_on_sale()) {
          echo "<div class='product-shop'><h2 class='product-title'>$title</h2> <span class='product-price'>$symbol $min_sale_price,00 </span></div>";
        } else {
          echo "<div class='product-shop'><h2 class='product-title'>$title</h2> <span class='product-price'>$symbol $regular_price,00 </span></div>";
        }
      } else {
       
        if($product->is_on_sale()) {
          echo "<div class='product-shop'><h2 class='product-title'>$title</h2> <span class='product-price'>$symbol $sale_price,00 </span></div>";
        } else {
          echo "<div class='product-shop'><h2 class='product-title'>$title</h2> <span class='product-price'>$symbol $price,00 </span></div>";
        }

      }
}

add_action( 'woocommerce_after_shop_loop_item', 'show_title_with_price', 5 ); 

function add_content_after_addtocart() {
    
  // get the current post/product ID
  $current_product_id = get_the_ID();

  // get the product based on the ID
  $product = wc_get_product( $current_product_id );

  // get the "Checkout Page" URL
  $checkout_url = wc_get_checkout_url ();
  if($product->is_type('variable')) {
    echo '';
  } else { 
  echo '<a href="'.$checkout_url.'?add-to-cart='.$current_product_id.'" class="buy-now button">Buy Now</a>';
  }
  //echo '<a href="'.$checkout_url.'" class="buy-now button">Buy Now</a>';
 
}
add_action( 'woocommerce_after_shop_loop_item', 'add_content_after_addtocart' );

function shuffle_variable_product_elements(){
  if ( is_product() ) {
      global $post;
      $product = wc_get_product( $post->ID );
      if ( $product->is_type( 'variable' ) ) {
          remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
          add_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation', 20 );

       
      }
  }
}
add_action( 'woocommerce_before_variations_form', 'shuffle_variable_product_elements', 10);

//Hide “From:$X”
add_filter( 'woocommerce_variable_sale_price_html', 'detect_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'detect_variation_price_format', 10, 2 );
function detect_variation_price_format( $price, $product ) {
// Main Price
  $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
  if ($prices[0] !== $prices[1]) {
    $price = $prices[0] !== $prices[1] ? sprintf( __( '', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
  }
  // Sale Price
  $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
  sort( $prices );
  $saleprice = $prices[0] !== $prices[1] ? sprintf( __( '', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
  if ( $price !== $saleprice ) {
    $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
  }
  return $price;
}

add_action( 'woocommerce_before_add_to_cart_button', 'get_selected_variation_stock', 11, 0 );
function get_selected_variation_stock() {
  global $product;

  if ( $product->is_type('variable') ) {
      $variations_data =[]; // Initializing

      // Loop through variations data
      foreach($product->get_available_variations() as $variation ) {
          // Set for each variation ID the corresponding price in the data array (to be used in jQuery)
          $variations_data[$variation['variation_id']] = $variation['display_price'];
      }
   
  ?>
  <script>

  function createGallery(productId) {

    var images = images_array[productId];
    
    var galleryHtml = `
    <div class="swiper-container-gallery sh-gal-swiper">
      <div class="swiper-wrapper ">
    `;

    for (let i = 0; i < images.length; i++) {
      galleryHtml = `
        ${galleryHtml}
          <div class="swiper-slide">
            <img src="${images[i]}" style="width: 100%;" />
          </div>
          
      `;
    }

    galleryHtml = `
      ${galleryHtml}
      </div>
      <div class="swiper-gal-button-next sh-gal-btn "><img src="<?php echo get_template_directory_uri(); ?>/assets/bastards-arrow-right.png; ?>"/></div> 
      <div class="swiper-pagination"></div>
      </div>
      
    `;

    $('#gallery-wrapper').html(galleryHtml);
    setSwiperGallery();

  }



  jQuery(document).ready(function($) {
    
      var vData = <?php echo json_encode($variations_data); ?>,
          stock = '.woocommerce-variation-availability > .stock';
          stockSimple = '.stock';

      var size_options = $('#pa_size option');
      var size_selected = $('#pa_size').val();
      var opts = [];
      var optsHtml = "";
      for (let i = 1; i < size_options.length; i++) {
          opts.push({text: size_options[i].text, val: size_options[i].value});
          let selectedClass = size_options[i].value == size_selected ? 'selected' : '';
          optsHtml = `${optsHtml}<div class="sh-size-opt ${selectedClass}"><input style="display:none;" value="${size_options[i].value}">${size_options[i].text}</div>`;
      }

      $('#pa_size').after(optsHtml);


      setTimeout(function(){
          $('#pa_fabric').prop("disabled", true);
          var $select2_color = $('#pa_colour').select2({ minimumResultsForSearch: -1, dropdownPosition: 'below'}).on('change', function() {
            setTimeout(function(){
              var variation_id = $('input.variation_id').val();
              createGallery(Number(variation_id));
            }, 300)
          }).trigger('change');
          var $select2_size = $('#pa_size').select2({ minimumResultsForSearch: -1, dropdownPosition: 'below'}).on('change', function() {
            setTimeout(function(){
              var variation_id = $('input.variation_id').val();
              createGallery(Number(variation_id));
            }, 300)
          }).trigger('change');
            var $select2_fabric = $('#pa_fabric').select2({ minimumResultsForSearch: -1, dropdownPosition: 'below'}).on('change', function() {
          }).trigger('change');

        }, 300);

    $('.sh-size-opt').on('click', function() {
      $('.sh-size-opt').removeClass('selected');
      $("#pa_size").val($(this).children('input').val()).trigger('change');
      $(this).addClass('selected');
    });
      // Once loaded (if a variation is selected by default)
      setTimeout(function(){

        var prices = $('span.price');
        if (prices.length == 0) {
          $('p.price').show();
        }
     
          if( 0 < $('input.variation_id').val() && $(stock).hasClass('out-of-stock')){ // OUT OF STOCK
              // $('.variations').after(`<?php echo do_shortcode('[popup_anything id="138"]'); ?>`);
              $('.sh-out-of-stock').remove();
              $('.variations').after(`<div class="sh-out-of-stock">out of stock</div>`);
              $('input[name="subscribe-product-id"]').val($('input.variation_id').val());
              $('.single_add_to_cart_button').hide();

          } else if (0 < $('input.variation_id').val() && !$(stock).hasClass('out-of-stock')) {
              // $('.variations_form a.paoc-popup').remove();
              $('.sh-out-of-stock').remove();
              $('.single_add_to_cart_button').show();
          }
      }, 200);

      // On live selected variation
      $('select').change( function(){
          setTimeout(function() {
          if( 0 < $('input.variation_id').val() && $(stock).hasClass('out-of-stock')){ // OUT OF STOCK
              // $('.variations_form a.paoc-popup').remove();
              $('.sh-out-of-stock').remove();
              // $('.variations').after(`<?php echo do_shortcode('[popup_anything id="138"]'); ?>`);
              $('.variations').after(`<div class="sh-out-of-stock">out of stock</div>`);
              //  $('.sh-popup-extra').text($('input.variation_id').val());
              $('input[name="subscribe-product-id"]').val($('input.variation_id').val());
              $('.single_add_to_cart_button').hide();

          } else if (0 < $('input.variation_id').val() && !$(stock).hasClass('out-of-stock')) {
              // $('.variations_form a.paoc-popup').remove();
              $('.sh-out-of-stock').remove();
              $('.single_add_to_cart_button').show();
          }
          }, 200);

      });
 
  });
  </script>
  <?php
}
}


/** remove clear button on product page*/
add_filter( 'woocommerce_reset_variations_link', '__return_false' );
/** remove added product to cart message */
add_filter( 'wc_add_to_cart_message_html', '__return_false' );
add_action( 'woocommerce_review_order_before_submit', 'woocommerce_order_review', 20 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );

add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'filter_dropdown_option_html', 12, 2 );
function filter_dropdown_option_html( $html, $args ) {
    $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' );
    $show_option_none_html = '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

    $html = str_replace($show_option_none_html, '', $html);

    return $html;
}

?>