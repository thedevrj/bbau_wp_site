<?php
/**
 * Template Name: Satellite Campus Landing Page
 */
defined('ABSPATH') || exit;

get_header();

// ACF Fields
$banner = get_field('campus_banner');
$about = get_field('about_campus');

// API Data
$api_base = getenv('DJANGO_API_URL');
$depts_url = $api_base . '/api/v1/departments/?campus=' . urlencode('Satellite Campus Amethi');
$depts_res = wp_remote_get($depts_url, array('timeout' => 10));
$departments = array();

if (!is_wp_error($depts_res) && wp_remote_retrieve_response_code($depts_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($depts_res), true);
    $departments = isset($decoded['results']) ? $decoded['results'] : $decoded;
}
?>

<div class="satellite-campus-portal">

    <!-- HERO SECTION -->
    <div class="sc-hero" style="background-image: url('<?php echo esc_url($banner); ?>');">
        <div class="sc-hero-overlay">
            <div class="sc-hero-card">
                <span class="sc-badge">Satellite Centre</span>
                <h1>Amethi </h1>
                <div class="sc-hero-line"></div>
            </div>
        </div>
    </div>

    <div class="container py-lg-5">

        <!-- BREADCRUMB -->
        <div class="sc-breadcrumb-wrap mb-5">
            <?php get_template_part('template-parts/breadcrumb'); ?>
        </div>

        <div class="row g-5">
            <div class="col-lg-4">
                <aside class="sc-sidebar">

                    <div class="sc-leadership-slider-mobile">
                        <?php 
                    if(have_rows('campus_leadership')):
                        while(have_rows('campus_leadership')): the_row();
                        $name = get_sub_field('name');
                        $designation = get_sub_field('designation');
                        $photo = get_sub_field('photo');
                    ?>
                        <div class="sc-osd-card-wrap pb-4">
                            <div class="sc-osd-card">
                                <div class="sc-osd-photo mt-3">
                                    <?php if($photo): ?>
                                    <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($name); ?>">
                                    <?php else: ?>
                                    <div class="sc-placeholder"><i class="fa-solid fa-user-tie"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div class="sc-osd-body">
                                    <h3><?php echo esc_html($name); ?></h3>
                                    <span class="sc-osd-desig"><?php echo esc_html($designation); ?></span>
                                    <div class="sc-osd-line"></div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        endwhile;
                    endif;
                    ?>
                    </div>



                </aside>
            </div>
            <!-- LEFT: ABOUT & DEPARTMENTS -->
            <div class="col-lg-8">

                <!-- ABOUT SECTION -->
                <section class="sc-section mb-5">
                    <h2 class="sc-section-title">About the Campus</h2>
                    <div class="sc-content-card">
                        <div class="sc-rich-text">
                            <?php echo wp_kses_post($about); ?>
                        </div>
                    </div>
                </section>

                <!-- DEPARTMENTS SECTION -->
                <section class="sc-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="sc-section-title mb-0">Explore Departments</h2>
                        <span class="sc-count-badge"><?php echo count($departments); ?> Departments</span>
                    </div>

                    <div class="sc-dept-grid">
                        <?php if(!empty($departments)): ?>
                        <?php foreach($departments as $dept): ?>
                        <a href="/departments/<?php echo esc_attr($dept['slug']); ?>" class="sc-dept-card">
                            <div class="sc-dept-icon">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div class="sc-dept-info">
                                <h3><?php echo esc_html(get_dept_display_name($dept)); ?></h3>
                                <span class="sc-view-link">View Department <i
                                        class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p>No departments currently listed for this campus.</p>
                        <?php endif; ?>
                    </div>
                </section>

            </div>

            <!-- RIGHT: OSD SPOTLIGHT -->

        </div>

    </div>
</div>

<style>
/* ============================================
   SATELLITE CAMPUS - PREMIUM CSS
============================================ */

:root {
    --sc-midnight: #0f172a;
    --sc-slate: #1e293b;
    --sc-gold: #c9a84c;
    --sc-gold-light: #e2d9cc;
    --sc-accent: #334155;
    --sc-bg: #fdfaf6;
    --sc-white: #ffffff;
}

.satellite-campus-portal {
    background-color: var(--sc-bg);
    padding-bottom: 80px;
    font-family: 'Nunito', sans-serif;
}

/* --- HERO --- */
.sc-hero {
    height: 350px;
    background-size: contain;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sc-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.7));
}

.sc-hero-overlay {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 800px;
    padding: 20px;
}

.sc-hero-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 25px;
    border-radius: 30px;
    text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    color: #fff;
    animation: fadeInScale 0.8s ease-out;
}

.sc-badge {
    background: var(--sc-gold);
    color: var(--sc-midnight);
    padding: 6px 20px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: inline-block;
    margin-bottom: 15px;
}

.sc-hero-card h1 {
    font-family: 'Merriweather', serif;
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 10px;
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
}

.sc-hero-card p {
    font-size: 1.2rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    opacity: 0.9;
}

.sc-hero-line {
    width: 80px;
    height: 4px;
    background: var(--sc-gold);
    margin: 20px auto 0;
    border-radius: 2px;
}

