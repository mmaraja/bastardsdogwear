<?php get_header();?>
<div class="hero-section vh-100">
    <div class="container-fluid p-0 d-flex h-100">
        <div class="hero-div-arrow col-4 col-md-4 col-xl-3">
            <div class="hero-arrow-container">
                <div class="arrow-hero">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/arrow-hero.png" height="28" width="30" alt="ScrollDown">
                </div>
            </div>
        </div>
        <div class="hero-div-pic col-8 col-md-8 col-xl-9">
            <div class="hero-text-container position-absolute">
                <p class="hero-text">Act like a dog ... Wear it like a dog.</p>
            </div>
            <video autoplay="" loop="" muted="" playsinline="" data-wf-ignore="true" >
            <source src="<?php echo get_template_directory_uri(); ?>/assets/bastards fri_hero video.mp4" type="video/webm">
            </video>
          
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php the_content(); ?>
    </div>
</div>
<?php get_footer(); ?>