<?php
function add_theme_scripts() {
  wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array() );
  wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/style.css', false, 1, 'all' );
    // all scripts
 
  wp_register_script( 'theme-script', get_template_directory_uri() . '/js/functions.js' , array('jquery'), '1.1', true);
  wp_enqueue_script( 'theme-script');
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'), '1', true );
  
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
  register_sidebar( array(
		'name'          => 'Contact form - footer',
		'id'            => 'footer_form',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
	) );

}
add_action( 'widgets_init', 'new_widgets_init' );
function phi_theme_support() {
  remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'phi_theme_support' );

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

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// removed rating s single-product strani
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
//removed SKU and category single-product stran
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// add description product
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_after_single_product_summary', 'the_content', 40 );

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10);



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

// function add_content_after_addtocart() {
    
//   // get the current post/product ID
//   $current_product_id = get_the_ID();

//   // get the product based on the ID
//   $product = wc_get_product( $current_product_id );

//   // get the "Checkout Page" URL
//   $checkout_url = wc_get_checkout_url ();
//   if($product->is_type('variable')) {
//     echo '';
//   } else { 
//   echo '<a href="'.$checkout_url.'?add-to-cart='.$current_product_id.'" class="buy-now button">Buy Now</a>';
//   }
//   //echo '<a href="'.$checkout_url.'" class="buy-now button">Buy Now</a>';
 
