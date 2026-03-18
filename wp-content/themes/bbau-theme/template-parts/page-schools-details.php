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

/* ================= DATA ================= */

$name            = esc_html($school['name'] ?? '');
$designation     = esc_html($school['dean']['designation'] ?? '');
$dean_name       = esc_html($school['dean']['name'] ?? '');
$dean_phone      = esc_html($school['dean']['phone'] ?? '');
$dean_email      = esc_html($school['dean']['email'] ?? '');
$dean_email_alt  = esc_html($school['dean']['institutional_email'] ?? '');
$dean_photo      = $school['dean']['photo'] ?? '';
$dean_about      = wp_kses_post($school['dean']['about'] ?? '');
$description     = $school['about_school'] ?? '';
$board_url       = esc_url($school['dean']['board_url'] ?? '#');
$minutes_url     = esc_url($school['dean']['minutes_url'] ?? '#');
$dean_url        = esc_url($school['dean']['slug'] ?? '#');
$specializations = esc_html($school['dean']['specializations'] ?? '');
$departments     = $school['departments'] ?? [];
$centers         = $school['centers'] ?? [];
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg py-lg-5">
    <?php get_template_part('template-parts/breadcrumb'); ?>

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
                                <img src="<?php echo esc_url($media_base . $dean_photo); ?>" alt="<?php echo esc_attr($dean_name); ?>">
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

                        <?php if ($specializations) : ?>
                            <div class="s-prof-specializations"><?php echo $specializations; ?></div>
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
            <?php if (!empty($centers)) : ?>
            <div class="s-departments-section">
                <h3 class="s-dept-heading">All Centers</h3>
                <div class="s-dept-pills">
                    <?php foreach ($centers as $center): ?>
                        <div class="s-dept-pill">
                            <a href="/centers/<?php echo esc_attr($center['slug'] ?? '#'); ?>">
                                <?php echo esc_html($center['name'] ?? $center); ?>
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

                    <div class="s-school-board">
                        <span class="s-school-board-label">School Board Committee</span>

                        <div class="s-board-actions">
                            <a href="<?php echo $board_url; ?>" class="s-school-board-link">View</a>

                            <?php if ($minutes_url && $minutes_url !== '#') : ?>
                                <a href="<?php echo $minutes_url; ?>" class="s-school-board-link alt">Minutes</a>
                            <?php endif; ?>
                        </div>
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

/* CARD */
.s-professor-card {
    width: 100%;
    max-width: 1100px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-radius: 24px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    animation: fadeUp 0.6s ease;
}

/* ============================================
   LEFT SIDE (IMAGE)
============================================ */

.s-prof-photo-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #3d2568, #6c3fc5);
    padding: 40px;
}

/* REMOVE OLD IMAGE BEHAVIOR */
.s-prof-photo-wrap img {
    width: auto;
    height: auto;
    max-width: 100%;
}

/* CIRCLE */
.s-prof-photo-circle {
    width: 240px;
    height: 240px;
    border-radius: 50%;
    padding: 8px;
    background: linear-gradient(135deg, var(--s-saffron2), var(--s-vivid));
    position: relative;
    box-shadow:
        0 15px 40px rgba(0,0,0,0.3),
        0 0 0 6px rgba(255,255,255,0.15);
}

/* IMAGE */
.s-prof-photo-circle img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    display: block;
}

/* GLOW EFFECT */
.s-prof-photo-circle::after {
    content: '';
    position: absolute;
    inset: -12px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,160,48,0.3), transparent 70%);
    z-index: -1;
}

/* FALLBACK */
.s-no-photo {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* ============================================
   RIGHT SIDE CONTENT
============================================ */

.s-prof-info {
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.s-prof-info h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    margin-bottom: 12px;
    color: var(--s-deep);
    position: relative;
}

/* UNDERLINE */
.s-prof-info h2::after {
    content: '';
    width: 120px;
    height: 3px;
    background: linear-gradient(90deg, var(--s-vivid), #00a8ff);
    display: block;
    margin-top: 6px;
    border-radius: 2px;
}

/* CONTACT */
.s-prof-contact-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 14px;
}

.s-prof-contact-chip {
    background: #f4f1fb;
    border: 1px solid var(--s-border);
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 13px;
}

.s-prof-contact-chip a {
    color: var(--s-vivid);
    text-decoration: none;
    font-weight: 600;
}

/* DESIGNATION */
.s-prof-designation {
    font-size: 12px;
    text-transform: uppercase;
    color: var(--s-vivid);
    margin-bottom: 10px;
}

/* SPECIALIZATION */
.s-prof-specializations {
    font-size: 13px;
    margin-bottom: 10px;
    border-left: 3px solid var(--s-saffron);
    padding-left: 10px;
}

/* ABOUT */
.s-prof-about {
    font-size: 14px;
    line-height: 1.7;
    color: #444;
    margin-bottom: 20px;
}

/* BUTTON */
.s-view-btn {
    align-self: flex-start;
    background: linear-gradient(135deg, var(--s-saffron), var(--s-saffron2));
    color: #fff;
    padding: 10px 26px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.s-view-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(224,123,24,0.3);
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
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.s-dept-pill a {
    text-decoration: none;
    color: var(--s-deep);
}

/* ============================================
   ABOUT CARD
============================================ */

.s-about-card {
    background: #fff;
    border-radius: 24px;
    padding: 30px;
    border: 1px solid var(--s-border);
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

/* ============================================
   BOARD
============================================ */

.s-school-board {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px dashed var(--s-border);
    flex-wrap: wrap;
}

.s-board-actions {
    display: flex;
    gap: 10px;
}

.s-school-board-link {
    background: var(--s-deep);
    color: #fff;
    padding: 9px 20px;
    border-radius: 50px;
    text-decoration: none;
}

.s-school-board-link.alt {
    background: #eee;
    color: #333;
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

@media(max-width:768px){

    .s-professor-card{
        grid-template-columns:1fr;
    }

    .s-prof-photo-wrap{
        padding:30px 0;
    }

    .s-prof-photo-circle{
        width:180px;
        height:180px;
    }

    .s-prof-info{
        padding:20px;
    }
}

</style>

<?php get_footer(); ?>