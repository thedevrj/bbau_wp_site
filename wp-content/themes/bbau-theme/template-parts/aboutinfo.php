<?php 
/*
Template Name: Profile Page
*/
defined( 'ABSPATH' ) || exit;
get_header();
$page_Id = get_the_ID();
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg py-lg-5">
    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <?php get_template_part('menu/menu'); ?>


        <!-- =============================
            ASSISTANT DIRECTORS
        ============================== -->

        <section class="dept-assistant-section">

            <div class="dept-grid">
                <?php if(have_rows('Department Profile')): ?>
                <?php while(have_rows('Department Profile')): the_row(); ?>
                <div class="assistant-card">
                    <div class="left">
                        <img src="<?php echo esc_url(get_sub_field('profile_image')); ?>"
                            alt="<?php echo esc_attr(get_sub_field('name')); ?>">
                    </div>
                    <div class="right">
                        <h4><?php the_sub_field('name'); ?></h4>
                        <p><?php the_sub_field('designation'); ?></p>
                        <p> <?php the_sub_field('contact_details'); ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php endif; ?>

            </div>

        </section>


        <!-- =============================
            ABOUT DEPARTMENT
        ============================== -->

        <section class="dept-about-section">

            <?php if ( have_posts() ) : ?>
              <?php while ( have_posts() ) : the_post(); ?>
              <?php the_content(); ?>
              <?php endwhile; ?>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php get_footer(); ?>
