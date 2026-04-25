<?php 
/*
Template Name: Profile Page
*/
defined( 'ABSPATH' ) || exit;
get_header();
$page_Id = get_the_ID();
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="profile-page">
    <div class="page-body">
        <div class="container">

            <?php get_template_part('template-parts/breadcrumb'); ?>

            <div class="menu-wrapper">
                <?php get_template_part('menu/menu'); ?>
            </div>

            <!-- ================= CONTENT WRAP ================= -->
            <div class="content-wrap">

                <!-- ================= CARD FLOATED INSIDE CONTENT ================= -->
                <div class="cards-column">
                    <?php if( have_rows('Department Profile') ): ?>
                        <?php while( have_rows('Department Profile') ): the_row(); ?>

                        <div class="profile-card">

                            <div class="profile-photo">
                                <img src="<?php echo esc_url(get_sub_field('profile_image')); ?>"
                                     alt="<?php echo esc_attr(get_sub_field('name')); ?>">
                            </div>

                            <div class="profile-content">

                                <h3 class="profile-name">
                                    <?php the_sub_field('name'); ?>
                                </h3>

                                <h6 class="profile-designation">
                                    <?php the_sub_field('designation'); ?>
                                </h6>

                                <div class="profile-contacts">
                                    <div class="contact-item">
                                        <div>
                                            <span class="contact-value">
                                                <?php the_sub_field('contact_details'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>

                <!-- ================= PAGE CONTENT (wraps beside card, then full width) ================= -->
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; ?>
                <?php endif; ?>

                <!-- ================= CLEARFIX ================= -->
                <div class="clearfix"></div>

            </div>

        </div>
    </div>
</div>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* ================= PAGE ================= */
.profile-page {
    background: #fdf9f4;
    font-family: 'Source Serif 4', serif;
}

.profile-page .page-body {
    padding: 40px 0;
}

.profile-page .container {
    max-width: 1200px;
    margin: auto;
    padding: 0 20px;
}

/* ================= CONTENT WRAP ================= */
.profile-page .content-wrap {
    width: 100%;
}

/* ================= CARD FLOATED LEFT ================= */
.profile-page .cards-column {
    float: left;
    width: 420px;
    margin-right: 40px;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* ================= CLEARFIX ================= */
.profile-page .clearfix {
    clear: both;
    display: block;
}

/* ================= CONTENT FLOWS BESIDE + BELOW CARD ================= */
.profile-page .content-wrap > h1,
.profile-page .content-wrap > h2,
.profile-page .content-wrap > h3,
.profile-page .content-wrap > h4,
.profile-page .content-wrap > h5,
.profile-page .content-wrap > h6,
.profile-page .content-wrap > p,
.profile-page .content-wrap > ul,
.profile-page .content-wrap > ol,
.profile-page .content-wrap > div:not(.cards-column):not(.clearfix),
.profile-page .content-wrap > table,
.profile-page .content-wrap > figure {
    /* these elements naturally flow beside the float, then wrap below */
    line-height: 1.8;
    font-size: 15px;
    color: #444;
    margin-bottom: 14px;
    word-break: break-word;
}

.profile-page .content-wrap > h2 {
    font-size: 26px;
    font-weight: 700;
    color: #1a2e5a;
    padding-bottom: 8px;
    display: inline-block;
    margin-bottom: 16px;
    margin-top: 0;
    line-height: 1.3;
}

.profile-page .content-wrap > h3,
.profile-page .content-wrap > h4 {
    color: #1a2e5a;
    font-weight: 700;
    margin-bottom: 10px;
    margin-top: 20px;
}

.profile-page .content-wrap > ul,
.profile-page .content-wrap > ol {
    padding-left: 20px;
}

.profile-page .content-wrap > ul li,
.profile-page .content-wrap > ol li {
    margin-bottom: 6px;
}

.profile-page .content-wrap a {
    color: #1a7abf;
    text-decoration: none;
}


/* ================= PROFILE CARD ================= */
.profile-page .profile-card {
    display: flex;
    gap: 15px;
    background: #ffffff;
    padding: 20px;
    border-radius: 14px;
    border-left: 5px solid #8B0000;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
    width: 100%;
    box-sizing: border-box;
}

.profile-page .profile-card:hover {
    transform: translateY(-4px);
}

/* ================= PHOTO ================= */
.profile-page .profile-photo {
    flex-shrink: 0;
}

.profile-page .profile-photo img {
    width: 140px;
    height: 160px;
    border-radius: 10px;
    object-fit: cover;
    display: block;
}

/* ================= CARD CONTENT ================= */
.profile-page .profile-content {
    padding-top: 5px;
    flex: 1;
    min-width: 0;
}

.profile-page .profile-name {
    font-size: 20px;
    color: #8B0000;
    font-weight: 700;
    margin-bottom: 6px;
    line-height: 1.3;
}

.profile-page .profile-designation {
    color: #c8a84b;
    margin-bottom: 10px;
    font-size: 14px;
    font-weight: 600;
}

/* ================= CONTACTS ================= */
.profile-page .profile-contacts {
    margin-top: 0;
}

.profile-page .contact-item {
    display: flex;
    gap: 8px;
    margin-top: 0;
    align-items: center;
}

.profile-page .contact-icon {
    width: 26px;
    height: 26px;
    background: #f5f0e8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}

.profile-page .contact-icon i {
    font-size: 11px;
    color: #8B0000;
}

.profile-page .contact-label {
    font-weight: 600;
    margin-right: 4px;
    color: #555;
}

.profile-page .contact-value {
    color: #333;
    font-size: 14px;
    line-height: 1.6;
}

.profile-page .contact-value p {
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1.6;
}

.profile-page .contact-value a {
    color: #333;
    text-decoration: none;
}

.profile-page .contact-value a:hover {
    text-decoration: underline;
    color: #8B0000;
}

/* ================= LAPTOP ================= */
@media (max-width: 1200px) {
    .profile-page .container {
        padding: 0 15px;
    }

    .profile-page .cards-column {
        width: 320px;
        margin-right: 30px;
    }
}

/* ================= TABLET ================= */
@media (max-width: 992px) {
    .profile-page .cards-column {
        float: none;
        width: 100%;
        margin-right: 0;
        margin-bottom: 24px;
    }

    .profile-page .profile-photo img {
        width: 130px;
        height: 150px;
    }
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .profile-page .profile-card {
        flex-direction: column;
        text-align: center;
    }

    .profile-page .profile-photo img {
        width: 100%;
        height: auto;
        max-height: 260px;
    }

    .profile-page .profile-name {
        font-size: 18px;
    }

    .profile-page .contact-item {
        justify-content: center;
    }

    .profile-page .content-wrap > h2 {
        font-size: 22px;
    }
}

/* ================= SMALL MOBILE ================= */
@media (max-width: 480px) {
    .profile-page .container {
        padding: 0 10px;
    }

    .profile-page .profile-card {
        padding: 15px;
    }

    .profile-page .profile-name {
        font-size: 16px;
    }

    .profile-page .profile-designation {
        font-size: 13px;
    }

    .profile-page .content-wrap > h2 {
        font-size: 20px;
    }
}

</style>

<?php get_footer(); ?>