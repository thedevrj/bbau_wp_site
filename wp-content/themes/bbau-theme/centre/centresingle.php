<?php
/*
Template Name: Centre Single Page Template
*/
defined('ABSPATH') || exit;

$slug = get_query_var('centre_slug');
if (empty($slug)) {
    $slug = isset($_GET['slug']) ? sanitize_title($_GET['slug']) : '';
}
$tab  = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'about';

$api_base = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$centre_data = array();

// Fetch base centre profile
if (!empty($slug)) {
    $centre_url = $api_base . '/api/v1/centres/' . urlencode($slug) . '/';
    $centre_res = wp_remote_get($centre_url, array('timeout' => 10));
    if (!is_wp_error($centre_res) && wp_remote_retrieve_response_code($centre_res) === 200) {
        $centre_data = json_decode(wp_remote_retrieve_body($centre_res), true);
    }
}

// Ensure valid tab
$allowed_tabs = ['about','thrust' ,'faculty', 'programs', 'research', 'notices', 'committees', 'gallery', 'timetable'];
if (!in_array($tab, $allowed_tabs)) {
    $tab = 'about';
}

get_header();
?>

<?php $page_id = get_the_Id(); ?>
<div class="container-fluid position-relative px-0 overflow-hidden">
    <img src="<?php echo get_field('desktop_1x', $page_id); ?>"
        srcset="<?php echo get_field('desktop_1x', $page_id); ?>"
        class="img-fluid d-lg-block d-none h_xl_250 object-fit-cover" alt="<?php the_title();?> Banner" width="100%" height="250">

    <!-- Mobile Image (only show if mobile_1x exists) -->
    <?php if(get_field('mobile_1x', $page_id)) : ?>
    <img src="<?php echo get_field('mobile_1x', $page_id); ?>" srcset="<?php echo get_field('mobile_1x', $page_id); ?> "
        class="img-fluid d-lg-none h_sm_204" alt="<?php the_title();?> Banner" width="100%" height="204">
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-lg-0 mt-md-5 pe-md-0 pe-5 subpage-hero-text position-absolute max_xl_w_498">
                <h1
                    class="d-block mt-0 mb-0 color_white text_medium sm_text_32 sm_line_height_38 text_40 line_height_48 text-capitalize me-lg-0 me-5 pe-lg-0 pe-5">
                    <?php echo esc_html(get_centre_display_name($centre_data)); ?></h1>

            </div>
        </div>
    </div>
</div>

<?php if (empty($centre_data)): ?>
    <div class="container py-5" style="text-align:center; min-height: 50vh;">
        <h2>Centre not found or slug not provided.</h2>
        <p>Please access this page through a valid centre link.</p>
    </div>
<?php else: ?>

<!--  PAGE WRAPPER (Scoped Styling) -->
<div class="centre-page-wrapper container-fluid py-lg-5">

    <!--  MENU AFTER BREADCRUMB -->
    <div class="container">
        <div class="centre-nav">
            <?php 
            function centre_nav_url($slug, $target_tab) {
                global $wp;
                return esc_url(add_query_arg(['tab' => $target_tab], home_url($wp->request)));
            }
            ?>
            <a href="<?php echo centre_nav_url($slug, 'about'); ?>" class="<?php echo ($tab === 'about') ? 'active' : ''; ?>">About</a>
            <a href="<?php echo centre_nav_url($slug, 'thrust'); ?>" class="<?php echo ($tab === 'thrust') ? 'active' : ''; ?>">Thrust Areas</a>
            <a href="<?php echo centre_nav_url($slug, 'programs'); ?>" class="<?php echo ($tab === 'programs') ? 'active' : ''; ?>">Programmes</a>
            <a href="<?php echo centre_nav_url($slug, 'faculty'); ?>" class="<?php echo ($tab === 'faculty') ? 'active' : ''; ?>">People</a>
            <a href="<?php echo centre_nav_url($slug, 'notices'); ?>" class="<?php echo ($tab === 'notices') ? 'active' : ''; ?>">Notices</a>
            <a href="<?php echo centre_nav_url($slug, 'research'); ?>" class="<?php echo ($tab === 'research') ? 'active' : ''; ?>">Research Activities</a>
            <a href="<?php echo centre_nav_url($slug, 'timetable'); ?>" class="<?php echo ($tab === 'timetable') ? 'active' : ''; ?>">Time Table</a>
            <a href="<?php echo centre_nav_url($slug, 'committees'); ?>" class="<?php echo ($tab === 'committees') ? 'active' : ''; ?>">Committees</a>
            <a href="<?php echo centre_nav_url($slug, 'gallery'); ?>" class="<?php echo ($tab === 'gallery') ? 'active' : ''; ?>">Gallery</a>
        </div>
    </div>

    <div class="container py-4">

        <?php 
        // DYNAMIC INCLUSION OF TAB FILE
        $tab_file = get_stylesheet_directory() . "/centre/tab-{$tab}.php";
        if(file_exists($tab_file)) {
            include($tab_file);
        } else {
            echo "<p>Content module not found.</p>";
        }
        ?>

    </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>


