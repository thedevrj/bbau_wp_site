<?php
/*
Template Name: Team Members
*/

defined('ABSPATH') || exit;

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid py-lg-5 page-bg page-template-about-bg">

    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">
        <div class="tm-page-wrap">

            <!-- HEADING -->
            <div class="tm-heading-wrap">
                <h2 class="tm-main-heading">
                    Directors / Coordinators / In-Charge
                </h2>
            </div>

            <!-- GRID -->
            <div class="tm-grid">

                <?php if( have_rows('team_members') ) : ?>
                <?php while( have_rows('team_members') ) : the_row();

                        $name        = get_sub_field('name');
                        $image       = get_sub_field('image');
                        $designation = get_sub_field('designation');
                        $center_name = get_sub_field('center_name');
                        $button_link = get_sub_field('button_link');

                        $initials = $name ? strtoupper(substr(trim($name), 0, 1)) : '?';
                        $img_url  = '';
                        if( $image ){
                            $img_url = is_array($image) ? $image['url'] : $image;
                        }
                    ?>

                <div class="tm-card">

                    <!-- TOP BAR -->
                    <div class="tm-top-bar">
                        <div class="tm-bar-circle"></div>
                    </div>

                    <!-- PHOTO -->
                    <div class="tm-image-wrap">
                        <?php if( $img_url ): ?>
                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($name); ?>"
                            class="tm-image">
                        <?php else: ?>
                        <div class="tm-avatar">
                            <?php echo esc_html($initials); ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- CONTENT -->
                    <div class="tm-content">

                        <?php if($name): ?>
                        <p class="tm-name"><?php echo esc_html($name); ?></p>
                        <?php endif; ?>

                        <?php if($designation): ?>
                        <span class="tm-designation">
                            <?php echo esc_html($designation); ?>
                        </span>
                        <?php endif; ?>

                        <?php if($center_name): ?>
                        <div class="tm-center-name">
                            <i class="fa-solid fa-building-columns"></i>
                            <?php echo esc_html($center_name); ?>
                        </div>
                        <?php endif; ?>

                        <?php if($button_link): ?>
                        <a href="<?php echo esc_url($button_link); ?>" class="tm-btn" rel="noopener noreferrer">
                            View Profile
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <?php endif; ?>

                    </div>

                </div>

                <?php endwhile; ?>

                <?php else: ?>
                <p class="tm-empty">No team members found.</p>
                <?php endif; ?>

            </div>

        </div>
    </div>

</div>

<style>
/* =========================
PAGE
========================= */

.tm-page-wrap {
    padding: 20px 0 50px;
}

/* =========================
GRID — 5 IN A ROW
========================= */

.tm-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 18px;
}

/* =========================
CARD
========================= */

.tm-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #ebebeb;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.tm-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.09);
}

/* =========================
TOP BAR COLOURS — nth-child
========================= */

.tm-card:nth-child(5n+1) .tm-top-bar {
    background: #334a62;
}

.tm-card:nth-child(5n+2) .tm-top-bar {
    background: #854F0B;
}

.tm-card:nth-child(5n+3) .tm-top-bar {
    background: #993556;
}

.tm-card:nth-child(5n+4) .tm-top-bar {
    background: #576017;
}

.tm-card:nth-child(5n+5) .tm-top-bar {
    background: #993C1D;
}

/* =========================
TOP BAR
========================= */

.tm-top-bar {
    width: 100%;
    height: 64px;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}

.tm-bar-circle {
    position: absolute;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    top: -25px;
    right: -15px;
}

/* =========================
IMAGE WRAP — overlaps bar
========================= */

.tm-image-wrap {
    margin-top: -36px;
    position: relative;
    z-index: 2;
    margin-bottom: 10px;
}

.tm-image {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    object-fit: cover;
    object-position: top center;
    border: 3px solid #ffffff;
    display: block;
    margin: 0 auto;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
}

/* =========================
AVATAR FALLBACK
========================= */

.tm-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    border: 3px solid #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 700;
    margin: 0 auto;
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
}

.tm-card:nth-child(5n+1) .tm-avatar {
    background: #334a62;
}

.tm-card:nth-child(5n+2) .tm-avatar {
    background: #854F0B;
}

.tm-card:nth-child(5n+3) .tm-avatar {
    background: #993556;
}

.tm-card:nth-child(5n+4) .tm-avatar {
    background: #576017;
}

.tm-card:nth-child(5n+5) .tm-avatar {
    background: #993C1D;
}

/* =========================
CONTENT
========================= */

.tm-content {
    padding: 0 12px 16px;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    flex: 1;
}

/* =========================
NAME
========================= */