// }
// add_action( 'woocommerce_after_shop_loop_item', 'add_content_after_addtocart' );

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
  // Get the product attribute value(s)
  $product = wc_get_product( $product->get_id() );
  $color = $product->get_attribute('pa_colour');
  $gender = $product->get_attribute('pa_option');
  
    ?>
    <script>

    function createGallery(productId) {

      var images = images_array[productId];

      var galleryHtml = `
      <div class="swiper-container-gallery sh-gal-swiper">
		   <div class="swiper-gal-button-prev sh-gal-btn "></div>
			  <div class="swiper-gal-button-next sh-gal-btn "></div> 

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
          var colour = '<?php echo($color);?>';
          var gender = '<?php echo($gender);?>';
          // if product has attribute 'pa_color' value(s)
          if( !colour ){
              // do something
              setTimeout(function() {
              var variation_id = $('input.variation_id').val();
              var product_id = $('input[name="product_id"]').val();
              createGallery(Number(variation_id));
              var div_id = "var_" + product_id;
              var html_product = $('#' + div_id).html();
              $('.additional-description').html(html_product);
            }, 300);
          } 
          if( !gender ){
              // do something
              setTimeout(function() {
              var variation_id = $('input.variation_id').val();
              var product_id = $('input[name="product_id"]').val();
              createGallery(Number(variation_id));
              var div_id = "var_" + product_id;
              var html_product = $('#' + div_id).html();
              $('.additional-description').html(html_product);
            }, 300);
          } 
       
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
            var str = size_options[i].text;
            //collar S 28 - 40 cm / leash L 300 cm
            // S 120 cm
            var ret = str.split(" ");
            var str1 = ret[0];
            var str2 = ret.splice(1).join(" ");
            // var ret2 = str2.split("/");
            // var str3;
            // if(ret2.length == 2) {
            //   str2 = ret2[0];
            //   str3 = ret2[1];
            // }
            // var str3 = ret[2];
            var class_size = "";
            if( i == 1) {
              var class_size = "first";
            } else if ( i == size_options.length-1)  {
              var class_size = "last";
            }
           
              optsHtml = `${optsHtml}<div class="sh-size-opt ${class_size} ${selectedClass}"><input style="display:none;" value="${size_options[i].value}">${str1}<br>${str2}</div>`;
              

        }
        if($('#product-210').length ) {
          optsHtml = `${optsHtml}<input type="button" class="size-trigger" value="Size chart">`;
          console.log('lalal')
        }

        const modal = $(".size-modal");
        const modal_trigger = $(".size-trigger");
        const closeButton = $(".size-close-button");

        function toggleModalSize() {
            modal.toggleClass("size-show-modal");
        }

        function windowOnClick(event) {
            if (event.target === modal) {
              toggleModalSize();
            }
        }
        $(document).ready(function() {
          $(".size-trigger").click(function() {
            toggleModalSize();
          }) 
          closeButton.on("click", function() {
            toggleModalSize();
          }) 
          
        })
      
              
        var tag_options = $('#pa_name-tag option');
        var tag_selected = $('#pa_name-tag').val();
        var tag_opts = [];
        var tag_optsHtml = "";
        
        for (let i = 1; i < tag_options.length; i++) {
          tag_opts.push({text: tag_options[i].text, val: tag_options[i].value});
            let select_class = tag_options[i].value == tag_selected ? 'selected' : '';
            var class_tag = "";
            if( i == 1) {
              var class_tag = "first";
            } else if ( i == size_options.length-1)  {
              var class_tag = "last";
            }
            tag_optsHtml = `${tag_optsHtml}<div class="sh-tag-opt ${class_tag} ${select_class}"><input style="display:none;" value="${tag_options[i].value}">${tag_options[i].text}</div>`;
        }

        var gender_options = $('#pa_option option');
        var gender_selected = $('#pa_option').val();
        var gender_opts = [];
        var gender_optsHtml = "";
        
        for (let i = 1; i < gender_options.length; i++) {
          gender_opts.push({text: gender_options[i].text, val: gender_options[i].value});
            let select_class = gender_options[i].value == gender_selected ? 'selected' : '';
            var class_tag = "";
            if( i == 1) {
              var class_tag = "first";
            } else if ( i == gender_options.length-1)  {
              var class_tag = "last";
            }
            gender_optsHtml = `${gender_optsHtml}<div class="sh-option-opt ${class_tag} ${select_class}"><input style="display:none;" value="${gender_options[i].value}">${gender_options[i].text}</div>`;
        }

        var fit_options = $('#pa_fit option');
        var fit_selected = $('#pa_fit').val();
        var fit_opts = [];
        var fit_optsHtml = "";
        
        for (let i = 1; i < fit_options.length; i++) {
          fit_opts.push({text: fit_options[i].text, val: fit_options[i].value});
            let select_class = fit_options[i].value == fit_selected ? 'selected' : '';
            var class_tag = "";
            if( i == 1) {
              var class_tag = "first";
            } else if ( i == size_options.length-1)  {
              var class_tag = "last";
            }
            fit_optsHtml = `${fit_optsHtml}<div class="sh-tag-opt ${class_tag} ${select_class}"><input style="display:none;" value="${fit_options[i].value}">${fit_options[i].text}</div>`;
        }
       
        var collarS_options = $('#pa_collar-size option');
        var collarS_selected = $('#pa_collar-size').val();
        var collarS_opts = [];
        var collarS_optsHtml = "";
        
        for (let i = 1; i < collarS_options.length; i++) {
          collarS_opts.push({text: collarS_options[i].text, val: collarS_options[i].value});
            let select_class = collarS_options[i].value == collarS_selected ? 'selected' : '';
            var class_sizeCollar = "";
            var collarText = collarS_options[i].text;
            var retCollar = collarText.split(" ");
            var collarText1 = retCollar[0];
            var collarText2 = retCollar.splice(1).join(" ");
            if( i == 1) {
              var class_sizeCollar = "first";
            } else if ( i == collarS_options.length-1)  {
              var class_sizeCollar = "last";
            }
            collarS_optsHtml = `${collarS_optsHtml}<div class="sh-collar-opt ${class_sizeCollar} ${select_class}"><input style="display:none;" value="${collarS_options[i].value}">${collarText1}<br>${collarText2}</div>`;
        }

        var leashS_options = $('#pa_leash-size option');
        var leashS_selected = $('#pa_leash-size').val();
        var leashS_opts = [];
        var leashS_optsHtml = "";
        
        for (let i = 1; i < leashS_options.length; i++) {
          leashS_opts.push({text: leashS_options[i].text, val: leashS_options[i].value});
            let select_class = leashS_options[i].value == leashS_selected ? 'selected' : '';
            var class_sizeLeash = "";
            var leashText = leashS_options[i].text;
            var retLeash = leashText.split(" ");
            var leashText1 = retLeash[0];
            var leashText2 = retLeash.splice(1).join(" ");
            if( i == 1) {
              var class_sizeLeash = "first";
            } else if ( i == leashS_options.length-1)  {
              var class_sizeLeash = "last";
            }
            leashS_optsHtml = `${leashS_optsHtml}<div class="sh-leash-opt ${class_sizeLeash} ${select_class}"><input style="display:none;" value="${leashS_options[i].value}">${leashText1}<br>${leashText2}</div>`;
        }
       
        $('#pa_size').after(optsHtml);
      
        $('#pa_collar-size').after(collarS_optsHtml);
        $('#pa_leash-size').after(leashS_optsHtml);
        $('#pa_name-tag').after(tag_optsHtml);
        $('#pa_fit').after(fit_optsHtml);
        $('#pa_option').after(gender_optsHtml);
        
       

        setTimeout(function(){
            var $select2_color = $('#pa_colour').select2({ minimumResultsForSearch: -1, dropdownPosition: 'below'}).on('change', function() {
              setTimeout(function(){
                var variation_id = $('input.variation_id').val();
                createGallery(Number(variation_id));
                var div_id = "var_" + variation_id;
                var html_product = $('#' + div_id).html();
                $('.additional-description').html(html_product);
              }, 300)
            }).trigger('change');
           
            var $select2_fabric = $('#pa_fabric').select2({ minimumResultsForSearch: -1, dropdownPosition: 'below'}).on('change', function() {
              setTimeout(function(){
                var variation_id = $('input.variation_id').val();
                createGallery(Number(variation_id));
                var div_id = "var_" + variation_id;
                var html_product = $('#' + div_id).html();
                $('.additional-description').html(html_product);
              }, 300)
            }).trigger('change');
          

           if($select2_color &&  $select2_color.data('select2')) {
            $select2_color.data('select2').$container.addClass("sh-product-select");
            $select2_color.data('select2').$dropdown.addClass("sh-product-select");   
           }
           if($select2_fabric &&  $select2_fabric.data('select2')) {
            $select2_fabric.data('select2').$container.addClass("sh-product-select");
            $select2_fabric.data('select2').$dropdown.addClass("sh-product-select");   
           }
           
          }, 300);
          setTimeout(function(){
        $('.sh-option-opt').on('click', function() {
          $('.sh-option-opt').removeClass('selected');
          $("#pa_option").val($(this).children('input').val()).trigger('change');
          $(this).addClass('selected');
          setTimeout(function(){
                var variation_id = $('input.variation_id').val();
                createGallery(Number(variation_id));
                var div_id = "var_" + variation_id;
                var html_product = $('#' + div_id).html();
                $('.additional-description').html(html_product);
          }, 300)
        });
        $(".sh-option-opt:first").trigger('click');
      }, 300)
        $('.sh-size-opt').on('click', function() {
          $('.sh-size-opt').removeClass('selected');
          $("#pa_size").val($(this).children('input').val()).trigger('change');
          $(this).addClass('selected');
        });
        $('.sh-tag-opt').on('click', function() {
          $('.sh-tag-opt').removeClass('selected');
          $("#pa_name-tag").val($(this).children('input').val()).trigger('change');
          $(this).addClass('selected');
        });
        $('.sh-collar-opt').on('click', function() {
          $('.sh-collar-opt').removeClass('selected');
          $("#pa_collar-size").val($(this).children('input').val()).trigger('change');
          $(this).addClass('selected');
        });
        $('.sh-leash-opt').on('click', function() {
          $('.sh-leash-opt').removeClass('selected');
          $("#pa_leash-size").val($(this).children('input').val()).trigger('change');
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
                $('.qib-container').after(`<div class="sh-out-of-stock">out of stock</div>`);
                $('input[name="subscribe-product-id"]').val($('input.variation_id').val());
                $('.single_add_to_cart_button').hide();

            } else if (0 < $('input.variation_id').val() && !$(stock).hasClass('out-of-stock')) {
                //$('.variations_form a.paoc-popup-click').remove();
                $('.sh-out-of-stock').remove();
                $('.single_add_to_cart_button').show();
            }
        }, 200);

        // On live selected variation
        $('select').change( function(){
            setTimeout(function() {
            if( 0 < $('input.variation_id').val() && $(stock).hasClass('out-of-stock')){ // OUT OF STOCK
                //$('.variations_form a.paoc-popup-click').remove();
                $('.sh-out-of-stock').remove();
                $('.single_variation_wrap').after(`<?php echo do_shortcode('[popup_anything id="542"]'); ?>`);
                $('.qib-container').after(`<div class="sh-out-of-stock">out of stock</div>`);
                //  $('.sh-popup-extra').text($('input.variation_id').val());
                $('input[name="subscribe-product-id"]').val($('input.variation_id').val());
                $('.single_add_to_cart_button').hide();

            } else if (0 < $('input.variation_id').val() && !$(stock).hasClass('out-of-stock')) {
                $('.variations_form a.paoc-popup-click').remove();
                $('.sh-out-of-stock').remove();
                $('.single_add_to_cart_button').show();
            }
            }, 200);

        });
   
    });
    </script>
    <?php
  } elseif ( $product->is_type('simple') ) {
    
      ?>
      <script>
  
      function createGallery(productId) {
  
        var images = images_array[productId];
  
        var galleryHtml = `
        <div class="swiper-container-gallery sh-gal-swiper">
         <div class="swiper-gal-button-prev sh-gal-btn "></div>
          <div class="swiper-gal-button-next sh-gal-btn "></div> 
  
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
            var simple_id = $('.single_add_to_cart_button').val();
            createGallery(Number(simple_id));
            var stockSimple = '.stock';
           
            setTimeout(function(){

            var prices = $('span.price');
            if (prices.length == 0) {
              $('p.price').show();
            }
            
            var div_id = "simple_" + simple_id;
            var html_product = $('#' + div_id).html();
            $('.additional-description').html(html_product);

              if( $(stockSimple).hasClass('out-of-stock')){ // OUT OF STOCK
                 $('form.cart').after(`<?php echo do_shortcode('[popup_anything id="542"]'); ?>`);
                  $('.sh-out-of-stock').remove();
                  $('form.cart').hide();
                  $('.price').after(`<div class="sh-out-of-stock">out of stock</div>`);
                  $('input[name="subscribe-product-id"]').val($('.single_add_to_cart_button').val());
                  $('.single_add_to_cart_button').hide();
                  createGallery(Number(simple_id));
                 

              } else if (!$(stockSimple).hasClass('out-of-stock')) {
                  $('.sh-out-of-stock').remove();
                  $('.single_add_to_cart_button').show();
                  $('form.cart').css('margin-top', '0');
              }
            }, 200);


         
            
  
      });
      </script>
      <?php
    }
}


