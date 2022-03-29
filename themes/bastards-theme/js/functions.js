 
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
    allowTouchMove: false,
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

// function setSwiperRelated(centered, slides, margin) {
//   var swiperRelated = new Swiper('.swiper-container-related', {
//     direction: 'horizontal',
//     centeredSlides: centered,
//     slidesPerView: slides,
//     spaceBetween: margin,
//     keyboard: {
//       enabled: true,
//       onlyInViewport: true,
//     },
//     loop: false,
//     loopFillGroupWithBlank: true,
//     navigation: {
//       nextEl: '.swiper-related-next',
//       prevEl: '.swiper-related-prev',
//     },
//   });
// }

