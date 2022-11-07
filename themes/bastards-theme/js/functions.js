 
 const hamburger = document.querySelector(".menuToggle");
 const navMenu = document.querySelector(".nav-menu");
 
 hamburger.addEventListener("click", mobileMenu);
 
 function mobileMenu() {
     hamburger.classList.toggle("active");
     navMenu.classList.toggle("active");
 }
 const navLink = document.querySelectorAll(".nav-link");

navLink.forEach(n => n.addEventListener("click", closeMenu));

function closeMenu() {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
}
 /*footer copyright*/
 if($('footer').length > 0 ){
    document.getElementById("year").innerHTML =new Date().getFullYear();
  }
 
function setSwiperGallery() {
  swiperGallery = new Swiper('.swiper-container-gallery', {
    direction: 'horizontal',
    slidesPerView: 'auto',
    allowTouchMove: true,
    spaceBetween: 200,
    initialSlide: 0,
    autoHeight: false,
    loop: true,
    keyboard: {
      enabled: true,
      onlyInViewport: true,
    },
    navigation: {
      nextEl: '.swiper-gal-button-next',
    },
    pagination: {
      el: '.swiper-pagination',
    }
  });
}

/**variation images / description images */
$(document).ready(function() {
  jQuery('.append-description').each(function(){
    var item = jQuery(this);
    var description = item.attr('request-email');
    item.parent().append('<div class="request-mail">'+description+'</div>');
  });

})
$(".menu-item-702 a").click(function() {
  $('html, body').animate({
     scrollTop: $("#accessories").offset().top + 130
  }, 500);
 });