/* --- SECTIONS --- */
.sc-section-title {
    font-family: 'Merriweather', serif;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--sc-midnight);
    margin-bottom: 25px;
    position: relative;
    display: inline-block;
}

.sc-section-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -8px;
    width: 50px;
    height: 3px;
    background: var(--sc-gold);
    border-radius: 2px;
}

.sc-content-card {
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    border: 1px solid var(--sc-gold-light);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.sc-rich-text {
    line-height: 1.8;
    color: var(--sc-slate);
    font-size: 0.9rem;
}

/* --- DEPT GRID --- */
.sc-dept-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.sc-dept-card {
    background: #fff;
    border: 1px solid var(--sc-gold-light);
    padding: 25px;
    border-radius: 18px;
    display: flex;
    align-items: stretch;
    /* 🔥 Changed from center to stretch */
    gap: 20px;
    text-decoration: none !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    /* 🔥 Ensures card heights are consistent */
}

.sc-dept-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px -10px rgba(139, 26, 26, 0.15);
    border-color: var(--sc-gold);
}

.sc-dept-icon {
    width: 60px;
    height: 60px;
    background: #f8fafc;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--sc-midnight);
    transition: 0.3s;
}

.sc-dept-card:hover .sc-dept-icon {
    background: var(--sc-midnight);
    color: var(--sc-gold);
}

.sc-dept-info {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.sc-dept-info h3 {
    font-family: 'Merriweather', serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--sc-midnight);
    margin: 0 0 15px;
    /* 🔥 Increased margin */
}

.sc-view-link {
    font-size: 0.8rem;
    /* 🔥 Slightly smaller for single line */
    font-weight: 700;
    color: var(--sc-gold);
    display: flex;
    align-items: center;
    gap: 8px;
    opacity: 0.8;
    margin-top: auto;
    white-space: nowrap;
    /* 🔥 Prevents breaking into two lines */
}

.sc-count-badge {
    background: var(--sc-midnight);
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
}

/* --- OSD CARD --- */
.sc-osd-card {
    background: var(--sc-midnight);
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);
    color: #fff;
    width: 340px;
}


.osd-label {
    text-transform: uppercase;
    letter-spacing: 3px;
    font-size: 10px;
    font-weight: 700;
    color: var(--sc-gold);
}

.sc-osd-photo {
    width: 180px;
    /* 🔥 Fixed width for circular shape */
    height: 180px;
    /* 🔥 Fixed height for circular shape */
    margin: 0 auto 20px;
    /* 🔥 Centered */
    border-radius: 50%;
    /* 🔥 CRITICAL: Circular */
    overflow: hidden;
    background: #1e293b;
    border: 3px solid var(--sc-gold);
    /* 🔥 Premium gold ring */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.sc-osd-photo img {
    width: 100%;
    height: 100%;
    object-fit: inherit;
}

.sc-osd-placeholder {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5rem;
    color: rgba(255, 255, 255, 0.1);
}

.sc-osd-body {
    padding: 30px;
    text-align: center;
}

.sc-osd-body {
    padding: 10px 20px 15px;
    /* 🔥 Refined padding */
    text-align: center;
}

.sc-osd-body h3 {
    font-family: 'Merriweather', serif;
    font-size: 1.3rem;
    /* 🔥 More professional size */
    font-weight: 700;
    margin-bottom: 5px;
}

.sc-osd-desig {
    color: var(--sc-gold);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.75rem;
}

.sc-osd-line {
    width: 30px;
    height: 2px;
    background: var(--sc-gold);
    margin: 15px auto;
    opacity: 0.6;
}

@media (min-width: 991px) and (max-width: 1200px) {
    .sc-osd-card {
        width: auto !important;
    }
}

.sc-contact-mini {
    .c-line {
        width: 30px;
        height: 2px;
        background: var(--sc-gold);
        margin: 10px 0 15px;
    }

    /* ANIMATIONS */
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @media (max-width: 991px) {
        .sc-osd-card {
            margin: 0 10px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            padding: 20px 10px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sc-osd-photo {
            width: 140px !important;
            height: 140px !important;
        }

        .sc-osd-body h3 {
            font-size: 1.1rem !important;
        }

        .sc-hero-card h1 {
            font-size: 2rem;
        }
    }
}
</style>

<?php get_footer(); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function($) {
    function initLeadershipSlider() {
        if ($(window).width() < 991) {
            if (!$('.sc-leadership-slider-mobile').hasClass('slick-initialized')) {
                $('.sc-leadership-slider-mobile').slick({
                    dots: true,
                    infinite: false,
                    speed: 300,
                    slidesToShow: 1,
                    centerMode: true,
                    // variableWidth: true,
                    // arrows: false
                });
            }
        } else {
            if ($('.sc-leadership-slider-mobile').hasClass('slick-initialized')) {
                $('.sc-leadership-slider-mobile').slick('unslick');
            }
        }
    }

    initLeadershipSlider();
    $(window).on('resize', initLeadershipSlider);
});
</script>