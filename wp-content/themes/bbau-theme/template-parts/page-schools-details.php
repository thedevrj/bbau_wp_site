<?php 
/*
Template Name: Schools Page Details
*/

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

/* ================= API ================= */

$api_base = getenv('DJANGO_API_URL');
$slug     = get_query_var('school_slug');
$api      = $api_base . "/api/v1/schools/" . $slug;

$response = wp_remote_get($api);
$school     = json_decode(wp_remote_retrieve_body($response), true);

/* ================= DATA ================= */

$name            = esc_html($school['name'] ?? '');
$designation     = esc_html($school['dean']['designation'] ?? '');
$dean_name       = esc_html($school['dean']['name'] ?? '');
$dean_phone      = esc_html($school['dean']['phone'] ?? '');
$dean_email      = esc_html($school['dean']['email'] ?? '');
$dean_photo      = esc_url($school['dean']['photo'] ?? '');
$description     = $school['about_school'] ?? '';
$board_url       = esc_url($school['dean']['board_url'] ?? '#');
$dean_url        = esc_url($school['dean']['slug'] ?? '#');
$specializations = esc_html($school['dean']['specializations'] ?? '');
$departments     = $school['departments'] ?? [];
?>



<!-- ================= BANNER ================= -->

<?php get_template_part('banners/about-banner'); ?>
<div class="container-fluid page-bg page-template-about-bg py-lg-5">
    <!-- ================= BREADCRUMB ================= -->
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- ================= PAGE TITLE ================= -->
                <h3 class="section-heading mb-3">
                    <?php echo $name; ?>
                </h3>
            </div>
        </div>
    </div>

    <section class="school-single-section">
        <div class="school-single-wrap">
            <div class="s-container">
                <!-- ================= DEAN CARD ================= -->
                <div class="s-professor-card">
                    <div class="s-prof-photo-wrap">
                        <div class="s-prof-photo">
                            <?php if ($dean_photo) : ?>
                            <img src="<?php echo $dean_photo; ?>" alt="<?php echo $dean_name; ?>">
                            <?php else : ?>
                            <svg viewBox="0 0 64 64">
                                <circle cx="32" cy="22" r="13" />
                                <path d="M8 56c0-13.25 10.75-24 24-24s24 10.75 24 24" />
                            </svg>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="s-prof-info">
                        <h2><?php echo $dean_name ?: 'Dean Name'; ?></h2>
                        <div class="s-prof-contact-row">
                            <?php if ($dean_phone) : ?>
                            <div class="s-prof-contact-chip">
                                <span class="s-chip-dot"></span>
                                Phone: <?php echo $dean_phone; ?>
                            </div>

                            <?php endif; ?>
                            <?php if ($dean_email) : ?>

                            <div class="s-prof-contact-chip">
                                <span class="s-chip-dot"></span>

                                <a href="mailto:<?php echo $dean_email; ?>">
                                    <?php echo $dean_email; ?>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($designation) : ?>

                        <div class="s-prof-designation">
                            <?php echo $designation; ?>
                        </div>

                        <?php endif; ?>
                        <?php if ($specializations) : ?>

                        <div class="s-prof-specializations">
                            <?php echo $specializations; ?>
                        </div>

                        <?php endif; ?>

                        <a href="<?php echo $dean_url; ?>" class="s-view-btn">
                            View Profile
                        </a>

                    </div>
                </div>

                <!-- ================= DEPARTMENTS ================= -->

                <?php if (!empty($departments)) : ?>
                <div class="s-departments-section">
                    <h3 class="s-dept-heading">
                        <?php echo $name; ?> comprises the following Departments.
                    </h3>
                    <div class="s-dept-pills">

                        <?php foreach ($departments as $dept) :
                            $dept_name = esc_html($dept['name'] ?? $dept);
                            $is_wide   = (strlen($dept_name) > 30) ? ' wide' : ''; ?>

                        <div class="s-dept-pill<?php echo $is_wide; ?>">
                            <a href="/departments/<?php echo $dept['slug']; ?>">
                                <?php echo $dept_name; ?>
                            </a>
                        </div>

                        <?php endforeach; ?>

                    </div>

                </div>

                <?php endif; ?>


                <!-- ================= ABOUT SECTION ================= -->

                <?php if ($description) : ?>

                <div class="s-about-card">

                    <div class="s-about-inner">

                        <?php

                            $desc = wp_kses_post($description);

                            if (strpos($desc, '<p>') === false) {
                                $paragraphs = array_filter(explode("\n\n", $desc));
                            foreach ($paragraphs as $para) {
                                echo '<p>' . trim($para) . '</p>';
                            }
                            } else {
                            echo $desc;
                            }
                        ?>


                        <div class="s-school-board">

                            <span class="s-school-board-label">
                                School Board Committee
                            </span>

                            <a href="<?php echo $board_url; ?>" class="s-school-board-link">
                                View
                            </a>

                        </div>

                    </div>

                </div>

                <?php endif; ?>


            </div>

        </div>

    </section>