.tm-name {
    font-size: 14px;
    font-weight: 700;
    color: #111;
    margin: 0;
    line-height: 1.4;
}

/* =========================
DESIGNATION BADGE
========================= */

.tm-designation {
    display: inline-block;
    font-size: 10px;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 20px;
    line-height: 1.5;
}

.tm-card:nth-child(5n+1) .tm-designation {
    background: #E1F5EE;
    color: #334a62;
}

.tm-card:nth-child(5n+2) .tm-designation {
    background: #FAEEDA;
    color: #633806;
}

.tm-card:nth-child(5n+3) .tm-designation {
    background: #FBEAF0;
    color: #72243E;
}

.tm-card:nth-child(5n+4) .tm-designation {
    background: #EEEDFE;
    color: #576017;
}

.tm-card:nth-child(5n+5) .tm-designation {
    background: #FAECE7;
    color: #712B13;
}

/* =========================
CENTER NAME
========================= */

.tm-center-name {
    width: 100%;
    background: #f5f7fa;
    border: 1px solid #e8eaed;
    border-radius: 10px;
    padding: 8px 10px;
    font-size: 11px;
    font-weight: 500;
    color: #444;
    line-height: 1.5;
    min-height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    flex: 1;
}

.tm-center-name i {
    font-size: 12px;
    flex-shrink: 0;
}

.tm-card:nth-child(5n+1) .tm-center-name i {
    color: #334a62;
}

.tm-card:nth-child(5n+2) .tm-center-name i {
    color: #854F0B;
}

.tm-card:nth-child(5n+3) .tm-center-name i {
    color: #993556;
}

.tm-card:nth-child(5n+4) .tm-center-name i {
    color: #576017;
}

.tm-card:nth-child(5n+5) .tm-center-name i {
    color: #993C1D;
}

/* =========================
BUTTON
========================= */

.tm-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    width: 100%;
    padding: 9px 0;
    border-radius: 9px;
    color: #fff !important;
    text-decoration: none !important;
    font-size: 12px;
    font-weight: 600;
    transition: opacity 0.2s, transform 0.2s;
    margin-top: auto;
}

.tm-btn i {
    font-size: 11px;
    transition: transform 0.2s;
}

.tm-btn:hover {
    opacity: 0.88;
    color: #fff !important;
}

.tm-btn:hover i {
    transform: translateX(3px);
}

.tm-card:nth-child(5n+1) .tm-btn {
    background: #334a62;
}

.tm-card:nth-child(5n+2) .tm-btn {
    background: #854F0B;
}

.tm-card:nth-child(5n+3) .tm-btn {
    background: #993556;
}

.tm-card:nth-child(5n+4) .tm-btn {
    background: #576017;
}

.tm-card:nth-child(5n+5) .tm-btn {
    background: #993C1D;
}

/* =========================
EMPTY
========================= */

.tm-empty {
    grid-column: 1 / -1;
    text-align: center;
    color: #888;
    padding: 40px 0;
}

/* =========================
≤1400px — 4 CARDS
========================= */

@media (max-width: 1400px) {
    .tm-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

/* =========================
≤1200px — 3 CARDS
========================= */

@media (max-width: 1200px) {
    .tm-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* =========================
≤992px — 2 CARDS
========================= */

@media (max-width: 992px) {
    .tm-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
}

/* =========================
≤768px — 2 CARDS SMALLER
========================= */

@media (max-width: 768px) {
    .tm-main-heading {
        font-size: 26px;
    }

    .tm-grid {
        gap: 14px;
    }

    .tm-image {
        width: 66px;
        height: 66px;
    }

    .tm-avatar {
        width: 66px;
        height: 66px;
        font-size: 20px;
    }

    .tm-name {
        font-size: 13px;
    }
}

/* =========================
≤576px — 1 CARD
========================= */

@media (max-width: 576px) {
    .tm-grid {
        grid-template-columns: 1fr;
        max-width: 300px;
        margin: 0 auto;
    }

    .tm-main-heading {
        font-size: 22px;
    }

    .tm-image {
        width: 70px;
        height: 70px;
    }

    .tm-avatar {
        width: 70px;
        height: 70px;
        font-size: 22px;
    }

    .tm-name {
        font-size: 14px;
    }

    .tm-content {
        padding: 0 14px 16px;
    }
}

/* =========================
≤380px
========================= */

@media (max-width: 380px) {
    .tm-grid {
        max-width: 100%;
    }

    .tm-image {
        width: 62px;
        height: 62px;
    }

    .tm-avatar {
        width: 62px;
        height: 62px;
        font-size: 20px;
    }

    .tm-name {
        font-size: 13px;
    }
}
</style>

<?php get_footer(); ?>