<style>

.centre-page-wrapper {
    background: #f7f4ef;
}

/*  MENU  */
.centre-nav {
    background: linear-gradient(90deg, #8B1A1A, #5c1010);
    display: flex;
    overflow-x: auto;
    padding: 0 20px;
    border-radius: 10px;
    margin: 15px 0 25px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    scrollbar-width: none;
}

.centre-nav::-webkit-scrollbar {
    display: none;
}

.centre-nav a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-size: 15.5px;
    font-weight: 500;
    padding: 14px 18px;
    white-space: nowrap;
    border-bottom: 3px solid transparent;
    transition: 0.3s;
}

.centre-nav a:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.08);
    border-bottom: 5px solid #c9a84c;
}

.centre-nav a.active {
    color: #fff;
    border-bottom: 3px solid #c9a84c;
}

.page-title {
    font-family: 'Merriweather', serif;
    font-size: 26px;
    font-weight: 700;
    color: #5c1010;
    margin-bottom: 28px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2d9cc;
    text-align: left;
}

.head-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 14px;
    display: flex;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(139, 26, 26, .09);
    margin: 0 auto 32px;
    max-width: 700px;
    transition: 0.3s;
}
.centre-page-wrapper .centre-title-gradient {
  font-family: 'Merriweather', serif;
  font-size: 32px;
  font-weight: 700;
  color: #5c1010;

  position: relative;
  display: inline-block;
  margin-bottom: 20px;
}

/*  UNDERLINE */
.centre-page-wrapper .centre-title-gradient::after {
  content: "";
  display: block;
  width: 180px;
  height: 4px;
  background: linear-gradient(90deg, #8B1A1A, #c9a84c); /* 🔥 red → gold */
  margin-top: 8px;
  border-radius: 2px;
}
.avatar {
    overflow: hidden;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: inherit;
}

.head-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(139, 26, 26, .18);
}

/* LEFT */
.head-left {
    background: linear-gradient(160deg, #5c1010, #8B1A1A);
    width: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 40px 24px;
}

.avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 5px solid #c9a84c;
    overflow: hidden;
}   

.head-badge {
    background: #c9a84c;
    color: #5c1010;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    padding: 6px 16px;
    border-radius: 20px;
}

.head-right {
    padding: 30px 35px;
}

.head-right .name {
    font-family: 'Merriweather', serif;
    font-size: 24px;
    font-weight: 700;
    color: #5c1010;

}

.head-right .role {
    font-size: 15px;
    color: #8B1A1A;
    margin-bottom: 18px;
    font-weight: 500;
}

/* CONTACT WRAPPER */
.contacts {
    display: flex;
    flex-direction: column;

    margin-top: 10px;
}

/* EACH ROW */
.contact-row {
    display: flex;
    align-items: center;
    font-size: 15px;
    color: #555;
}

.icon {
    width: 24px;
    text-align: center;
}

.label {
    min-width: 70px;
    font-weight: 600;
    color: #5c1010;
}

/* VALUE */
.value {
    color: #555;
}

/* LINKS */
.value a {
    color: #8B1A1A;
    text-decoration: none;
}

.value a:hover {
    text-decoration: underline;
}

.section h3 {
    font-family: 'Merriweather', serif;
    color: #5c1010;
    border-bottom: 1px solid #e2d9cc;
}

.section p {
    color: #555;
    line-height: 1.8;
}

.committee-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.committee-text {
    font-size: 15px;
    color: #444;
}

.committee-link {
    font-size: 14px;
    font-weight: 600;
    color: #8B1A1A;
    text-decoration: none;
    white-space: nowrap;
}

.committee-link:hover {
    color: #5c1010;
}

@media (max-width: 580px) {
    .head-card {
        flex-direction: column;
    }

    .head-left {
        width: 100%;
        flex-direction: row;
        padding: 20px;
    }
}
</style>