// remove choose an option from product dropdown
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'wc_remove_options_text');
function wc_remove_options_text( $args ){
    $args['show_option_none'] = '';
    return $args;
}

/** remove clear button on product page*/
add_filter( 'woocommerce_reset_variations_link', '__return_false' );
/** remove added product to cart message */
add_filter( 'wc_add_to_cart_message_html', '__return_false' );
add_action( 'woocommerce_review_order_before_submit', 'woocommerce_order_review', 20 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );

/*single product page - removed META(sku), related products */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**quantity text on single product page */
add_action('woocommerce_before_add_to_cart_quantity', 'wc_text_after_quantity');
function wc_text_after_quantity() {
    if ( is_product()) {
        echo '<div class="label"><span>Quantity</span></div>';
    }
}

/**replace coupon code on checkout */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_review_order_before_submit', 'woocommerce_checkout_coupon_form', 20 );
// Removes Order Notes Title
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );
// Remove Order Notes Field
add_filter( 'woocommerce_checkout_fields' , 'hide_order_notes' );
function hide_order_notes( $fields ) {

  unset($fields['order']['order_comments']);
  unset($fields['billing']['billing_company']);
  unset($fields['billing']['billing_last_name']);
  
  return $fields;

}
add_filter('woocommerce_default_address_fields', 'override_default_address_checkout_fields', 20, 1);
function override_default_address_checkout_fields( $address_fields ) {
    $address_fields['address_1']['placeholder'] = '';
    $address_fields['address_2']['placeholder'] = '';
    $address_fields['postcode']['label'] = 'ZIP/Postal code';
    return $address_fields;
}
/**woocommerce checkout  */
/**change position of email input */

