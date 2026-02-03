<?php
   /**
    * Template Name: Default Fullwidth Template
    */
   
   // Exit if accessed directly.
   defined( 'ABSPATH' ) || exit;
   get_header();
   ?>
<main>
    <!-- Banner -->
    <?php get_template_part( 'banners/about-banner' ); ?>
    <!-- End Banner -->
    <div class="container-fluid py-lg-5 page-bg page-template-about-bg min_xl_h_1172 min_sm_h_1469 overflow-hidden">
        <div class="container px-lg-3 px-0 py-4 max_xl_w_1280 position-relative">
            <div class="row py-lg-2 py-3">
                <div class="col-lg-12">
                    <h3><?php the_title()?></h3>
                    <?php 
                  if ( have_posts() ) : 
                     while ( have_posts() ) : the_post();
                        the_content();
                     endwhile;
                  endif;
                  ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>