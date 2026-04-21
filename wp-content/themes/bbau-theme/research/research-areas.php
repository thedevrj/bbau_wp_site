<?php
/**
 * Template Name: Research Areas
 */

get_header();

$api_base = getenv('DJANGO_API_URL');

// Fetch Departments for Filters
$depts_url = $api_base . '/api/v1/departments/?page_size=500';
$depts_res = wp_remote_get($depts_url, array('timeout' => 10));
$departments = array();
if (!is_wp_error($depts_res) && wp_remote_retrieve_response_code($depts_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($depts_res), true);
    $departments = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<main id="primary" class="site-main research-portal">
    <?php get_template_part('banners/about-banner');?>
    <!-- <div class="research-hero">
        <div class="container">
            <h1>Research & Innovation</h1>
            <p>Advancing knowledge through cutting-edge research and collaborative innovation.</p>
            
            <div class="research-nav">
                <a href="/research-projects" class="nav-card">
                    <i class="fas fa-project-diagram"></i>
                    <span>Research Projects</span>
                </a>
                <a href="/research-facilities" class="nav-card">
                    <i class="fas fa-microscope"></i>
                    <span>Research Facilities</span>
                </a>
                <a href="/rd-cell-team" class="nav-card">
                    <i class="fas fa-users-cog"></i>
                    <span>R&D Cell Members</span>
                </a>
                <a href="/research-publications" class="nav-card">
                    <i class="fas fa-book"></i>
                    <span>Publications</span>
                </a>
                <a href="/research-patents" class="nav-card">
                    <i class="fas fa-certificate"></i>
                    <span>Patents</span>
                </a>
            </div>
        </div>
    </div> -->

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>
        <div class="portal-header mb-4">
            <h2 class="section-title modal-title-blue"> Research Areas</h2>
        </div>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="ra-search-box">
                <i class="fas fa-search ra-search-icon"></i>
                <input type="text" id="area-search" placeholder="Search by area or specialization..." autocomplete="off">
            </div>
            
            <select id="dept-filter" class="custom-select">
                <option value="">All Departments</option>
                <?php foreach($departments as $dept): ?>
                    <option value="<?php echo esc_attr($dept['slug']); ?>"><?php echo esc_html($dept['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- RESEARCH AREAS GRID -->
        <div id="loading-spinner" class="text-center py-5 text-muted">
            <i class="fas fa-spinner fa-spin fa-2x mb-3 d-block"></i> Loading research areas...
        </div>

        <div id="no-results" class="text-center py-5 text-muted" style="display: none;">
            No research areas found matching your criteria.
        </div>

        <div class="areas-grid" id="areas-container">
            <!-- Dynamic Cards Go Here -->
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('area-search');
    const deptFilter = document.getElementById('dept-filter');
    const container = document.getElementById('areas-container');
    const loading = document.getElementById('loading-spinner');
    const noResults = document.getElementById('no-results');
    const apiBase = "<?php echo esc_js($api_base); ?>";
    
    let debounceTimer;

    function fetchAreas() {
        const query = searchInput.value.toLowerCase().trim();
        const dept = deptFilter.value;
        
        let url = `${apiBase}/api/v1/research-areas/?page_size=500&`;
        if (query) url += `search=${encodeURIComponent(query)}&`;
        if (dept) url += `department__slug=${encodeURIComponent(dept)}&`;

        container.style.display = 'none';
        noResults.style.display = 'none';
        loading.style.display = 'block';

        fetch(url)
            .then(res => res.json())
            .then(data => {
                const areas = data.results || data;
                renderAreas(areas);
            })
            .catch(err => {
                console.error('Error fetching areas:', err);
                loading.style.display = 'none';
                noResults.style.display = 'block';
                noResults.textContent = 'Failed to load research areas. Please try again later.';
            });
    }

    function renderAreas(areas) {
        loading.style.display = 'none';

        if (areas.length === 0) {
            noResults.style.display = 'block';
            return;
        }

        container.style.display = 'grid';

        const html = areas.map((area) => {
            const desc = area.description && area.description.trim() ? area.description : 'No detailed description provided.';
            const deptName = area.department_name || 'Generic';
            return `
                <div class="area-card">
                    <div class="area-dept-badge">${deptName}</div>
                    <h3 class="area-title">${area.available_research_areas_or_Specialization}</h3>
                    <div class="area-desc">${desc}</div>
                </div>
            `;
        }).join('');
        
        container.innerHTML = html;
    }

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchAreas, 400);
    });
    
    deptFilter.addEventListener('change', fetchAreas);

    // Initial Fetch
    fetchAreas();
});
</script>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
:root {
    --theme-blue: #1e3a8a;
    --theme-amber: #b45309;
}

.modal-title-blue {
    color: var(--theme-blue);
    font-size: 1.5rem;
    font-weight: 700;
}

.filter-bar {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    margin-bottom: 30px;
    display: flex;
    gap: 15px;
    flex-wrap: nowrap;
    align-items: center;
    border: 1px solid #f1f5f9;
}

.ra-search-box {
    flex: 2;
    min-width: 200px;
    position: relative;
}

.ra-search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.ra-search-box input {
    width: 100%;
    padding: 10px 15px 10px 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.ra-search-box input:focus {
    border-color: var(--theme-blue);
    outline: none;
    box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
}

.custom-select {
    flex: 1;
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    color: #475569;
    background-color: #f8fafc;
    min-width: 120px;
    cursor: pointer;
}

.areas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 25px;
}

.area-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    border-left: 4px solid var(--theme-blue);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
}

.area-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.area-dept-badge {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #475569;
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-block;
    align-self: flex-start;
    margin-bottom: 12px;
}

.area-title {
    color: var(--theme-blue);
    font-size: 1.15rem;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 12px;
}

.area-desc {
    color: #64748b;
    font-size: 0.95rem;
    line-height: 1.6;
    flex-grow: 1;
}

@media (max-width: 768px) {
    .filter-bar { flex-direction: column; }
    .custom-select { width: 100%; }
}
</style>

<?php get_footer(); ?>