add_filter( 'woocommerce_billing_fields', 'bbloomer_move_checkout_email_field' );

function bbloomer_move_checkout_email_field( $address_fields ) {
    $address_fields['billing_email'] = array(
      'label' => __('Email', 'woocommerce'),
      'required' => true,
      'priority' => 1,
      'custom_attributes' => array( 'request-email'=>'After you have made a purchase of a made-to-measure item, 
      we will send you an email with requested measurements of your dog we need to make said item' ),
      'input_class' => array( 'append-description' ),
    );
    $address_fields['billing_phone'] = array(
      'label' => __('Telephone', 'woocommerce'),
      'required' => true,
      'priority' => 2,
    );
    $address_fields['billing_first_name'] = array(
      'label' => __('Full name', 'woocommerce'),
      'required' => true,
      'priority' => 3,
    );
    $address_fields['billing_address_1']['priority'] = 4;
    $address_fields['billing_address_2']['priority'] = 5;
    $address_fields['billing_city'] =  array(
      'label' => __('City', 'woocommerce'),
      'required' => true,
      'priority' => 6,
    );
    $address_fields['billing_postcode']['priority'] = 7;
  
  
    return $address_fields;
}

/*wrapp checkout fields in div*/
function change_woocommerce_field_markup($field, $key, $args, $value) {
  $field = str_replace('form-row', '', $field);

  $field = '<div class="single-field-wrapper" data-priority="' . $args['priority'] . 
  '">' . $field . '</div>';
    if($key === 'billing_email') {
      $field = '<div class="email-wrapper wrapper-box"><div class="wrapper-heading"><h4>Customer Info</h4><span>*Required</span></div>'.$field .'</div>';
    }
    if($key === 'billing_phone')
      $field = '<div class="phone-wrapper wrapper-box"><div class="wrapper-heading"><h4>Additional Information</h4><span>*Required</span></div>'.$field .'</div>';
    if ($key === 'billing_first_name') {
      $field = '<div class="shipping-address-wrapper wrapper-box"><div class="wrapper-heading"><h4>Shipping Address</h4><span>*Required</span></div><div class="inner-wrap">'.$field;
    } else if($key === 'billing_state') {
      $field = $field .'</div></div>';
    } 
      
  return $field;
} 
add_filter("woocommerce_form_field","change_woocommerce_field_markup", 10, 4);
add_action( 'woocommerce_checkout_after_customer_details', 'cart_items_data' );
/**add cart data below billing fields, checkout */
function cart_items_data() {
  global $woocommerce;
  $items = $woocommerce->cart->get_cart();
  echo '<div class="checkout_product-data wrapper-box">';
  echo "<div class='wrapper-heading'><h4>Items in order</h4></div>";
      foreach($items as $item => $values) { 
          $_product =  wc_get_product( $values['data']->get_id() );
          //product image
          $getProductDetail = wc_get_product( $values['product_id'] );
          echo "<div class='checkout_product-item'>";
            echo "<div class='checkout_product-left'>";
              echo $getProductDetail->get_image(); // accepts 2 arguments ( size, attr )
              echo "<div class='checkout_product-info'>";
                echo "<b class='variation_checkout-title'>".$_product->get_name()  .'</b> <br><span class="variation_checkout-quantity">Quantity: '.$values['quantity'].'</span>'; 
              echo "</div>";
            echo "</div>";
            echo "<div class='checkout_product-totals'>";
              $product_price_single = $values['data']->get_price();
              $product_price_total_formatted = number_format($product_price_single * $values['quantity'], 2, ',', '.'); 
              echo '<span><span class="woocommerce-Price-currencySymbol">€</span>&nbsp;' . $product_price_total_formatted . '</span>';
            echo "</div>";
          echo "</div>";
      }
    echo "</div>";
}
/**payment methods*/
add_action( 'woocommerce_checkout_billing', 'my_custom_display_payments', 20 );

/**
 * Displaying the Payment Gateways 
 */
function my_custom_display_payments() {
  if ( WC()->cart->needs_payment() ) {
    $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
    WC()->payment_gateways()->set_current_gateway( $available_gateways );
  } else {
    $available_gateways = array();
  }
  ?>
  <div id="checkout_payments" class="wrapper-box">
    <div class="wrapper-heading">
      <h4><?php esc_html_e( 'Payment Info', 'woocommerce' ); ?></h4>
      <span>*Required</span>
    </div>
    <?php if ( WC()->cart->needs_payment() ) : ?>
    <ul class="wc_payment_methods payment_methods methods">
    <?php
    if ( ! empty( $available_gateways ) ) {
      foreach ( $available_gateways as $gateway ) {
        wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
      }
    } else {
      echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
    }
    ?>
    </ul>
  <?php endif; ?>
  </div>
<?php
}
/*change position of place order button on checkout*/
function output_payment_button() {
  $order_button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place Order', 'woocommerce' ) );
  echo '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />';
}
add_action( 'woocommerce_checkout_after_order_review', 'output_payment_button' );

function remove_woocommerce_order_button_html() {
  return '';
}
add_filter( 'woocommerce_order_button_html', 'remove_woocommerce_order_button_html' );

/**change coupon code section checkout */
add_filter('gettext', 'custom_strings_translation', 20, 3);
function custom_strings_translation( $translated_text, $text, $domain ) {
    if( $text == 'If you have a coupon code, please apply it below.' ){
        $translated_text =  __( 'Discount code', $domain );
    }
    else if( $text == 'Apply coupon' ){
      $translated_text =  __( 'Apply', $domain );
    }
    return $translated_text;
}

/*change product loop style on homepage*/
function my_product_block( $html, $data, $product ) {
    
    $price = $product->get_price();
    $sale_price = $product->get_sale_price();
    $symbol = get_woocommerce_currency_symbol();
    if ($product->is_type('variable')) {
      $regular_price  =  $product->get_price( 'min' );
      $html = '<li class="wc-block-grid__product">
          <div class="image-wrap">
              <a href="' . $data->permalink . '" class="wc-block-grid__product-link">' . $data->image . '</a>
              <div class="product-shop"><h3><a href="' . $data->permalink . '">' . $data->title . '</a></h3><span class="product-price">'. $symbol . $regular_price . ',00</span></div>
          </div>
          ' . $data->button . '
      </li>';
    } 
    
  return $html;
}
add_filter( 'woocommerce_blocks_product_grid_item_html', 'my_product_block', 10, 3);

/**hide shipping method name eg. flat rate */
add_filter( 'woocommerce_cart_shipping_method_full_label', 'bbloomer_remove_shipping_label', 9999, 2 );
   
function bbloomer_remove_shipping_label( $label, $method ) {
    $new_label = preg_replace( '/^.+:/', '', $label );
    return $new_label;
}
/*shop page- simple product change read more button*/

add_filter( 'woocommerce_loop_add_to_cart_link', 'my_out_of_stock_button' );
function my_out_of_stock_button( $args ){
  global $product;
  $product = wc_get_product( $product->get_id() );
  $permalink = $product->get_permalink();
  if($product->is_type('variable')) {
   $product_attribute_taxonomies = array( 'pa_size-shop', 'pa_colour');
    // Loop through your defined product attribute taxonomies
    foreach( $product_attribute_taxonomies as $taxonomy ){
        if( taxonomy_exists($taxonomy) ){
            $label_name = wc_attribute_label( $taxonomy, $product );

            $term_names = $product->get_attribute( $taxonomy );
            if( ! empty($term_names) ){
              $str_arr = explode (",", $term_names); 
              $new_arr = '<div>' . implode( '</div><div> ', $str_arr ) . '</div>';
          }
       
      }
    }
    if( $product && !$product->is_in_stock() ){
      return '<div class="info-product"><div class="attributes-shop">' . $new_arr  . '</div><a class="buy-now button" href="' .$permalink . '">SHOP PRODUCT</a></div>';
    } elseif ($product && $product->is_in_stock()) {
      return '<div class="info-product"><div class="attributes-shop">' . $new_arr  . '</div><a class="buy-now button" href="' .$permalink . '">SHOP PRODUCT</a></div>';
    }
  } elseif ($product->is_type('simple')) {
    if( $product && !$product->is_in_stock() ){
      return '<a class="buy-now button" href="' .$permalink . '">SHOP PRODUCT</a>';
    } elseif ($product && $product->is_in_stock()) {
      return '<a class="buy-now button" href="' .$permalink . '">SHOP PRODUCT</a>';
    }
  }
  return $args; 
}

	/*QUANTITY +/- FUNCTION*/
  $event_listeners =
  '		
  // Make the code work after page load.
  $(document).ready(function(){			
    QtyChng();		
  });

  // Make the code work after executing AJAX.
  $(document).ajaxComplete(function () {
    QtyChng();
  });
  ';
  
  $event_listeners = apply_filters( 'qib_change_event_listeners', $event_listeners);
  
  $quantity_change =
  
  '
  // Find quantity input field corresponding to increment button clicked.
  var qty = $( this ).siblings( ".quantity" ).find( ".qty" );
  // Read value and attributes min, max, step.
  var val = parseFloat(qty.val());
  var max = parseFloat(qty.attr( "max" ));
  var min = parseFloat(qty.attr( "min" ));		
  var step = parseFloat(qty.attr( "step" ));
  
  // Change input field value if result is in min and max range.
  // If the result is above max then change to max and alert user about exceeding max stock.
  // If the field is empty, fill with min for "-" (0 possible) and step for "+".
  if ( $( this ).is( ".plus" ) ) {
    if ( val === max ) return false;				   
    if( isNaN(val) ) {
      qty.val( step );			
    } else if ( val + step > max ) {
      qty.val( max );
    } else {
      qty.val( val + step );
    }	   
  } else {			
    if ( val === min ) return false;
    if( isNaN(val) ) {
      qty.val( min );
    } else if ( val - step < min ) {
      qty.val( min );
    } else {
      qty.val( val - step );
    }
  }
  
  qty.val( Math.round( qty.val() * 100 ) / 100 );
  qty.trigger("change");
  $( "body" ).removeClass( "sf-input-focused" );
  ';
  
  $quantity_change = apply_filters( 'qib_change_quantity_change', $quantity_change);		

  wc_enqueue_js( $event_listeners .		
    
    '
    function QtyChng() {
      $(document).off("click", ".qib-button").on( "click", ".qib-button", function() {'				
        . $quantity_change .					
      '});
    }
    '
  );

add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_true' );
add_filter( 'woocommerce_is_attribute_in_product_name', '__return_true' );

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'custom_empty_cart_message', 10 );

function custom_empty_cart_message() {
    $html  = '<p class="cart-empty">';
    $html .= wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) );
    echo $html . '</p>';
}

