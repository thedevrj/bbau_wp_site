<?php 
/*
Template Name: Schools Page Details
*/

defined('ABSPATH') || exit;
get_header();

/* ================= API ================= */

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$slug       = get_query_var('school_slug');
$api        = $api_base . "/api/v1/schools/" . $slug;

$response = wp_remote_get($api);

$school = [];
if (!is_wp_error($response)) {
    $school = json_decode(wp_remote_retrieve_body($response), true);
}

/* ================= DATA (FIXED ACCORDING TO API) ================= */

$name            = esc_html($school['name'] ?? '');

$designation     = esc_html($school['dean']['role'] ?? '');
$dean_name       = esc_html($school['dean']['name'] ?? '');

$dean_phone      = esc_html($school['dean']['phone1'] ?? '');
$dean_email      = esc_html($school['dean']['insti_email'] ?? '');
$dean_email_alt  = esc_html($school['dean']['other_email'] ?? '');

$dean_photo      = $school['dean']['photo'] ?? '';
$dean_about      = wp_kses_post($school['dean']['bio'] ?? '');

$description     = $school['about_school'] ?? '';

$board_url       = '#'; 
$minutes_url     = '#';

$dean_url        = esc_url('/faculty/' . ($school['dean']['slug'] ?? ''));

$specializations = '';

$departments     = $school['departments'] ?? [];

/* 🔥 FIXED KEY */
$centers         = $school['centres'] ?? [];
?>

<?php get_template_part('banners/about-banner'); ?>

<!-- ✅ CHANGED container-fluid TO container -->
<div class="container-fluid page-bg py-lg-5">

    <?php get_template_part('template-parts/breadcrumb'); ?>

    <!-- HEADING -->
    <div class="row">
        <div class="col-12">
            <h3 class="section-heading mb-4"><?php echo $name; ?></h3>
        </div>
    </div>

    <section class="school-single-section">
        <div class="full-width-wrap">

            <!-- DEAN CARD -->
            <div class="s-dean-centered">
                <div class="s-professor-card">

                    <!-- LEFT -->
                    <div class="s-prof-photo-wrap">
                        <div class="s-prof-photo-circle">
                            <?php if ($dean_photo) : ?>
                            <img src="<?php echo esc_url($media_base . $dean_photo); ?>"
                                alt="<?php echo esc_attr($dean_name); ?>">
                            <?php else : ?>
                            <div class="s-no-photo">No Image</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="s-prof-info">

                        <h2><?php echo $dean_name ?: 'Dean Name'; ?></h2>

                        <div class="s-prof-contact-row">

                            <?php if ($dean_phone) : ?>
                            <div class="s-prof-contact-chip">📞 <?php echo $dean_phone; ?></div>
                            <?php endif; ?>

                            <?php if ($dean_email) : ?>
                            <div class="s-prof-contact-chip">
                                <a href="mailto:<?php echo $dean_email; ?>">📧 <?php echo $dean_email; ?></a>
                            </div>
                            <?php endif; ?>

                            <?php if ($dean_email_alt) : ?>
                            <div class="s-prof-contact-chip">
                                <a href="mailto:<?php echo $dean_email_alt; ?>">🏫 <?php echo $dean_email_alt; ?></a>
                            </div>
                            <?php endif; ?>

                        </div>

                        <?php if ($designation) : ?>
                        <div class="s-prof-designation"><?php echo $designation; ?></div>
                        <?php endif; ?>

                        <?php if ($dean_about) : ?>
                        <div class="s-prof-about"><?php echo $dean_about; ?></div>
                        <?php endif; ?>

                        <a href="<?php echo $dean_url; ?>" class="s-view-btn">View Profile</a>

                    </div>

                </div>
            </div>

            <!-- DEPARTMENTS -->
            <?php if (!empty($departments)) : ?>
            <div class="s-departments-section">
                <h3 class="s-dept-heading"><?php echo $name; ?> comprises the following Departments</h3>

                <div class="s-dept-pills">
                    <?php foreach ($departments as $dept): ?>
                    <div class="s-dept-pill">
                        <a href="/departments/<?php echo esc_attr($dept['slug'] ?? '#'); ?>">
                            <?php echo esc_html($dept['name'] ?? $dept); ?>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- CENTERS -->
            <?php if (!empty($centers) && is_array($centers)) : ?>
            <div class="s-departments-section">
                <h3 class="s-dept-heading">All Centers</h3>

                <div class="s-dept-pills">
                    <?php foreach ($centers as $center): ?>
                    <div class="s-dept-pill">
                        <a href="/centers/<?php echo esc_attr($center['slug'] ?? '#'); ?>">
                            <?php echo esc_html($center['name'] ?? 'Center'); ?>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- ABOUT -->
            <?php if ($description) : ?>
            <div class="s-about-card">
                <div class="s-about-inner">

                    <?php
                        $desc = wp_kses_post($description);
                        echo (strpos($desc, '<p>') === false)
                            ? '<p>' . implode('</p><p>', array_filter(explode("\n\n", $desc))) . '</p>'
                            : $desc;
                        ?>

                    <!-- SCHOOL BOARD -->
                    <div class="s-school-board">

                        <div class="s-board-row">
                            <span class="s-school-board-label">School Board Committee</span>
                            <a href="<?php echo $board_url; ?>" class="s-school-board-link">View</a>
                        </div>

                        <?php if ($minutes_url && $minutes_url !== '#') : ?>
                        <div class="s-board-row">
                            <span class="s-school-board-label">Minutes</span>
                            <a href="<?php echo $minutes_url; ?>" class="s-school-board-link">View</a>
                        </div>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
            <?php endif; ?>

        </div>
    </section>

