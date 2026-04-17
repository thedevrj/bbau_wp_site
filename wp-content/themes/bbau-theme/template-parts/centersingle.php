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

    <div class="menu-wrapper">
        <?php get_template_part('menu/menu'); ?>
    </div>

    <div class="page-body">
        <div class="container">
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
                            <img src="<?php echo get_sub_field('image')['url']; ?>" alt="">
                        </div>

                        <div class="profile-content">

                            <h3 class="profile-name">
                                <?php echo get_sub_field('name'); ?>
                            </h3>

                            <h6 class="profile-designation">
                                <?php echo get_sub_field('designation'); ?>
                            </h6>

                            <div class="profile-contacts">

                                <!-- PHONE -->
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div>
                                        <span class="contact-label">Phone:</span>
                                        <span class="contact-value">
                                            <a href="tel:<?php echo get_sub_field('phone'); ?>">
                                                <?php echo get_sub_field('phone'); ?>
                                            </a>
                                        </span>
                                    </div>
                                </div>

                                <!-- EMAIL -->
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div>
                                        <span class="contact-label">Email:</span>
                                        <span class="contact-value">
                                            <a href="mailto:<?php echo get_sub_field('email'); ?>">
                                                <?php echo get_sub_field('email'); ?>
                                            </a>
                                        </span>
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
                    <h3 class="section-title">About</h3>
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

.ciie-page {
    background: #fdf9f4;
    font-family: 'Source Serif 4', serif;
}

.container {
    max-width: 1200px;
    margin: auto;
    padding: 0 20px;
}

.page-body {
    padding: 40px 0;
}

.top-section {
    display: flex;
    gap: 40px;
    align-items: flex-start;
}

.cards-column {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.side-text {
    flex: 1;
    padding-top: 10px;
}

.section-title {
    color: #8B0000;
    margin-bottom: 15px;
    font-size: 22px;
}

.profile-card {
    display: flex;
    gap: 15px;
    background: #ffffff;
    padding: 20px;
    border-radius: 14px;
    border-left: 5px solid #8B0000;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    transition: 0.3s;
}

.profile-card:hover {
    transform: translateY(-4px);
}

.profile-photo img {
    width: 170px;
    height: 180px;
    border-radius: 10px;
    object-fit: cover;
}

.profile-content {
    padding-top: 5px;
}

.profile-name {
    font-size: 22px;
    color: #8B0000;
    font-weight: 700;
    margin-bottom: 6px;
}

.profile-designation {
    color: #c8a84b;
    margin-bottom: 10px;
    font-size: 15px;
}

.profile-contacts {
    margin-top: 10px;
}

.contact-item {
    display: flex;
    gap: 8px;
    margin-top: 8px;
    align-items: center;
}

.contact-icon {
    width: 26px;
    height: 26px;
    background: #f5f0e8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.contact-label {
    font-weight: 600;
    margin-right: 4px;
}

.contact-value a {
    color: #333;
    text-decoration: none;
}

.contact-value a:hover {
    text-decoration: underline;
}

.full-width-section {
    margin-top: 30px;
    padding-top: 10px;
    line-height: 1.7;
}

/* ===== Laptop ===== */
@media (max-width: 1200px) {
    .container {
        padding: 0 15px;
    }
}

/* ===== Tablet ===== */
@media (max-width: 992px) {

    .top-section {
        flex-direction: column;
    }

    .cards-column,
    .side-text {
        width: 100%;
    }
}

/* ===== Mobile ===== */
@media (max-width: 768px) {

    .profile-card {
        flex-direction: column;
        text-align: center;
    }

    .profile-photo img {
        width: 100%;
        height: auto;
    }

    .profile-name {
        font-size: 20px;
    }
}

/* ===== Small Mobile ===== */
@media (max-width: 480px) {

    .container {
        padding: 0 10px;
    }

    .profile-card {
        padding: 15px;
    }

    .profile-name {
        font-size: 18px;
    }

    .profile-designation {
        font-size: 14px;
    }
}
</style>

<?php get_footer(); ?>