function contactform_dequeue_scripts() {


  if( !is_page(array('contact', 'subscribe'))) {
      wp_dequeue_script( 'contact-form-7' );
wp_dequeue_script('google-recaptcha');
      wp_dequeue_style( 'contact-form-7' );
  
  }

}
add_action( 'wp_enqueue_scripts', 'contactform_dequeue_scripts', 99 );

/*IF COLLAR WITH NAME TAG IS ADDED TO CART, TWO ADDITIONAL FIELDS ON CHECKOUT */

// add_action( 'woocommerce_checkout_after_customer_details', 'my_custom_checkout_field2');

// function my_custom_checkout_field( $checkout ) {
//   foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
//     $product = $cart_item['data'];
//     $id = $product->get_id();
//     $products = array(667, 668, 669, 670);  // Product Ids

//     if (in_array($id, $products)) { 
//     echo '<div id="my_custom_checkout_field"><h2>' . __('My Field') . '</h2>';

//     echo woocommerce_form_field( 'my_field_name', array(
//         'type'          => 'text',
//         'class'         => array('my-field-class form-row-wide'),
//         'label'         => __('Fill in this field'),
//         'placeholder'   => __('Enter something'),
//         ), $checkout->get_value( 'my_field_name' ));

//     echo '</div>';
//       }
//     }
// }