</div>

<style>
/* ============================================
   SCHOOLS SINGLE PAGE - FINAL CLEAN CSS
============================================ */

/* VARIABLES */
:root {
    --s-bg: #faf7f2;
    --s-deep: #2c1a4a;
    --s-vivid: #6c3fc5;
    --s-saffron: #e07b18;
    --s-saffron2: #f5a030;
    --s-border: #ddd5f0;
}

/* PAGE */
.school-single-section {
    font-family: 'Nunito', sans-serif;
    background: var(--s-bg);
    padding-bottom: 60px;
    padding-top: 35px;
}

/* FULL WIDTH */
.full-width-wrap {
    width: 100%;
    padding: 0 40px;
}

@media (max-width: 768px) {
    .full-width-wrap {
        padding: 0 16px;
    }
}

/* ============================================
   CENTERED DEAN CARD
============================================ */

.s-dean-centered {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
}

.s-professor-card {
    width: 100%;
    max-width: 1050px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-radius: 22px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.12);
    animation: fadeUp 0.6s ease;
}

/* LEFT */
.s-prof-photo-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #2c1a4a, #6c3fc5);
    padding: 35px;
}

.s-prof-photo-circle {
    width: 250px;
    height: 250px;
    border-radius: 50%;
    padding: 6px;
    background: linear-gradient(135deg, var(--s-saffron2), var(--s-vivid));
    position: relative;
    box-shadow:
        0 12px 30px rgba(0, 0, 0, 0.25),
        0 0 0 4px rgba(255, 255, 255, 0.2);
}

.s-prof-photo-circle img {
    width: 100%;
    height: 100%;
    border-radius: 50%;

}

.s-prof-photo-circle::after {
    content: '';
    position: absolute;
    inset: -10px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245, 160, 48, 0.25), transparent 70%);
    z-index: -1;
}

/* RIGHT */
.s-prof-info {
    padding: 35px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.s-prof-info h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    margin-bottom: 10px;
    color: var(--s-deep);
}

