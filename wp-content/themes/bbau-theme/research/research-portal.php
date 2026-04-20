<?php
/**
 * Template Name: Research Portal
 */

get_header();

$api_base = getenv('DJANGO_API_URL');

// Fetch Projects
$projects_url = $api_base . '/api/v1/research-projects/';
$projects_res = wp_remote_get($projects_url, array('timeout' => 10));
$projects_data = array();
if (!is_wp_error($projects_res) && wp_remote_retrieve_response_code($projects_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($projects_res), true);
    $projects_data = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

// Fetch Scholars
$scholars_url = $api_base . '/api/v1/research-scholars/';
$scholars_res = wp_remote_get($scholars_url, array('timeout' => 10));
$scholars_data = array();
if (!is_wp_error($scholars_res) && wp_remote_retrieve_response_code($scholars_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($scholars_res), true);
    $scholars_data = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

// Fetch Departments for filtering
$depts_url = $api_base . '/api/v1/departments/';
$depts_res = wp_remote_get($depts_url, array('timeout' => 10));
$departments = array();
if (!is_wp_error($depts_res) && wp_remote_retrieve_response_code($depts_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($depts_res), true);
    $departments = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<main id="primary" class="site-main research-portal">
    <div class="research-hero">
        <div class="container">
            <h1>Research & Innovation</h1>
            <p>Advancing knowledge through cutting-edge research and collaborative innovation.</p>
            
            <div class="research-nav">
                <a href="/research-facilities" class="nav-card">
                    <i class="fas fa-microscope"></i>
                    <span>Research Facilities</span>
                </a>
                <a href="/rd-cell-team" class="nav-card">
                    <i class="fas fa-users-cog"></i>
                    <span>R&D Cell Members</span>
                </a>
                <a href="/research/publications" class="nav-card">
                    <i class="fas fa-book"></i>
                    <span>Publications</span>
                </a>
                <a href="/research/patents" class="nav-card">
                    <i class="fas fa-certificate"></i>
                    <span>Patents</span>
                </a>
            </div>
        </div>
    </div>

    <div class="research-container container">
        <div class="portal-header">
            <h2 class="section-title">Central Research Data</h2>
            <div class="filter-controls">
                <label for="dept-filter">Filter by Department:</label>
                <select id="dept-filter" class="custom-select">
                    <option value="">All Departments</option>
                    <?php foreach($departments as $dept): ?>
                        <option value="<?php echo esc_attr($dept['slug']); ?>"><?php echo esc_html($dept['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- PROJECTS -->
        <div class="data-section">
            <h3>Funded Research Projects</h3>
            <div class="table-container">
                <table class="data-table" id="projects-table">
                    <thead>
                        <tr>
                            <th>Project Title</th>
                            <th>Principal Investigator</th>
                            <th>Agency & Grant</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($projects_data as $proj): ?>
                        <tr class="project-row" data-dept="<?php echo esc_attr($proj['department_slug'] ?? ''); ?>">
                            <td class="bold-cell"><?php echo esc_html($proj['title']); ?></td>
                            <td>
                                <?php echo esc_html($proj['pi_name']); ?>
                                <?php if(!empty($proj['co_investigators_names'])): ?>
                                    <div class="sub-text">Co-PI: <?php echo esc_html(implode(', ', $proj['co_investigators_names'])); ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="agency"><?php echo esc_html($proj['funding_agency']); ?></div>
                                <div class="amount">₹<?php echo number_format($proj['amount_sanctioned'] ?? 0); ?></div>
                            </td>
                            <td>
                                <span class="status-badge <?php echo strtolower($proj['status']); ?>">
                                    <?php echo esc_html($proj['status']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SCHOLARS -->
        <div class="data-section">
            <h3>PhD Scholars</h3>
            <div class="table-container">
                <table class="data-table" id="scholars-table">
                    <thead>
                        <tr>
                            <th>Scholar Name</th>
                            <th>Research Topic</th>
                            <th>Supervisor</th>
                            <th>Reg. Year</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($scholars_data as $scholar): ?>
                        <tr class="scholar-row" data-dept="<?php echo esc_attr($scholar['department_slug'] ?? ''); ?>">
                            <td class="bold-cell"><?php echo esc_html($scholar['scholar_name']); ?></td>
                            <td class="italic-cell">"<?php echo esc_html($scholar['research_topic']); ?>"</td>
                            <td><?php echo esc_html($scholar['supervisor_name']); ?></td>
                            <td><?php echo esc_html($scholar['registration_year']); ?></td>
                            <td>
                                <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $scholar['status'])); ?>">
                                    <?php echo esc_html($scholar['status']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
document.getElementById('dept-filter').addEventListener('change', function() {
    const slug = this.value;
    document.querySelectorAll('.project-row, .scholar-row').forEach(row => {
        row.style.display = (!slug || row.dataset.dept === slug) ? '' : 'none';
    });
});
</script>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<?php get_footer(); ?>
