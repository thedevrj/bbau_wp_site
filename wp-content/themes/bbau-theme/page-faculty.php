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
if (!empty($_GET['faculty_type']))    $query_params['faculty_type'] = sanitize_text_field($_GET['faculty_type']);
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

<?php get_template_part('banners/about-banner'); ?>

<main id="primary" class="site-main faculty-directory" style="background:#fdfaf6; padding-bottom:60px;">
    <div class="container pt-4">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <!-- Search & Filter Section -->
        <div class="faculty-filters">
            <form method="GET" action="" id="faculty-filter-form">
                <div class="filter-row">
                    <div class="filter-search">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" name="search" placeholder="Search by name, designation..."
                            value="<?php echo esc_attr($_GET['search'] ?? ''); ?>">
                    </div>
                    <div class="filter-dropdowns">
                        <select name="school" onchange="this.form.submit()">
                            <option value="">All Schools</option>
                            <?php foreach ($schools_list as $s): ?>
                            <option value="<?php echo esc_attr($s['slug']); ?>"
                                <?php selected($_GET['school'] ?? '', $s['slug']); ?>>
                                <?php echo esc_html($s['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="department" onchange="this.form.submit()">
                            <option value="">All Departments</option>
                            <?php foreach ($depts_list as $d): ?>
                            <option value="<?php echo esc_attr($d['slug']); ?>"
                                <?php selected($_GET['department'] ?? '', $d['slug']); ?>>
                                <?php echo esc_html($d['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="campus" onchange="this.form.submit()">
                            <option value="">All Campuses</option>
                            <option value="BBAU" <?php selected($_GET['campus'] ?? '', 'BBAU'); ?>>BBAU</option>
                            <option value="Satellite Campus Amethi"
                                <?php selected($_GET['campus'] ?? '', 'Satellite Campus Amethi'); ?>>Satellite Campus
                                Amethi</option>
                        </select>
                        <select name="faculty_type" onchange="this.form.submit()">
                            <option value="">All Types</option>
                            <option value="Teaching" <?php selected($_GET['faculty_type'] ?? '', 'Teaching'); ?>>
                                Teaching</option>
                            <option value="Non-Teaching"
                                <?php selected($_GET['faculty_type'] ?? '', 'Non-Teaching'); ?>>Non-Teaching</option>
                        </select>
                    </div>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-filter-search"><i class="fa-solid fa-search"></i> Search</button>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="btn-filter-clear">Clear Filters</a>
                    <span class="result-count"><?php echo intval($total_count); ?> faculty found</span>
                </div>
            </form>
        </div>

        <!-- Faculty Grid -->
        <?php if (!empty($faculty_list)): ?>
        <div class="faculty-dir-grid">
            <?php foreach ($faculty_list as $fac): ?>
            <a href="<?php echo esc_url(home_url('/faculty/' . ($fac['slug'] ?? ''))); ?>" class="faculty-dir-card">
                <div class="fdc-photo-wrap">
                    <?php if (!empty($fac['photo'])): ?>
                    <img src="<?php echo esc_url($media_base . $fac['photo']); ?>"
                        alt="<?php echo esc_attr($fac['photo_alt_text'] ?? $fac['name']); ?>">
                    <?php else: ?>
                    <div class="fdc-no-photo"><i class="fa-solid fa-user-tie"></i></div>
                    <?php endif; ?>
                </div>
                <div class="fdc-body">
                    <h3 class="fdc-name"><?php echo esc_html($fac['name']); ?></h3>
                    <p class="fdc-designation"><?php echo esc_html($fac['designation']); ?></p>
                    <?php if (!empty($fac['department']['name'])): ?>
                    <span class="fdc-dept"><?php echo esc_html($fac['department']['name']); ?></span>
                    <?php elseif (!empty($fac['school']['name'])): ?>
                    <span class="fdc-dept"><?php echo esc_html($fac['school']['name']); ?></span>
                    <?php elseif (!empty($fac['centre']['name'])): ?>
                    <span class="fdc-dept"><?php echo esc_html($fac['centre']['name']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($fac['insti_email'])): ?>
                    <div class="fdc-email"><i class="fa-solid fa-envelope"></i>
                        <?php echo esc_html($fac['insti_email']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="fdc-footer">
                    <span class="fdc-view">View Profile <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="faculty-pagination">
            <?php if ($current_page > 1): ?>
            <a href="<?php echo esc_url(add_query_arg('page_num', $current_page - 1)); ?>" class="page-btn">&laquo;
                Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="<?php echo esc_url(add_query_arg('page_num', $i)); ?>"
                class="page-btn <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
            <a href="<?php echo esc_url(add_query_arg('page_num', $current_page + 1)); ?>" class="page-btn">Next
                &raquo;</a>
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

<style>
/* ── Filter Bar ── */
.faculty-filters {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
}

.filter-row {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    align-items: stretch;
}

.filter-search {
    position: relative;
    flex: 1;
    min-width: 250px;
}

.filter-search input {
    width: 100%;
    padding: 12px 15px 12px 42px;
    border: 2px solid #e2d9cc;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: 0.2s;
    outline: none;
}

.filter-search input:focus {
    border-color: #8B1A1A;
    box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1);
}

.search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.filter-dropdowns {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-dropdowns select {
    padding: 12px 15px;
    border: 2px solid #e2d9cc;
    border-radius: 10px;
    font-size: 0.9rem;
    background: #fff;
    cursor: pointer;
    min-width: 160px;
    outline: none;
    transition: 0.2s;
}

.filter-dropdowns select:focus {
    border-color: #8B1A1A;
}

.filter-actions {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 15px;
}

.btn-filter-search {
    padding: 10px 25px;
    background: #5c1010;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.2s;
}

.btn-filter-search:hover {
    background: #8B1A1A;
}

.btn-filter-clear {
    padding: 10px 20px;
    border: 2px solid #e2d9cc;
    border-radius: 10px;
    color: #64748b !important;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
}

.btn-filter-clear:hover {
    border-color: #8B1A1A;
    color: #8B1A1A;
}

.result-count {
    margin-left: auto;
    font-size: 0.9rem;
    color: #64748b;
    font-weight: 600;
}

/* ── Faculty Card Grid ── */
.faculty-dir-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}

.faculty-dir-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    transition: 0.3s;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
}

.faculty-dir-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 35px rgba(139, 26, 26, 0.12);
    border-color: #c9a84c;
}

.fdc-photo-wrap {
    height: 280px;
    overflow: hidden;
    background: #f1f5f9;
}

.fdc-photo-wrap img {
    width: 100%;
    height: 100%;
    object-fit: inherit;
    transition: 0.4s;
}

.faculty-dir-card:hover .fdc-photo-wrap img {
    transform: scale(1.05);
}

.fdc-no-photo {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: #cbd5e1;
}

.fdc-body {
    padding: 20px;
    flex-grow: 1;
}

.fdc-name {
    margin: 0 0 6px;
    font-family: 'Merriweather', serif;
    font-size: 1.15rem;
    color: #5c1010;
    font-weight: 700;
}

.fdc-designation {
    margin: 0 0 10px;
    font-size: 0.9rem;
    color: #8B1A1A;
    font-weight: 600;
}

.fdc-dept {
    display: inline-block;
    font-size: 0.8rem;
    background: #fdfaf6;
    border: 1px solid #e2d9cc;
    padding: 3px 12px;
    border-radius: 20px;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 8px;
}

.fdc-email {
    font-size: 0.82rem;
    color: #64748b;
    margin-top: 8px;
}

.fdc-footer {
    padding: 15px 20px;
    border-top: 1px solid #f1f5f9;
}

.fdc-view {
    font-size: 0.85rem;
    font-weight: 700;
    color: #5c1010;
    transition: 0.2s;
}

.faculty-dir-card:hover .fdc-view {
    color: #c9a84c;
}

/* ── Pagination ── */
.faculty-pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.page-btn {
    padding: 10px 18px;
    border: 2px solid #e2d9cc;
    border-radius: 10px;
    color: #5c1010;
    text-decoration: none;
    font-weight: 700;
    transition: 0.2s;
}

.page-btn:hover,
.page-btn.active {
    background: #5c1010;
    color: #fff;
    border-color: #5c1010;
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .filter-row {
        flex-direction: column;
    }

    .filter-dropdowns {
        flex-direction: column;
    }

    .filter-dropdowns select {
        width: 100%;
    }

    .filter-actions {
        flex-wrap: wrap;
    }

    .result-count {
        margin-left: 0;
        width: 100%;
        text-align: center;
    }

    .faculty-dir-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
}
</style>

<?php get_footer(); ?>