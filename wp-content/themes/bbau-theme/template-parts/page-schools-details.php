<?php
/**
 * Template Name: School Details Template 
 */
defined('ABSPATH') || exit;

// Fetch data from API
$slug = get_query_var('school_slug');
if (empty($slug)) {
    $slug = isset($_GET['slug']) ? sanitize_title($_GET['slug']) : '';
}

$tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'about';

$api_base = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$base_url = home_url('/schools/');

$school_data = array();
if (!empty($slug)) {
    $api_url = $api_base . '/api/v1/schools/' . urlencode($slug) . '/';
    $response = wp_remote_get($api_url, array('timeout' => 10));
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $school_data = json_decode(wp_remote_retrieve_body($response), true);
    }
}

if (empty($school_data)) {
    get_header();
    echo '<div class="container py-5 text-center"><h2>School not found.</h2></div>';
    get_footer();
    return;
}

$committees_url = $api_base . '/api/v1/school-board-committees/?school__slug=' . urlencode($slug);
$minutes_url = $api_base . '/api/v1/school-board-minutes/?school__slug=' . urlencode($slug);
$committees_res = wp_remote_get($committees_url, array('timeout' => 10));
$minutes_res = wp_remote_get($minutes_url, array('timeout' => 10));
if (!is_wp_error($committees_res) && wp_remote_retrieve_response_code($committees_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($committees_res), true);
    $committees = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
if (!is_wp_error($minutes_res) && wp_remote_retrieve_response_code($minutes_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($minutes_res), true);
    $minutes = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
// Prepare variables
$name = esc_html($school_data['name']);
$about_school = $school_data['about_school'];
$dean_message = $school_data['dean_message'];
$departments = $school_data['departments'] ?: [];
$leadership_title = $school_data['leadership_title']; 

$centers_api = $api_base . "/api/v1/centres/";
$centers_response = wp_remote_get($centers_api);

$matched_centres = []; // final array

if (!is_wp_error($centers_response)) {
    $centers_data = json_decode(wp_remote_retrieve_body($centers_response), true);

    if (is_array($centers_data)) {
        foreach ($centers_data as $center) {
            if (
                isset($center['school_name']) &&
                $center['school_name'] === $name
            ) {
                $matched_centres[] = [
                    'name' => $center['name'],
                    'slug' => $center['slug']
                ];
            }
        }
    }
}
// $centers = $school_data['centres'] ?: [];

// Dean Info
$dean = $school_data['dean'] ?: [];
$dean_name = $dean['name'] ?: 'Dean Name';
$dean_photo = $dean['photo'];
$dean_phone1 = $dean['phone1'];
$dean_phone2 = $dean['phone2'];
$dean_email = $dean['insti_email'];
$dean_email2 = $dean['other_email'];
$dean_url = home_url('/faculty/' . ($dean['slug'] ?: ''));

// Filter Departments
$main_departments = array_filter($departments, function($d) { 
    return stripos($d['campus'], 'Amethi') === false; 
});
$amethi_departments = array_filter($departments, function($d) { 
    return stripos($d['campus'], 'Amethi') !== false; 
});

get_header();
?>

<!-- BANNER -->
<?php get_template_part('banners/about-banner'); ?>

<!-- MAIN WRAPPER (Department Style) -->
<div class="dept-page-wrapper py-lg-5">
    <div class="container">

        <!-- NAVIGATION TABS -->
        <div class="dept-nav">
            <?php 
            function school_tab_url($slug, $target_tab) {
                global $wp;
                return esc_url(add_query_arg(['tab' => $target_tab], home_url($wp->request)));
            }
            ?>
            <a href="<?php echo school_tab_url($slug, 'about'); ?>"
                class="<?php echo ($tab === 'about') ? 'active' : ''; ?>">About & Dean</a>
            <a href="<?php echo school_tab_url($slug, 'departments'); ?>"
                class="<?php echo ($tab === 'departments') ? 'active' : ''; ?>">Departments</a>
            <?php if (!empty($matched_centres)): ?>
            <a href="<?php echo school_tab_url($slug, 'centers'); ?>"
                class="<?php echo ($tab === 'centers') ? 'active' : ''; ?>">Centers</a>
            <?php endif; ?>
            <a href="<?php echo school_tab_url($slug, 'committee'); ?>"
                class="<?php echo ($tab === 'committee') ? 'active' : ''; ?>">Committees</a>
        </div>

        <!-- TAB CONTENT -->
        <div class="tab-content-area py-4">

            <?php if ($tab === 'about') : ?>
            <!-- DEAN CARD (HOD STYLE) -->
            <div class="hod-card">
                <div class="hod-left">
                    <div class="avatar">
                        <?php if ($dean_photo) : ?>
                        <img src="<?php echo esc_url($media_base . $dean_photo); ?>" alt="Dean Photo">
                        <?php else : ?>
                        <i class="fas fa-user-tie" style="font-size: 80px; color: rgba(255,255,255,0.3);"></i>
                        <?php endif; ?>
                    </div>
                    <div class="hod-badge"><?php echo strtoupper($leadership_title); ?></div>
                </div>
                <div class="hod-right">
                    <div class="name"><?php echo $dean_name; ?></div>
                    <div class="role"><?php echo  $leadership_title; ?> of School</div>
                    <div class="contacts">
                    <div class="contact-row">
                        <?php if ($dean_phone1) : ?>
                            <span class="label">Phone1:</span>
                            <span class="icon"><i class="fa fa-phone"></i></span>
                            <span class="value"><a
                                    href="tel:<?php echo esc_attr($dean_phone1); ?>">+91 <?php echo esc_html($dean_phone1); ?></a></span>
                        <?php endif; ?>
                        <?php if ($dean_phone2) : ?>
                            <span class="label">Phone2:</span>
                            <span class="icon"><i class="fa fa-phone"></i></span>
                            <span class="value"><a
                                    href="tel:<?php echo esc_attr($dean_phone2); ?>">+91 <?php echo esc_html($dean_phone2); ?></a></span>
                        <?php endif; ?>
                        </div>
                        <?php if ($dean_email) : ?>
                        <div class="contact-row">
                            <span class="label">Email:</span>
                            <span class="icon"><i class="fa fa-envelope"></i></span>
                            <span class="value"><a
                                    href="mailto:<?php echo esc_attr($dean_email); ?>"><?php echo esc_html($dean_email); ?></a></span>
                        </div>
                        <?php endif; ?>
                        <?php if ($dean_email2) : ?>
                        <div class="contact-row">
                            <span class="label">Email:</span>
                            <span class="icon"><i class="fa fa-envelope"></i></span>
                            <span class="value"><a
                                    href="mailto:<?php echo esc_attr($dean_email2); ?>"><?php echo esc_html($dean_email2); ?></a></span>
                        </div>
                        <?php endif; ?>
                        <div class="contact-row mt-3">
                            <span class="value"><a href="<?php echo $dean_url; ?>" class="btn-profile">View Profile
                                    <i class="fa-solid fa-arrow-right"></i></a></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DEAN MESSAGE -->
            <?php if ($dean_message) : ?>
            <div class="section-card mb-5">
                <h3 class="dept-title-gradient">Dean's Message</h3>
                <div class="message-content">
                    <?php echo wp_kses_post($dean_message); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- ABOUT SCHOOL -->
            <?php if ($about_school) : ?>
            <div class="section-card">
                <h3 class="dept-title-gradient">About the School</h3>
                <div class="about-content">
                    <?php echo wp_kses_post($about_school); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php elseif ($tab === 'departments') : ?>
            <!-- MAIN CAMPUS -->
            <div class="section-card mb-5">
                <h3 class="dept-title-gradient">Departments (Main Campus)</h3>
                <div class="dept-list-modern">
                    <?php foreach ($main_departments as $dept) : ?>
                    <a href="<?php echo esc_url(home_url('/departments/' . $dept['slug'])); ?>" class="dept-link-item">
                        <span><?php echo esc_html($dept['name']); ?></span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- AMETHI CAMPUS -->
            <?php if (!empty($amethi_departments)) : ?>
            <div class="section-card">
                <h3 class="dept-title-gradient">Departments (Amethi)</h3>
                <div class="dept-list-modern">
                    <?php foreach ($amethi_departments as $dept) : ?>
                    <a href="<?php echo esc_url(home_url('/departments/' . $dept['slug'])); ?>"
                        class="dept-link-item amber">
                        <span><?php echo esc_html($dept['name']); ?></span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php elseif ($tab === 'centers') : ?>
            <div class="section-card">
                <h3 class="dept-title-gradient">Centers under <?php ?> </h3>
                <div class="centers-grid-modern">
                    <?php foreach ($matched_centres as $center) : ?>
                    <a href="/centers/<?php echo esc_attr($center['slug'] ); ?>" class="center-box">
                        <!-- <div class="center-icon"></div> -->
                        <h4><?php echo esc_html($center['name']); ?></h4>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php elseif ($tab === 'committee') : ?>
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <!-- COMMITTEES -->
                    <h3 class="dept-title-gradient">School Committees</h3>

                    <?php if(!empty($committees)): ?>
                    <div class="committees-wrap">
                        <?php foreach ($committees as $comm) : ?>
                        <div class="committee-card">
                            <div class="committee-header">
                                <h4><?php echo esc_html($comm['name']); ?></h4>
                            </div>
                            <div class="committee-body">
                                <?php if(!empty($comm['description'])): ?>
                                <div class="committee-desc"><?php echo wp_kses_post($comm['description']); ?>
                                    <?php endif; ?>
                                    <?php if(!empty($comm['notification_or_document'])): ?>
                                    <p>Committee Notification:<a class="link-new"
                                            href=<?php echo ($comm['notification_or_document']); ?>> &nbsp; View
                                            Notification </a></p>
                                    <?php endif; ?>
                                </div>

                                <?php if(!empty($comm['members'])): ?>
                                <table class="members-table">
                                    <thead>
                                        <tr>
                                            <th>Member Name</th>
                                            <th>Role in Committee</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($comm['members'] as $member): ?>
                                        <tr>
                                            <td><strong><?php echo esc_html($member['members']); ?></strong></td>
                                            <td>
                                                <span class="role-badge">
                                                    <?php echo esc_html($member['designation'] === 'Others' ? $member['other_designation'] : $member['designation']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif;?>
                </div>
                <div class="col-lg-6 mb-3">
                    <h3 class="dept-title-gradient"> Minutes of Meetings</h3>
                    <?php if (!empty($minutes)) : ?>

                    <div class="section-card">
                        <div class="minutes-list-modern">
                            <?php foreach ($minutes as $min) : ?>
                            <a href="<?php echo esc_url( $min['minutes']); ?>" class="minute-row" target="_blank">
                                <div class="min-date">
                                    <span class="d"><?php echo date('d', strtotime($min['date_of_meeting'])); ?></span>
                                    <span class="m"><?php echo date('M', strtotime($min['date_of_meeting'])); ?></span>

                                </div>
                                <div class="min-info">
                                    <strong><?php echo esc_html(!empty($min['meeting_title']) ? $min['meeting_title'] : 'Board Meeting'); ?></strong>
                                    <span>Download PDF <i class="fa-solid fa-file-pdf"></i></span>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>


                </div>
            </div>


            <!-- MINUTES -->

            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>

<style>
/* ================= PAGE BACKGROUND ================= */
.dept-page-wrapper {
    background: #f7f4ef;
    min-height: 80vh;
}


.committees-wrap {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.committee-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
}

.committee-header {
    background: linear-gradient(135deg, #5c1010, #8B1A1A);
    padding: 15px 40px;
    color: #fff;
}

.committee-header h4 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
}

.committee-body {
    padding: 25px;
}

.committee-desc {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
    border-bottom: 2px solid #f3f4f6;
}

.members-table {
    width: 100%;
    border-collapse: collapse;
}

.members-table th {
    text-align: left;
    padding: 12px;
    background: #fdfaf6;
    font-size: 0.85rem;
    text-transform: uppercase;
    color: #8B1A1A;
    font-weight: 700;
}

.members-table td {
    padding: 12px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.95rem;
    color: #333;
}

.role-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #f1f5f9;
    color: #475569;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 20px;
    text-transform: uppercase;
}

/* ================= MENU ================= */
.dept-nav {
    background: linear-gradient(90deg, #8B1A1A, #5c1010);
    display: flex;
    overflow-x: auto;
    padding: 0 20px;
    border-radius: 10px;
    margin: -30px 0 25px;
    /* Offset to overlap banner */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 10;
}

.dept-nav::-webkit-scrollbar {
    display: none;
}

.dept-nav a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    padding: 18px 25px;
    white-space: nowrap;
    transition: 0.3s;
    border-bottom: 4px solid transparent;
}

.dept-nav a:hover,
.dept-nav a.active {
    color: #fff;
    border-bottom: 4px solid #c9a84c;
    background: rgba(255, 255, 255, 0.05);
}

/* ================= CARDS & SECTIONS ================= */
.section-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
}

.dept-title-gradient {
    font-family: 'Merriweather', serif;
    font-size: 28px;
    font-weight: 700;
    color: #5c1010;
    position: relative;
    display: inline-block;
    margin-bottom: 30px;
}

.dept-title-gradient::after {
    content: "";
    display: block;
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, #8B1A1A, #c9a84c);
    margin-top: 10px;
    border-radius: 2px;
}

/* ================= DEAN CARD (HOD STYLE) ================= */
.hod-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 14px;
    display: flex;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(139, 26, 26, .08);
    margin: 0 auto 40px;
    max-width: 800px;
    transition: 0.3s;
}

