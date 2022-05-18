<!DOCTYPE html>
<html>
<head>
    <title><?php bloginfo('name'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <?php wp_head(); ?>
   
</head>

<body <?php body_class(); ?> >
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
