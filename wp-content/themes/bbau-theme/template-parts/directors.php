<?php
/*
Template Name: Team Members
*/

defined('ABSPATH') || exit;

get_header();
?>

<!-- =========================
BANNER
========================= -->

<?php get_template_part('banners/about-banner'); ?>

<!-- =========================
PAGE START
========================= -->

<div class="container-fluid py-lg-5 page-bg page-template-about-bg">

    <!-- =========================
    BREADCRUMB
    ========================= -->

    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">

        <div class="tm-page-wrap">
            <div class="tm-heading-wrap">
                    <h2 class="tm-main-heading">
                        Directors / Coordinators / In-Charge
                    </h2>

                </div>

            <!-- =========================
            GRID
            ========================= -->

            <div class="tm-grid">
                
                <?php if( have_rows('team_members') ) : ?>

                <?php while( have_rows('team_members') ) : the_row();

                    $name         = get_sub_field('name');
                    $image        = get_sub_field('image');
                    $designation  = get_sub_field('designation');
                    $email        = get_sub_field('email');
                    $phone        = get_sub_field('phone_number');
                    $button_link  = get_sub_field('button_link');

                ?>

                <!-- =========================
                CARD
                ========================= -->

                <div class="tm-card">

                    <!-- CIRCLES -->

                    <div class="tm-circle-1"></div>
                    <div class="tm-circle-2"></div>

                    <!-- IMAGE -->

                    <div class="tm-image-wrap">

                        <?php if($image): ?>

                        <img src="<?php echo esc_url(is_array($image) ? $image['url'] : $image); ?>"
                            alt="<?php echo esc_attr($name); ?>" class="tm-image">

                        <?php else: ?>

                        <div class="tm-avatar">

                            <?php echo esc_html(strtoupper(substr($name,0,1))); ?>

                        </div>

                        <?php endif; ?>

                    </div>

                    <!-- CONTENT -->

                    <div class="tm-content">

                        <?php if($name): ?>

                        <p class="tm-name">

                            <?php echo esc_html($name); ?>

                        </p>

                        <?php endif; ?>

                        <?php if($designation): ?>

                        <span class="tm-designation">

                            <?php echo esc_html($designation); ?>

                        </span>

                        <?php endif; ?>

                        <!-- INFO -->

                        <div class="tm-info-wrap">

                            <?php if($email): ?>

                            <div class="tm-info">

                                <i class="fa-solid fa-envelope"></i>

                                <a href="mailto:<?php echo esc_attr($email); ?>" class="tm-link">

                                    <?php echo esc_html($email); ?>

                                </a>

                            </div>

                            <?php endif; ?>

                            <?php if($phone): ?>

                            <div class="tm-info">

                                <i class="fa-solid fa-phone"></i>

                                <a href="tel:<?php echo esc_attr($phone); ?>" class="tm-link">

                                    <?php echo esc_html($phone); ?>

                                </a>

                            </div>

                            <?php endif; ?>

                        </div>

                        <!-- BUTTON -->

                        <?php if($button_link): ?>

                        <a href="<?php echo esc_url($button_link); ?>" class="tm-btn" target="_blank"
                            rel="noopener noreferrer">

                            View Profile

                        </a>

                        <?php endif; ?>

                    </div>

                </div>

                <?php endwhile; ?>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<!-- =========================
CSS
========================= -->

<style>
/* =========================
FONT AWESOME
========================= */

@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');

/* =========================
PAGE WRAPPER
========================= */

.tm-page-wrap {
    padding: 20px 0 10px;
}

/* =========================
GRID
========================= */

.tm-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 22px;
}

/* =========================
CARD
========================= */

.tm-card {
    background: linear-gradient(160deg, #ccc 60%, #9FE1CB 100%);
    border: 1px solid #6c757d;
    border-radius: 20px;
    padding: 28px 18px 24px;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: transform .22s ease, box-shadow .22s ease;
}

.tm-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.10);
}

/* =========================
DECORATIVE CIRCLES
========================= */

.tm-circle-1 {
    position: absolute;
    width: 160px;
    height: 160px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.25);
    top: -55px;
    right: -55px;
}

.tm-circle-2 {
    position: absolute;
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    bottom: -35px;
    left: -35px;
}

/* =========================
IMAGE
========================= */

.tm-image-wrap {
    margin-bottom: 16px;
    position: relative;
    z-index: 1;
}

.tm-image {
    width: 110px;
    height: 110px;
    object-fit: cover;
    object-position: top center;
    border-radius: 50%;
    display: block;
    margin: 0 auto;
    border: 4px solid #fff;
}

/* =========================
AVATAR
========================= */

.tm-avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    border: 4px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: 700;
    margin: 0 auto;
    color: #fff;
    background: #8b0000;
}

/* =========================
CONTENT
========================= */

.tm-content {
    position: relative;
    z-index: 1;
}

/* =========================
NAME
========================= */

.tm-name {
    font-size: 17px;
    font-weight: 700;
    margin: 0 0 8px;
    line-height: 1.4;
    color: #111;
}

/* =========================
DESIGNATION
========================= */

.tm-designation {
    display: inline-block;
    font-size: 14px;
    font-weight: 600;
    padding: 4px 14px;
    border-radius: 20px;
    margin-bottom: 14px;
    background: rgb(232 152 152 / 50%);
    color: #333;
}

/* =========================
INFO WRAP
========================= */

.tm-info-wrap {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 18px;
    text-align: left;
    background: rgba(255, 255, 255, 0.55);
    border-radius: 10px;
    padding: 10px 14px;
}

.tm-info {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #444;
    overflow: hidden;
}

.tm-info i {
    font-size: 12px;
    width: 16px;
    text-align: center;
    color: #8b0000;
}

/* =========================
LINK
========================= */

.tm-link {
    color: #333 !important;
    text-decoration: none !important;
    font-size: 12px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}

/* =========================
BUTTON
========================= */

.tm-btn {
    display: inline-block;
    padding: 10px 28px;
    border-radius: 10px;
    background: #8b0000;
    color: #fff !important;
    text-decoration: none !important;
    font-size: 13px;
    font-weight: 600;
    transition: .3s;
}

.tm-btn:hover {
    background: #000;
    color: #fff !important;
}

/* =========================
LARGE DESKTOP
========================= */

@media(max-width:1400px) {

    .tm-grid {
        grid-template-columns: repeat(4, 1fr);
    }

}

/* =========================
LAPTOP
========================= */

@media(max-width:1200px) {

    .tm-grid {
        grid-template-columns: repeat(3, 1fr);
    }

}

/* =========================
TABLET
========================= */

@media(max-width:768px) {

    .tm-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

/* =========================
MOBILE
========================= */

@media(max-width:576px) {

    .tm-grid {
        grid-template-columns: 1fr;
    }

    .tm-card {
        padding: 22px 16px 20px;
        border-radius: 16px;
    }

    .tm-image {
        width: 90px;
        height: 90px;
    }

    .tm-avatar {
        width: 90px;
        height: 90px;
        font-size: 30px;
    }

    .tm-name {
        font-size: 15px;
    }

    .tm-designation {
        font-size: 12px;
    }

    .tm-info {
        font-size: 11px;
    }

    .tm-link {
        font-size: 11px;
    }

    .tm-btn {
        padding: 9px 22px;
        font-size: 12px;
    }

}
</style>

<?php get_footer(); ?>