</div>

<style>
/* ============================================
   SCHOOLS SINGLE PAGE
============================================ */

@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Nunito:wght@300;400;600;700;800&display=swap');

/* VARIABLES */

:root {
    --s-bg: #faf7f2;
    --s-deep: #2c1a4a;
    --s-rich: #3d2568;
    --s-vivid: #6c3fc5;
    --s-saffron: #e07b18;
    --s-saffron2: #f5a030;
    --s-white: #fff;
    --s-border: #ddd5f0;
}

/* PAGE WRAPPER */

.school-page-wrap {
    font-family: 'Nunito', sans-serif;
    background: var(--s-bg);
    position: relative;
    overflow: hidden;
}

/* subtle background pattern */

.school-page-wrap::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
        linear-gradient(45deg, rgba(108, 63, 197, 0.04) 25%, transparent 25%),
        linear-gradient(-45deg, rgba(108, 63, 197, 0.04) 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, rgba(108, 63, 197, 0.04) 75%),
        linear-gradient(-45deg, transparent 75%, rgba(108, 63, 197, 0.04) 75%);
    background-size: 20px 20px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0;
    pointer-events: none;
    z-index: 0;
}

/* HEADER BAR */

.s-header-bar {
    position: relative;
    z-index: 10;
    background: linear-gradient(98deg, var(--s-deep) 0%, #3a2260 55%, var(--s-rich) 100%);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 38px;
    height: 62px;
    box-shadow: 0 4px 24px rgba(44, 26, 74, 0.32);
}

.s-header-bar::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--s-saffron2), #ffc84a, var(--s-saffron2));
}

.s-hb-left {
    display: flex;
    align-items: center;
    gap: 13px;
}

.s-hb-seal {
    width: 37px;
    height: 37px;
    border-radius: 50%;
    background: rgba(245, 160, 48, 0.15);
    border: 2px solid rgba(245, 160, 48, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Playfair Display', serif;
    font-weight: 900;
    color: var(--s-saffron2);
}

.s-hb-title {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    color: #fff;
}

.s-hb-dash {
    font-size: 1.4rem;
    color: var(--s-saffron2);
}

/* MAIN CONTAINER */

.s-container {
    position: relative;
    z-index: 1;
    max-width: 860px;
    margin: 36px auto;
    padding: 0 20px;
    display: flex;
    flex-direction: column;
    gap: 26px;
}

/* PROFESSOR CARD */

.s-professor-card {
    background: linear-gradient(118deg, #5530a8 0%, #3d2270 45%, var(--s-deep) 100%);
    border-radius: 28px;
    padding: 30px 34px;
    display: flex;
    gap: 28px;
    align-items: center;
    color: #fff;
    box-shadow:
        0 14px 48px rgba(44, 26, 74, 0.28),
        0 2px 8px rgba(44, 26, 74, 0.14),
        inset 0 1px 0 rgba(255, 255, 255, 0.07);
    position: relative;
    overflow: hidden;
    animation: sFadeUp .55s ease both;
}

.s-professor-card::before {
    content: '';
    position: absolute;
    right: -55px;
    top: -55px;
    width: 240px;
    height: 240px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
}

.s-professor-card::after {
    content: '';
    position: absolute;
    right: 60px;
    bottom: -65px;
    width: 170px;
    height: 170px;
    border-radius: 50%;
    background: rgba(224, 123, 24, 0.11);
}

/* PHOTO */

.s-prof-photo-wrap {
    display: flex;
    align-items: center;
}

.s-prof-photo {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid rgba(255, 255, 255, 0.28);
    background: rgba(255, 255, 255, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow:
        0 0 0 5px rgba(245, 160, 48, 0.2),
        0 8px 28px rgba(0, 0, 0, 0.32);
}

.s-prof-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.s-prof-photo svg {
    width: 58px;
    height: 58px;
    fill: rgba(255, 255, 255, 0.4);
}

/* INFO */

.s-prof-info {
    flex: 1;
}

.s-prof-info h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.s-prof-contact-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 10px;
}

.s-prof-contact-chip {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 20px;
    padding: 5px 12px;
    font-size: .8rem;
}

.s-prof-contact-chip a {
    color: #fff;
    text-decoration: none;
}

.s-chip-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--s-saffron2);
}

