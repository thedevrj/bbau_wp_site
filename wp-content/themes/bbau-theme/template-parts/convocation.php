<?php
/*
Template Name: Convocation Chronicle
*/

defined('ABSPATH') || exit;

get_header();
?>

<!-- =========================================
   FULL WIDTH HERO BANNER
========================================= -->

<div class="convocation-hero">

    <div class="convocation-top">

        <div class="convocation-icon">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>

        <div>

            <div class="convocation-subtitle">
                BABASAHEB BHIMRAO AMBEDKAR UNIVERSITY
            </div>

            <h1 class="convocation-title">
                Convocation
            </h1>

            <div class="convocation-year-line">
                Celebrating Academic Excellence
            </div>

        </div>

    </div>

</div>

<div class="container-fluid page-bg page-template-about-bg py-lg-5">

    <!-- =========================================
       BREADCRUMB
    ========================================= -->

    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">

        <div class="convocation-wrap">

            <!-- =========================================
               ABOUT SECTION
            ========================================= -->

            <div class="convocation-section">

                <div class="section-heading-wrap">

                    <h2 class="section-heading">
                        About the Convocation
                    </h2>

                </div>

                <p class="convocation-text">
                    The Annual Convocation of Babasaheb Bhimrao Ambedkar University is one of the most cherished
                    milestones in a student's academic journey. It is the day when years of dedication, perseverance and
                    learning are formally recognised as graduates receive their degrees, diplomas and medals from
                    distinguished national leaders and dignitaries.
                </p>

                <?php 
                $main_image = get_field('main_convocation_image');
                ?>

                <?php if($main_image): ?>

                <div class="convocation-main-image">

                    <img src="<?php echo esc_url($main_image['url']); ?>"
                        alt="<?php echo esc_attr($main_image['alt']); ?>">

                </div>

                <?php endif; ?>

            </div>

            <!-- =========================================
               REPEATER START
            ========================================= -->

            <?php if( have_rows('convocation_years') ): ?>

            <?php while( have_rows('convocation_years') ) : the_row();

                    $year = get_sub_field('year');
                    $chief_guest = get_sub_field('chief_guest');
                    $role = get_sub_field('role');
                    $highlight = get_sub_field('highlight');

                    $graduates = get_sub_field('graduates');
                    $gold_medals = get_sub_field('gold_medals');
                    $departments = get_sub_field('departments');

                    $big_image = get_sub_field('big_image');

                    $small_image_1 = get_sub_field('small_image_1');
                    $small_image_2 = get_sub_field('small_image_2');

                    $third_image_1 = get_sub_field('third_image_1');
                    $third_image_2 = get_sub_field('third_image_2');
                    $third_image_3 = get_sub_field('third_image_3');

                ?>

            <!-- =========================================
                   YEAR SECTION
                ========================================= -->

            <div class="convocation-year-section">

                <!-- YEAR BANNER -->
                <div class="year-banner">

                    <div class="year-number">
                        <?php echo esc_html($year); ?>
                    </div>

                    <div class="year-vline"></div>

                    <div>

                        <div class="year-badge">
                            Chief Guest
                        </div>

                        <div class="year-name">
                            <?php echo esc_html($chief_guest); ?>
                        </div>

                        <div class="year-role">
                            <?php echo esc_html($role); ?>
                        </div>

                    </div>

                </div>

                <!-- STATS -->
                <div class="stats-row">

                    <div class="stat-card">

                        <div class="stat-num">
                            <?php echo esc_html($graduates); ?>
                        </div>

                        <div class="stat-label">
                            Graduates
                        </div>

                    </div>

                    <div class="stat-card">

                        <div class="stat-num">
                            <?php echo esc_html($gold_medals); ?>
                        </div>

                        <div class="stat-label">
                            Gold Medals
                        </div>

                    </div>

                    <div class="stat-card">

                        <div class="stat-num">
                            <?php echo esc_html($departments); ?>
                        </div>

                        <div class="stat-label">
                            Departments
                        </div>

                    </div>

                </div>

                <!-- HIGHLIGHT -->
                <div class="highlight-strip">
                    <?php echo esc_html($highlight); ?>
                </div>

                <!-- IMAGE GRID -->
                <div class="convocation-grid">

                    <!-- BIG IMAGE -->
                    <div class="convocation-card big-card">

                        <?php if($big_image): ?>

                        <img src="<?php echo esc_url($big_image['url']); ?>"
                            alt="<?php echo esc_attr($big_image['alt']); ?>">

                        <?php endif; ?>

                        <div class="card-caption">
                            Main Ceremony
                        </div>

                    </div>

                    <!-- SIDE GRID -->
                    <div class="side-grid">

                        <!-- SMALL IMAGE 1 -->
                        <div class="convocation-card small-card">

                            <?php if($small_image_1): ?>

                            <img src="<?php echo esc_url($small_image_1['url']); ?>"
                                alt="<?php echo esc_attr($small_image_1['alt']); ?>">

                            <?php endif; ?>

                            <div class="card-caption">
                                Ceremony Moment
                            </div>

                        </div>

                        <!-- SMALL IMAGE 2 -->
                        <div class="convocation-card small-card">

                            <?php if($small_image_2): ?>

                            <img src="<?php echo esc_url($small_image_2['url']); ?>"
                                alt="<?php echo esc_attr($small_image_2['alt']); ?>">

                            <?php endif; ?>

                            <div class="card-caption">
                                Special Event
                            </div>

                        </div>

                    </div>

                </div>

                <!-- THIRD GRID -->
                <div class="three-grid">

                    <!-- THIRD IMAGE 1 -->
                    <div class="convocation-card third-card">

                        <?php if($third_image_1): ?>

                        <img src="<?php echo esc_url($third_image_1['url']); ?>"
                            alt="<?php echo esc_attr($third_image_1['alt']); ?>">

                        <?php endif; ?>

                        <div class="card-caption">
                            Academic Procession
                        </div>

                    </div>

                    <!-- THIRD IMAGE 2 -->
                    <div class="convocation-card third-card">

                        <?php if($third_image_2): ?>

                        <img src="<?php echo esc_url($third_image_2['url']); ?>"
                            alt="<?php echo esc_attr($third_image_2['alt']); ?>">

                        <?php endif; ?>

                        <div class="card-caption">
                            Award Ceremony
                        </div>

                    </div>

                    <!-- THIRD IMAGE 3 -->
                    <div class="convocation-card third-card">

                        <?php if($third_image_3): ?>

                        <img src="<?php echo esc_url($third_image_3['url']); ?>"
                            alt="<?php echo esc_attr($third_image_3['alt']); ?>">

                        <?php endif; ?>

                        <div class="card-caption">
                            Celebration Moment
                        </div>

                    </div>

                </div>

            </div>

            <?php endwhile; ?>

            <?php endif; ?>

        </div>

    </div>

