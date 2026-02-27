<?php 
/*
Template Name: Department Page
*/
defined( 'ABSPATH' ) || exit;
get_header();
$page_Id = get_the_ID();
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg py-lg-5">
    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>


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

<style>
/* =====================================
   Department Page Styling
===================================== */

:root {
    --primary: #1a3a6b;
    --primary-dark: #0f2347;
    --accent: #8b1a1a;
    --border: #d8e0f2;
    --text: #444;
    --bg-soft: #f5f7fc;
}

/* =========================
   Assistant Directors Section
========================= */

.dept-assistant-section {
    margin-bottom: 60px;
}

/* 2 Cards Per Row */
.dept-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

/* Horizontal Card */
.assistant-card {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    background: #ffffff;
    border: 1px solid var(--border);
    padding: 20px;
    border-radius: 6px;
    transition: 0.3s ease;
}

.assistant-card:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
}

/* LEFT IMAGE */
.assistant-card .left {
    flex-shrink: 0;
}

.assistant-card .left img {
    width: 110px;
    height: 130px;
    object-fit: cover;
    border-radius: 4px;
}

/* RIGHT CONTENT */
.assistant-card .right {
    flex: 1;
}

/* Name */
.assistant-card .right h4 {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 5px;
}

/* Designation */
.assistant-card .right p:first-of-type {
    font-size: 13px;
    font-weight: 600;
    color: var(--accent);
    text-transform: uppercase;
    margin-bottom: 10px;
}

/* Contact Info */
.assistant-card .right p {
    font-size: 14px;
    color: var(--text);
    margin-bottom: 5px;
}

/* Links */
.link-new {
    color: var(--primary);
    text-decoration: none;
    font-size: 14px;
}

.link-new:hover {
    color: var(--accent);
}

/* Tenure link spacing */
.assistant-card .right a.link-new {
    display: inline-block;
    margin-top: 8px;
}

/* =========================
   About Department
========================= */

.section-title {
    font-size: 26px;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 20px;
    border-left: 4px solid var(--primary);
    padding-left: 12px;
}

.dept-about-section {
    background: var(--bg-soft);
    padding: 40px;
    border-radius: 6px;
}

.dept-about-section p {
    font-size: 15px;
    line-height: 1.8;
    color: var(--text);
}

/* =========================
   Responsive
========================= */

@media (max-width: 992px) {
    .dept-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .assistant-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .assistant-card .left img {
        width: 120px;
        height: 140px;
    }
}
</style>