.hod-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 50px rgba(139, 26, 26, .15);
}

.hod-left {
    background: linear-gradient(160deg, #5c1010, #8B1A1A);
    width: 280px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 15px;
    padding: 40px 20px;
}

.avatar {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    border: 4px solid #c9a84c;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: inherit;
}

.hod-badge {
    background: #c9a84c;
    color: #5c1010;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    padding: 6px 16px;
    border-radius: 20px;
}

.hod-right {
    padding: 40px;
    flex: 1;
}

.hod-right .name {
    font-family: 'Merriweather', serif;
    font-size: 26px;
    font-weight: 700;
    color: #5c1010;
    margin-bottom: 5px;
}

.hod-right .role {
    font-size: 16px;
    color: #8B1A1A;
    font-weight: 600;
    margin-bottom: 25px;
}

.contact-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 15px;
}

.contact-row .label {
    font-weight: 700;
    color: #5c1010;
    min-width: 60px;
}

.contact-row .icon {
    color: #c9a84c;
}

.contact-row a {
    color: #666;
    text-decoration: none;
}

.contact-row a:hover {
    color: #8B1A1A;
}

.btn-profile {
    display: inline-block;
    background: #8B1A1A;
    color: #fff !important;
    padding: 8px 20px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    transition: 0.3s;
}