</div>

<style>
/* ================================================
   CONVOCATION CHRONICLE – COMPLETE CSS
================================================ */

/* ===== WRAPPER ===== */
.convocation-wrap {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 40px rgba(0, 0, 0, .10);
}

/* ===== HERO ===== */
.convocation-hero {
    background: linear-gradient(135deg, #061526, #0e2b57);
    padding: 60px 90px;
}

.convocation-top {
    display: flex;
    align-items: center;
    gap: 24px;
}

.convocation-icon {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .07);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, .18);
    flex-shrink: 0;
}

.convocation-icon i {
    color: #d4af37;
    font-size: 36px;
}

.convocation-subtitle {
    color: #d4af37;
    letter-spacing: 3px;
    font-size: 12px;
    margin-bottom: 8px;
    text-transform: uppercase;
}

.convocation-title {
    color: #fff;
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 10px;
    line-height: 1.15;
}

.convocation-year-line {
    color: rgba(255, 255, 255, .55);
    font-size: 14px;
    letter-spacing: .5px;
}

/* ===== ABOUT SECTION ===== */
.convocation-section {
    padding: 50px;
}


.convocation-text {
    font-size: 15px;
    line-height: 2;
    color: #555;
    margin-bottom: 30px;
}

.convocation-main-image {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
}

.convocation-main-image img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    border-radius: 16px;
    display: block;
    transition: transform .45s ease;
}

.convocation-main-image:hover img {
    transform: scale(1.03);
}

/* ===== YEAR SECTION ===== */
.convocation-year-section {
    padding: 50px;
    border-top: 1px solid #f0ece0;
}

