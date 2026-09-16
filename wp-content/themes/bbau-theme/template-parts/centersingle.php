<?php
/*
Template Name: CIIE Page
*/
defined('ABSPATH') || exit;

get_header();
?>

<!-- ================= FULL WIDTH BANNER ================= -->
<div class="ciie-banner">
    <?php get_template_part('banners/about-banner'); ?>
</div>

<!-- ================= PAGE START ================= -->
<div class="ciie-page">
    <div class="page-body">
        <div class="container">
            <?php get_template_part('template-parts/breadcrumb'); ?>

            <div class="menu-wrapper">
                <?php get_template_part('menu/menu'); ?>
            </div>

            <div class="top-section">

                <!-- ================= LEFT: CARDS ================= -->
                <div class="cards-column">

                    <?php if (have_rows('members')): ?>
                    <?php while (have_rows('members')): the_row(); ?>

                    <div class="profile-card">

                        <div class="profile-photo">
                            <img src="<?php echo esc_url(get_sub_field('image')['url']); ?>" alt="<?php echo esc_attr(get_sub_field('name')); ?>">
                        </div>

                        <div class="profile-content">

                            <h3 class="profile-name">
                                <?php echo esc_html(get_sub_field('name')); ?>
                            </h3>

                            <h6 class="profile-designation">
                                <?php echo esc_html(get_sub_field('designation')); ?>
                            </h6>

                            <div class="profile-contacts">

                                <!-- PHONE -->
                                <div class="contact-item">
                                    <div class="contact-value">
                                        <div class="contact-icon">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <a href="tel:<?php echo esc_attr(get_sub_field('phone')); ?>">
                                            <?php echo esc_html(get_sub_field('phone')); ?>
                                        </a>
                                    </div>
                                </div>

                                <!-- EMAIL -->
                                <div class="contact-item">
                                    <div class="contact-value">
                                        <div class="contact-icon">
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>
                                        <a href="mailto:<?php echo esc_attr(get_sub_field('email')); ?>">
                                            <?php echo esc_html(get_sub_field('email')); ?>
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <?php endwhile; ?>
                    <?php endif; ?>

                </div>

                <!-- ================= RIGHT ================= -->
                <div class="side-text">
                    <h2 class="section-title">About</h2>
                    <?php echo get_field('about'); ?>
                </div>

            </div>

            <!-- ================= BOTTOM CONTENT ================= -->
            <div class="full-width-section">
                <?php echo get_field('bottom_content'); ?>
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

.ciie-page {
    background: #fdf9f4;
    font-family: 'Source Serif 4', serif;
}

.page-body {
    padding: 40px 0;
}

.ciie-page .container {
    max-width: 1200px;
    margin: auto;
    padding: 0 20px;
}

.menu-wrapper {
    margin-bottom: 25px;
}

/* ================= TOP SECTION ================= */

.top-section {
    width: 100%;
    overflow: hidden;
}

