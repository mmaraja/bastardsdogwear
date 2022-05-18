<?php get_header(); ?>

<div class="post-class">
    <div class="post-container">
        <div class="img-post">
            <?php if ( has_post_thumbnail() ) : the_post_thumbnail();
            endif; ?>
        </div>
        <div class="post-header">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/arrow-hero.png" width="40" alt="ScrollDown">
            <h1 class="post-title"><?php the_title(); ?></h1>
        </div>
    </div>
</div>
<?php the_content(); ?>

<?php  get_footer(); ?>