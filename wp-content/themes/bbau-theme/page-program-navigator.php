<?php
/*
Template Name: Program Navigator Template
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_API_URL');

$query_params = array();
if (!empty($_GET['page_num']))        $query_params['page'] = intval($_GET['page_num']);

$schools_url = $api_base . '/api/v1/schools/';
$programs_url = $api_base . '/api/v1/programs/?page_size=500' ;
$programs_url_pagination = $api_base . '/api/v1/programs/?'. http_build_query($query_params);

// Fetch Schools for the filter
$schools_res = wp_remote_get($schools_url, array('timeout' => 10));
$schools = array();
if (!is_wp_error($schools_res) && wp_remote_retrieve_response_code($schools_res) === 200) {
    $schools = json_decode(wp_remote_retrieve_body($schools_res), true);
}

// Fetch All Programs
$programs_res = wp_remote_get($programs_url_pagination, array('timeout' => 15));
$programs = array();
$total_count = 0;
$next_page = null;
$prev_page = null;
if (!is_wp_error($programs_res) && wp_remote_retrieve_response_code($programs_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($programs_res), true);
    $programs = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
    $total_count = isset($decoded['count']) ? $decoded['count'] : count($programs);
    $next_page = isset($decoded['next']) ? $decoded['next'] : null;
    $prev_page = isset($decoded['previous']) ? $decoded['previous'] : null;
}
$current_page = isset($_GET['page_num']) ? max(1, intval($_GET['page_num'])) : 1;
$total_pages = ($total_count > 0) ? ceil($total_count / 20) : 1;
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="admissions-portal py-lg-5">
    <div class="container">

        <!-- HEADER SECTION -->
        <div class="adm-header mb-5">
            <h2 class="adm-title">Program Navigator</h2>
        </div>

        <!-- FILTER BAR -->
        <div class="adm-filter-bar sticky-top">
            <div class="filter-group">
                <label>Filter by Level</label>
                <div class="level-tabs">
                    <button class="level-tab active" data-level="all">All</button>
                    <button class="level-tab" data-level="UG">Undergraduate</button>
                    <button class="level-tab" data-level="PG">Postgraduate</button>
                    <button class="level-tab" data-level="PHD">PhD</button>
                    <button class="level-tab" data-level="Integrated">Integrated</button>
                    <button class="level-tab" data-level="Others">Others</button>

                </div>
            </div>

            <div class="filter-group">
                <label>Filter by School</label>
                <select id="school-select" class="adm-select">
                    <option value="all">All Schools</option>
                    <?php foreach($schools as $school): ?>
                    <option value="<?php echo esc_attr($school['name']); ?>"><?php echo esc_html($school['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group explorer-search">
                <label>Search Programs</label>
                <input type="text" id="prog-search" placeholder="Enter keywords..." class="adm-input">
            </div>
        </div>

        <!-- PROGRAMS GRID -->
        <div id="prog-grid" class="mt-5">
            <?php if(!empty($programs)): ?>
            <div class="row g-4">
                <?php foreach($programs as $prog): ?>
                <div class="col-md-6 col-lg-4 prog-card-wrapper" data-level="<?php echo esc_attr($prog['level']); ?>"
                    data-school="<?php echo esc_attr($prog['school_name'] ?? ''); ?>"
                    data-name="<?php echo esc_attr(strtolower($prog['name'])); ?>">
                    <?php 
                            set_query_var('prog_data', $prog);
                            get_template_part('template-parts/admission-card'); 
                            ?>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="no-results" class="text-center py-5" style="display:none;">
                <h3>No programs match your filters.</h3>
                <p>Try adjusting your criteria or reset the filters.</p>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <h3>No programs found.</h3>
            </div>
            <?php endif; ?>
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

    </div>
</div>

<style>
.admissions-portal {
    background: #fdfaf6;
    min-height: 80vh;
}

.adm-header {
    text-align: center;
    border-bottom: 2px solid #e2d9cc;
    padding-bottom: 30px;
}

.adm-title {
    font-family: 'Merriweather', serif;
    color: #5c1010;
    font-size: 3rem;
    font-weight: 700;
}


/* FILTER BAR */
.adm-filter-bar {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    align-items: flex-end;
    margin-top: -40px;
    z-index: 1000;
    border: 1px solid #e2d9cc;
}

.filter-group {
    flex: 1;
}

.filter-group label {
    display: block;
    font-weight: 700;
    color: #5c1010;
    margin-bottom: 8px;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.level-tabs {
    display: flex;
    background: #f3f4f6;
    padding: 5px;
    border-radius: 8px;
    gap: 5px;
}

.level-tab {
    flex: 1;
    border: none;
    background: transparent;
    padding: 8px 12px;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

.level-tab.active {
    background: #8B1A1A;
    color: #fff;
}

.adm-select,
.adm-input {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.95rem;
}

.adm-select:focus,
.adm-input:focus {
    outline: none;
    border-color: #8B1A1A;
    box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1);
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .adm-filter-bar {
        margin-top: 0;
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.level-tab');
    const schoolSelect = document.getElementById('school-select');
    const searchInput = document.getElementById('prog-search');
    const cards = document.querySelectorAll('.prog-card-wrapper');
    const noResults = document.getElementById('no-results');

    let currentLevel = 'all';
    let currentSchool = 'all';
    let currentSearch = '';

    function filterPrograms() {
        let visibleCount = 0;

        cards.forEach(card => {
            const level = card.dataset.level;
            const school = card.dataset.school;
            const name = card.dataset.name;

            const levelMatch = (currentLevel === 'all' || level === currentLevel);
            const schoolMatch = (currentSchool === 'all' || school === currentSchool);
            const searchMatch = (currentSearch === '' || name.includes(currentSearch));

            if (levelMatch && schoolMatch && searchMatch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.style.display = (visibleCount === 0) ? 'block' : 'none';
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentLevel = this.dataset.level;
            filterPrograms();
        });
    });

    schoolSelect.addEventListener('change', function() {
        currentSchool = this.value;
        filterPrograms();
    });

    searchInput.addEventListener('input', function() {
        currentSearch = this.value.toLowerCase().trim();
        filterPrograms();
    });
});
</script>

<?php get_footer(); ?>