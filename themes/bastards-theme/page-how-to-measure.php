<?php get_header(); ?>
<div class="container-fluid p-0 d-flex flex-column">
    <div class="measure-row">
        <div class="col">

        </div>
        <div class="col">
        <div class="measure-text">
            <h1 class="measure-hero-header text-uppercase">how to measure</h1>
        </div>
        </div>
    </div>
    <div class="measure-pic d-flex">
        <div class="measure-div-pic col-12 col-sm-6">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/dog-measurments.png" alt="Dog measurments">
        </div>
        <div class="measure-div-text col-12 col-sm-6">
            <?php dynamic_sidebar( 'measurment' ); ?>
        </div>
    </div>
</div>

<div class="container-lg">
    <div class="row">
        <?php the_content(); ?>
    </div>
</div>
<?php  get_footer(); ?>