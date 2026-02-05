<?php
   /**
    * Template Name: About Us Template
    */
   
   // Exit if accessed directly.
   defined( 'ABSPATH' ) || exit;
   get_header();
   ?>
<main>
    <!-- Banner -->
    <?php get_template_part( 'banners/about-banner' ); ?>
    <!-- End Banner -->
    <div class="container-fluid py-lg-5 page-bg page-template-about-bg overflow-hidden">
        <div class="container px-lg-3 px-0 py-4 max_xl_w_1280 position-relative">
            <div class="row py-lg-2 py-3">
                <?php if (get_field('top_content')) : ?>
                <div class="col-md-8">
                    <?php the_field('top_content'); ?>
                <?php endif; ?>
                </div>
                <?php if (get_field('top_image')) : ?>
                <div class="col-md-4">
                    <img src="<?php echo get_field('top_image'); ?>" alt="University Overview">
                <?php endif; ?>
                </div>
                    
                <?php if (get_field('bottom_image')) : ?>
                <div class="col-md-4">
                   <img src="<?php echo get_field('bottom_image'); ?>" alt="About University">
                <?php endif; ?>
                </div>
                <?php if (get_field('bottom_content')) : ?>
                <div class="col-md-8">
                    <?php the_field('bottom_content'); ?>
                <?php endif; ?>
                </div>

                 <?php if (get_field('objectives_title')) : ?>
                <h3><?php the_field('objectives_title'); ?></h3>
            <?php endif; 
            if ( have_posts() ) : 
                     while ( have_posts() ) : the_post();
                        the_content();
                     endwhile;
                  endif;?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>