.s-prof-info h2::after {
    content: '';
    width: 90px;
    height: 3px;
    background: linear-gradient(90deg, var(--s-vivid), #00a8ff);
    display: block;
    margin-top: 6px;
    border-radius: 2px;
}

.s-prof-contact-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.s-prof-contact-chip {
    background: #f6f3fd;
    border: 1px solid var(--s-border);
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 12px;
}

.s-prof-contact-chip a {
    color: var(--s-vivid);
    text-decoration: none;
    font-weight: 600;
}

.s-prof-designation {
    font-size: 11px;
    text-transform: uppercase;
    color: var(--s-vivid);
    margin-bottom: 8px;
}

.s-prof-specializations {
    font-size: 13px;
    margin-bottom: 10px;
    border-left: 3px solid var(--s-saffron);
    padding-left: 10px;
}

.s-prof-about {
    font-size: 13.5px;
    line-height: 1.6;
    color: #444;
    margin-bottom: 16px;
}

.s-view-btn {
    align-self: flex-start;
    background: linear-gradient(135deg, var(--s-saffron), var(--s-saffron2));
    color: #fff;
    padding: 8px 22px;
    border-radius: 40px;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
}

.s-view-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(224, 123, 24, 0.25);
}

/* ============================================
   HEADINGS
============================================ */

.s-dept-heading {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--s-deep);
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.s-dept-heading::before {
    content: '';
    width: 6px;
    height: 26px;
    background: linear-gradient(180deg, var(--s-vivid), var(--s-saffron));
    border-radius: 3px;
}

/* ============================================
   GRID
============================================ */

.s-dept-pills {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 30px;
}

.s-dept-pill {
    background: #fff;
    border-radius: 14px;
    padding: 16px 18px;
    border: 1px solid #eee;
    font-weight: 600;
    transition: 0.3s;
    position: relative;
}

.s-dept-pill::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 5px;
    background: linear-gradient(180deg, var(--s-vivid), var(--s-saffron));
}

.s-dept-pill:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.s-dept-pill a {
    text-decoration: none;
    color: var(--s-deep);
}

/* ============================================
   ABOUT CARD (ONLY CURVED LINE)
============================================ */

.s-about-card {
    position: relative;
    background: #eeeeee;
    border-radius: 20px;
    padding: 30px 35px 30px 50px;
    border: 1px solid var(--s-border);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

/* CURVED LINE */
.s-about-card::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 20px;
    bottom: 20px;
    width: 5px;
    border-radius: 30px;
    background: linear-gradient(180deg,
            var(--s-vivid),
            var(--s-deep),
            var(--s-saffron));
}

/* ============================================
   SCHOOL BOARD (ROW BASED DESIGN)
============================================ */

/* MAIN CONTAINER */
.s-school-board {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px dashed var(--s-border);
    width: 100%;
}

/* EACH ROW */
.s-board-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    /* 🔥 pushes View to right corner */
    padding: 14px 0;
    border-bottom: 1px solid #eee;
    /* optional divider */
}

/* REMOVE BORDER FROM LAST ROW */
.s-board-row:last-child {
    border-bottom: none;
}

/* LABEL (LEFT SIDE TEXT) */
.s-school-board-label {
    font-weight: 700;
    font-size: 15px;
    color: var(--s-deep);
    letter-spacing: 0.5px;
}

/* VIEW BUTTON (RIGHT SIDE) */
.s-school-board-link {
    background: var(--s-deep);
    color: #fff;
    padding: 8px 22px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    transition: 0.3s;
}

/* HOVER EFFECT */
.s-school-board-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(44, 26, 74, 0.25);
}

/* ============================================
   RESPONSIVE
============================================ */

@media (max-width: 768px) {

    .s-board-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .s-school-board-link {
        align-self: flex-start;
    }
}

/* ============================================
   ANIMATION
============================================ */

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(25px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ============================================
   RESPONSIVE
============================================ */

@media(max-width:768px) {

    .s-professor-card {
        grid-template-columns: 1fr;
    }

    .s-prof-photo-wrap {
        padding: 25px 0;
    }

    .s-prof-photo-circle {
        width: 160px;
        height: 160px;
    }

    .s-prof-info {
        padding: 20px;
        text-align: center;
        align-items: center;
    }

    .s-view-btn {
        align-self: center;
    }
}
</style>

<?php get_footer(); ?>