/* ===== YEAR BANNER ===== */
.year-banner {
    background: #0e2b57;
    border-radius: 16px;
    padding: 28px 36px;
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 24px;
}

.year-number {
    font-size: 76px;
    font-weight: 700;
    color: #d4af37;
    line-height: 1;
    min-width: 170px;
}

.year-vline {
    width: 1px;
    height: 64px;
    background: rgba(255, 255, 255, .15);
    margin-right: 28px;
    flex-shrink: 0;
}

.year-badge {
    color: #d4af37;
    text-transform: uppercase;
    letter-spacing: 3px;
    font-size: 11px;
    margin-bottom: 8px;
}

.year-name {
    color: #fff;
    font-size: 26px;
    font-weight: 700;
    line-height: 1.25;
    margin-bottom: 5px;
    word-break: break-word;
}

.year-role {
    color: rgba(255, 255, 255, .65);
    font-size: 15px;
    word-break: break-word;
}

/* ===== STATS ===== */
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}

.stat-card {
    background: #f4f2ee;
    border-radius: 12px;
    padding: 18px 20px;
    text-align: center;
    transition: .3s;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-num {
    font-size: 30px;
    font-weight: 700;
    color: #0e2b57;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 11px;
    color: #888;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* ===== HIGHLIGHT ===== */
.highlight-strip {
    background: #f8f5ed;
    border-left: 4px solid #d4af37;
    border-radius: 0 10px 10px 0;
    padding: 14px 20px;
    margin-bottom: 24px;
    font-size: 14px;
    color: #555;
    line-height: 1.8;
    word-break: break-word;
}

/* ===== GRID ===== */
.convocation-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 16px;
}

.side-grid {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.three-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 16px;
}

/* ===== CARD ===== */
.convocation-card {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    background: #12223a;
    transition: all .3s ease;
}

.convocation-card:hover {
    transform: translateY(-3px);
}

.convocation-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .45s ease;
}

.convocation-card:hover img {
    transform: scale(1.05);
}

.big-card {
    height: 460px;
}

.small-card {
    height: 222px;
}

.third-card {
    height: 200px;
}

.card-caption {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 18px 20px;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    background: linear-gradient(transparent, rgba(0, 0, 0, .82));
}

/* ===== EMPTY IMAGE FIX ===== */
.convocation-card img[src=""],
.convocation-main-image img[src=""] {
    display: none;
}

/* ================================================
   TABLET
================================================ */
@media(max-width:991px) {

    .convocation-grid {
        grid-template-columns: 1fr;
    }

    .convocation-hero {
        padding: 40px 28px;
    }

    .convocation-title {
        font-size: 36px;
    }

    .convocation-section,
    .convocation-year-section {
        padding: 30px 28px;
    }

    .big-card {
        height: 320px;
    }

    .small-card {
        height: 220px;
    }

    .three-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

/* ================================================
   MOBILE
================================================ */
@media(max-width:767px) {

    .convocation-top {
        flex-direction: column;
        text-align: center;
    }

    .convocation-title {
        font-size: 30px;
    }

    .convocation-section,
    .convocation-year-section {
        padding: 24px 18px;
    }

    .year-banner {
        flex-direction: column;
        text-align: center;
        gap: 12px;
        padding: 24px 20px;
    }

    .year-vline {
        display: none;
    }

    .year-number {
        font-size: 56px;
        min-width: unset;
    }

    .year-name {
        font-size: 20px;
    }

    .stats-row {
        grid-template-columns: 1fr 1fr;
    }

    .three-grid {
        grid-template-columns: 1fr;
    }

    .convocation-main-image img {
        height: 240px;
    }

    .big-card {
        height: 240px;
    }

    .small-card,
    .third-card {
        height: 180px;
    }

    .convocation-card img {
        min-height: 180px;
    }

}

/* ================================================
   SMALL MOBILE
================================================ */
@media(max-width:420px) {

    .stats-row {
        grid-template-columns: 1fr;
    }

    .convocation-title {
        font-size: 24px;
    }

    .section-heading {
        font-size: 22px;
    }

    .year-number {
        font-size: 48px;
    }

}
</style>
<?php get_footer(); ?>