<footer class="d-flex justify-content-center flex-column">
<div class="container-md p-0">
<div class="d-flex contact_footer">
  <div class="col-11 col-md-4">
  <?php echo do_shortcode('[mailerlite_form form_id=1]'); ?>
  </div>
</div>
</div>
<div class="menu-section">
 <div class="container-md p-0">
    <div class="m-0 pt-5 row d-flex flex-row justify-content-start">
      <div class="ps-lg-0 col-sm-3 col-md-3 col-lg-3  mb-4 mb-md-0 text-left">
        <h5 class="p-foo-title text-uppercase"><?php _e('Products:', 'bastards-theme') ?></h5>
        <?php wp_nav_menu(
          array(
              'theme_location' => 'products-footer',
            )
          );
        ?>   
        
      </div>
      <div class="col-sm-3 col-md-3 col-lg-3 mb-4 mb-md-0 text-left">
        <h5 class="p-foo-title text-uppercase"><?php _e('About:', 'bastards-theme') ?></h5>
        <?php wp_nav_menu(
          array(
              'theme_location' => 'about-footer',
            )
          );
        ?>   
      </div>
      <div class="col-sm-3 col-md-3 col-lg-3 mb-4 mb-md-0 text-left">
        <h5 class="p-foo-title text-uppercase"><?php _e('Need help:', 'bastards-theme') ?></h5>
        <?php wp_nav_menu(
          array(
              'theme_location' => 'need-help-footer',
            )
          );
        ?>   
      </div>
      <div class="col-sm-3 col-md-3 col-lg-3 mb-4 mb-md-0 text-left">
        <h5 class="p-foo-title text-uppercase"><?php _e('Follow us:', 'bastards-theme') ?></h5>
        <?php wp_nav_menu(
          array(
              'theme_location' => 'follow-us',
            )
          );
        ?>   
      </div>
    </div>
  </div>
</div>
<div class="copyright-section container">
    <div class="stripe-footer">
      <img width="180" src="<?php echo get_template_directory_uri(); ?>/assets/logo-stripe.png" alt="">
    </div>
    <p class="p-copyright text-end pe-4 ">
        © BASTARDS, <span id="year"></span>
    </p>
</div>
</footer>

<?php wp_footer(); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
(function($) {

var Defaults = $.fn.select2.amd.require('select2/defaults');

$.extend(Defaults.defaults, {
  dropdownPosition: 'auto'
});

var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');

var _positionDropdown = AttachBody.prototype._positionDropdown;

AttachBody.prototype._positionDropdown = function() {

  var $window = $(window);

  var isCurrentlyAbove = this.$dropdown.hasClass('select2-dropdown--above');
  var isCurrentlyBelow = this.$dropdown.hasClass('select2-dropdown--below');

  var newDirection = null;

  var offset = this.$container.offset();

  offset.bottom = offset.top + this.$container.outerHeight(false);

  var container = {
      height: this.$container.outerHeight(false)
  };

  container.top = offset.top;
  container.bottom = offset.top + container.height;

  var dropdown = {
    height: this.$dropdown.outerHeight(false)
  };

  var viewport = {
    top: $window.scrollTop(),
    bottom: $window.scrollTop() + $window.height()
  };

  var enoughRoomAbove = viewport.top < (offset.top - dropdown.height);
  var enoughRoomBelow = viewport.bottom > (offset.bottom + dropdown.height);

  var css = {
    left: offset.left,
    top: container.bottom
  };

  // Determine what the parent element is to use for calciulating the offset
  var $offsetParent = this.$dropdownParent;

  // For statically positoned elements, we need to get the element
  // that is determining the offset
  if ($offsetParent.css('position') === 'static') {
    $offsetParent = $offsetParent.offsetParent();
  }

  var parentOffset = $offsetParent.offset();

  css.top -= parentOffset.top
  css.left -= parentOffset.left;

  var dropdownPositionOption = this.options.get('dropdownPosition');

  if (dropdownPositionOption === 'above' || dropdownPositionOption === 'below') {
    newDirection = dropdownPositionOption;
  } else {

    if (!isCurrentlyAbove && !isCurrentlyBelow) {
      newDirection = 'below';
    }

    if (!enoughRoomBelow && enoughRoomAbove && !isCurrentlyAbove) {
      newDirection = 'above';
    } else if (!enoughRoomAbove && enoughRoomBelow && isCurrentlyAbove) {
      newDirection = 'below';
    }

  }

  if (newDirection == 'above' ||
  (isCurrentlyAbove && newDirection !== 'below')) {
      css.top = container.top - parentOffset.top - dropdown.height;
  }

  if (newDirection != null) {
    this.$dropdown
      .removeClass('select2-dropdown--below select2-dropdown--above')
      .addClass('select2-dropdown--' + newDirection);
    this.$container
      .removeClass('select2-container--below select2-container--above')
      .addClass('select2-container--' + newDirection);
  }

  this.$dropdownContainer.css(css);

};

})(window.jQuery);


</script>
<?php if(is_product()) {?>
<script type='text/javascript'>
    var term_color = $('#select2-pa_colour-container').val();
    <?php
    global $product;
   
    $variations = $product->get_available_variations();
    $variations_id = wp_list_pluck( $variations, 'variation_id' );
    $name = $product->get_name();
    $price = $product->get_price();
    $term_size = $product->get_attribute( 'pa_size-shop' );
    $term_color = $product->get_attribute( 'pa_colour' );
    ?>
    window.dataLayer = window.dataLayer || [];
      dataLayer.push({
          'name' : '<?php echo $name ?>',
          'id' : '<?php echo $variations_id ?>',
          'price' : '<?php echo $price , "€"?>',
          'brand' : '',
          'category' : '<?php echo strip_tags($product->get_categories(', ', '', '')); ?>',
          'variant' : '<?php echo $name , " " , $term_color , " " , $term_size?>',
          'coupon' : ''          
      });
    
</script>
<?php  } ?>
</body>
</html>