add_action( 'woocommerce_checkout_update_order_meta', 'bbloomer_save_new_checkout_field' );
function bbloomer_save_new_checkout_field( $order_id ) { 
    if ( $_POST['phone_name_tag'] ) {
      update_post_meta( $order_id, '_phone_name_tag', esc_attr( $_POST['phone_name_tag'] ) );
    }
   if ( $_POST['dogs_name_tag'] ) { 
      update_post_meta( $order_id, '_dogs_name_tag', esc_attr( $_POST['dogs_name_tag'] ) );
    }
}
  
add_action( 'woocommerce_admin_order_data_after_billing_address', 'bbloomer_show_new_checkout_field_order', 10, 1 );
function bbloomer_show_new_checkout_field_order( $order ) {    
  echo "<p><strong>Dog's name for COLLAR name tag:</strong> " . get_post_meta( $order->get_id(), '_dogs_name_tag', true ) . "</p><br>";
  echo "<p><strong>Contact number:</strong> " . get_post_meta( $order->get_id(), '_phone_name_tag', true ) . "</p><br>";
}
 
add_action( 'woocommerce_email_after_order_table', 'bbloomer_show_new_checkout_field_emails', 20, 4 );
function bbloomer_show_new_checkout_field_emails( $order, $sent_to_admin, $plain_text, $email ) {
    if ( get_post_meta( $order->get_id(), '_phone_name_tag', true ) ) {
      echo '<p><strong>Contact number for Name tag:</strong> ' . get_post_meta( $order->get_id(), '_phone_name_tag', true ) . '</p>';
    }
    if ( get_post_meta( $order->get_id(), '_dogs_name_tag', true ) ) {
      echo '<p><strong>Dog\'s name for Name tag:</strong> ' . get_post_meta( $order->get_id(), '_dogs_name_tag', true ) . '</p>';
    } 
}

add_action( 'woocommerce_single_product_summary', 'shoptimizer_custom_author_field', 8);
  
function shoptimizer_custom_author_field() { ?>
 
<?php if(get_field('short_description')) { ?>
	<div class="info-description"><?php the_field('short_description'); ?></div>
<?php }
}

function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );


/** GET FREE SHIPPING OVER 300 - CART NOTE */

function cart_notice() {
  $free_shipping_settings = get_option( 'woocommerce_free_shipping_settings' );
  $maximum = 300;
  $current = WC()->cart->subtotal;
  $remainder = $maximum - $current;
  if ( $current < $maximum ) {
    echo "<div class='shipping-amount'>You're €" .  number_format((float)$remainder, 2, ',', '') . " away from free shipping.</div>";
  }
}
 
add_action( 'xoo_wsc_totals_end', 'cart_notice' );
 