.s-prof-designation {
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--s-saffron2);
    margin-bottom: 12px;
}

.s-prof-specializations {
    font-size: .82rem;
    border-left: 3px solid var(--s-saffron);
    padding-left: 12px;
    margin-bottom: 18px;
}

/* BUTTON */

.s-view-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--s-saffron2);
    color: var(--s-deep);
    padding: 10px 26px;
    border-radius: 50px;
    font-weight: 800;
    text-decoration: none;
    letter-spacing: .05em;
    transition: .2s;
}

.s-view-btn:hover {
    background: #ffc040;
    transform: translateY(-2px);
}

/* DEPARTMENTS */

.s-dept-heading {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--s-deep);
}

.s-dept-heading::before {
    content: '';
    width: 5px;
    height: 24px;
    background: linear-gradient(180deg, var(--s-saffron2), var(--s-saffron));
    border-radius: 3px;
}

.s-dept-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 11px;
}

.s-dept-pill {
    background: #fff;
    border: 2px solid var(--s-border);
    border-radius: 50px;
    padding: 11px 26px;
    font-weight: 700;
    position: relative;
    transition: .2s;
}

.s-dept-pill:hover {
    background: linear-gradient(135deg, var(--s-vivid), var(--s-rich));
    color: #fff;
    border-color: var(--s-vivid);
    transform: translateY(-3px);
}

/* ABOUT CARD */

.s-about-card {
    background: #fff;
    border-radius: 28px;
    padding: 34px 36px;
    border: 1.5px solid var(--s-border);
    box-shadow: 0 4px 28px rgba(44, 26, 74, 0.09);
    position: relative;
    overflow: hidden;
}

.s-about-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--s-vivid), var(--s-deep), var(--s-vivid));
}

.s-about-inner p {
    line-height: 1.9;
    color: var(--s-deep);
    margin-bottom: 13px;
}

/* SCHOOL BOARD */

.s-school-board {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1.5px dashed var(--s-border);
    flex-wrap: wrap;
    gap: 10px;
}

.s-school-board-label {
    font-weight: 700;
    color: var(--s-deep);
}

.s-school-board-link {
    background: var(--s-deep);
    color: #fff;
    padding: 9px 22px;
    border-radius: 50px;
    text-decoration: none;
    font-size: .85rem;
    transition: .2s;
}

.s-school-board-link:hover {
    background: var(--s-vivid);
    transform: translateY(-2px);
}

/* ANIMATION */

@keyframes sFadeUp {
    from {
        opacity: 0;
        transform: translateY(24px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* RESPONSIVE */

@media(max-width:600px) {

    .s-header-bar {
        padding: 0 18px;
    }

    .s-container {
        margin: 22px auto;
        gap: 20px;
    }

    .s-professor-card {
        flex-direction: column;
        align-items: center;
        padding: 26px 20px;
    }

    .s-about-card {
        padding: 24px 20px;
    }

    .s-dept-pill {
        padding: 10px 20px;
        font-size: .83rem;
    }

}
</style>
<?php get_footer();?>