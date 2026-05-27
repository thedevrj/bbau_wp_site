<?php
/*
Template Name: Faculty Directory
*/
defined('ABSPATH') || exit;
get_header();

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');

// Build API URL with query parameters from the URL
$query_params = array();
if (!empty($_GET['search']))          $query_params['search'] = sanitize_text_field($_GET['search']);
if (!empty($_GET['department']))      $query_params['department__slug'] = sanitize_text_field($_GET['department']);
if (!empty($_GET['school']))          $query_params['school__slug'] = sanitize_text_field($_GET['school']);
if (!empty($_GET['campus']))          $query_params['campus'] = sanitize_text_field($_GET['campus']);
if (!empty($_GET['page_num']))        $query_params['page'] = intval($_GET['page_num']);

$api_url = $api_base . '/api/v1/faculty/?' . http_build_query($query_params);

$response = wp_remote_get($api_url, array('timeout' => 15));
$faculty_list = array();
$total_count = 0;
$next_page = null;
$prev_page = null;

if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($response), true);
    $faculty_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
    $total_count = isset($decoded['count']) ? $decoded['count'] : count($faculty_list);
    $next_page = isset($decoded['next']) ? $decoded['next'] : null;
    $prev_page = isset($decoded['previous']) ? $decoded['previous'] : null;
}

// Fetch schools and departments for filter dropdowns (fetch all, not paginated)
$schools_res = wp_remote_get($api_base . '/api/v1/schools/?page_size=500', array('timeout' => 10));
$schools_list = array();
if (!is_wp_error($schools_res) && wp_remote_retrieve_response_code($schools_res) === 200) {
    $s_decoded = json_decode(wp_remote_retrieve_body($schools_res), true);
    $schools_list = isset($s_decoded['results']) ? $s_decoded['results'] : (is_array($s_decoded) ? $s_decoded : array());
}

$depts_res = wp_remote_get($api_base . '/api/v1/departments/?page_size=500', array('timeout' => 10));
$depts_list = array();
if (!is_wp_error($depts_res) && wp_remote_retrieve_response_code($depts_res) === 200) {
    $d_decoded = json_decode(wp_remote_retrieve_body($depts_res), true);
    $depts_list = isset($d_decoded['results']) ? $d_decoded['results'] : (is_array($d_decoded) ? $d_decoded : array());
}

$current_page = isset($_GET['page_num']) ? max(1, intval($_GET['page_num'])) : 1;
$total_pages = ($total_count > 0) ? ceil($total_count / 20) : 1;
?>

<!-- PREMIUM HERO BANNER -->
<section class="premium-hero-fac">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="fac-content-glass animate-fac-up">
            <div class="badge-fac">Academic Excellence</div>
            <h1 style="font-size: 2rem;">Faculty Directory</h1>
        </div>
    </div>
</section>