.cards-column {
    float: left;
    width: 420px;
    margin-right: 40px;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.side-text {
    overflow: hidden;
}

/* ================= CONTENT STYLE ================= */

.side-text,
.full-width-section {
    font-size: 15px;
    line-height: 1.8;
    color: #444;
}

.side-text h1,
.side-text h2,
.side-text h3,
.side-text h4,
.side-text h5,
.side-text h6,
.side-text p,
.side-text ul,
.side-text ol,
.side-text div,
.side-text table,
.side-text figure,
.full-width-section h1,
.full-width-section h2,
.full-width-section h3,
.full-width-section h4,
.full-width-section h5,
.full-width-section h6,
.full-width-section p,
.full-width-section ul,
.full-width-section ol,
.full-width-section div,
.full-width-section table,
.full-width-section figure {
    line-height: 1.8;
    font-size: 15px;
    color: #444;
    margin-bottom: 14px;
    word-break: break-word;
}

.side-text h2,
.full-width-section h2 {
    font-size: 26px;
    font-weight: 700;
    color: #1a2e5a;
    padding-bottom: 8px;
    display: inline-block;
    margin-bottom: 16px;
    line-height: 1.3;
}

.side-text h3,
.side-text h4,
.full-width-section h3,
.full-width-section h4 {
    color: #1a2e5a;
    font-weight: 700;
    margin-bottom: 10px;
    margin-top: 20px;
}

.side-text ul,
.side-text ol,
.full-width-section ul,
.full-width-section ol {
    padding-left: 20px;
}

.side-text ul li,
.side-text ol li,
.full-width-section ul li,
.full-width-section ol li {
    margin-bottom: 6px;
}

.side-text a,
.full-width-section a {
    color: #1a7abf;
    text-decoration: none;
}

.side-text a:hover,
.full-width-section a:hover {
    text-decoration: underline;
}

/* ================= SECTION TITLE ================= */

.section-title {
    font-size: 26px;
    font-weight: 700;
    color: #1a2e5a;
    margin-bottom: 18px;
}

/* ================= CARD ================= */

.profile-card {
    display: flex;
    gap: 15px;
    background: #fff;
    padding: 20px;
    border-radius: 14px;
    border-left: 5px solid #8B0000;
    box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
    transition: transform .3s;
    width: 100%;
}

.profile-card:hover {
    transform: translateY(-4px);
}

/* ================= IMAGE ================= */

.profile-photo {
    flex-shrink: 0;
}

.profile-photo img {
    width: 140px;
    height: 160px;
    border-radius: 10px;
    object-fit: cover;
    display: block;
}

/* ================= PROFILE CONTENT ================= */

.profile-content {
    padding-top: 5px;
    flex: 1;
    min-width: 0;
}

.profile-name {
    font-size: 20px;
    font-weight: 700;
    color: #8B0000;
    margin-bottom: 6px;
    line-height: 1.3;
}

.profile-designation {
    font-size: 14px;
    font-weight: 600;
    color: #c8a84b;
    margin-bottom: 10px;
}

/* ================= CONTACTS ================= */

.profile-contacts {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.contact-item {
    display: flex;
    align-items: center;
}

.contact-value {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    line-height: 1.6;
    color: #333;
    word-break: break-word;
}

/* ICON */

.contact-icon {
    width: 26px;
    height: 26px;
    background: #f5f0e8;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 11px;
    color: #8B0000;
    flex-shrink: 0;
}

/* LINK */

.contact-value a {
    color: #333;
    text-decoration: none;
    word-break: break-word;
    transition: .3s;
}

.contact-value a:hover {
    color: #8B0000;
    text-decoration: underline;
}

/* ================= 1200px ================= */

@media (max-width: 1200px) {

    .cards-column {
        width: 340px;
        margin-right: 30px;
    }

    .profile-photo img {
        width: 120px;
        height: 140px;
    }

    .profile-name {
        font-size: 17px;
    }

    .contact-value {
        font-size: 13px;
    }

}

/* ================= TABLET ≤992px ================= */

@media (max-width: 992px) {

    .cards-column {
        width: 260px;
        margin-right: 24px;
    }

    .profile-card {
        flex-direction: column;
        align-items: flex-start;
        padding: 16px;
        gap: 12px;
    }

    .profile-photo img {
        width: 100%;
        height: 160px;
        border-radius: 8px;
    }

    .profile-name {
        font-size: 15px;
    }

    .profile-designation {
        font-size: 12px;
    }

    .contact-value {
        font-size: 12px;
    }

}
/* ================= MOBILE ≤768px — float OFF ================= */

@media (max-width: 768px) {

    .page-body {
        padding: 24px 0 36px;
    }

    .ciie-page .container {
        padding: 0 14px;
    }

    .cards-column {
        float: none;
        width: 100%;
        margin-right: 0;
        margin-bottom: 24px;
    }

    /* CARD — vertical stack */
    .profile-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 16px 14px;
        gap: 12px;
    }

    /* IMAGE — full width but capped */
    .profile-photo img {
        width: 100%;
        max-width: 160px;
        height: 180px;
        border-radius: 10px;
        object-fit: cover;
        margin: 0 auto;
        display: block;
    }

    /* CONTENT — centered */
    .profile-content {
        width: 100%;
        padding-top: 0;
    }

    .profile-name {
        font-size: 16px;
        text-align: center;
    }

    .profile-designation {
        font-size: 13px;
        text-align: center;
    }

    /* CONTACTS — centered */
    .profile-contacts {
        align-items: center;
        gap: 8px;
    }

    .contact-item {
        justify-content: center;
    }

    .contact-value {
        font-size: 13px;
        justify-content: center;
        flex-wrap: wrap;
        text-align: center;
    }

}

/* ================= SMALL MOBILE ≤480px ================= */

@media (max-width: 480px) {

    .ciie-page .container {
        padding: 0 10px;
    }

    .profile-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 14px 12px;
    }

    .profile-photo img {
        width: 100%;
        max-width: 180px;
        height: auto;
        max-height: 200px;
        margin: 0 auto;
    }

    .contact-item {
        justify-content: center;
    }

    .contact-value {
        justify-content: center;
        font-size: 12px;
        flex-wrap: wrap;
    }

    .contact-icon {
        width: 22px;
        height: 22px;
        font-size: 10px;
    }

}

/* ================= VERY SMALL ≤360px ================= */

@media (max-width: 360px) {

    .ciie-page .container {
        padding: 0 8px;
    }

    .profile-name {
        font-size: 14px;
    }

    .contact-value {
        font-size: 11px;
    }

    .contact-icon {
        width: 20px;
        height: 20px;
        font-size: 9px;
    }

}

</style>

<?php get_footer(); ?>