.btn-profile:hover {
    background: #5c1010;
    transform: scale(1.05);
}

/* ================= MODERN LISTS ================= */
.dept-list-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 15px;
}

.dept-link-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 25px;
    background: #f8f9fa;
    border-radius: 12px;
    text-decoration: none !important;
    color: #5c1010 !important;
    font-weight: 700;
    transition: 0.3s;
    border-left: 5px solid #8B1A1A;
}

.dept-link-item:hover {
    background: #8B1A1A;
    color: #fff !important;
    transform: translateX(10px);
}

.dept-link-item.amber {
    border-left-color: #c9a84c;
}

.centers-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.center-box {
    text-align: center;
    padding: 30px;
    background: #fff;
    border: 2px solid #f0eee9;
    border-radius: 20px;
    text-decoration: none !important;
    transition: 0.3s;
}

.center-box:hover {
    border-color: #c9a84c;
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

/* .center-icon {
    font-size: 2.5rem;
    color: #c9a84c;
    margin-bottom: 15px;
} */

.center-box h4 {
    color: #5c1010;
    font-size: 1.1rem;
    font-weight: 700;
}

.minute-row {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 15px;
    background: #fdfbf7;
    border-radius: 12px;
    margin-bottom: 12px;
    text-decoration: none !important;
    transition: 0.2s;
}

.minute-row:hover {
    background: #fff;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transform: scale(1.01);
}

.min-date {
    background: #8B1A1A;
    color: #fff;
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.min-date .d {
    font-weight: 800;
    font-size: 20px;
    line-height: 1;
}

.min-date .m {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.min-info strong {
    display: block;
    color: #5c1010;
    font-size: 16px;
}

.min-info span {
    font-size: 13px;
    color: #8B1A1A;
    font-weight: 600;
}

@media (max-width: 768px) {
    .hod-card {
        flex-direction: column;
    }

    .hod-left {
        width: 100%;
        padding: 30px;
    }

    .school-hero-title {
        font-size: 2rem;
    }
}
</style>