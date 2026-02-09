<?php
/**
 * Template Name: About Us Template
 */

defined('ABSPATH') || exit;
get_header();
?>

<main>

    <!-- Banner -->
    <?php get_template_part('banners/about-banner'); ?>
    <!-- End Banner -->

    <div class="container-fluid py-lg-5 page-bg page-template-about-bg">
        <?php get_template_part('template-parts/breadcrum'); ?>

        <div class="container px-lg-3 px-0 py-4 max_xl_w_1280">

            <!-- ================= ABOUT SECTION ================= -->
            <div class="about-section">

                <!-- ===== VISION (IMAGE RIGHT) ===== -->
                <?php if (get_field('top_image')) : ?>
                    <img
                        class="about-img right"
                        src="<?php echo esc_url(get_field('top_image')); ?>"
                        alt="University Overview">
                <?php endif; ?>

                <?php if (get_field('top_content')) : ?>
                    <div class="about-content">
                        <?php the_field('top_content'); ?>
                    </div>
                <?php endif; ?>

                <div class="clearfix"></div>

                <!-- ===== MISSION (IMAGE LEFT) ===== -->
                <?php if (get_field('bottom_image')) : ?>
                    <img
                        class="about-img left"
                        src="<?php echo esc_url(get_field('bottom_image')); ?>"
                        alt="About University">
                <?php endif; ?>

                <?php if (get_field('bottom_content')) : ?>
                    <div class="about-content">
                        <?php the_field('bottom_content'); ?>
                    </div>
                <?php endif; ?>

                <div class="clearfix"></div>

                <!-- ===== OBJECTIVES / PAGE CONTENT ===== -->
                <?php if (get_field('objectives_title')) : ?>
                    <h3><?php the_field('objectives_title'); ?></h3>
                <?php endif; ?>

                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>

            </div>
            <!-- ================= END ABOUT SECTION ================= -->

        </div>
    </div>

</main>

<?php get_footer(); ?>
