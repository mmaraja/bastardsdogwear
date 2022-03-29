<?php 
/**
* Template Name: About
*/
get_header(); ?>
<div class="hero-section about">
    <div class="container-fluid p-0 d-flex h-100 position-relative">
        <div class="about-text col-md-4">
            <h1 class="about-hero-header">read our story</h1>
        </div>
        <div class="about-video col-md-8">
            <div class="hero-div-arrow">
                <div class="hero-arrow-container">
                    <div class="arrow-hero">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/arrow-hero.png" width="50" alt="ScrollDown">
                    </div>
                </div>
            </div>
            <div class="hero-div-pic">
                <video autoplay="" loop="" muted="" playsinline="" data-wf-ignore="true" >
                <source src="<?php echo get_template_directory_uri(); ?>/assets/bastards fri_hero video.mp4" type="video/webm">
                </video>
            
            </div>
        </div>
    </div>
</div>
<div class="container-lg">
    <div class="row">
        <?php the_content(); ?>
    </div>
</div>
<?php  get_footer(); ?>