<main id="primary" class="site-main faculty-directory" style="background:#fdfaf6; padding-bottom:60px;">
    <div class="container pt-4">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <!-- PREMIUM GLASS FILTERS -->
        <div class="faculty-glass-filters animate-fac-up mt-5" style="animation-delay: 0.1s;">
            <form method="GET" action="" id="faculty-filter-form" class="w-100 d-flex flex-wrap gap-4 align-items-end">
                <div class="faculty-search-box" style="flex: 1; min-width: 300px;">
                    <i class="fas fa-search faculty-search-icon"></i>
                    <input type="text" name="search" placeholder="Search by name, expertise or designation..."
                        value="<?php echo esc_attr($_GET['search'] ?? ''); ?>" autocomplete="off">
                </div>

                <div class="faculty-filter-group" style="flex: 2;">
                    <div class="faculty-filter-item">
                        <label>School</label>
                        <select name="school" class="faculty-select" onchange="this.form.submit()">
                            <option value="">All Schools</option>
                            <?php foreach ($schools_list as $s): ?>
                            <option value="<?php echo esc_attr($s['slug']); ?>"
                                <?php selected($_GET['school'] ?? '', $s['slug']); ?>>
                                <?php echo esc_html($s['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="faculty-filter-item">
                        <label>Department</label>
                        <select name="department" class="faculty-select" onchange="this.form.submit()">
                            <option value="">All Departments</option>
                            <?php foreach ($depts_list as $d): ?>
                            <option value="<?php echo esc_attr($d['slug']); ?>"
                                <?php selected($_GET['department'] ?? '', $d['slug']); ?>>
                                <?php echo esc_html(get_dept_display_name($d)); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="faculty-filter-item">
                        <label>Campus</label>
                        <select name="campus" class="faculty-select" onchange="this.form.submit()">
                            <option value="">All Campuses</option>
                            <option value="BBAU" <?php selected($_GET['campus'] ?? '', 'BBAU'); ?>>Main Campus (Lucknow)
                            </option>
                            <option value="Satellite Campus Amethi"
                                <?php selected($_GET['campus'] ?? '', 'Satellite Campus Amethi'); ?>>Satellite Campus
                                (Amethi)</option>
                        </select>
                    </div>
                </div>

                <div class="filter-footer-actions d-flex align-items-center gap-3 w-100 mt-2">
                    <button type="submit" class="btn-fac-profile" style="padding: 12px 30px;">Apply Filters</button>
                    <a href="<?php echo esc_url(get_permalink()); ?>"
                        class="text-muted small fw-bold text-decoration-none">Clear All</a>
                    <span class="ms-auto small fw-bold text-muted"><?php echo intval($total_count); ?> Faculty Experts
                        found</span>
                </div>
            </form>
        </div>

        <!-- Faculty Grid -->
        <?php if (!empty($faculty_list)): ?>
        <div class="faculty-dir-grid">
            <?php foreach ($faculty_list as $fac): ?>
            <a href="<?php echo esc_url(home_url('/faculty/' . ($fac['slug'] ?? ''))); ?>" class="fac-card-premium1">
                <div class="fac-image-wrap">
                    <?php if (!empty($fac['photo'])): ?>
                    <img src="<?php echo esc_url($media_base . $fac['photo']); ?>"
                        alt="<?php echo esc_attr($fac['name']); ?>">
                    <?php else: ?>
                    <div class="fac-no-photo"><i class="fas fa-user-graduate"></i></div>
                    <?php endif; ?>
                    <div class="fac-overlay-info">
                        <span
                            class="campus-pill <?php echo (($fac['campus'] ?? '') === 'Satellite Campus Amethi') ? 'amethi' : 'main'; ?>">
                            <?php echo (($fac['campus'] ?? '') === 'Satellite Campus Amethi') ? 'Amethi' : 'Lucknow'; ?>
                        </span>
                    </div>
                </div>
                <div class="fac-info-body">
                    <h3 class="fac-name-new"><?php echo esc_html($fac['name']); ?></h3>
                    <p class="fac-title-new"><?php echo esc_html($fac['designation']); ?></p>

                    <div class="fac-dept-box">
                        <?php 
                        $dept_name = $fac['department']['name'] ?? ($fac['school']['name'] ?? ($fac['centre']['name'] ?? 'University Faculty'));
                        echo esc_html($dept_name);
                        ?>
                    </div>

                    <!-- <?php if (!empty($fac['insti_email'])): ?>
                    <div class="fac-email-new">
                        <i class="far fa-envelope"></i> <?php echo esc_html($fac['insti_email']); ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($fac['other_email'])): ?>
                    <div class="fac-email-new">
                        <i class="far fa-envelope"></i> <?php echo esc_html($fac['other_email']); ?>
                    </div>
                    <?php endif; ?> -->
                </div>
                <div class="fac-card-footer">
                    <span>View Portfolio</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="faculty-pagination animate-fac-up" style="animation-delay: 0.3s;">
            <?php if ($current_page > 1): ?>
                <a href="<?php echo esc_url(add_query_arg('page_num', $current_page - 1)); ?>" class="page-btn prev-next">
                    <i class="fas fa-chevron-left me-2"></i> Previous
                </a>
            <?php endif; ?>

            <?php 
            // Simple logic for showing page numbers
            for ($i = 1; $i <= $total_pages; $i++): 
                if ($i == 1 || $i == $total_pages || ($i >= $current_page - 1 && $i <= $current_page + 1)):
            ?>
                <a href="<?php echo esc_url(add_query_arg('page_num', $i)); ?>"
                    class="page-btn <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php 
                elseif ($i == $current_page - 2 || $i == $current_page + 2):
                    echo '<span class="px-2 text-muted">...</span>';
                endif;
            endfor; 
            ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="<?php echo esc_url(add_query_arg('page_num', $current_page + 1)); ?>" class="page-btn prev-next">
                    Next <i class="fas fa-chevron-right ms-2"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="text-center py-5" style="margin-top:40px;">
            <i class="fa-solid fa-user-slash" style="font-size:3rem; color:#cbd5e1;"></i>
            <h3 style="margin-top:15px; color:#64748b;">No faculty members found.</h3>
            <p style="color:#94a3b8;">Try adjusting your search or filters.</p>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php include_once(get_template_directory() . '/styles-faculty.php'); ?>

<?php get_footer(); ?>