<?php 
/**
* Template Name: Blog
*/
get_header(); ?>
<div class="hero-section about about-blog">
    <div class="container-lg h-100">
        <div class="row h-100">
            <div class="col-2 col-md-1 col-lg-1 hero-div-arrow">
                <div class="hero-arrow-container blog-arrow">
                    <div class="arrow-hero">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/arrow-hero.png" width="40" alt="ScrollDown">
                    </div>
                </div>
            </div>
            <div class="col-10 col-md-8 col-lg-8 blog-text ps-0">
                <h1 class="about-hero-header blog">BASTARDS blog</h1>
            </div>
        </div>
    </div>
</div>
<div class="blog-wrapper">
<div class="container-lg">
    <div class="row">
            <?php  $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'category_name' => 'blog',
                'posts_per_page' => 5,
            );
            $arr_posts = new WP_Query( $args );
            
            if ( $arr_posts->have_posts() ) :
            
                while ( $arr_posts->have_posts() ) :
                    $arr_posts->the_post(); ?>
                <article class="col-sm-4" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php
                    if ( has_post_thumbnail() ) : the_post_thumbnail();
                    endif; ?>
                    <header class="entry-header">
                        <a href="<?php the_permalink(); ?>"><h2 class="entry-title"><?php the_title(); ?></h2></a>
                    </header>
                </article>
            <?php
            endwhile;
            endif; ?>
        </div>
    </div>
</div>
<?php  get_footer(); ?>