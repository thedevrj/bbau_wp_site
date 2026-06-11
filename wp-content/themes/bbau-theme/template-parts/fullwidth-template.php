<?php
/**
 * Template Name: Fullwidth Template
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="fullwidth-template">

    <!-- Banner -->
    <?php get_template_part( 'banners/about-banner' ); ?>
    <!-- End Banner -->

    <div class="container-fluid py-lg-5 page-bg page-template-about-bg">

        <?php get_template_part('template-parts/breadcrumb'); ?>


        <div class="container px-lg-3 px-0 max_xl_w_1280 position-relative">
            <div class="menu-wrapper">
                <?php get_template_part('menu/menu'); ?>
            </div>
            <div class="row py-lg-2 py-3">
                <div class="col-lg-12">
                    <!-- Page Content -->
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