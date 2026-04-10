<?php
/*
Template name: Research Portal
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

<main id="primary" class="site-main" style="background:#f3f4f6; padding-bottom:60px;">

    <div class="research-header">
        <h1>Research & Innovation</h1>
        <p>Exploring new frontiers, securing global grants, and cultivating top-tier PhD scholars.</p>
        
        <div class="filter-wrap" style="margin-top:25px;">
            <select id="department-filter" style="padding:10px 20px; border-radius:30px; border:none; width:300px; font-weight:600;">
                <option value="">All Departments</option>
                <?php foreach($departments as $dept): ?>
                    <option value="<?php echo esc_attr($dept['slug']); ?>"><?php echo esc_html($dept['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="research-container">

        <!-- PROJECTS SECTION -->
        <h2 class="section-title">Funded Research Projects</h2>
        <div class="table-responsive">
            <table class="research-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">Title</th>
                        <th style="width: 20%;">Principal Investigator</th>
                        <th style="width: 20%;">Agency & Funding</th>
                        <th style="width: 15%;">Co-Investigators</th>
                        <th style="width: 15%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($projects_data)): ?>
                    <?php foreach($projects_data as $project): ?>
                    <tr class="project-row" data-dept="<?php echo esc_attr($project['department_slug'] ?? ''); ?>">
                        <td style="font-weight:600; color:#111827;"><?php echo esc_html($project['title'] ?? ''); ?>
                        </td>
                        <td><?php echo esc_html($project['pi_name'] ?? 'N/A'); ?></td>
                        <td>
                            <strong><?php echo esc_html($project['funding_agency'] ?? ''); ?></strong><br>
                            <?php if(!empty($project['amount_sanctioned'])): ?>
                            ₹<?php echo number_format((float)$project['amount_sanctioned'], 2); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                                    if(isset($project['co_investigators_names']) && is_array($project['co_investigators_names'])) {
                                        echo esc_html(implode(', ', $project['co_investigators_names']));
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                        </td>
                        <td>
                            <?php 
                                    $status = $project['status'] ?? 'Ongoing';
                                    $status_class = ($status === 'Completed') ? 'status-completed' : 'status-ongoing';
                                    ?>
                            <span class="<?php echo $status_class; ?>"><?php echo esc_html($status); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">No research projects currently listed.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- SCHOLARS SECTION -->
        <h2 class="section-title">Registered PhD Scholars</h2>
        <div class="table-responsive">
            <table class="research-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Enrollment No.</th>
                        <th style="width: 18%;">Scholar Name</th>
                        <th style="width: 35%;">Research Topic</th>
                        <th style="width: 22%;">Supervisors</th>
                        <th style="width: 10%;">Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($scholars_data)): ?>
                    <?php foreach($scholars_data as $scholar): ?>
                    <tr class="scholar-row" data-dept="<?php echo esc_attr($scholar['department_slug'] ?? ''); ?>">
                        <td><span
                                style="font-family:monospace; background:#f3f4f6; padding:3px 6px; border-radius:4px;"><?php echo esc_html($scholar['enrollment_no'] ?? ''); ?></span>
                        </td>
                        <td style="font-weight:600; color:#111827;">
                            <?php echo esc_html($scholar['scholar_name'] ?? ''); ?></td>
                        <td style="font-style:italic;">"<?php echo esc_html($scholar['research_topic'] ?? ''); ?>"</td>
                        <td>
                            <strong>Sup:</strong> <?php echo esc_html($scholar['supervisor_name'] ?? ''); ?><br>
                            <?php if(!empty($scholar['co_supervisor_name'])): ?>
                            <strong>Co:</strong> <?php echo esc_html($scholar['co_supervisor_name']); ?>
                            <?php endif; ?>
                        </td>
                        <td><?php echo esc_html($scholar['registration_year'] ?? ''); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">No PhD scholars registered currently.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<script>
document.getElementById('department-filter').addEventListener('change', function() {
    const slug = this.value;
    
    // Filter Projects
    document.querySelectorAll('.project-row').forEach(row => {
        if (!slug || row.dataset.dept === slug) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });

    // Filter Scholars
    document.querySelectorAll('.scholar-row').forEach(row => {
        if (!slug || row.dataset.dept === slug) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<?php get_footer(); ?>


<style>
.research-header {
    background: linear-gradient(135deg, #1e3a8a, #ea580c);
    color: white;
    padding: 60px 20px;
    text-align: center;
    border-bottom: 5px solid #ea580c;
}

.research-header h1 {
    font-size: 3rem;
    margin: 0;
    font-family: 'Inter', sans-serif;
    color: white;
}

.research-header p {
    font-size: 1.2rem;
    margin-top: 15px;
    opacity: 0.9;
}

.research-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
    font-family: 'Inter', sans-serif;
}

.section-title {
    font-size: 2rem;
    color: #1f2937;
    margin-bottom: 25px;
    border-left: 5px solid #ea580c;
    padding-left: 15px;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
    margin-bottom: 50px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.research-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.research-table th {
    background: #f9fafb;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

.research-table td {
    padding: 15px;
    border-bottom: 1px solid #e5e7eb;
    color: #4b5563;
    vertical-align: top;
}

.research-table tr:hover {
    background-color: #fffedd;
}

.research-table tr:last-child td {
    border-bottom: none;
}

.status-ongoing {
    background: #dbeafe;
    color: #1e40af;
    padding: 4px 8px;
    border-radius: 9999px;
    font-size: 0.85rem;
    font-weight: 600;
}

.status-completed {
    background: #dcfce7;
    color: #166534;
    padding: 4px 8px;
    border-radius: 9999px;
    font-size: 0.85rem;
    font-weight: 600;
}
</style>
