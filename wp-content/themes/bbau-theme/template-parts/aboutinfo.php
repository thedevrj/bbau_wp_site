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
   ROOT VARIABLES
===================================== */

:root {
    --primary: #1a3a6b;
    --primary-dark: #0f2347;
    --accent: #8b1a1a;
    --border: #d8e0f2;
    --text: #444;
    --bg-soft: #f5f7fc;
}


/* =====================================
   ASSISTANT DIRECTORS SECTION
===================================== */

.dept-assistant-section {
    margin-bottom: 60px;
}


/* GRID - 2 CARDS PER ROW */
.dept-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}


/* CARD */
.assistant-card {

    display: flex;
    align-items: center;

    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 13px;

    overflow: hidden;

    transition: all 0.3s ease;

    min-height: 220px;
}

.assistant-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}


/* =====================================
   LEFT IMAGE 50%
===================================== */

.assistant-card .left {

    flex: 0 0 50%;
    max-width: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: var(--bg-soft);

    padding: 25px;
}


/* CIRCULAR IMAGE */
.assistant-card .left img {

    width: 210px;
    height: 210px;

    border-radius: 50%;

    object-fit: cover;

    border: 5px solid #ffffff;

    box-shadow: 0 6px 20px rgba(0,0,0,0.12);

    transition: 0.3s;
}

.assistant-card:hover .left img {
    transform: scale(1.05);
}


/* =====================================
   RIGHT CONTENT 50%
===================================== */

.assistant-card .right {

    flex: 0 0 50%;
    max-width: 50%;

    padding: 25px;
}


/* NAME */
.assistant-card .right h4 {

    font-size: 19px;
    font-weight: 700;

    color: var(--primary-dark);

    margin-bottom: 6px;
}


/* DESIGNATION */
.assistant-card .right p:first-of-type {

    font-size: 13px;
    font-weight: 600;

    color: var(--accent);

    text-transform: uppercase;

    margin-bottom: 10px;
}


/* CONTACT TEXT */
.assistant-card .right p {

    font-size: 14px;

    color: var(--text);

    margin-bottom: 6px;

    line-height: 1.5;
}


/* LINKS */
.link-new {

    color: var(--primary);

    text-decoration: none;

    font-weight: 500;
}

.link-new:hover {

    color: var(--accent);

    text-decoration: underline;
}



/* =====================================
   ABOUT DEPARTMENT SECTION
===================================== */

.dept-about-section {

    background: linear-gradient(180deg,#f5f7fc,#eef2fb);

    padding: 40px;

    border-radius: 12px;

    border-left: 5px solid var(--primary);

    box-shadow: 0 5px 20px rgba(0,0,0,0.05);

    margin-top: 40px;
}


/* ABOUT TITLE */
.section-title {

    font-size: 26px;

    font-weight: 700;

    color: var(--primary-dark);

    margin-bottom: 15px;
}


/* ABOUT TEXT */
.dept-about-section p {

    font-size: 15px;

    line-height: 1.8;

    color: var(--text);

    max-width: 900px;
}



/* =====================================
   RESPONSIVE DESIGN
===================================== */

@media (max-width: 992px) {

    .dept-grid {
        grid-template-columns: 1fr;
    }

    .assistant-card {

        flex-direction: column;

        text-align: center;
    }

    .assistant-card .left,
    .assistant-card .right {

        flex: 100%;
        max-width: 100%;
    }

    .assistant-card .right {
        padding-top: 10px;
    }
}


@media (max-width: 576px) {

    .assistant-card .left img {

        width: 120px;
        height: 120px;
    }

    .section-title {

        font-size: 22px;
    }

}
</style>