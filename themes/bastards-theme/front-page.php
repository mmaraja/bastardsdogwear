<?php get_header();?>
<div class="hero-section vh-100">
    <div class="container-fluid px-0 mt-6 d-flex h-100">
        <div class="hero-div-arrow col-3 col-md-4 col-xl-3">
            <div class="hero-arrow-container">
                <div class="arrow-hero">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/arrow-hero.png" height="28" width="30" alt="ScrollDown">
                </div>
            </div>
        </div>
        <div class="hero-div-pic col-9 col-md-8 col-xl-9 ps-6 ps-3 ps-sm-0 d-flex justify-content-center">
            <div class="hero-text-container position-absolute">
                <p class="hero-text">Act like a dog ... Wear it like a dog.</p>
            </div>
            <video disableRemotePlayback  autoplay="" loop="" muted="" playsinline="" data-wf-ignore="true" >
            <source src="<?php echo get_template_directory_uri(); ?>/assets/bastards fri_hero video_small.mp4" type="video/webm">
            </video>
          
        </div>
    </div>
</div>
    <?php the_content(); ?>

<?php get_footer(); ?>