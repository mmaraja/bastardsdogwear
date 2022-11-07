<!DOCTYPE html>
<html>
<head>
    <title><?php bloginfo('name'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    
    <!-- Google Tag Manager -->
    
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-58G77J4');</script>
    <!-- End Google Tag Manager -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    
    <?php wp_head(); ?>
   <!-- Meta Pixel Code -->
   <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1052504555290621');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1052504555290621&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
</head>

<body <?php body_class(); ?> >
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-58G77J4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<header class="d-flex flex-wrap align-items-center border-bottom border-dark position-fixed bg-white justify-content-between justify-content-lg-start w-100 top-0">
    <div class="col-4 col-sm-4 col-md-4 col-xl-3">
        <div class="logo-wrapper">
        <a href="<?php echo esc_url( home_url( '/' )); ?>" class="navbar-brand ms-2 ms-md-4 ms-lg-5">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="BastardsDogWearLogo">
        </a>
        </div>
    </div>
    <div class="ps-6 col-lg-5 col-xl-6 screen-menu">
        <?php wp_nav_menu(
            array(
                'theme_location' => 'primary-menu',
                'menu_class' => 'primary-menu'
            )
        );?>
    </div>


    <div class="col-7 col-md-7 col-lg-3 pe-2 pe-md-4 pe-lg-5 text-end">
        <div class="me-4 me-lg-0">
          
        </div>
        <button  class="menuToggle" id="navigation-toggle" aria-label="Toggle navigation" ></button>
        <nav class="navbar"> 
        <div id="navbarNav">
            <?php wp_nav_menu(
                array(
                    'theme_location' => 'primary-menu',
                    'menu_class' => 'nav-menu'
                )
            );?>
        </div>
        
    </nav>
    </div>
   
   
</header>
